<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "brief4";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

session_start();
$product_id = $_GET['product_id'];

$sql = "SELECT * FROM products WHERE product_id=$product_id";

$result = mysqli_query($conn, $sql);
$result = mysqli_fetch_assoc($result);
$newItem = true;
for ($i = 0; $i < count($_SESSION['cart_items']); $i += 1) {
    if ($_SESSION['cart_items'][$i]['id'] == $product_id) {
        $_SESSION['cart_items'][$i]['quantity'] += 1;
        $newItem = false;
        $_SESSION['cart_total'] += $result['price'];
        $_SESSION['cart_num_of_items'] = $_SESSION['cart_num_of_items'] + 1;
        echo "here";
        break;
    }
}
if ($newItem === true) {
    $_SESSION['cart_items'][] = ["id" => $product_id, "quantity" => 1];
    $_SESSION['cart_total'] += $result['price'];
    $_SESSION['cart_num_of_items'] += 1;
    echo "not here";
}


// $_SESSION['cart'][] = $product_id;
