<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\ValidatorEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;


/**
 * Class RegisterController
 * 
 * This controller handles user registration, activation, and reactivation.
 * It validates the input, creates new users, sends activation emails, and provides routes to handle user activation.
 */
class RegisterController extends Controller
{
    /**
     * Store a new user in the database.
     *
     * This method validates the user input (first name, last name, email, password), 
     * creates a new user in the database, and sends an activation email with a signed URL for the user to activate their account.
     * 
     * @param  \Illuminate\Http\Request  $request The HTTP request object containing the user's input data.
     * @return \Illuminate\Http\RedirectResponse Redirects the user to the registration page with a success message.
     * 
     * @throws \Illuminate\Validation\ValidationException If validation fails, the request is redirected back with error messages.
     */
    public function store(Request $request)
    {
        // Custom error messages for validation
        $messages = [
            'firstName.required' => 'First name is required.',
            'firstName.string' => 'First name must be a string.',
            'firstName.max' => 'First name may not be greater than 255 characters.',
            'firstName.min' => 'First name must be at least 2 characters.',
            'firstName.regex' => 'First name may only contain letters, spaces, and apostrophes.',
            'lastName.required' => 'Last name is required.',
            'lastName.string' => 'Last name must be a string.',
            'lastName.max' => 'Last name may not be greater than 255 characters.',
            'lastName.min' => 'Last name must be at least 2 characters.',
            'lastName.regex' => 'Last name may only contain letters, spaces, and apostrophes.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'Email has already been taken.',
            'password.required' => 'Password is required.',
            'password.confirmed' => 'Passwords do not match.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.regex' => 'Password must contain at least one letter, one number, and one special character (@$!%*?&).',
            'g-recaptcha-response.required' => 'Please complete the reCAPTCHA.',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.'
        ];

        // Validate the input data using Laravel's Request validate method
        $request->validate([
            'firstName' => 'required|string|min:2|max:255|regex:/^[a-zA-Z\s\']+$/',
            'lastName' => 'required|string|min:2|max:255|regex:/^[a-zA-Z\s\']+$/',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[A-Za-z]/',  // Debe contener al menos una letra
                'regex:/[0-9]/',      // Debe contener al menos un número
                'regex:/[\@\$\!\%\*\?\&]/' // Asegurar que los caracteres especiales sean reconocidos
            ],
            'g-recaptcha-response' => 'required|captcha'
        ], $messages);

        // Create a new user in the database
        $user = User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password
        ]);
        
        // Generate a temporary signed URL for the user to activate their account
        $signedroute = URL::temporarySignedRoute(
            'activate',
            now()->addMinutes(30), // The URL is valid for 30 minutes
            ['user' => $user->id]
        );


            try {
            // Enviar el correo de activación
            Mail::to($user->email)->send(new ValidatorEmail($signedroute));

            // Si el correo se envía correctamente, redirigir con un mensaje de éxito
            return redirect()->route('register')->with('success', 'User created, check your email to activate your account.');
        } catch (\Exception $e) {
            // Capturar cualquier error y devolver un mensaje de error
            return redirect()->route('register')->with('error', 'Failed to send email: ' . $e->getMessage());
        }

    }

    /**
     * Activate the user account.
     *
     * This method is called when the user clicks the activation link in the email.
     * It sets the user's `is_active` attribute to true and saves the user.
     * 
     * @param \App\Models\User $user The user to be activated.
     * @return \Illuminate\View\View The confirmation view for the activation.
     */
    public function activate(User $user)
    {
        // Activate the user's account
        $user->is_active = true;
        $user->save();

        // Return the confirmation view
        return view('mails.confirmemail');
    }

    /**
     * Refresh the signed route for user activation.
     *
     * This method is used to regenerate a new activation URL if the original one expires.
     * The new URL is sent to the user by email.
     * 
     * @param \Illuminate\Http\Request $request The HTTP request containing the user ID.
     * @return \Illuminate\Http\RedirectResponse Redirects to the login page or back to the registration page based on the result.
     */
    public function refreshSignedRoute(Request $request)
    {
        // Find the user by ID
        $user = User::find($request->user_id);

        // If the user does not exist, redirect back with an error message
        if (!$user) {
            return redirect()->back()->with('error', 'The user does not exist.');
        }

        // If the user is already active, redirect to login
        if ($user->is_active) {
            return redirect()->route('login')->with('success', 'The account is active, sign in.');
        }

        // Generate a new signed route for activation
        $signedRoute = URL::temporarySignedRoute(
            'activate',
            now()->addMinutes(30), // The URL is valid for 30 minutes
            ['user' => $user->id]
        );
      
        // Resend the activation email with the new signed URL
        Mail::to($user->email)->send(new ValidatorEmail($signedRoute));

    

        // Redirect to the login page with a success message
        return redirect()->route('login')->with('success', 'A new activation link has been sent to your email.');
    }

    /**
     * Show the activation view for a user.
     *
     * This method displays the activation view where the user can confirm their account activation.
     * 
     * @param int $userId The ID of the user to activate.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View Returns the activation view or redirects if the user does not exist.
     */
    public function showActivationView($userId)
    {
        // Find the user by ID
        $user = User::find($userId);

        // If the user does not exist, redirect back with an error message
        if (!$user) {
            return redirect()->route('register')->with('error', 'The user does not exist.');
        }

        // Return the activation view with the user ID
        return view('Access.activation', ['userId' => $userId]);
    }
}
