<?php
/**
 * nailla-email.php  —  Nailla Prospek Report Emailer
 *
 * Post JSON:  { name, contact, reason, interest, context }
 *
 * Sends via cPanel SMTP (nailla@sixer0-bk.my.id) — no SMTP certificate
 * verification needed when connecting via localhost / server's own hostname.
 * Falls back to PHP mail() if SMTP is unavailable.
 *
 * CONFIG — edit the three $NAILLA_* constants below.
 */

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '0');

header('Content-Type: application/json');
header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit; }

// ─────────────────────────────────────────────────────────
// CONFIG  —  only change these three values
// ─────────────────────────────────────────────────────────
$NAILLA_USER     = 'nailla@sixer0-bk.my.id';   // sender
$NAILLA_PASS     = 'nailla!Email';              // email password
$NAILLA_SMTP     = 'mail.sixer0-bk.my.id';      // SMTP host
$NAILLA_PORT     = 465;                          // implicit TLS
$NAILLA_FROM     = 'nailla@sixer0-bk.my.id';
$NAILLA_FROM_NAME= 'Nailla Bot';

$OWNER_TO        = 'sixer0.bk@gmail.com';       // primary recipient
$OWNER_CC        = 'sixer0.bk@live.com';        // CC
$REPLY_TO        = 'nailla@sixer0-bk.my.id';
$SUBJECT         = '[Nailla] Prospek Baru dari Website Sixer0';
$SUBJECT_DOCS     = '[Nailla] Dokumentasi dari Website Sixer0';
// ─────────────────────────────────────────────────────────

// Read request body
$raw  = file_get_contents('php://input');
$data = is_string($raw) && strlen($raw) > 0 ? json_decode($raw, true) : [];

// ── Normalise ──────────────────────────────────────────
$name       = $data['name']       ?? 'Tidak diketahui';
$contact    = $data['contact']    ?? 'Tidak ada';
$reason     = trim($data['reason'] ?? 'unknown');
$interest   = $data['interest']   ?? 'Umum';
$context    = $data['context']    ?? '';
$attachments= $data['attachments'] ?? [];    // [{name, content_base64}]

if ($reason === '') $reason = 'unknown';

// ── Build plain-text body ─────────────────────────────────
$body  = "Halo Budi,\n\n";
$body .= "Nailla baru saja menerima sinyal prospek baru dari website Sixer0.\n\n";
$body .= str_repeat('─', 40) . "\n";
$body .= "  Nama / Perusahaan : {$name}\n";
$body .= "  Kontak            : {$contact}\n";
$body .= "  Minat             : {$interest}\n";
$body .= "  Alasan (ditulis)   : {$reason}\n";
$body .= str_repeat('─', 40) . "\n\n";

if ($context) {
    $body .= "Konteks percakapan terakhir:\n{$context}\n\n";
}

$body .= "— Nailla (auto-report)\n";
$body .= "  " . date('Y-m-d H:i:s T') . "\n";

// ── Build MIME headers ────────────────────────────────────
$subject = ($attachments ? $SUBJECT_DOCS : $SUBJECT);
$altBoundary = '=ALT=' . md5((string)time());
$boundary    = '=NM='  . md5((string)time());

