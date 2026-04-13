<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { text-align: center; margin-bottom: 30px; }
        .btn { display: inline-block; padding: 12px 24px; background-color: #5d87ff; color: #fff; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .footer { margin-top: 30px; font-size: 12px; color: #777; border-top: 1px solid #eee; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>¡Hola, {{ $user->name }}!</h2>
        </div>
        
        <p>Has sido invitado a colaborar en la tienda <strong>{{ $store->name }}</strong> en el sistema de Feria.</p>
        
        @if($tempPassword)
            <p>Se ha creado una cuenta para ti. Aquí tienes tus credenciales de acceso:</p>
            <ul>
                <li><strong>Email:</strong> {{ $user->email }}</li>
                <li><strong>Contraseña temporal:</strong> {{ $tempPassword }}</li>
            </ul>
            <p>Por favor, cambia tu contraseña una vez que hayas ingresado.</p>
        @else
            <p>Puedes acceder con tu cuenta habitual de {{ $user->email }}.</p>
        @endif
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ config('app.url') }}" class="btn">Acceder al Sistema</a>
        </div>
        
        <p>¡Gracias por sumarte!</p>
        
        <div class="footer">
            Este es un correo automático, por favor no respondas a este mensaje.
        </div>
    </div>
</body>
</html>
