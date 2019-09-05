<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'Login' => 'Login',
    'Logout' =>'Logout',
    'Register' => 'Register',
    'E-MailAddress/Username'=> 'E-Mail Address/Username',
    'Username' => 'Username',
    'E-MailAddress' => 'E-Mail Address',
    'ConfirmPassword' => 'Confirm Password',
    'Password' => 'Password',
    'ResetPassword' => 'Reset Password',
    'SendPasswordResetLink' => 'Send Password Reset Link',
    'InfoResetPassword' => 'Enter your email to reset your password',
    'ResetPasswordAlertInfo' => 'We have e-mailed your password reset link!',
    'RememberMe' => 'Remember Me',
    'ForgotYourPassword' => 'Forgot Your Password?',
    'VerifyYourEmailAddress' => 'Verify Your Email Address',
    'ClickHere' => 'click here',

    'Before proceeding, please check your email for a verification link'=> 'Before proceeding, please check your email for a verification link.',
    'If you did not receive the email' => 'If you did not receive the email',
    'A fresh verification link has been sent to your email address' => 'A fresh verification link has been sent to your email address.',

    /**Correo reset password */
    'ResetPasswordNotification' => 'Reset Password Notification',
    'You are receiving this email because we received a password reset request for your account'=>'You are receiving this email because we received a password reset request for your account.',
    'This password reset link will expire in :count minutes' =>'This password reset link will expire in :count minutes.',
    'If you did not request a password reset, no further action is required' => 'If you did not request a password reset, no further action is required.',

    /**Correo verify account */
    'VerifyEmailAddress' => 'Verify Email Address',
    'Please click the button below to verify your email address' => 'Please click the button below to verify your email address.',
    'If you did not create an account, no further action is required' => 'If you did not create an account, no further action is required.',

    'WelcomeTo' => 'Welcome to '.config('app.name', 'Laravel'),
    'Greeting' => 'Hello!'
];
