<?php
require_once '../includes/config.php';

if (!isLoggedIn()) {
    redirect('../auth/login.php');
}

$pageTitle = "Sell Waste";
include '../includes/header.php';


// Handle error messages
$error = isset($_GET['error']) ? $_GET['error'] : null;
?>
<?php if (isset($_SESSION['flash_message'])): ?>
    <div class="<?= $_SESSION['flash_class'] ?? 'alert alert-info' ?>">
        <?= htmlspecialchars($_SESSION['flash_message']) ?>
    </div>
    <?php unset($_SESSION['flash_message'], $_SESSION['flash_class']); ?>
<?php endif; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-success shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-recycle me-2"></i>Sell Your Waste
                    </h4>
                </div>
                
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger mb-4">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?php 
                            switch ($error) {
                                case "InvalidWasteType":
                                    echo "The selected waste type is not allowed. Please choose a valid type.";
                                    break;
                                case "UploadError":
                                    echo "There was an issue uploading the file. Please try again.";
                                    break;
                                default:
                                    echo "Something went wrong. Please try again.";
                            }
                            ?>
                        </div>
                    <?php endif; ?>

                    <form action="create_item.php" method="post" enctype="multipart/form-data">
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">Name of Waste*</label>
                            <input type="text" class="form-control form-control-lg" id="name" name="name" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="type" class="form-label fw-bold">Type of Waste*</label>
                            <select class="form-select form-select-lg" id="type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="Plastic">Plastic</option>
                                <option value="Metal">Metal</option>
                                <option value="Paper">Paper</option>
                                <option value="Glass">Glass</option>
                                <option value="Electronics">Electronics</option>
                                <option value="Organic">Organic</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="image" class="form-label fw-bold">Upload Image*</label>
                            <input type="file" class="form-control form-control-lg" id="image" name="image" accept="image/*" required>
                            <div class="form-text">Max file size: 2MB (JPEG, PNG only)</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-plus-circle me-2"></i>Submit Listing
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>