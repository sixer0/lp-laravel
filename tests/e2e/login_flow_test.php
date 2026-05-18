<?php
/**
 * Integration Test: Admin Login Flow
 * 
 * This script verifies that the admin login process works correctly, 
 * including CSRF token handling, credentials validation, and redirection.
 */

// Configuration
$baseUrl = "http://127.0.0.1:8000";
$loginUrl = "$baseUrl/admin/login";
$dashboardUrl = "$baseUrl/admin";
$cookieFile = __DIR__ . '/../../cookie.txt';
$loginResponseFile = __DIR__ . '/../../login_response.html';
$dashboardResponseFile = __DIR__ . '/../../dashboard_response.html';

// Cleanup previous runs
if (file_exists($cookieFile)) @unlink($cookieFile);
if (file_exists($loginResponseFile)) @unlink($loginResponseFile);
if (file_exists($dashboardResponseFile)) @unlink($dashboardResponseFile);

echo "Starting Integration Test: Admin Login Flow...\n";
echo "----------------------------------------------\n";

// Initialize cURL session
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);

// 1. Get Login Page & CSRF Token
echo "[1/3] Fetching login page and CSRF token... ";
curl_setopt($ch, CURLOPT_URL, $loginUrl);
$loginPage = curl_exec($ch);

if (curl_errno($ch)) {
    echo "FAILED: " . curl_error($ch) . "\n";
    exit(1);
}

if (preg_match('/name="_token"\s+value="([^"]+)"/', $loginPage, $matches) || 
    preg_match('/value="([^"]+)"\s+name="_token"/', $loginPage, $matches)) {
    $csrfToken = $matches[1];
    echo "SUCCESS (Token: $csrfToken)\n";
} else {
    echo "FAILED: CSRF token not found in page content.\n";
    exit(1);
}

// 2. Execute Login POST
echo "[2/3] Submitting login credentials... ";
$loginData = [
    '_token' => $csrfToken,
    'username' => 'Sixer0',
    'password' => '123Bukapintu#'
];

curl_setopt($ch, CURLOPT_URL, $loginUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($loginData));

$loginResponse = curl_exec($ch);
$loginHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    echo "FAILED: " . curl_error($ch) . "\n";
    exit(1);
}

file_put_contents($loginResponseFile, $loginResponse);
echo "SUCCESS (Status: $loginHttpCode)\n";

// 3. Verify Dashboard Access
echo "[3/3] Verifying dashboard access... ";
curl_setopt($ch, CURLOPT_URL, $dashboardUrl);
curl_setopt($ch, CURLOPT_POST, false);
$dashboardResponse = curl_exec($ch);
$dashboardHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    echo "FAILED: " . curl_error($ch) . "\n";
    exit(1);
}

file_put_contents($dashboardResponseFile, $dashboardResponse);
echo "SUCCESS (Status: $dashboardHttpCode)\n";

echo "----------------------------------------------\n";

// Final Assessment
$passed = true;

if ($loginHttpCode >= 400) {
    echo "❌ TEST FAILED: Login POST returned error status $loginHttpCode.\n";
    $passed = false;
}

if ($dashboardHttpCode !== 200) {
    echo "❌ TEST FAILED: Dashboard GET returned status $dashboardHttpCode (Expected 200).\n";
    $passed = false;
}

// Check if dashboard contains expected admin content
if ($passed && strpos($dashboardResponse, 'Sixer0 Admin') === false) {
    echo "❌ TEST FAILED: Dashboard response does not contain admin user info.\n";
    $passed = false;
}

if ($passed) {
    echo "✅ ALL TESTS PASSED: Admin login flow is fully functional.\n";
    exit(0);
} else {
    echo "❌ TEST FAILED: One or more steps failed.\n";
    exit(1);
}
