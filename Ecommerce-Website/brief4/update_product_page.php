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
    <title>Update Product</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="dashboard.css"> <!-- Link to your dashboard CSS -->
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f7f7;
        }

        .user-name-container {
            position: fixed;
            top: 0;
            right: 0;
            padding: 10px;
            background-color: #343a40; /* Match the sidebar background */
            color: #ffffff;
            z-index: 1000; /* Ensure it is above other content */
            font-size: 1rem;
            font-weight: bold;
        }

        .main-content {
            margin-left: 290px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
        }

        h2 {
            font-weight: bold;
            color: #3B5D50;
            margin-bottom: 30px;
            text-transform: capitalize;
        }

        .btn-warning {
            background-color: #3B5D50;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-warning:hover {
            background-color: #334d43;
        }

        .form-group label {
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .form-group input, .form-group textarea {
            border-radius: 5px;
            border-color: #ced4da;
            padding: 10px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus, .form-group textarea:focus {
            border-color: #3B5D50;
            box-shadow: none;
        }

        .form-actions {
            margin-top: 30px;
            text-align: left;
        }

        .img-preview {
            max-width: 200px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 5px;
            background-color: #f8f8f8;
        }

        .form-group textarea {
            resize: vertical;
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


    <!-- User Name Section -->
    </div>
    <!-- Sidebar -->
    <nav class="custom-sidebar navbar navbar-dark bg-dark" aria-label="Furni navigation bar">
        <div class="container-fluid">
            <a class="navbar-brand" href="http://127.0.0.1/ecommerce-Website/client/home.php">Furni<span>.</span></a>
            <div class="custom-sidebar-nav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="http://127.0.0.1/ecommerce-Website/brief4/products_page.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="http://127.0.0.1/ecommerce-Website/brief4/categories_page.php">Categories</a></li>
                    <li class="nav-item"><a class="nav-link" href="http://127.0.0.1/ecommerce-Website/brief4/users_page.php">Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.html">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <h2>Update Product</h2>
        <form id="formm" action="update_product.php?id=<?php echo $_GET['id'] ?>" method="POST" enctype="multipart/form-data">
            <div class="container">
                <?php
                $apiurl = "http://127.0.0.1/Ecommerce-Website/brief4/get_product.php/?id=" . $_GET['id'];
                $response = file_get_contents($apiurl);

                if ($response === FALSE) {
                    die('Error occurred while fetching data from API.');
                }

                $product = json_decode($response, true);

                if ($product === NULL) {
                    die('Error occurred while decoding JSON response.');
                }

                if (isset($product)) {
                    echo "
                    <div class='form-group'>
                        <label for='product_id'>Product ID</label>
                        <input type='text' class='form-control' id='product_id' value='{$product['product_id']}' readonly>
                    </div>
                    <div class='form-group'>
                        <label for='product_name'>Name</label>
                        <input type='text' class='form-control' id='product_name' name='product_name' value='{$product['product_name']}'>
                    </div>
                    <div class='form-group'>
                        <label for='price'>Price</label>
                        <input type='text' class='form-control' id='price' name='price' value='{$product['price']}'>
                    </div>
                    <div class='form-group'>
                        <label for='description'>Description</label>
                        <textarea class='form-control' id='description' name='description' rows='4'>{$product['description']}</textarea>
                    </div>
                    <div class='form-group'>
                        <label for='image'>Product Image</label>
                        <input type='file' class='form-control-file' id='image' name='image'>
                        <img src='./product_images/{$product['product_image']}' alt='Current Product Image' class='img-preview'>
                    </div>
                    <div class='form-actions'>
                        <button type='button' onclick='submitForm()' class='btn btn-warning'>Update</button>
                    </div>";
                } else {
                    echo "<div class='alert alert-warning' role='alert'>No products found or API response is not as expected.</div>";
                }
                ?>
            </div>
        </form>
    </div>

    <script>
        function submitForm() {
            document.getElementById("formm").submit();
        }
    </script>
</body>

</html>
