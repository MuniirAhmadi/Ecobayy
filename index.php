<?php
require_once 'includes/config.php';

$pageTitle = "Home";
include 'includes/header.php';

// Check if user is admin
$isAdmin = isLoggedIn() && isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
?>

<!-- Hero Section -->
<section class="hero bg-success text-white py-5">
    <div class="container py-5">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-4">Welcome to EcoBay</h1>
                <p class="lead mb-5">Join our community to recycle, earn points, and help the environment</p>
                
                <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                    <?php if (!isLoggedIn()): ?>
                        <a href="<?= $base_url ?>auth/register.php" class="btn btn-light btn-lg px-4 gap-3">Get Started</a>
                        <a href="<?= $base_url ?>auth/login.php" class="btn btn-outline-light btn-lg px-4">Login</a>
                    <?php elseif ($isAdmin): ?>
                        <a href="<?= $base_url ?>admin/dashboard.php" class="btn btn-light btn-lg px-4 gap-3">Admin Dashboard</a>
                        <a href="<?= $base_url ?>admin/users.php" class="btn btn-outline-light btn-lg px-4">Users List</a>
                    <?php else: ?>
                        <a href="<?= $base_url ?>profile/view.php" class="btn btn-light btn-lg px-4 gap-3">My Profile</a>
                        <a href="<?= $base_url ?>item/sell.php" class="btn btn-outline-light btn-lg px-4">Recycle Now</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container px-4 py-5">
        <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
            <div class="col d-flex align-items-start">
                <div class="icon-square bg-success bg-opacity-10 text-success flex-shrink-0 me-3 p-3 rounded">
                    <i class="fas fa-leaf fa-2x"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-2">Eco-Friendly</h3>
                    <p>Contribute to a greener planet by recycling your waste properly</p>
                </div>
            </div>
            
            <div class="col d-flex align-items-start">
                <div class="icon-square bg-success bg-opacity-10 text-success flex-shrink-0 me-3 p-3 rounded">
                    <i class="fas fa-trophy fa-2x"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-2">Earn Points</h3>
                    <p>Get rewarded with eco-points for your recycling efforts</p>
                </div>
            </div>
            
            <div class="col d-flex align-items-start">
                <div class="icon-square bg-success bg-opacity-10 text-success flex-shrink-0 me-3 p-3 rounded">
                    <i class="fas fa-map-marker-alt fa-2x"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-2">Find Centers</h3>
                    <p>Locate recycling centers near you with our interactive map</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>