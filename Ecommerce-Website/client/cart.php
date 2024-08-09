<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "brief4";
var_dump($_SESSION);
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize session variables if not set
if (!isset($_SESSION['cart_items'])) {
    $_SESSION['cart_items'] = [];
}
if (!isset($_SESSION['cart_total'])) {
    $_SESSION['cart_total'] = 0;
}
if (!isset($_SESSION['cart_num_of_items'])) {
    $_SESSION['cart_num_of_items'] = 0;
}

// Handle cart update via POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data['action'] === 'update') {
        $productId = $data['productId'];
        $quantity = $data['quantity'];
        $_SESSION['cart'][$productId] = $quantity;

        // Recalculate cart total
        $_SESSION['cart_total'] = 0;
        $_SESSION['cart_num_of_items'] = 0;
        foreach ($_SESSION['cart_items'] as $id => $qty) {
            $apiurl = "http://127.0.0.1/Ecommerce-Website/brief4/get_product.php?id=$id";
            $response = file_get_contents($apiurl);
            $product = json_decode($response, true);
            $_SESSION['cart_total'] += $product['price'] * $qty;
            $_SESSION['cart_num_of_items'] += $qty;
        }
    } elseif ($data['action'] === 'delete') {
        $productId = $data['productId'];
        unset($_SESSION['cart_items'][$productId]);

        // Recalculate cart total
        $_SESSION['cart_total'] = 0;
        $_SESSION['cart_num_of_items'] = 0;
        foreach ($_SESSION['cart_items'] as $id => $qty) {
            $apiurl = "http://127.0.0.1/Ecommerce-Website/brief4/get_product.php?id=$id";
            $response = file_get_contents($apiurl);
            $product = json_decode($response, true);
            $_SESSION['cart_total'] += $product['price'] * $qty;
            $_SESSION['cart_num_of_items'] += $qty;
        }
    } elseif (isset($data['checkout']) && $data['checkout']) {
        $userId = $_SESSION['user_id'];
        $totalAmount = $_SESSION['cart_total'];
        $orderQuery = "INSERT INTO orders (user_id, total_amount) VALUES ('$userId', '$totalAmount')";
        if ($conn->query($orderQuery) === TRUE) {
            $orderId = $conn->insert_id;
            foreach ($_SESSION['cart_items'] as $productId => $quantity) {
                $orderItemQuery = "INSERT INTO order_items (order_id, product_id, quantity) VALUES ('$orderId', '$productId', '$quantity')";
                $conn->query($orderItemQuery);
            }
            $_SESSION['cart_items'] = [];
            $_SESSION['cart_total'] = 0;
            $_SESSION['cart_num_of_items'] = 0;
            echo json_encode(['success' => true, 'message' => 'Order placed successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error placing order']);
        }
        exit;
    }
    echo json_encode(['success' => true]);
    exit;
}

$conn->close();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="favicon.png">
    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="css/tiny-slider.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="cart.css">
    <title>Cart</title>
    <style>
        /* Custom styles for a better looking page */
    </style>
</head>

