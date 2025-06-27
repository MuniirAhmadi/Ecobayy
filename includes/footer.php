</main>
        
<footer class="bg-dark text-white py-5">
    <div class="container">
        <div class="row">
            <!-- About Us Section -->
            <div class="col-md-4 mb-4 mb-md-0">
                <h4 class="text-success mb-3">About Us</h4>
                <p>Recycle Platform is dedicated to promoting environmental sustainability through proper waste management and recycling.</p>
            </div>
            
            <!-- Quick Links Section -->
            <div class="col-md-4 mb-4 mb-md-0">
                <h4 class="text-success mb-3">Quick Links</h4>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="<?= $base_url ?>index.php" class="text-white text-decoration-none">
                            <i class="fas fa-home me-2"></i> Home
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= $base_url ?>about.php" class="text-white text-decoration-none">
                            <i class="fas fa-info-circle me-2"></i> How It Works
                        </a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php if ($is_admin): ?>
                            <li class="mb-2">
                                <a href="<?= $base_url ?>admin/dashboard.php" class="text-white text-decoration-none">
                                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="<?= $base_url ?>admin/users.php" class="text-white text-decoration-none">
                                    <i class="fas fa-users-cog me-2"></i> Manage Users
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="mb-2">
                                <a href="<?= $base_url ?>profile/view.php" class="text-white text-decoration-none">
                                    <i class="fas fa-user me-2"></i> My Profile
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="mb-2">
                            <a href="<?= $base_url ?>item/sell.php" class="text-white text-decoration-none">
                                <i class="fas fa-recycle me-2"></i> Recycle Waste
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="mb-2">
                            <a href="<?= $base_url ?>auth/login.php" class="text-white text-decoration-none">
                                <i class="fas fa-sign-in-alt me-2"></i> Login
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?= $base_url ?>auth/register.php" class="text-white text-decoration-none">
                                <i class="fas fa-user-plus me-2"></i> Register
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            
            <!-- Contact Us Section -->
            <div class="col-md-4">
                <h4 class="text-success mb-3">Contact Us</h4>
                <p class="mb-2">
                    <i class="fas fa-envelope me-2"></i> contact@recycleplatform.com
                </p>
                <p class="mb-2">
                    <i class="fas fa-phone me-2"></i> +1 (555) 123-4567
                </p>
                <?php if ($is_admin): ?>
                    <p class="mb-0">
                        <i class="fas fa-shield-alt me-2"></i> <strong>Admin Mode</strong>
                    </p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="row mt-4 pt-3 border-top border-secondary">
            <div class="col-12 text-center">
                <p class="mb-0">&copy; <?= date('Y') ?> Recycle Platform. All rights reserved.</p>
                <?php if ($is_admin): ?>
                    <p class="text-muted small mt-1 mb-0">Admin Panel v2.1</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</footer>

<!-- JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous"></script>
<script src="<?= $base_url ?>assets/js/main.js"></script>
</body>
</html>