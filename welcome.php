<?php
// Oturum başlatma
session_start();

// Kullanıcı giriş yapmamışsa ana sayfaya yönlendir
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

// Kullanıcı bilgilerini al
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoş Geldiniz - Azure AD Kimlik Doğrulama</title>
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
        .welcome-container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 600px;
            width: 90%;
        }
        .user-info {
            margin: 2rem 0;
            padding: 1rem;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
        .logout-button {
            background-color: #dc3545;
            color: white;
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .logout-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <h1>Hoş Geldiniz, <?php echo htmlspecialchars($user['name']); ?>!</h1>
        <div class="user-info">
            <p><strong>E-posta:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        </div>
        <a href="logout.php" class="logout-button">Çıkış Yap</a>
    </div>
</body>
</html>