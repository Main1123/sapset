<?php

return [
    'general' => [
        'nombre_sistema' => env('NOMBRE_SISTEMA', 'SAPSET'),
        'version' => env('VERSION_SISTEMA', '1.0.0'),
        'logo' => env('LOGO_SISTEMA', 'img/default-logo.png'),
    ],

    'contacto' => [
        'email' => env('EMAIL_CONTACTO', 'contacto@sapset.com'),
        'telefono' => env('TELEFONO_CONTACTO', '+58 000-000-0000'),
        'direccion' => env('DIRECCION_CONTACTO', 'Ciudad, Estado, País'),
    ],

    'horarios' => [
        'abierto' => env('HORARIO_ABIERTO', '08:00'),
        'cerrado' => env('HORARIO_CERRADO', '17:00'),
        'dias' => env('DIAS_OPERATIVOS', 'Lunes a Viernes'),
    ],

    'redes_sociales' => [
        'facebook' => env('FACEBOOK_URL', '#'),
        'twitter' => env('TWITTER_URL', '#'),
        'instagram' => env('INSTAGRAM_URL', '#'),
        'linkedin' => env('LINKEDIN_URL', '#'),
    ],

    'colores' => [
        'primary' => env('COLOR_PRIMARY', '#120587'),
        'secondary' => env('COLOR_SECONDARY', '#3498db'),
        'success' => env('COLOR_SUCCESS', '#2ecc71'),
        'danger' => env('COLOR_DANGER', '#e74c3c'),
    ],
];
