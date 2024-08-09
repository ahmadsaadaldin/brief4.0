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
    <title>Update User</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="dashboard.css"> <!-- Link to your dashboard CSS -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f7f7;
            padding-top:0;
            margin-right:100px;
        }

        .custom-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
            background-color: #343a40;
            color: white;
            padding: 20px;
        }

        .custom-sidebar .navbar-brand {
            color: white;
            font-size: 24px;
            margin-bottom: 30px;
        }

        .custom-sidebar .nav-link {
            color: white;
            font-size: 18px;
        }

        .custom-sidebar .nav-link:hover {
            color: #adb5bd;
        }

        .main-content {
            margin-left: 200px; 
            padding: 30px;
            padding-top:0;
        }

        .form-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 40px;
            padding-top:20px;
            padding-bottom:20px;
            max-width: 700px;
            margin-top: 20px auto;
        }

        h2 {
            font-weight: bold;
            color: #3B5D50;
            margin-bottom: 30px;
            text-transform: capitalize;
        }

        .btn-warning {
            background-color: #3B5D50;
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-warning:hover {
            background-color: #334d43;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .form-group label {
            font-weight: bold;
            color: #333;
        }

        .form-group input {
            border-radius: 5px;
            border-color: #ced4da;
            padding: 10px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            border-color: #3B5D50;
            box-shadow: none;
        }
        .user-name-container {
    position: fixed;
    top: 0;
    right: 0;
    padding: 10px;
    background-color: #343a40; /* Match the background color of the navbar */
    color: #ffffff;
    z-index: 1000; 
    margin-top:30px;
    margin-right: 30px;
}

.user-name {
    font-size: 1rem;
    font-weight: bold;
}

    </style>
</head>

<body>
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
        <div class="form-container">
            <h2>Update User</h2>
            <form id="formm" action="update_user.php?id=<?php echo $_GET['id'] ?>" method="POST">
                <div class="form-group">
                    <label for="user_id">User ID</label>
                    <input type="text" class="form-control" id="user_id" name="user_id" value="<?php echo $_GET['id']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="user_name">User Name</label>
                    <input type="text" class="form-control" id="user_name" name="user_name">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="form-group">
                    <label for="role_id">Role ID</label>
                    <input type="number" class="form-control" id="role_id" name="role_id">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="form-actions">
                    <button type="button" onclick="submitForm()" class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function submitForm() {
            document.getElementById("formm").submit();
        }
    </script>
</body>

</html>
