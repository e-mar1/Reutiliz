<!DOCTYPE html>
<html>
<head>
    <title>Vérification de votre message</title>
</head>
<body>
    <h2>Vérification de votre message</h2>
    
    <p>Bonjour,</p>
    
    <p>Vous avez envoyé un message à {{ $messageDetails['to'] }} avec le sujet : {{ $messageDetails['subject'] }}</p>
    
    <p>Pour confirmer l'envoi de votre message, veuillez cliquer sur le lien ci-dessous :</p>
    
    <p>
        <a href="{{ $verificationUrl }}" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            Confirmer l'envoi du message
        </a>
    </p>
    
    <p>Ce lien expirera dans 24 heures.</p>
    
    <p>Si vous n'avez pas envoyé ce message, vous pouvez ignorer cet email.</p>
    
    <p>Cordialement,<br>L'équipe Reutiliz</p>
</body>
</html> 