<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #fef2f2; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 40px rgba(220, 38, 38, 0.1); border: 1px solid #fee2e2; }
        .header { background: #dc2626; padding: 40px; text-align: center; }
        .content { padding: 40px; text-align: center; }
        .footer { background: #fef2f2; padding: 25px; text-align: center; font-size: 11px; color: #991b1b; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
        .otp-box { background: #fff1f2; border: 2px dashed #dc2626; border-radius: 20px; padding: 35px; margin: 30px 0; display: inline-block; }
        .otp-code { font-size: 48px; font-weight: 900; color: #dc2626; letter-spacing: 12px; margin: 0; line-height: 1; }
        h1 { margin: 0; color: white; font-size: 22px; text-transform: uppercase; letter-spacing: 3px; font-weight: 900; }
        h2 { color: #111827; margin-top: 0; font-size: 24px; font-weight: 800; }
        p { line-height: 1.6; color: #4b5563; font-size: 15px; }
        .divider { height: 1px; background: #fee2e2; margin: 30px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>ONPC CASERNE</h1>
        </div>
        <div class="content">
            <h2>Code de Sécurité</h2>
            <p>Bonjour,</p>
            <p>Une demande de réinitialisation de mot de passe a été initiée pour votre compte <strong>Caserne/Groupe</strong> sur le portail ONPC.</p>
            
            <div class="otp-box">
                <div class="otp-code">{{ $otp }}</div>
            </div>
            
            <p style="font-weight: bold; color: #dc2626;">Saisissez ce code sur la page de vérification pour continuer.</p>
            
            <div class="divider"></div>
            
            <p style="font-size: 13px; color: #9ca3af;">Si vous n'êtes pas à l'origine de cette demande, veuillez ignorer cet email. Votre mot de passe actuel restera inchangé.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Office National de la Protection Civile - Côte d'Ivoire
        </div>
    </div>
</body>
</html>
