<?php
require_once '../includes/config.php';

if (!isLoggedIn()) {
    redirect('../auth/login.php');
}

$userId = $_SESSION['user_id'];
$itemId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch item data
$stmt = $pdo->prepare("SELECT * FROM items WHERE id = ? AND user_id = ?");
$stmt->execute([$itemId, $userId]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    $_SESSION['error'] = "Item not found or access denied.";
    redirect('view.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $type = trim($_POST['type']);
    $description = trim($_POST['description']);

    $errors = [];

    if (empty($name)) $errors[] = "Item name is required.";
    if (empty($type)) $errors[] = "Item type is required.";
    if (empty($description)) $errors[] = "Description is required.";

    $newImagePath = $item['image_path'];

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

        if (!in_array($image['type'], $allowedTypes)) {
            $errors[] = "Only JPG, PNG, and WEBP images are allowed.";
        } elseif ($image['size'] > 2 * 1024 * 1024) {
            $errors[] = "Image must be less than 2MB.";
        } elseif ($image['error'] === 0) {
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $newName = uniqid('item_', true) . '.' . $ext;
            $uploadPath = "../uploads/" . $newName;

            if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
                // Delete old image if exists
                if (file_exists($item['image_path'])) {
                    unlink($item['image_path']);
                }
                $newImagePath = $uploadPath;
            } else {
                $errors[] = "Failed to upload image.";
            }
        }
    }

    if (empty($errors)) {
        $update = $pdo->prepare("UPDATE items SET name = ?, type = ?, description = ?, image_path = ? WHERE id = ? AND user_id = ?");
        $update->execute([$name, $type, $description, $newImagePath, $itemId, $userId]);

        $_SESSION['message'] = "Item updated successfully.";
        redirect('view.php');
    }
}
?>

<?php $pageTitle = "Edit Item"; ?>
<?php include '../includes/header.php'; ?>

<div class="container py-5">
    <h2 class="mb-4 border-bottom pb-2">Edit Waste Listing</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" class="row g-3">
        <div class="col-md-6">
            <label for="name" class="form-label">Item Name</label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars($item['name']) ?>" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label for="type" class="form-label">Item Type</label>
            <select name="type" id="type" class="form-select" required>
                <option value="" disabled>Select Type</option>
                <option value="Plastic" <?= $item['type'] === 'Plastic' ? 'selected' : '' ?>>Plastic</option>
                <option value="Metal" <?= $item['type'] === 'Metal' ? 'selected' : '' ?>>Metal</option>
                <option value="Paper" <?= $item['type'] === 'Paper' ? 'selected' : '' ?>>Paper</option>
                <option value="Glass" <?= $item['type'] === 'Glass' ? 'selected' : '' ?>>Glass</option>
                <option value="Organic" <?= $item['type'] === 'Organic' ? 'selected' : '' ?>>Organic</option>
            </select>
        </div>

        <div class="col-12">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" rows="4" class="form-control" required><?= htmlspecialchars($item['description']) ?></textarea>
        </div>

        <div class="col-12">
            <label for="image" class="form-label">Upload New Image (optional)</label><br>
            <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="Item Image" class="img-thumbnail mb-2" style="max-height: 150px;">
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <div class="col-12 mt-3">
            <button type="submit" class="btn btn-success">Update Item</button>
            <a href="view.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
