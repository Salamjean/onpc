<!DOCTYPE html>
<html>

<head>
    <title>Activation de votre compte Groupe ONPC</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f3f4f6; margin: 0; padding: 20px;">
    <div
        style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <div style="background-color: #0000cc; padding: 20px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0; font-size: 24px;">Bienvenue sur ONPC</h1>
        </div>
        <div style="padding: 30px;">
            <p style="font-size: 16px; color: #374151;">Bonjour <strong>{{ $groupe->name }}</strong>,</p>
            <p style="font-size: 16px; color: #374151;">Votre compte groupe d'intervention a ete cree par votre caserne.
                Pour activer votre acces, vous devez definir votre mot de passe.</p>

            <div style="text-align: center; margin: 30px 0;">
                <p
                    style="font-size: 14px; color: #6b7280; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;">
                    Votre code de verification (OTP)</p>
                <div
                    style="background-color: #f3f4f6; border: 2px dashed #ff8300; display: inline-block; padding: 15px 30px; border-radius: 8px; font-size: 32px; font-weight: bold; color: #0000cc; letter-spacing: 5px;">
                    {{ $otpCode }}
                </div>
            </div>

            <p style="font-size: 16px; color: #374151;">Cliquez sur le bouton ci-dessous pour definir votre mot de passe
                :</p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('caserne.auth.groupe.setup-form', ['email' => $groupe->email]) }}"
                    style="background-color: #ff8300; color: #ffffff; text-decoration: none; padding: 12px 30px; border-radius: 6px; font-weight: bold; font-size: 16px; display: inline-block;">Activer
                    mon compte groupe</a>
            </div>

            <p
                style="font-size: 14px; color: #6b7280; margin-top: 40px; border-top: 1px solid #e5e7eb; padding-top: 14px;">
                Si vous n'etes pas concerne par ce compte, veuillez ignorer cet e-mail.
            </p>
        </div>
    </div>
</body>

</html>
