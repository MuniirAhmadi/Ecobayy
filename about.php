<?php
require_once 'includes/config.php';
$pageTitle = "How It Works";
include 'includes/header.php';
?>

<div class="container py-5">
    <h1 class="mb-4 border-bottom pb-2">How to Use the Recycle Platform</h1>

    <div class="row g-4">
        <!-- Step 1 -->
        <div class="col-md-4">
            <div class="card h-100 border-success shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-user-plus fa-3x text-success mb-3"></i>
                    <h5 class="card-title">1. Register or Login</h5>
                    <p class="card-text">Create a free account or log in to access the recycling features.</p>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <a href="<?= $base_url ?>auth/register.php" class="btn btn-outline-success btn-sm">Register Now</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="col-md-4">
            <div class="card h-100 border-success shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-plus-circle fa-3x text-success mb-3"></i>
                    <h5 class="card-title">2. Submit Waste Item</h5>
                    <p class="card-text">Go to your profile and upload details of the item you want to recycle.</p>
                    <a href="<?= $base_url ?>item/sell.php" class="btn btn-outline-success btn-sm">Recycle Waste</a>
                </div>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="col-md-4">
            <div class="card h-100 border-success shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-star fa-3x text-success mb-3"></i>
                    <h5 class="card-title">3. Earn Eco Points</h5>
                    <p class="card-text">Once your item is picked up and verified, you’ll earn eco points.</p>
                    <a href="<?= $base_url ?>profile/view.php" class="btn btn-outline-success btn-sm">View Points</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional Info -->
    <div class="mt-5">
        <h3 class="mb-3">Why Use This Platform?</h3>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i> Promote environmental sustainability</li>
            <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i> Easy-to-use waste listing system</li>
            <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i> Reward-based eco points system</li>
            <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i> Admins can manage user submissions effectively</li>
        </ul>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
