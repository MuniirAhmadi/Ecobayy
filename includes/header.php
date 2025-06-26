<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define base URL
$base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/ecobayy/';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recycle Platform - <?= $pageTitle ?? 'Eco-Friendly Recycling' ?></title>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="main-header">
        <div class="container">
            <div class="logo">
                <a href="<?= $base_url ?>index.php">
                    <i class="fas fa-recycle"></i>
                    <span>Recycle Platform</span>
                </a>
            </div>
            
            <nav class="main-nav">
                <ul>
                    <li><a href="<?= $base_url ?>index.php">Home</a></li>
                    <li><a href="<?= $base_url ?>about.php">How It Works</a></li>
                    <li><a href="<?= $base_url ?>centers.php">Recycling Centers</a></li>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="<?= $base_url ?>profile/view.php">My Profile</a></li>
                        <li><a href="<?= $base_url ?>item/sell.php">Sell Your Waste</a></li>
                        <li><a href="<?= $base_url ?>auth/logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="<?= $base_url ?>auth/login.php">Login</a></li>
                        <li><a href="<?= $base_url ?>auth/register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main-content">