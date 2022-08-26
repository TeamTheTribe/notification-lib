# Notifications MS
Version 0.8.6

# Instalacion libreria
1. Añadir repositorio en el archivo composer.json del proyecto.
```
    "repositories": [
        { "type": "vcs", "url": "git@github.com:TeamTheTribe/notification-lib.git" }
    ]
```
2. Ejecutar el siguiente comando
```
 composer require the-tribe/notifications-ms
```


# Pasos de instalacion Laravel
1. Ejecutar el siguiente comando para hacer la publicacion del servicio
```
php artisan vendor:publish --provider="TheTribe\\NotificationMS\\Laravel\\ServiceProvider"
```
2. Modificar el archivo notifications.php ubicado el la ruta path/config/notifications.php.
```
<?php
return [
    "url" => [
        "develop" => "http://msnotifications.dev",
        "stage" => "http://msnotifications.stage",
        "production" => "http://msnotifications"
    ],
    "middleware" => [
        "web"
        // Añadir middleware de session si utilizas uno diferente a web
    ]
];
```
3. Añadir a la session el Sharp id al momento del usuario realizar login
```
$request->session()->put('sharp_id', <sharp_user>);
```
