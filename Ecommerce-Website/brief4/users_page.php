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
        .btn-add-user {
            background-color: #3B5D50;
            color: white;
            border: none;
        }
        .btn-add-user:hover {
            background-color: #218838;
            color: white;
        }
        .table {
            width: 100%; /* Ensures the table takes up full container width */
        }
        .table td, .table th {
            padding-left: 8px; 
            padding-right: 8px;
        }
        .btn-group {
            display: flex;
            gap: 10px; /* Adds space between buttons */
        }
        .btn-group .btn {
            margin: 0; 
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
    </style>
</head>
<body>

<?php
session_start(); // Start the session

// Check if the session variable is set
if (isset($_SESSION['admin'])) {
    $adminName = $_SESSION['admin'];
} else {
    $adminName = 'Guest'; // Default value if session variable is not set
}
?>

<!-- User Name Section -->
<div class="user-name-container">
    <?php echo htmlspecialchars($adminName); ?>
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
                <li class="nav-item"><a class="nav-link" href="http://127.0.0.1/ecommerce-Website/brief4/categories_page.php">Categories</a></li>
                <li class="nav-item"><a class="nav-link" href="http://127.0.0.1/ecommerce-Website/brief4/users_page.php">Users</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.html">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container-fluid">
    <div class="main-container">
        <div class="container">
            <div id="users" class="mt-4">
                <h2>Manage Users</h2>
                <div class="mb-3">
                    <a href="http://127.0.0.1/ecommerce-Website/brief4/add_users_page.php" class="btn btn-add-user">Add User</a>
                </div>
                <div id="users-table-container" class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">User ID</th>
                                <th scope="col">User Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role ID</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $apiurl = 'http://127.0.0.1/Ecommerce-Website/brief4/get_users.php';
                            $response = file_get_contents($apiurl);

                            if ($response === FALSE) {
                                die('Error occurred while fetching data from API.');
                            }

                            $data = json_decode($response, true);

                            if ($data === NULL) {
                                die('Error occurred while decoding JSON response.');
                            }

                            if (is_array($data) && isset($data['data']) && !empty($data['data'])) {
                                foreach ($data['data'] as $user) {
                                    if (is_array($user) && isset($user['user_id']) && isset($user['user_name']) && isset($user['email']) && isset($user['role_id'])) {
                                        echo "
                                        <tr>
                                            <td>{$user['user_id']}</td>
                                            <td>{$user['user_name']}</td>
                                            <td>{$user['email']}</td>
                                            <td>{$user['role_id']}</td>
                                            <td>
                                                <div class='btn-group' role='group'>
                                                    <a href='update_user_page.php?id={$user['user_id']}' class='btn btn-edit btn-sm'>Edit</a>
                                                    <a href='delete_user.php?id={$user['user_id']}' class='btn btn-delete btn-sm'>Delete</a>
                                                </div>
                                            </td>
                                        </tr>";
                                    } else {
                                        echo "<tr><td colspan='5'>Invalid user data received.</td></tr>";
                                    }
                                }
                            } else {
                                echo "<tr><td colspan='5'>No users found or API response is not as expected.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
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