<body>
    <nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark" aria-label="Furni navigation bar">
        <div class="container">
            <a class="navbar-brand" href="home.php">Furni<span>.</span></a>

            <!-- Search Form -->
            <form class="d-flex ms-3" method="post" action="products.php">
                <input class="form-control me-2" type="number" placeholder="Filter By Price" aria-label="Search" name="query" required>
                <button class="btn btn-outline-light" type="submit">Search</button>
            </form>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsFurni">
                <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="categoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Category</a>
                        <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
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
                                        echo "<li><a class='dropdown-item' href='category_page.php?id={$category['category_id']}'>{$category['category_name']}</a></li>";
                                    }
                                }
                            }
                            ?>

                        </ul>
                    </li>
                    <li><a class="nav-link" href="http://localhost/ecommerce-Website/client/about.php">About</a></li>
                    <li><a class="nav-link" href="http://localhost/ecommerce-Website/client/contact.php">Contact</a></li>
                    <li><a class="nav-link" href="<?php
                                                    if (isset($_SESSION['user_id'])) {
                                                        echo "http://localhost/ecommerce-Website/reg/process_logout.php";
                                                    } else {
                                                        echo "http://localhost/ecommerce-Website/reg/login.php";
                                                    }
                                                    ?>"><?php
                                                        if (isset($_SESSION['user_id'])) {
                                                            echo "Log out";
                                                        } else {
                                                            echo "Log In";
                                                        }
                                                        ?></a></li>
                </ul>

                <ul class=" custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                    <li><a class="nav-link" href="<?php if (isset($_SESSION['user_id'])) {
                                                        echo "http://localhost/ecommerce-Website/client/user.php?id={$_SESSION['user_id']}";
                                                    } else {
                                                        echo "http://localhost/ecommerce-Website/reg/login.php";
                                                    }
                                                    ?>
													 "><i class="fa-regular fa-user"></i></a></li>
                    <li><a class="nav-link" href="<?php if (isset($_SESSION['user_id'])) {
                                                        echo "http://localhost/ecommerce-Website/client/cart.php";
                                                    } else {
                                                        echo "http://localhost/ecommerce-Website/reg/login.php";
                                                    }
                                                    ?>"><i class="fa-solid fa-cart-shopping"></i><?php echo $_SESSION['cart_num_of_items'] ?></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Header/Navigation -->
    <!-- Start Cart Section -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <h2>Your Cart</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th style="text-align: center;">Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="cart-items">
                        <?php foreach ($_SESSION['cart_items'] as $product) : ?>
                            <tr data-product-id="<?php
                                                    $apiurl = "http://127.0.0.1/Ecommerce-Website/brief4/get_product.php?id={$product['id']}";
                                                    $response = file_get_contents($apiurl);
                                                    $response = json_decode($response, true);
                                                    echo $response['product_id'];
                                                    ?>">
                                <td><?php echo $response['product_name']; ?></td>
                                <td><?php echo $response['price']; ?></td>
                                <td>
                                    <div class="input-group">
                                        <button class="btn btn-outline-secondary decrease" type="button">-</button>
                                        <input type="text" class="form-control quantity-amount" value="<?php echo $product['quantity']; ?>" readonly>
                                        <button class="btn btn-outline-secondary increase" type="button">+</button>
                                    </div>
                                </td>
                                <td><a href="#" class="btn btn-danger btn-sm remove-item">Remove</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Cart Total</h4>
                        <p>Total Amount: <span id="total-amount">$ <?php echo $_SESSION['cart_total']; ?></span></p>
                        <button class="btn btn-black btn-lg py-3 btn-block" id="checkout">Proceed To Checkout</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Cart Section -->

        <!-- Scripts -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
                function recalculateTotal() {
                    let totalAmount = 0;
                    document.querySelectorAll('#cart-items tr').forEach(row => {
                        let price = parseFloat(row.querySelector('td:nth-child(2)').innerText);
                        let quantity = parseInt(row.querySelector('.quantity-amount').value);
                        totalAmount += price * quantity;
                    });
                    document.getElementById('total-amount').innerText = '$' + totalAmount.toFixed(2);
                }

                document.querySelectorAll('.increase').forEach(button => {
                    button.addEventListener('click', (e) => {
                        let input = e.target.closest('.input-group').querySelector('.quantity-amount');
                        let currentValue = parseInt(input.value);
                        input.value = currentValue + 1;
                        updateCart({
                            productId: e.target.closest('tr').getAttribute('data-product-id'),
                            quantity: input.value
                        }, 'update');
                        recalculateTotal();
                    });
                });

                document.querySelectorAll('.decrease').forEach(button => {
                    button.addEventListener('click', (e) => {
                        let input = e.target.closest('.input-group').querySelector('.quantity-amount');
                        let currentValue = parseInt(input.value);
                        if (currentValue > 1) {
                            input.value = currentValue - 1;
                            updateCart({
                                productId: e.target.closest('tr').getAttribute('data-product-id'),
                                quantity: input.value
                            }, 'update');
                            recalculateTotal();
                        }
                    });
                });

                document.querySelectorAll('.remove-item').forEach(button => {
                    button.addEventListener('click', (e) => {
                        e.preventDefault();
                        if (confirm('Are you sure you want to remove this item?')) {
                            let row = e.target.closest('tr');
                            let productId = row.getAttribute('data-product-id');
                            row.remove();
                            updateCart({
                                productId: productId
                            }, 'delete');
                            recalculateTotal();
                        }
                    });
                });

                function updateCart(data, action) {
                    fetch('', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                action: action,
                                ...data
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (!data.success) {
                                alert('Error updating cart');
                            }
                        });
                }

                document.getElementById('checkout').addEventListener('click', () => {
                    fetch('', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                checkout: true
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.message);
                                window.location.href = 'order_confirmation.html'; // Redirect after successful checkout
                            } else {
                                alert('Error processing order');
                            }
                        });
                });
            });
        </script>
</body>

</html>