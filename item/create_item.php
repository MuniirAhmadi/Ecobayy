<?php
require_once '../includes/config.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../sell.php?error=InvalidRequest');
}

// Verify user is logged in
if (!isLoggedIn()) {
    redirect('../auth/login.php');
}

// Validate and sanitize inputs
$errors = [];

// Required fields
$name = sanitizeInput($_POST['name'] ?? '');
$type = sanitizeInput($_POST['type'] ?? '');
$description = sanitizeInput($_POST['description'] ?? '');

// Validate waste type
$allowedTypes = ['Plastic', 'Metal', 'Paper', 'Glass', 'Electronics', 'Organic', 'Others'];
if (!in_array($type, $allowedTypes)) {
    $errors[] = 'InvalidWasteType';
}

// Validate image upload
$imageUpload = $_FILES['image'] ?? null;
if (!$imageUpload || $imageUpload['error'] !== UPLOAD_ERR_OK) {
    $errors[] = 'UploadError';
} else {
    // Check if the file is an actual image and get MIME type
    $imageInfo = getimagesize($imageUpload['tmp_name']);
    $allowedMimeTypes = ['image/jpeg', 'image/png'];
    if ($imageInfo === false || !in_array($imageInfo['mime'], $allowedMimeTypes)) {
        $errors[] = 'UploadError';
    }

    // Check file size (max 2MB)
    if ($imageUpload['size'] > 2000000) {
        $errors[] = 'UploadError';
    }

    // Allow certain file extensions
    $imageFileType = strtolower(pathinfo($imageUpload['name'], PATHINFO_EXTENSION));
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
        $errors[] = 'UploadError';
    }
}

// If there are errors, redirect back with the first error
if (!empty($errors)) {
    redirectWithFlash('../item/sell.php', $errors[0], 'alert alert-danger');
}

// Process image upload securely
$uploadDir = '../uploads/items/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$imageName = uniqid('item_', true) . '.' . $imageFileType;
$targetFile = $uploadDir . $imageName;

// Re-encode the image to strip malicious code
switch ($imageInfo['mime']) {
    case 'image/jpeg':
        $imageResource = imagecreatefromjpeg($imageUpload['tmp_name']);
        imagejpeg($imageResource, $targetFile, 90);
        break;
    case 'image/png':
        $imageResource = imagecreatefrompng($imageUpload['tmp_name']);
        imagepng($imageResource, $targetFile, 6);
        break;
    default:
        redirectWithFlash('../item/sell.php', $errors[0], 'alert alert-danger');
}
imagedestroy($imageResource);

// Double-check file permissions
chmod($targetFile, 0644);

// Save to database
try {
    $stmt = $pdo->prepare("INSERT INTO items (user_id, name, type, image_path, description) VALUES (:user_id, :name, :type, :image_path, :description)");
    $stmt->execute([
        ':user_id' => $_SESSION['user_id'],
        ':name' => $name,
        ':type' => $type,
        ':image_path' => '../uploads/items/' . $imageName,
        ':description' => $description
    ]);
    redirectWithFlash('../item/sell.php', 'Item added successfully!');
} catch (PDOException $e) {
    @unlink($targetFile);
    error_log("Database error: " . $e->getMessage());
    redirectWithFlash('../item/sell.php', 'Database error occurred. Please try again.', 'alert alert-danger');
}