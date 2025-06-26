<?php
require_once 'includes/config.php';

$pageTitle = "Home";
include 'includes/header.php';
?>

<div class="hero">
    <div class="container">
        <h1>Welcome to Recycle Platform</h1>
        <p>Join our community to recycle, earn points, and help the environment</p>
        
        <?php if (!isLoggedIn()): ?>
            <div class="cta-buttons">
                <a href="auth/register.php" class="btn btn-primary">Get Started</a>
                <a href="auth/login.php" class="btn btn-secondary">Login</a>
            </div>
        <?php else: ?>
            <div class="cta-buttons">
                <a href="profile/view.php" class="btn btn-primary">My Profile</a>
                <a href="#" class="btn btn-secondary">Recycle Now</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="features container">
    <div class="feature">
        <i class="fas fa-leaf"></i>
        <h3>Eco-Friendly</h3>
        <p>Contribute to a greener planet by recycling your waste properly</p>
    </div>
    
    <div class="feature">
        <i class="fas fa-trophy"></i>
        <h3>Earn Points</h3>
        <p>Get rewarded with eco-points for your recycling efforts</p>
    </div>
    
    <div class="feature">
        <i class="fas fa-map-marker-alt"></i>
        <h3>Find Centers</h3>
        <p>Locate recycling centers near you with our interactive map</p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>