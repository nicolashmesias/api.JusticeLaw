<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de Restablecimiento</title>
    <style>
        /* Estilos del correo */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .code {
            font-size: 24px;
            font-weight: bold;
            color: #444;
            text-align: center;
            padding: 10px;
            border: 1px dashed #ddd;
            margin: 20px 0;
        }
        .footer {
            font-size: 12px;
            color: #aaa;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Restablecimiento de Contraseña</h1>
        <p>Hola,</p>
        <p>Recibimos una solicitud para restablecer la contraseña de tu cuenta.</p>
        <p>Tu código de verificación es:</p>
        <div class="code">{{ $resetCode }}</div>
        <p>Si no realizaste esta solicitud, ignora este correo.</p>
        <p>Gracias,</p>
        <p><strong>El equipo de Justice Law</strong></p>
        <div class="footer">
            Este correo es generado automáticamente. Por favor, no respondas.
        </div>
    </div>
</body>
</html>
