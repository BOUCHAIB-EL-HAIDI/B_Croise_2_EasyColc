<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f7f6;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .header {
            background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
            color: #ffffff;
            padding: 40px 20px;
            text-align: center;
        }
        .content {
            padding: 40px;
        }
        .footer {
            background: #f9fafb;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
        }
        .btn {
            display: inline-block;
            padding: 16px 32px;
            background-color: #4f46e5;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 12px;
            font-weight: bold;
            margin-top: 20px;
            box-shadow: 0 4px 6px rgba(79, 70, 229, 0.2);
        }
        h1 { margin: 0; font-size: 24px; }
        p { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Proposition de Colocation 🏠</h1>
        </div>
        <div class="content">
            <p>Bonjour,</p>
            <p>Vous avez été invité à rejoindre la colocation <strong>"{{ $invitation->colocation->name }}"</strong> sur EasyColoc.</p>
            <p>EasyColoc vous permet de gérer vos dépenses, vos tâches ménagères et votre calendrier commun en toute simplicité.</p>
            <div style="text-align: center;">
                <a href="{{ route('invitations.show', $invitation->token) }}" class="btn">Rejoindre la colocation</a>
            </div>
            <p style="margin-top: 30px; font-size: 14px; color: #6b7280;">
                Si le bouton ne fonctionne pas, copiez et collez le lien suivant dans votre navigateur :<br>
                {{ route('invitations.show', $invitation->token) }}
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} EasyColoc. Tous droits réservés.
        </div>
    </div>
</body>
</html>
