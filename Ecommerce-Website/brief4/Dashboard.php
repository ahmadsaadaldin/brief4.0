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
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="dashboard.css">
    <style>
        .full-height {
            height: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 20px;
            margin-bottom: 20px;
        }

        .card {
            background-color: #EDEBDF;
            color: #333;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin: 5px;
            /* Reduced margin */
            transition: all 0.3s ease;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .card i {
            font-size: 3rem;
            margin-bottom: 10px;
            color: #333;
        }

        .card-title {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .card-text {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .card-btn {
            margin-top: 15px;
        }

        .row {
            margin-left: 0;
            margin-right: 0;
            width: 100%;
        }

        .col-md-3 {
            padding-left: 15px;
            padding-right: 15px;
        }

        /* Hover effect */
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }
        /* dashboard.css */

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
            <a class="navbar-brand" href="http://localhost/ecommerce-Website/client/home.php">Furni<span>.</span></a>

            <!-- Navigation Links -->
            <div class="custom-sidebar-nav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="http://127.0.0.1/ecommerce-Website/brief4/products_page.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="http://127.0.0.1/ecommerce-Website/brief4/categories_page.php">Categories</a></li>
                    <li class="nav-item"><a class="nav-link" href="http://127.0.0.1/ecommerce-Website/brief4/users_page.php">Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="http://127.0.0.1/ecommerce-Website/reg/process_logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div style="margin-top:50px" class="alert alert-info" role="alert">
                    <h4  class="alert-heading">Welcome, <?php echo $_SESSION['admin']; ?>!</h4>
                    <p>Here’s an overview of your dashboard. You can quickly manage your products, users, orders, and categories from here.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container full-height">
        <div class="row">
            <?php
            $apiurl = 'http://127.0.0.1/Ecommerce-Website/brief4/website_data.php';
            $response = file_get_contents($apiurl);

            if ($response === FALSE) {
                die('<div class="alert alert-danger" role="alert">Error occurred while fetching data from API.</div>');
            }

            $data = json_decode($response, true);

            if ($data === NULL) {
                die('<div class="alert alert-danger" role="alert">Error occurred while decoding JSON response.</div>');
            }

            if (isset($data) && is_array($data)) {
                echo '
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <i class="fas fa-box-open"></i>
                    <h5 class="card-title">Products</h5>
                    <p class="card-text">' . $data['product_count'] . '</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <i class="fas fa-users"></i>
                    <h5 class="card-title">Users</h5>
                    <p class="card-text">' . $data['user_count'] . '</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <i class="fas fa-shopping-cart"></i>
                    <h5 class="card-title">Orders</h5>
                    <p class="card-text">' . $data['order_count'] . '</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <i class="fas fa-tags"></i>
                    <h5 class="card-title">Categories</h5>
                    <p class="card-text">' . $data['category_count'] . '</p>
                </div>
            </div>
        </div>';
            } else {
                echo '<div class="alert alert-warning" role="alert">No data found or API response is not as expected.</div>';
            }
            ?>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx1 = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                datasets: [{
                    label: 'Sales',
                    data: [1200, 1500, 1800, 1700, 2000, 1900],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctx2 = document.getElementById('ordersChart').getContext('2d');
        var ordersChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                datasets: [{
                    label: 'Orders',
                    data: [8, 11, 15, 13, 16, 10],
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>