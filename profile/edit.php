<?php
require_once '../includes/config.php';

if (!isLoggedIn()) {
    redirect('../auth/login.php');
}

$user = getUserById($_SESSION['user_id']);
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = sanitizeInput($_POST['first_name']);
    $last_name = sanitizeInput($_POST['last_name']);
    $email = sanitizeInput($_POST['email']);
    $address = sanitizeInput($_POST['address']);
    $phone = sanitizeInput($_POST['phone']);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    // Check if email exists (excluding current user)
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $stmt->execute([$email, $_SESSION['user_id']]);
    if ($stmt->rowCount() > 0) {
        $errors[] = "Email already in use by another account";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, address = ?, phone = ? WHERE id = ?");
        if ($stmt->execute([$first_name, $last_name, $email, $address, $phone, $_SESSION['user_id']])) {
            $success = true;
            // Refresh user data
            $user = getUserById($_SESSION['user_id']);
        } else {
            $errors[] = "Error updating profile";
        }
    }
}
?>

<?php $pageTitle = "Edit Profile"; ?>
<?php include '../includes/header.php'; ?>

<div class="container">
    <h2>Edit Profile</h2>
    
    <?php if (!empty($errors)): ?>
        <div class="alert error">
            <?php foreach ($errors as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
            </div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="alert success">
            <p>Profile updated successfully!</p>
        </div>
    <?php endif; ?>
    
    <form action="edit.php" method="post">
        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="first_name" value="<?= $user['first_name'] ?>">
        </div>
        
        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="last_name" value="<?= $user['last_name'] ?>">
        </div>
        
        <div class="form-group">
            <label>Email*</label>
            <input type="email" name="email" value="<?= $user['email'] ?>" required>
        </div>
        
        <div class="form-group">
            <label>Address</label>
            <textarea name="address"><?= $user['address'] ?></textarea>
        </div>
        
        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" value="<?= $user['phone'] ?>">
        </div>
        
        <button type="submit" class="btn">Update Profile</button>
        <a href="view.php" class="btn cancel">Cancel</a>
    </form>
</div>

<?php include '../includes/footer.php'; ?>