<?php
/**
 * Zpracovani poptavkoveho formulare pro bezny PHP hosting.
 */

declare(strict_types=1);

const CILOVY_EMAIL = 'info@dominikandel.cz';
const ODESILATEL_EMAIL = 'no-reply@dominikandel.cz';

header('Content-Type: application/json; charset=utf-8');

function json_response(bool $success, string $message, int $status = 200): void
{
    http_response_code($status);
    echo json_encode([
        'success' => $success,
        'message' => $message,
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(false, 'Metoda odeslání není povolena.', 405);
}

if (!empty($_POST['anti_spam_trap'] ?? '')) {
    json_response(true, 'Poptávka byla zpracována.');
}

$jmeno = trim(strip_tags((string) ($_POST['jmeno'] ?? '')));
$telefon = trim(strip_tags((string) ($_POST['telefon'] ?? '')));
$email = trim((string) ($_POST['email'] ?? ''));
$zprava = trim(strip_tags((string) ($_POST['zprava'] ?? '')));
$gdpr = isset($_POST['gdpr']);

if ($jmeno === '' || $telefon === '' || $zprava === '') {
    json_response(false, 'Prosím vyplňte všechna povinná pole (jméno, telefon a zprávu).', 400);
}

if (!$gdpr) {
    json_response(false, 'Pro odeslání poptávky musíte souhlasit se zpracováním osobních údajů.', 400);
}

if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    json_response(false, 'Zadaná e-mailová adresa nemá platný formát.', 400);
}

$safeJmeno = htmlspecialchars($jmeno, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$safeTelefon = htmlspecialchars($telefon, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$safeEmail = htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$safeZprava = nl2br(htmlspecialchars($zprava, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'));

$predmet = 'Nová poptávka z webu od: ' . $jmeno;
$encodedPredmet = '=?UTF-8?B?' . base64_encode($predmet) . '?=';

$htmlZprava = <<<HTML
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Nová poptávka z webu</title>
</head>
<body style="font-family: Arial, sans-serif; color: #1e293b; line-height: 1.6; background-color: #f8fafc; padding: 20px;">
    <div style="max-width: 640px; margin: 0 auto; background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden;">
        <div style="background-color: #1e293b; color: #ffffff; padding: 24px;">
            <h1 style="margin: 0; font-size: 24px;">Nová poptávka služeb</h1>
            <p style="margin: 6px 0 0; color: #f59e0b; font-weight: bold;">Dominik Anděl - stavební a malířské práce</p>
        </div>
        <div style="padding: 24px;">
            <p><strong>Jméno:</strong><br>{$safeJmeno}</p>
            <p><strong>Telefon:</strong><br><a href="tel:{$safeTelefon}" style="color: #d97706;">{$safeTelefon}</a></p>
            <p><strong>E-mail:</strong><br>{$safeEmail}</p>
            <p><strong>Požadované práce / zpráva:</strong><br>{$safeZprava}</p>
        </div>
    </div>
</body>
</html>
HTML;

$headers = [
    'MIME-Version: 1.0',
    'Content-Type: text/html; charset=UTF-8',
    'From: Web Dominik Andel <' . ODESILATEL_EMAIL . '>',
];

if ($email !== '') {
    $headers[] = 'Reply-To: <' . $email . '>';
}

$odeslano = mail(CILOVY_EMAIL, $encodedPredmet, $htmlZprava, implode("\r\n", $headers));

if (!$odeslano) {
    json_response(false, 'Omlouváme se, při odesílání e-mailu došlo k chybě. Prosím, kontaktujte nás telefonicky.', 500);
}

json_response(true, 'Vaše poptávka byla úspěšně odeslána. Brzy se vám ozveme.');
