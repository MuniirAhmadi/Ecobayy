<?php
require_once '../includes/config.php';

// Check if user is admin
if (!isLoggedIn() || !$_SESSION['is_admin']) {
    redirect('../index.php');
}

// Get pending items
$stmt = $pdo->prepare("SELECT i.*, u.username as user_name, u.address as user_address 
                      FROM items i 
                      JOIN users u ON i.user_id = u.id 
                      WHERE i.status = 'Pending'
                      ORDER BY i.created_at DESC");
$stmt->execute();
$pendingItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get completed pickups
$stmt = $pdo->prepare("SELECT i.*, u.username as user_name, u.address as user_address
                      FROM items i
                      JOIN users u ON i.user_id = u.id
                      WHERE i.status = 'Sold' AND i.admin_id = ?
                      ORDER BY i.pickup_date DESC");
$stmt->execute([$_SESSION['user_id']]);
$completedItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php $pageTitle = "Admin Dashboard"; ?>
<?php include '../includes/header.php'; ?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h2 class="mb-0">Admin Dashboard</h2>
        <a href="users.php" class="btn btn-outline-primary">Manage Users</a>
    </div>
    
    <div class="admin-sections">
        <!-- Pending Items Section -->
        <section class="pending-items mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">Pending Waste Pickups</h3>
                <span class="badge bg-warning text-dark"><?= count($pendingItems) ?> pending</span>
            </div>
            
            <?php if (empty($pendingItems)): ?>
                <div class="alert alert-info">No pending waste pickups.</div>
            <?php else: ?>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    <?php foreach ($pendingItems as $item): ?>
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <div class="card-img-top" style="height: 200px; overflow: hidden;">
                                    <img src="<?= htmlspecialchars($item['image_path']) ?>" class="img-fluid h-100 w-100 object-fit-cover" alt="<?= htmlspecialchars($item['name']) ?>">
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title"><?= htmlspecialchars($item['name']) ?></h4>
                                    <p class="card-text"><strong class="text-success">Type:</strong> <?= htmlspecialchars($item['type']) ?></p>
                                    <p class="card-text"><strong class="text-success">Posted by:</strong> <?= htmlspecialchars($item['user_name']) ?></p>
                                    <p class="card-text"><strong class="text-success">Location:</strong> <?= htmlspecialchars($item['user_address']) ?></p>
                                    <p class="card-text"><strong class="text-success">Description:</strong> <?= htmlspecialchars($item['description']) ?></p>

                                    <form action="process_pickup.php" method="post" class="mt-auto">
                                        <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                                        <div class="mb-3">
                                            <label class="form-label">Points to Award</label>
                                            <input type="number" class="form-control" name="points" min="1" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pickup Date</label>
                                            <input type="date" class="form-control" name="pickup_date" required>
                                        </div>
                                        <button type="submit" class="btn btn-success w-100">Mark as Picked Up</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
        
        <!-- Completed Items Section -->
        <section class="completed-items">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">Your Completed Pickups</h3>
                <span class="badge bg-success"><?= count($completedItems) ?> completed</span>
            </div>
            
            <?php if (empty($completedItems)): ?>
                <div class="alert alert-info">No completed pickups yet.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-success">
                            <tr>
                                <th>Item</th>
                                <th>User</th>
                                <th>Points</th>
                                <th>Pickup Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($completedItems as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['name']) ?></td>
                                    <td><?= htmlspecialchars($item['user_name']) ?></td>
                                    <td><span class="badge bg-success"><?= $item['points_earned'] ?></span></td>
                                    <td><?= date('M j, Y', strtotime($item['pickup_date'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>
    </div>
</div>

<?php include '../includes/footer.php'; ?>