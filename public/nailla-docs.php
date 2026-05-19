<?php

header('Content-Type: application/json');

// ── Constants ──────────────────────────────────────────────
const NA_USER  = 'nailla@sixer0-bk.my.id';
const NA_PASS  = 'nailla!Email';
const NA_FROM  = 'nailla@sixer0-bk.my.id';
const OWNER_TO = 'sixer0.bk@gmail.com';
const OWNER_CC = 'sixer0.bk@live.com';

// ── Input ──────────────────────────────────────────────────
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

$atts = $data['attachments'] ?? [];
$name = strtolower($data['sender_name'] ?? 'Visitor');
$email = $data['sender_email'] ?? '';
$msg   = $data['message'] ?? '';

$n      = is_array($atts) ? count($atts) : 0;
$attach_str = $n > 0 ? " ({$n} lampiran)" : '';

// Subject prefix ringsan acts like human send
$subj = $name . ' — Pesan dari website' . $attach_str;

// plain-text body yang consisten
$eol   = "\r\n";
$lines = [];
$lines[] = "Halo Budi,";
$lines[] = "";
$lines[] = "Saya $name baru saja mengirim pesan melalui website landing.";
$lines[] = "";
if ($email)  $lines[] = "Email  : $email";
if ($msg)    $lines[] = "Pesan : " . str_replace("\n", ' ', wordwrap($msg, 72));
$lines[] = "";
$lines[] = "Nailla mengirim pesan ini otomatis sebagai notifikasi.";
$lines[] = gmdate('d M Y H:i') . ' T';
$lines[] = "";
$lines[] = "Nailla";
$body = implode($eol, $lines);

// Minimal MIME headers (no attachments in roleplay — roleplay calls omit att key)
$mime  = "Content-Type: text/plain; charset=utf-8" . $eol;
$mime .= "Content-Transfer-Encoding: 8bit" . $eol;

// ── SMTP: STARTTLS + AUTH PLAIN ────────────────────────────
function smtpSend(string $host, int $port, string $user, string $pw,
                  string $from, string $to, string $cc, string $subj,
                  string $body, string $mime): array
{
    $fp = @fsockopen('tcp://' . $host, $port, $errno, $errstr, 15);
    if (!is_resource($fp)) {
        return ['ok' => false, 'error' => "connect: {$errstr} ({$errno})"];
    }
    stream_set_blocking($fp, true);
    stream_set_timeout($fp, 30);
    define('D', __DIR__);

    function L($t, $m) { file_put_contents(D . '/NV28.log', "$t: $m\n", FILE_APPEND); }
    function R($tag, $tmo = 5) {
        stream_set_timeout($GLOBALS['fp'], $tmo);
        $line = rtrim(fgets($GLOBALS['fp']) ?: '[timeout]');
        $line = rtrim($line, "\r\n");
        L($tag, substr($line, 0, 80));
        return $line;
    }
    function W($c) { fwrite($GLOBALS['fp'], $c . "\r\n"); L('WR', substr($c, 0, 50) . " ..."); }

    $GLOBALS['fp'] = $fp;

    L('START', '');
    R('BAN');               // 220

    W('EHLO nailla');      R('EH1a');
    for ($i = 1; $i < 30; $i++) {
        $ln = R("EH1b$i");
        if (strlen($ln) < 3 || strncmp($ln, '250', 3) !== 0 || $ln[3] !== '-') break;
    }

    // Flush leftover EHLO/anti-spam bytes
    for ($j = 1; $j <= 5; $j++) {
        stream_set_timeout($fp, 2);
        $buf = fread($fp, 65536);
        if ($buf === false || $buf === '') break;
        $final = false;
        foreach (explode("\n", rtrim($buf)) as $chunk) {
            if (strlen($chunk) >= 3 && strncmp($chunk, '250', 3) === 0
                && (strlen($chunk) < 4 || $chunk[3] !== '-')) { $final = true; break; }
        }
        if ($final) break;
    }

    W('STARTTLS');
    if (strncmp(R('STT', 10), '220', 3) !== 0) {
        fclose($fp);
        return ['ok' => false, 'error' => 'no TLS'];
    }
    try { stream_socket_enable_crypto($fp, true, STREAM_CRYPTO_METHOD_TLS_CLIENT); }
    catch (Throwable $ex) {
        fclose($fp);
        return ['ok' => false, 'error' => $ex->getMessage()];
    }
    L('TLS', 'up');

    for ($j = 1; $j <= 4; $j++) { $fl = R("TLSF$j", 1); if (strlen($fl) < 3 || strncmp($fl,'250',3)!==0 || $fl[3]!=='-') break; }

    W('EHLO nailla'); R('EH2a');
    for ($i = 1; $i < 30; $i++) {
        $ln = R("EH2b$i");
        if (strlen($ln) < 3 || strncmp($ln, '250', 3) !== 0 || $ln[3] !== '-') break;
    }

    $creds = base64_encode(chr(0) . $user . chr(0) . $pw);
    W('AUTH PLAIN ' . $creds); $ar = R('AUTH');
    if (strncmp($ar, '235', 3) !== 0) {
        fclose($fp);
        return ['ok' => false, 'error' => "AUTH: {$ar}"];
    }

    W('MAIL FROM:<' . $from . '>'); R('MF', 10);
    W('RCPT TO:<' . $to . '>');     R('RT', 10);
    W('RCPT TO:<' . $cc . '>');     R('RC', 10);
    W('DATA');                       R('DAT', 10);

    // ── Body + clean dot terminator (dot-stuffed, always on own line) ──
    $fwrite = fn($s) => fwrite($fp, $s);
    $fwrite('Subject: ' . $subj . $eol);
    $fwrite('From: Nailla <' . $from . '>' . $eol);
    $fwrite('To: ' . $to . $eol);
    $fwrite('Cc: ' . $cc . $eol);
    $fwrite($mime . $eol);           // blank line after MIME headers
    $fwrite($body . $eol);           // body ends with trailing newline
    $fwrite('.' . $eol);             // DOT — standalone line

    $dot = R('DOT', 15);
    L('DOT', $dot);
    W('QUIT'); R('QT', 5); fclose($fp);

    return ['ok' => strncmp(trim($dot), '250', 3) === 0, 'reply' => $dot];
}

// ── Execute ────────────────────────────────────────────────
$res = smtpSend('mail.sixer0-bk.my.id', 587,
    NA_USER, NA_PASS, NA_FROM, OWNER_TO, OWNER_CC,
    $subj, $body, $mime);

echo json_encode($res, JSON_PRETTY_PRINT);
