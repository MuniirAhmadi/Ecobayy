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

<main class="sell-waste">
    <div class="container">
        <h2>Sell Your Waste</h2>
        
        <?php if ($error): ?>
            <div class="alert error">
                <?php 
                switch ($error) {
                    case "InvalidWasteType":
                        echo "The selected waste type is not allowed. Please choose a valid type.";
                        break;
                    case "UploadError":
                        echo "There was an issue uploading the file. Please try again.";
                        break;
                    case "InvalidPrice":
                        echo "Please enter a valid price (minimum RM 0.10).";
                        break;
                    case "InvalidWeight":
                        echo "Please enter a valid weight (minimum 0.1 kg).";
                        break;
                    default:
                        echo "Something went wrong. Please try again.";
                }
                ?>
            </div>
        <?php endif; ?>

        <form action="backend/process_waste.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name of Waste</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="type">Type of Waste</label>
                <select id="type" name="type" required>
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
            
            <div class="form-row">
                <div class="form-group">
                    <label for="price">Price (RM)</label>
                    <input type="number" id="price" name="price" min="0.10" step="0.01" required>
                </div>
                
                <div class="form-group">
                    <label for="weight">Weight (kg)</label>
                    <input type="number" id="weight" name="weight" min="0.1" step="0.1" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="image">Upload Image</label>
                <input type="file" id="image" name="image" accept="image/*" required>
                <small>Max file size: 2MB (JPEG, PNG only)</small>
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4"></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Submit Listing</button>
        </form>
    </div>
</main>

<?php include '../includes/footer.php'; ?>