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
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            margin: 0; 
            padding: 0; 
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
            padding-left: 135px; 
            padding-right: 100px;
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
<nav class="custom-sidebar navbar navbar-dark bg-dark" aria-label="Furni navigation bar">
    <div class="container-fluid">
        <!-- Logo at the top -->
        <a class="navbar-brand" href="http://127.0.0.1/ecommerce-Website/client/home.php">Furni<span>.</span></a>
        
        <!-- Navigation Links -->
        <div class="custom-sidebar-nav">
            <ul class="navbar-nav">
            <li class="nav-item">
                    <a class="nav-link" href="http://127.0.0.1/Ecommerce-Website/brief4/dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item"><a class="nav-link" href="http://127.0.0.1/ecommerce-Website/brief4/products_page.php">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="http://127.0.0.1//ecommerce-Website/brief4/categories_page.php">Categories</a></li>
                <li class="nav-item"><a class="nav-link" href="http://127.0.0.1/ecommerce-Website/brief4/users_page.php">Users</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.html">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="main-content">
    <div class="container">
        <div class="main-container">
            <div class="container-fluid">
                <div class="row">
                    <div id="categories" class="mt-4">
                        <h2>Manage Categories</h2>
                        <div class="mb-3">
                            <a href="http://127.0.0.1/ecommerce-Website/brief4/add_categories_page.php" class="btn btn-add-user">Add category</a>
                        </div>
                        <div id="categories-table-container">
                            <table class="table table-striped" id="categories-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Category ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
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

                                    if (is_array($data) && !empty($data)) {
                                        foreach ($data as $category) {
                                            if (is_array($category) && isset($category['category_id']) && isset($category['category_name'])) {
                                                echo "
                                            <tr>
                                                <td>{$category['category_id']}</td>
                                                <td>{$category['category_name']}</td>
                                                <td>
                                                <div class='btn-group' role='group' aria-label='Category Actions'>
                                                    <a href='update_category_page.php?id={$category['category_id']}' class='btn btn-warning btn-sm btn-edit' style='margin-right:25px;width:50px'>Edit</a>
                                                    <a href='delete_category.php?id={$category['category_id']}' class='btn btn-danger btn-sm btn-delete'>Delete</a>
                                                </div>
                                            </td>

                                            </tr>";
                                            } else {
                                                echo "<tr><td colspan='3'>Invalid category data received.</td></tr>";
                                            }
                                        }
                                    } else {
                                        echo "<tr><td colspan='3'>No categories found or API response is not as expected.</td></tr>";
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
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
