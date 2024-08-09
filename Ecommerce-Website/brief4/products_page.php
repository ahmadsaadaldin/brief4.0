<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: http://localhost/Ecommerce-Website/client/home.php');
}
?>
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
            padding-left: 10px; 
            padding-right: 10px;
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
        .btn-group {
            display: flex;
        }
        .btn-group .btn {
            margin: 0; 
        }
        .btn-group .btn-edit {
            margin-right: 10px;
        }
        #products-table {
            width: 100%;
            table-layout: fixed;
        }
        .table-responsive {
            overflow-x: auto;
        }
        #products-table th, #products-table td {
            max-width: 150px; /* Adjust as needed */
            overflow: hidden;
            text-overflow: ellipsis;
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
<nav class="custom-sidebar navbar navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="http://127.0.0.1/ecommerce-Website/client/home.php">Furni<span>.</span></a>
        
        <div class="custom-sidebar-nav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="http://127.0.0.1/Ecommerce-Website/brief4/dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item"><a class="nav-link" href="http://127.0.0.1/ecommerce-Website/brief4/products_page.php">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="http://127.0.0.1/ecommerce-Website/brief4/categories_page.php">Categories</a></li>
                <li class="nav-item"><a class="nav-link" href="http://127.0.0.1/ecommerce-Website/brief4/users_page.php">Users</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.html">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container">
    <div class="main-container">
        <div class="container-fluid">
            <div class="row">
                <div id="products" class="mt-4">
                    <h2>Manage Products</h2>
                    <div class="mb-3">
                        <a href="http://127.0.0.1/ecommerce-Website/brief4/add_products_page.php" class="btn btn-add-user">Add product</a>
                    </div>
                    <div id="products-table-container" class="table-responsive">
                        <table class="table table-striped" id="products-table">
                            <thead>
                                <tr>
                                    <th scope="col">Product ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $apiurl = 'http://localhost/Ecommerce-Website/brief4/get_products.php';
                                $response = file_get_contents($apiurl);

                                if ($response === FALSE) {
                                    die('Error occurred while fetching data from API.');
                                }

                                $data = json_decode($response, true);

                                if ($data === NULL) {
                                    die('Error occurred while decoding JSON response.');
                                }

                                if (isset($data) && is_array($data)) {
                                    foreach ($data as $product) {
                                        echo "
                                    <tr>
                                        <td>{$product['product_id']}</td>
                                        <td>{$product['product_name']}</td>
                                        <td>{$product['price']}</td>
                                        <td>{$product['description']}</td>
                                        <td><img src='./product_images/{$product['product_image']}' width='40px' height='40px'></td>
                                        <td>
                                            <div class='btn-group' role='group'>
                                                <a href='update_product_page.php?id={$product['product_id']}' class='btn btn-warning btn-sm btn-edit' style='width:60px'>Edit</a>
                                                <a href='delete_product.php?id={$product['product_id']}' class='btn btn-danger btn-sm btn-delete' >Delete</a>
                                            </div>
                                        </td>
                                    </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>No products found or API response is not as expected.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
