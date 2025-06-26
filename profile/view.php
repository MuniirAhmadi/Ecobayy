<?php
require_once '../includes/config.php';

if (!isLoggedIn()) {
    redirect('../auth/login.php');
}

$user = getUserById($_SESSION['user_id']);
?>

<?php $pageTitle = "My Profile"; ?>
<?php include '../includes/header.php'; ?>

<div class="container">
    <h2>My Profile</h2>
    
    <div class="profile-info">
        <div class="profile-details">
            <p><strong>Username:</strong> <?= $user['username'] ?></p>
            <p><strong>Email:</strong> <?= $user['email'] ?></p>
            <p><strong>Name:</strong> <?= $user['first_name'] ?> <?= $user['last_name'] ?></p>
            <p><strong>Address:</strong> <?= $user['address'] ?? 'Not provided' ?></p>
            <p><strong>Phone:</strong> <?= $user['phone'] ?? 'Not provided' ?></p>
            <p><strong>Eco Points:</strong> <?= $user['eco_points'] ?></p>
            
            <a href="edit.php" class="btn">Edit Profile</a>
            <a href="../auth/logout.php" class="btn logout">Logout</a>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>