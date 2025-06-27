<?php
require_once '../includes/config.php';

// Check if user is admin
if (!isLoggedIn() || !$_SESSION['is_admin']) {
    redirect('../index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'])) {
    $itemId = $_POST['item_id'];
    $points = (int)$_POST['points'];
    $pickupDate = $_POST['pickup_date'];
    
    try {
        $pdo->beginTransaction();
        
        // 1. Get the item and user details
        $stmt = $pdo->prepare("SELECT i.*, u.id as user_id 
                              FROM items i 
                              JOIN users u ON i.user_id = u.id 
                              WHERE i.id = ? AND i.status = 'Pending'");
        $stmt->execute([$itemId]);
        $item = $stmt->fetch();
        
        if (!$item) {
            throw new Exception("Item not found or already processed");
        }
        
        // 2. Update the item status
        $stmt = $pdo->prepare("UPDATE items SET 
                              status = 'Sold',
                              admin_id = ?,
                              points_earned = ?,
                              pickup_date = ?
                              WHERE id = ?");
        $stmt->execute([
            $_SESSION['user_id'],
            $points,
            $pickupDate,
            $itemId
        ]);
        
        // 3. Update user's points
        $stmt = $pdo->prepare("UPDATE users SET 
                              eco_points = eco_points + ? 
                              WHERE id = ?");
        $stmt->execute([$points, $item['user_id']]);
        
        $pdo->commit();
        
        // Redirect with success message
        redirect('dashboard.php?success=pickup_completed');
        
    } catch (Exception $e) {
        $pdo->rollBack();
        redirect('dashboard.php?error=' . urlencode($e->getMessage()));
    }
}

redirect('dashboard.php');