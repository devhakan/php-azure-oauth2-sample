<?php
// Oturum başlatma ve gerekli dosyaları dahil etme
session_start();
require_once __DIR__ . '/vendor/autoload.php';

// .env dosyasından çevre değişkenlerini yükleme
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Kullanıcı zaten giriş yapmışsa welcome.php'ye yönlendir
if (isset($_SESSION['user'])) {
    header('Location: welcome.php');
    exit;
}

// Azure AD kimlik doğrulama için gerekli bilgileri al
$tenant = $_ENV['AZURE_AD_TENANT_ID'];
$client_id = $_ENV['AZURE_AD_CLIENT_ID'];
$redirect_uri = $_ENV['REDIRECT_URI'];

// Azure AD OAuth2 yetkilendirme URL'sini oluştur
$auth_url = sprintf(
    'https://login.microsoftonline.com/%s/oauth2/v2.0/authorize?client_id=%s&response_type=code&redirect_uri=%s&scope=%s',
    $tenant,
    $client_id,
    urlencode($redirect_uri),
    urlencode('User.Read offline_access')
);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Azure AD Kimlik Doğrulama</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f2f5;
        }
        .login-container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .login-button {
            background-color: #0078d4;
            color: white;
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .login-button:hover {
            background-color: #006abc;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Hoş Geldiniz</h1>
        <p>Lütfen Microsoft hesabınızla giriş yapın</p>
        <a href="<?php echo $auth_url; ?>" class="login-button">Microsoft ile Giriş Yap</a>
    </div>
</body>
</html>