<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
file_put_contents(__DIR__ . '/_sodium_test_tr.txt', "HASHING_TEST\n");
file_put_contents(__DIR__ . '/_sodium_key.secret', '');

// Test password hashing mechanisms available
$results = [];
$results[] = 'SODIUM: ' . (extension_loaded('sodium') ? 'OK' : 'MISSING');
$results[] = 'HASH_ALGO: ' . (defined('PASSWORD_DEFAULT') ? PASSWORD_DEFAULT : 'undefined');
$results[] = 'PASSWORD_DEFAULT=Bcrypt: ' . (PASSWORD_DEFAULT === PASSWORD_BCRYPT ? 'YES' : 'NO');

// Test bcrypt hash generation
$tests = ['123Bukapintu#', 'akunbypass', 'admin'];
foreach ($tests as $pw) {
    $h = password_hash($pw, PASSWORD_DEFAULT);
    $verify = password_verify($pw, $h);
    $results[] = "HASH($pw) -> $h, verify=$verify";
}

// Generate the admin hash
$admin_pw = '123Bukapintu#';
$admin_hash = password_hash($admin_pw, PASSWORD_DEFAULT);
$admin_verify = password_verify($admin_pw, $admin_hash);
$results[] = "ADMIN HASH: $admin_hash, verify=$admin_verify";

// Store for retrieval
file_put_contents(
    __DIR__ . '/_sodium_key.secret',
    "PW=$admin_pw\nHASH=$admin_hash\n"
);
file_put_contents(__DIR__ . '/_sodium_test_tr.txt', implode("\n", $results) . "\n");
