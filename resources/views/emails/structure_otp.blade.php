<!DOCTYPE html>
<html>
<head>
    <title>Bienvenue sur ONPC</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px;">
        <h2 style="color: #0000cc;">Bienvenue sur le Portail ONPC</h2>
        <p>Bonjour <strong>{{ $structure->nom }}</strong>,</p>
        <p>Votre structure a été enregistrée avec succès par l'administration de l'ONPC.</p>
        <p>Pour finaliser la configuration de votre compte et définir votre mot de passe, veuillez utiliser le code OTP ci-dessous :</p>
        
        <div style="background-color: #f8fafc; padding: 30px; text-align: center; border-radius: 15px; margin: 25px 0; border: 1px dashed #cbd5e1;">
            <p style="margin-bottom: 10px; font-size: 12px; color: #64748b; font-weight: bold; uppercase; letter-spacing: 1px;">Votre code de validation (OTP)</p>
            <span style="font-size: 42px; font-weight: 900; letter-spacing: 8px; color: #0000cc;">{{ $otp }}</span>
        </div>

        <div style="text-align: center; margin: 35px 0;">
            <p style="font-size: 14px; color: #475569; margin-bottom: 20px;">Cliquez sur le bouton ci-dessous pour configurer votre mot de passe :</p>
            <a href="{{ route('structure.auth.setup', ['email' => $structure->email]) }}" style="background-color: #0000cc; color: #ffffff; padding: 18px 35px; text-decoration: none; border-radius: 12px; font-weight: 800; text-transform: uppercase; font-size: 13px; display: inline-block; box-shadow: 0 10px 20px rgba(0,0,204,0.15);">Configurer mon compte</a>
        </div>

        <div style="background-color: #fff7ed; padding: 15px; border-radius: 10px; border-left: 4px solid #ff8300; margin-bottom: 25px;">
            <p style="font-size: 13px; color: #9a3412; margin: 0;"><strong>Note :</strong> Une fois votre mot de passe défini, vous pourrez vous connecter à tout moment sur votre portail à cette adresse : <br>
            <a href="{{ route('structure.auth.login') }}" style="color: #0000cc; font-weight: bold;">{{ route('structure.auth.login') }}</a></p>
        </div>

        <p style="font-size: 14px; color: #64748b;">Ce code est confidentiel et expirera bientôt. Pour toute assistance, contactez le support ONPC.</p>
        
        <p>Si vous n'êtes pas à l'origine de cette demande, veuillez ignorer ce mail.</p>
        
        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 12px; color: #888;">© {{ date('Y') }} ONPC - Protection Civile. Tous droits réservés.</p>
    </div>
</body>
</html>
