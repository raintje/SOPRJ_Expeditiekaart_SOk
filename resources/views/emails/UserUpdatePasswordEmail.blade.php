<!DOCTYPE html>
<html>
    <head>
        <title>Gebruiker Gewijzigd</title>
    </head>
    <body>
        <p>Beste {{ $details['name'] }}, </p>
        <br>
        <p> Het wachtwoord van uw account met email: <u>{{ $details['email'] }}</u> is gewijzigd door de beheerder van de Expeditiekaart Voor Bedrijfsovername in de Agrarische sector.</p>
        <br>
        <br>
        <p>Dubbelklik op de zwarte box om uw nieuwe wachtwoord te bekijken: <span style="background-color:black">{{ $details['password'] }}</span></p>
        <br>
        <br>
        <p>Dit is een automatisch gegenereerd bericht en reacties op deze mail worden niet gelezen.</p>
    </body>
</html>
