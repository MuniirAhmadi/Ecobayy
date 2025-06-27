<?php
require_once '../includes/config.php';

if (!isLoggedIn()) {
    redirect('../auth/login.php');
}

$user = getUserById($_SESSION['user_id']);

// Get pending items
$pendingStmt = $pdo->prepare("SELECT * FROM items 
                            WHERE user_id = ? AND status = 'Pending'
                            ORDER BY created_at DESC");
$pendingStmt->execute([$_SESSION['user_id']]);
$pendingItems = $pendingStmt->fetchAll(PDO::FETCH_ASSOC);

// Get sold items
$soldStmt = $pdo->prepare("SELECT * FROM items 
                          WHERE user_id = ? AND status = 'Sold'
                          ORDER BY pickup_date DESC");
$soldStmt->execute([$_SESSION['user_id']]);
$soldItems = $soldStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php $pageTitle = "My Profile"; ?>
<?php include '../includes/header.php'; ?>

<div class="container py-5">
    <h2 class="mb-4 border-bottom pb-2">My Profile</h2>
    
    <div class="card mb-5 shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-3"><strong class="text-success">Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
                    <p class="mb-3"><strong class="text-success">Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                    <p class="mb-3"><strong class="text-success">Name:</strong> <?= htmlspecialchars($user['first_name']) ?> <?= htmlspecialchars($user['last_name']) ?></p>
                </div>
                <div class="col-md-6">
                    <p class="mb-3"><strong class="text-success">Address:</strong> <?= !empty($user['address']) ? htmlspecialchars($user['address']) : 'Not provided' ?></p>
                    <p class="mb-3"><strong class="text-success">Phone:</strong> <?= !empty($user['phone']) ? htmlspecialchars($user['phone']) : 'Not provided' ?></p>
                    <p class="mb-3"><strong class="text-success">Eco Points:</strong> <span class="badge bg-success"><?= $user['eco_points'] ?></span></p>
                </div>
            </div>
            
            <div class="mt-4">
                <a href="edit.php" class="btn btn-success me-2">Edit Profile</a>
                <a href="../auth/logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>

    <div class="my-items">
        <h3 class="mb-4 border-bottom pb-2">Pending Waste Listings</h3>
        
        <?php if (empty($pendingItems)): ?>
            <div class="alert alert-info">You don't have any pending waste listings.</div>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
                <?php foreach ($pendingItems as $item): ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="card-img-top" style="height: 200px; overflow: hidden;">
                                <img src="<?= htmlspecialchars($item['image_path']) ?>" class="img-fluid h-100 w-100 object-fit-cover" alt="<?= htmlspecialchars($item['name']) ?>">
                            </div>
                            <div class="card-body">
                                <h4 class="card-title"><?= htmlspecialchars($item['name']) ?></h4>
                                <p class="card-text"><strong class="text-success">Type:</strong> <?= htmlspecialchars($item['type']) ?></p>
                                <p class="card-text"><?= nl2br(htmlspecialchars($item['description'])) ?></p>
                            </div>
                            <div class="card-footer bg-white">
                                <div class="d-flex justify-content-between">
                                    <a href="edit_item.php?id=<?= $item['id'] ?>" class="btn btn-sm btn-outline-success">Edit</a>
                                    <a href="../profile/delete_item.php?id=<?= $item['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <h3 class="mb-4 border-bottom pb-2">Recycle History</h3>
        
        <?php if (empty($soldItems)): ?>
            <div class="alert alert-info">No items have been recycled yet.</div>
        <?php else: ?>
            <div class="table-responsive mb-5">
                <table class="table table-hover">
                    <thead class="table-success">
                        <tr>
                            <th>Item</th>
                            <th>Type</th>
                            <th>Points Earned</th>
                            <th>Pickup Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($soldItems as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['name']) ?></td>
                                <td><?= htmlspecialchars($item['type']) ?></td>
                                <td><span class="badge bg-success"><?= $item['points_earned'] ?></span></td>
                                <td><?= date('M j, Y', strtotime($item['pickup_date'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>