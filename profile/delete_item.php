<?php
require_once '../includes/config.php';

if (!isLoggedIn()) {
    redirect('../auth/login.php');
}

$userId = $_SESSION['user_id'] ?? null;
$itemId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($itemId > 0 && $userId) {
    // Verify the item belongs to the logged-in user
    $checkStmt = $pdo->prepare("SELECT * FROM items WHERE id = ? AND user_id = ?");
    $checkStmt->execute([$itemId, $userId]);
    $item = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if ($item) {
        // Delete the item
        $deleteStmt = $pdo->prepare("DELETE FROM items WHERE id = ?");
        $deleteStmt->execute([$itemId]);

        // Optional: delete the image from server if stored locally
        if (!empty($item['image_path']) && file_exists($item['image_path'])) {
            unlink($item['image_path']);
        }

        $_SESSION['message'] = "Item deleted successfully.";
    } else {
        $_SESSION['error'] = "Item not found or you don't have permission to delete it.";
    }
} else {
    $_SESSION['error'] = "Invalid request.";
}

redirect('view.php'); // Redirect back to profile
