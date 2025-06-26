<?php
require_once '../includes/config.php';

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username']);
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $first_name = sanitizeInput($_POST['first_name']);
    $last_name = sanitizeInput($_POST['last_name']);

    // Validate inputs
    if (empty($username)) $errors[] = "Username is required";
    if (empty($email)) $errors[] = "Email is required";
    if (empty($password)) $errors[] = "Password is required";
    if ($password !== $confirm_password) $errors[] = "Passwords do not match";

    // Check if username/email exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->rowCount() > 0) $errors[] = "Username or Email already exists";

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, first_name, last_name) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$username, $email, $hashed_password, $first_name, $last_name])) {
            $success = true;
            // Redirect to login after 3 seconds
            header("refresh:3;url=login.php");
        } else {
            $errors[] = "Something went wrong. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | Recycle Platform</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    
    <div class="container">
        <h2>Create an Account</h2>
        
        <?php if (!empty($errors)): ?>
            <div class="alert error">
                <?php foreach ($errors as $error): ?>
                    <p><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert success">
                <p>Registration successful! Redirecting to login page...</p>
            </div>
        <?php else: ?>
            <form action="register.php" method="post">
                <div class="form-group">
                    <label>Username*</label>
                    <input type="text" name="username" required>
                </div>
                
                <div class="form-group">
                    <label>Email*</label>
                    <input type="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label>Password*</label>
                    <input type="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <label>Confirm Password*</label>
                    <input type="password" name="confirm_password" required>
                </div>
                
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="first_name">
                </div>
                
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="last_name">
                </div>
                
                <button type="submit">Register</button>
            </form>
            
            <p>Already have an account? <a href="login.php">Login here</a></p>
        <?php endif; ?>
    </div>
</body>
</html>