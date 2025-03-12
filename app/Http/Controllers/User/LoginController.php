<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\CodeEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

/**
 * Class LoginController
 * Handles user authentication, including login, 2FA (Two-Factor Authentication), logout, and account activation.
 */
class LoginController extends Controller
{
    /**
     * Handle user login.
     *
     * Validates the user's credentials, checks if the account is active,
     * and initiates two-factor authentication (2FA) if applicable.
     *
     * @param  \Illuminate\Http\Request  $request The HTTP request object containing the login credentials.
     * @return \Illuminate\Http\RedirectResponse Redirects to the 2FA view if the login is successful, or back with an error message.
     */
    public function login(Request $request)
    {
        // Validate credentials and reCAPTCHA
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        // If the user does not exist or the password is incorrect, return an error
        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', 'Incorrect username or password.');
        }

        // Check if the account is active
        if (!$user->is_active) {
            return redirect()->back()->with('error', 'Your account is not active, check your email to activate your account.');
        }

        // Store the user ID in the session without authenticating
        session(['2fa_user_id' => encrypt($user->id)]);

        // Generate and send the 2FA code
        $this->generateAndSend2FACode($user);

        // Redirect to the 2FA view
        return redirect()->route('2fa.view')->with('success', 'A code has been sent to your email.');
    }

    /**
     * Generate a 2FA code and send it to the user's email.
     *
     * @param  \App\Models\User  $user The authenticated user for whom the 2FA code will be generated.
     * @return void
     */
    public function generateAndSend2FACode($user)
    {
        // Generate a random 6-digit code for 2FA
        $code = mt_rand(100000, 999999);

        // Encrypt the 2FA code and store it in the user's database record
        $encrypted_code = Hash::make($code);
        $user->two_factor_code = $encrypted_code;
        $user->two_factor_expires_at = now()->addMinutes(5); // Set expiry time for 2FA code
        $user->save();

        // Send the 2FA code to the user's email
        Mail::to($user->email)->send(new CodeEmail($code));
    }

    /**
     * Verify the 2FA code entered by the user.
     *
     * Validates the entered code, checks if it matches the stored code,
     * and ensures the code has not expired. If successful, logs in the user.
     *
     * @param  \Illuminate\Http\Request  $request The HTTP request containing the entered 2FA code.
     * @return \Illuminate\Http\RedirectResponse Redirects based on the outcome of the verification.
     */
    public function verify2FACode(Request $request)
    {
        // Validate that the code is a 6-digit number
        $request->validate([
            'code' => 'required|numeric|digits:6',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        Log::info('2FA code verification started');

        try {
            // Get the user_id from the session
            $user_id = decrypt(session('2fa_user_id'));
            Log::info('2FA code verification started for user id: ' . $user_id);
        } catch (\Exception $e) {
            Log::error('Error decrypting user ID: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Session expired. Please log in again.');
        }

        // Find the user
        $user = User::find($user_id);

        if (!$user) {
            Log::error("User with ID $user_id not found.");
            return redirect()->route('login')->with('error', 'User not found.');
        }

        // Validate that the entered code matches the stored code
        if (!Hash::check($request->code, $user->two_factor_code)) {
            Log::warning("Incorrect 2FA code for user $user_id.");
            return redirect()->route('2fa.view')->with('error', 'Incorrect code.');
        }

        // Check if the code has expired
        if (now()->greaterThan($user->two_factor_expires_at)) {
            Log::warning("2FA code expired for user $user_id.");
            return redirect()->route('2fa.view')->with('error', 'Code expired.');
        }

        Log::info("2FA code verified for user $user_id.");

        // Now authenticate the user
        Auth::login($user, true);

        // Clear the user's 2FA code
        $user->two_factor_code = null;
        $user->two_factor_expires_at = null;
        $user->save();

        // Clear the 2FA session
        session()->forget('2fa_user_id');

        // Redirect to the main page
        return redirect()->route('welcome')->with('success', 'Authentication successful.');
    }


    /**
     * Log the user out and end the session.
     *
     * @param  \Illuminate\Http\Request  $request The HTTP request.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating the user has logged out successfully.
     */
    public function logout(Request $request)
    {
        // Log the user out and destroy the session
        Auth::logout();
        return redirect('/login');
    }

    /**
     * Activate a user's account via a signed URL.
     *
     * Validates the signed URL, activates the user's account if valid,
     * and redirects to the activation page with a success message.
     *
     * @param  \App\Models\User  $user The user whose account will be activated.
     * @param  \Illuminate\Http\Request  $request The HTTP request containing the signed URL.
     * @return \Illuminate\Http\RedirectResponse Redirects to the activation page with a success or error message.
     */
    public function activate(User $user, Request $request)
    {
        // Validate the signed URL for security
        if (!$request->hasValidSignature()) {
            return redirect()->route('access.activation', ['user' => $user->id])
                ->with('error', 'Invalid or expired URL.');
        }

        // Activate the user's account
        $user->is_active = true;
        $user->save();

        // Redirect with a success message
        return redirect()->route('access.activation', ['user' => $user->id])
            ->with('success', 'Account activated successfully.');
    }


}
