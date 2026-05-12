<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f9; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; mx-auto; margin: 40px auto; background: #fff; border-radius: 20px; overflow: hidden; shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #eef2f5; }
        .header { background: #0000cc; padding: 40px; text-align: center; }
        .content { padding: 40px; text-align: center; }
        .footer { background: #f9fafb; padding: 20px; text-align: center; font-size: 12px; color: #9ca3af; }
        .otp-box { background: #f0f7ff; border: 2px dashed #0000cc; border-radius: 15px; padding: 30px; margin: 30px 0; display: inline-block; }
        .otp-code { font-size: 42px; font-weight: 900; color: #0000cc; letter-spacing: 10px; margin: 0; }
        .button { background: #ff8300; color: white; padding: 15px 30px; text-decoration: none; border-radius: 12px; font-weight: bold; display: inline-block; margin-top: 20px; }
        h1 { margin: 0; color: white; font-size: 24px; text-transform: uppercase; letter-spacing: 2px; }
        p { line-height: 1.6; color: #4b5563; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>ONPC SÉCURITÉ</h1>
        </div>
        <div class="content">
            <h2 style="color: #111827; margin-top: 0;">Code de vérification</h2>
            <p>Bonjour, vous avez demandé la réinitialisation de votre mot de passe pour votre espace partenaire ONPC.</p>
            <p>Veuillez utiliser le code ci-dessous pour valider votre identité :</p>
            
            <div class="otp-box">
                <div class="otp-code">{{ $otp }}</div>
            </div>
            
            <p style="font-size: 14px; color: #6b7280;">Ce code est confidentiel et expirera bientôt. Ne le partagez avec personne.</p>
            
            <p>Si vous n'avez pas demandé ce code, vous pouvez ignorer cet email en toute sécurité.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Office National de la Protection Civile. Tous droits réservés.
        </div>
    </div>
</body>
</html>
