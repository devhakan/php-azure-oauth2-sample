<?php
// Oturum başlatma ve gerekli dosyaları dahil etme
session_start();
require_once __DIR__ . '/vendor/autoload.php';

// .env dosyasından çevre değişkenlerini yükleme
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Azure AD kimlik doğrulama için gerekli bilgileri al
$tenant = $_ENV['AZURE_AD_TENANT_ID'];
$client_id = $_ENV['AZURE_AD_CLIENT_ID'];
$client_secret = $_ENV['AZURE_AD_CLIENT_SECRET'];
$redirect_uri = $_ENV['REDIRECT_URI'];

// İzin verilen domainleri al
$allowed_domains = explode(',', $_ENV['ALLOWED_DOMAINS']);

// Yetkilendirme kodunu kontrol et
if (!isset($_GET['code'])) {
    die('Yetkilendirme kodu eksik');
}

// Token almak için POST isteği gönder
$token_url = sprintf(
    'https://login.microsoftonline.com/%s/oauth2/v2.0/token',
    $tenant
);

$token_data = [
    'grant_type' => 'authorization_code',
    'client_id' => $client_id,
    'client_secret' => $client_secret,
    'code' => $_GET['code'],
    'redirect_uri' => $redirect_uri,
    'scope' => 'User.Read offline_access'
];

$ch = curl_init($token_url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($token_data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$token_response = json_decode(curl_exec($ch), true);
curl_close($ch);

if (!isset($token_response['access_token'])) {
    die('Erişim tokeni alınamadı');
}

// Microsoft Graph API istemcisini oluştur
$graph = new Microsoft\Graph\Graph();
$graph->setAccessToken($token_response['access_token']);

try {
    // Kullanıcı bilgilerini Microsoft Graph API'den al
    $user = $graph->createRequest('GET', '/me')
        ->setReturnType(Microsoft\Graph\Model\User::class)
        ->execute();

    // Kullanıcının email adresini kontrol et
    $email = $user->getMail();
    $domain = substr(strrchr($email, "@"), 1);
    
    // Domain kontrolü
    if (!in_array($domain, $allowed_domains)) {
        session_destroy();
        die('Erişim reddedildi: Sadece belirlenen alan adlarından hesaplara izin verilmektedir.');
    }

    // Kullanıcı bilgilerini oturuma kaydet
    $_SESSION['user'] = [
        'name' => $user->getDisplayName(),
        'email' => $email
    ];

    // Kullanıcıyı karşılama sayfasına yönlendir
    header('Location: welcome.php');
    exit;
} catch (Exception $e) {
    die('Kullanıcı bilgileri alınırken hata oluştu: ' . $e->getMessage());
}