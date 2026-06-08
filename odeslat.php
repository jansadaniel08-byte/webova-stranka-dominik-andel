<?php
/**
 * PHP skript pro zpracování poptávkového formuláře webu Dominik Anděl
 * Bezpečné zpracování dat, ochrana proti spamu a odeslání HTML e-mailu
 */

// Nastavení cílového e-mailu, kam mají poptávky chodit
define('CILOVY_EMAIL', 'info@dominikandel.cz'); // <-- ZDE ZADEJ SVŮJ E-MAIL

// Nastavení hlaviček pro JSON odpověď
header('Content-Type: application/json; charset=utf-8');

// Kontrola, zda se jedná o POST požadavek
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Metoda odeslání není povolena.']);
    exit;
}

// Ochrana proti spamu - Honeypot (skryté pole z formuláře, které běžný uživatel nevidí, ale robot ho vyplní)
if (!empty($_POST['anti_spam_trap'])) {
    // Robot vyplnil skryté pole, tiše ignorujeme nebo vrátíme úspěch, aby si myslel, že uspěl
    echo json_encode(['success' => true, 'message' => 'Poptávka byla zpracována.']);
    exit;
}

// Získání a vyčištění dat z formuláře
$jmeno = isset($_POST['jmeno']) ? trim(strip_tags($_POST['jmeno'])) : '';
$telefon = isset($_POST['telefon']) ? trim(strip_tags($_POST['telefon'])) : '';
$email = isset($_POST['email']) ? trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)) : '';
$zprava = isset($_POST['zprava']) ? trim(strip_tags($_POST['zprava'])) : '';
$gdpr = isset($_POST['gdpr']) ? true : false;

// Základní validace povinných polí
if (empty($jmeno) || empty($telefon) || empty($zprava)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Prosím vyplňte všechna povinná pole (Jméno, Telefon a Zprávu).']);
    exit;
}

if (!$gdpr) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Pro odeslání poptávky musíte souhlasit se zpracováním osobních údajů.']);
    exit;
}

// Sestavení předmětu e-mailu
$predmet = "Nová poptávka z webu od: " . $jmeno;

// Sestavení HTML obsahu e-mailu pro přehledný vzhled ve schránce řemeslníka
$html_zprava = "
<html>
<head>
    <title>Nová poptávka z webu</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #1e293b; line-height: 1.6; background-color: #f8fafc; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border: 1px solid #e2e8f0; overflow: hidden; }
        .header { bg-color: #1e293b; background: #1e293b; color: #ffffff; padding: 30px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; letter-spacing: -0.5px; }
        .header p { margin: 5px 0 0; color: #d97706; font-size: 14px; font-weight: bold; text-transform: uppercase; }
        .content { padding: 30px; }
        .field { margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px; }
        .field-title { font-size: 12px; text-transform: uppercase; color: #64748b; font-weight: bold; margin-bottom: 5px; }
        .field-value { font-size: 16px; color: #0f172a; font-weight: 500; }
        .field-value.message { white-space: pre-line; background-color: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid #f1f5f9; color: #334155; }
        .footer { background-color: #f1f5f9; padding: 15px; text-align: center; font-size: 12px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h1>Nová poptávka služeb</h1>
            <p>Dominik Anděl - Stavební & malířské práce</p>
        </div>
        <div class='content'>
            <div class='field'>
                <div class='field-title'>Jméno zákazníka</div>
                <div class='field-value'>{$jmeno}</div>
            </div>
            <div class='field'>
                <div class='field-title'>Telefonní číslo</div>
                <div class='field-value'><a href='tel:{$telefon}' style='color: #d97706; text-decoration: none; font-weight: bold;'>{$telefon}</a></div>
            </div>
            <div class='field'>
                <div class='field-title'>E-mailová adresa</div>
                <div class='field-value'>" . ($email ? "<a href='mailto:{$email}' style='color: #1e293b;'>{$email}</a>" : "Nebylo zadáno") . "</div>
            </div>
            <div class='field' style='border-bottom: none;'>
                <div class='field-title'>Požadované práce / Zpráva</div>
                <div class='field-value message'>{$zprava}</div>
            </div>
        </div>
        <div class='footer'>
            Tento e-mail byl automaticky odeslán z poptávkového formuláře na webu dominikandel.cz.
        </div>
    </div>
</body>
</html>
";

// Nastavení e-mailových hlaviček pro HTML formát a správné kódování
$headers = [];
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=utf-8';

// Nastavení odesílatele (ideálně na doméně webu, aby e-mail nespadl do spamu)
$domena = $_SERVER['SERVER_NAME'];
$headers[] = "From: Web Dominik Andel <no-reply@{$domena}>";

// Pokud zákazník vyplnil e-mail, nastavíme "Reply-To", aby šlo na mail odpovědět přímo v poště
if (!empty($email)) {
    $headers[] = "Reply-To: {$jmeno} <{$email}>";
}

// Odeslání e-mailu přes standardní PHP mailer
$odeslano = mail(CILOVY_EMAIL, $predmet, $html_zprava, implode("\r\n", $headers));

if ($odeslano) {
    echo json_encode([
        'success' => true,
        'message' => 'Vaše poptávka byla úspěšně odeslána. Brzy se vám ozveme.'
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Omlouváme se, ale při odesílání e-mailu na našem serveru došlo k chybě. Prosím, kontaktujte nás telefonicky.'
    ]);
}
exit;
?>