if ($attachments) {
    // multipart/mixed  → first sub-part is the message (alternative text+html)
    $eol     = "\r\n";
    $headers = [
        "From: {$NAILLA_FROM_NAME} <{$NAILLA_FROM}>",
        "To: {$OWNER_TO}",
        "Cc: {$OWNER_CC}",
        "Subject: {$subject}",
        "MIME-Version: 1.0",
        "Content-Type: multipart/mixed; boundary=\"{$boundary}\"",
    ];

    // ── message: multipart/alternative inside ──
    $txtPart  = "--{$boundary}{$eol}";
    $txtPart .= "Content-Type: multipart/alternative; boundary=\"{$altBoundary}\"\r\n\r\n";
    $txtPart .= "--{$altBoundary}{$eol}";
    $txtPart .= "Content-Type: text/plain; charset=utf-8\r\n\r\n{$body}{$eol}{$eol}";

    $htmlBody = nl2br(htmlspecialchars($body, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8'));
    $txtPart .= "--{$altBoundary}{$eol}";
    $txtPart .= "Content-Type: text/html; charset=utf-8\r\n\r\n{$htmlBody}{$eol}{$eol}";
    $txtPart .= "--{$altBoundary}--{$eol}{$eol}";

    // ── attachment parts ──
    foreach ($attachments as $att) {
        $fname = $att['name'] ?? 'unnamed';
        $fdata = base64_decode($att['content_base64'] ?? $att['content'] ?? '');
        $fenc  = chunk_split(base64_encode($fdata));
        $fext  = strtolower(pathinfo($fname, PATHINFO_EXTENSION));
        $mime  = $fext === 'md' ? 'text/markdown'
               : (($fext === 'json' || $fext === 'txt') ? 'text/plain'
               : ($fext === 'pdf' ? 'application/pdf'
               : 'application/octet-stream'));

        if ($fext === 'md') $fname .= "; charset=utf-8";
        $txtPart .= "--{$boundary}{$eol}";
        $txtPart .= "Content-Type: {$mime}; name=\"{$fname}\"\r\n";
        $txtPart .= "Content-Transfer-Encoding: base64\r\n";
        $txtPart .= "Content-Disposition: attachment; filename=\"{$fname}\"\r\n\r\n";
        $txtPart .= $fenc . $eol;
    }
    $txtPart .= "--{$boundary}--{$eol}";
    $message = $txtPart;
} else {
    // no attachments — plain multipart/alternative
    $headers = [
        "From: {$NAILLA_FROM_NAME} <{$NAILLA_FROM}>",
        "To: {$OWNER_TO}",
        "Cc: {$OWNER_CC}",
        "Subject: {$subject}",
        "MIME-Version: 1.0",
        "Content-Type: multipart/alternative; boundary=\"{$boundary}\"",
    ];

    $txtPart  = "--{$boundary}\r\n";
    $txtPart .= "Content-Type: text/plain; charset=utf-8\r\n\r\n{$body}\r\n\r\n";

    $htmlBody = nl2br(htmlspecialchars($body, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8'));
    $htmlPart = "--{$boundary}\r\n";
    $htmlPart .= "Content-Type: text/html; charset=utf-8\r\n\r\n{$htmlBody}\r\n\r\n";
    $message  = $txtPart . $htmlPart . "--{$boundary}--\r\n";
}

// ── SMTP send ─────────────────────────────────────────────
function smtpSend(string $host, int $port, string $user, string $pass, string $from, string $to, string $cc, string $subject, string $msg, array $hdrs, bool $debug = false): array
{
    $errno = $errstr = 0;
    $proto = ($port === 465) ? 'ssl://' : 'tcp://';
    $fp = @fsockopen($proto.$host, $port, $errno, $errstr, 15);
    if (!is_resource($fp)) {
        return ['ok'=>false, 'error'=>"Cannot connect to {$host}:{$port} ({$proto}) — $errstr ($errno)"];
    }
    stream_set_blocking($fp, true);
    stream_set_timeout($fp, 30);

    $rd = function() use ($fp, $debug) {
        $line = fgets($fp);
        if ($debug) error_log("[SMTP] << {$line}");
        return $line;
    };
    $wr = function(string $cmd) use ($fp, $debug) {
        fwrite($fp, $cmd."\r\n");
        if ($debug) error_log("[SMTP] >> {$cmd}");
    };

    $rd();                    // initial server greet (220)
    $wr("EHLO ".(gethostname() ?: 'nailla.local'));
    while (substr(trim($rd()), 3, 1) !== ' ') {}   // read multi-line 250

    // Upgrade to TLS only when using a plaintext connection (port 587)
    // Port 465 uses implicit SSL — already encrypted, no STARTTLS needed.
    if ($port !== 465) {
        $wr("STARTTLS");          $rd();                // 220 Ready to start TLS
        stream_socket_enable_crypto($fp, STREAM_CRYPTO_METHOD_TLS_CLIENT);
        $wr("EHLO ".(gethostname() ?: 'nailla.local'));
        while (substr(trim($rd()), 3, 1) !== ' ') {}   // re-identify after TLS
    }

    $wr("AUTH LOGIN");
    $rd();                    // 334 VXNlcm5hbWU6
    $wr(base64_encode($user)); $rd();   // 334 UGFzc3dvcmQ6
    $wr(base64_encode($pass)); $rd();   // 235 Authenticated

    $wr("MAIL FROM:<{$from}>");     $rd();
    $wr("RCPT TO:<{$to}>");         $rd();
    $wr("RCPT TO:<{$cc}>");         $rd();
    $wr("DATA");                     $rd();  // 354 Start mail
    $fullMsg = implode("\r\n", $hdrs) . "\r\n\r\n" . $msg;
    fwrite($fp, $fullMsg."\r\n.\r\n");  $rd();  // 250 Queued

    $wr("QUIT");   $rd();
    fclose($fp);
    return ['ok'=>true];
}

// ── Attempt delivery ──────────────────────────────────────
$delivered = false;
$sendError = '';
$method    = 'none';

// 1) SMTP via cPanel host
if (!empty($NAILLA_USER) && !empty($NAILLA_PASS) && !empty($NAILLA_SMTP)) {
    $result = smtpSend($NAILLA_SMTP, $NAILLA_PORT, $NAILLA_USER, $NAILLA_PASS,
                       $NAILLA_FROM, $OWNER_TO, $OWNER_CC, $subject, $message, $headers);
    if ($result['ok']) { $delivered = true; $method = 'cpanel-smtp'; }
    else               { $sendError = $result['error']; }
}

// 2) Fall back to PHP mail()
if (!$delivered && function_exists('mail')) {
    @mail($OWNER_TO, $subject, $attachments ? $body : $body, $headers);
    $delivered = true; $method = 'php-mail';
}

// ── Response ──────────────────────────────────────────────
http_response_code($delivered ? 200 : 500);
echo json_encode([
    'ok'              => $delivered,
    'to'              => $OWNER_TO,
    'cc'              => $OWNER_CC,
    'subject'         => $subject,
    'name'            => $name,
    'contact'         => $contact,
    'reason'          => $reason,
    'interest'        => $interest,
    'timestamp'       => gmdate('c'),
    'error'           => $delivered ? null : ($sendError ?: 'All delivery methods failed'),
    'delivery_method' => $method,
    'doc'            => $attachments ? count($attachments) : 0,
], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
