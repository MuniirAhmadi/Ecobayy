<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define base URL
$base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/ecobay-secure/';

// Check if user is admin
$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
?>
<?php flash('flash_message'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Recycle Platform - <?= $pageTitle ?? 'Eco-Friendly Recycling' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Optional: Your custom CSS for any additional styling -->
    <!-- <link rel="stylesheet" href="<?= $base_url ?>assets/css/style.css"> -->
</head>
<body>
    <header class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="<?= $base_url ?>index.php">
                <i class="fas fa-recycle me-2"></i>
                <span>EcoBay</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <nav class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $base_url ?>index.php">
                            <i class="fas fa-home me-1"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $base_url ?>about.php">
                            <i class="fas fa-info-circle me-1"></i> How It Works
                        </a>
                    </li>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php if ($is_admin): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= $base_url ?>admin/dashboard.php">
                                    <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= $base_url ?>admin/users.php">
                                    <i class="fas fa-users me-1"></i> Users
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= $base_url ?>item/sell.php">
                                    <i class="fas fa-plus-circle me-1"></i> Recycle Waste
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= $base_url ?>profile/view.php">
                                    <i class="fas fa-user me-1"></i> My Profile
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i> Hi, <?= htmlspecialchars($_SESSION['username'] ?? 'User') ?>
                                <?php if ($is_admin): ?>
                                    <span class="badge bg-danger ms-1"><i class="fas fa-shield-alt"></i> Admin</span>
                                <?php endif; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?= $base_url ?>auth/logout.php">
                                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                                </a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $base_url ?>auth/login.php">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $base_url ?>auth/register.php">
                                <i class="fas fa-user-plus me-1"></i> Register
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container my-4">