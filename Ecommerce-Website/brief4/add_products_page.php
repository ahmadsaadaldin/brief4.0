<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: http://localhost/Ecommerce-Website/client/home.php');
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    /* Existing styles */
body {
    margin-left: 0; 
    padding-top: 0px; 
}

.main-container {
    padding-left: 20px; 
}

.btn-edit {
    background-color: #3B5D50;
    color: white;
    border: none;
}

.btn-delete {
    background-color: #dc3545;
    color: white;
    border: none;
}

.btn-edit:hover {
    background-color: #334d43;
    color: white;
}

.btn-delete:hover {
    background-color: #c82333;
    color: white;
}

.table td, .table th {
    padding-left: 50px; 
    padding-right: 50px;
}

.btn-add-user {
    background-color: #3B5D50;
    color: white;
    border: none;
}

.btn-add-user:hover {
    background-color: #218838;
    color: white;
}

.sidebar {
    height: 100vh;
    width: 250px;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #343a40;
    padding-top: 20px;
}

.sidebar a {
    color: #fff;
    padding: 15px 20px;
    text-decoration: none;
    display: block;
}

.sidebar a:hover {
    background-color: #495057;
}

.main-content {
    margin-left: 250px;
    padding: 20px;
    padding-top:0px;
}

.form-container {
    max-width: 800px; 
    margin: 0 auto;
    padding: 9px;
    padding-top: 0;
    background-color: #f8f9fa; 
    border-radius: 8px; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
}

/* New styles for checkboxes */
.checkbox-container {
    display: flex;
    flex-wrap: wrap;
    gap: 100px; 
}

.checkContainer {
    display: flex;
    align-items: center;
    margin-bottom: 10px; 
}

.form-check-input {
    margin-right: 10px;
}
.user-name-container {
    position: fixed;
    top: 0;
    right: 0;
    padding: 10px;
    background-color: #343a40; /* Match the background color of the navbar */
    color: #ffffff;
    z-index: 1000; 

}

.user-name {
    font-size: 1rem;
    font-weight: bold;
}

    </style>
</head>
<body>
<div class="user-name-container">
        <span class="user-name"><?php echo $_SESSION['admin']; ?></span>
    </div>
<!-- Sidebar -->
<nav class="custom-sidebar navbar navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="http://localhost/ecommerce-Website/client/home.php">Furni<span>.</span></a>
        
        <div class="custom-sidebar-nav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="http://127.0.0.1/Ecommerce-Website/brief4/dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item"><a class="nav-link" href="http://127.0.0.1/Ecommerce-Website/brief4/products_page.php">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="http://127.0.0.1/Ecommerce-Website/brief4/categories_page.php">Categories</a></li>
                <li class="nav-item"><a class="nav-link" href="http://127.0.0.1/Ecommerce-Website/brief4/users_page.php">Users</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.html">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="main-content">
    <div class="container-fluid">
        <div class="row">
            <main class="col-md-12">
                <div id="products" class="mt-4 form-container">
                    
                    <form action="add_product.php" method="POST" enctype="multipart/form-data">
                    <h2>Add Products</h2>
                        <div class="form-group">
                            <label for="product_name">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name">
                        </div>
                        <div class="form-group">
                            <label for="product_price">Product Price</label>
                            <input type="number" class="form-control" id="product_price" name="price">
                        </div>
                        <div class="form-group">
                            <label for="product_description">Product Description</label>
                            <textarea class="form-control" id="product_description" name="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="product_image">Product Image URL</label>
                            <input type="file" class="form-control" id="product_image" name="image">
                        </div>
                        <div class="form-group">
                            <p>Categories</p>
                            <div class="checkbox-container" style="margin-left:3%">
                                <?php
                                $apiurl = 'http://127.0.0.1/Ecommerce-Website/brief4/get_categories.php';
                                $response = file_get_contents($apiurl);

                                if ($response === FALSE) {
                                    die('Error occurred while fetching data from API.');
                                }

                                $data = json_decode($response, true);

                                if ($data === NULL) {
                                    die('Error occurred while decoding JSON response.');
                                }

                                if (isset($data) && is_array($data)) {
                                    foreach ($data as $category) {
                                        echo "
                                    <span class='checkContainer'>
                                        <input class='form-check-input' type='checkbox' name='category_ids[]' value='{$category['category_id']}' id='defaultCheck{$category['category_id']}'>
                                        <label class='form-check-label' for='defaultCheck{$category['category_id']}'>
                                            {$category['category_name']}
                                        </label>
                                    </span>";
                                    }
                                } else {
                                    echo "<p>No categories found or API response is not as expected.</p>";
                                }
                                ?>
                            </div>
                        </div>
                        <button style="background-color:#3B5D50;border:none" type="submit" class="btn btn-primary">Add Product</button>
                    </form>
                </div>
            </main>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
