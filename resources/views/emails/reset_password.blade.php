<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de Recuperación de Contraseña</title>
</head>
<body>
    <h1>Recuperación de Contraseña</h1>
    <p>Hola,</p>
    <p>Para recuperar tu contraseña, utiliza el siguiente código:</p>
    <h2>{{ $code }}</h2>
    <p>Si no solicitaste este cambio, puedes ignorar este mensaje.</p>
    <p>Gracias, el equipo de {{ config('app.name') }}</p>
</body>
</html>
