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
    'Login' => 'Iniciar sesión',
    'Logout' =>'Cerrar sesión',
    'Register' => 'Registrate',
    'E-MailAddress/Username'=> 'Correo electrónico o Usuario',
    'Username' => 'Nombre de usuario',
    'E-MailAddress' => 'Correo electrónico',
    'ConfirmPassword' => 'Confirmar contraseña',
    'Password' => 'Contraseña',
    'ResetPassword' => 'Restablecer contraseña',
    'SendPasswordResetLink' => 'Enviar enlace para restablecer contraseña',
    'InfoResetPassword' => 'Ingrese su correo electrónico para restablecer su contraseña.',
    'ResetPasswordAlertInfo' => '¡Hemos enviado a tu correo electrónico el enlace para restablecer tu contraseña!',
    'RememberMe' => 'Recuerdame',
    'ForgotYourPassword' => 'Olvidaste tu contraseña?',
    'VerifyYourEmailAddress' => 'Verifica tu correo electronico',
    'ClickHere' => 'Haga click aquí',

    'Before proceeding, please check your email for a verification link'=> 'Antes de continuar, ingresa a tu correo electronico para verificar tu cuenta.',
    'If you did not receive the email' => 'Si no has recibido el correo electronico',
    'A fresh verification link has been sent to your email address' => 'Se ha enviado un nuevo correo de verificación a su dirección de correo electrónico.',

     /**Correos reset password */
     'ResetPasswordNotification' => 'Restablecer contraseña',
     'You are receiving this email because we received a password reset request for your account'=>'Está recibiendo este correo electrónico porque recibimos una solicitud para restablecer la contraseña de su cuenta.',
     'This password reset link will expire in :count minutes' =>'Este enlace para restablecer contrasena expirará en :count minutos.',
     'If you did not request a password reset, no further action is required' => 'Si no solicitó un restablecimiento de contraseña, no es necesario realizar el cambio.',

      /**Correo verify account */
      'VerifyEmailAddress' => 'Verificar cuenta',
      'Please click the button below to verify your email address' => 'Por favor, haga clic en el botón de abajo para verificar su dirección de correo electrónico.',
      'If you did not create an account, no further action is required' => 'Si no creó una cuenta, no es necesario realizar la verificación.',

      'WelcomeTo' => 'Bienvenido a '.config('app.name', 'Laravel'),
      'Greeting' => 'Hola!'
    ];
