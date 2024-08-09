<?php
include('db_connect.php');

$product_id = $_GET['id'];
$product_name = $_POST['product_name'];
$price = $_POST['price'];
$description = $_POST['description'];

if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
    $filename = $_FILES["image"]["name"];
    $tempname = $_FILES["image"]["tmp_name"];
    $folder = "./product_images/" . $filename;

    move_uploaded_file($tempname, $folder);

    $sql = "UPDATE products 
            SET product_name='$product_name', price='$price', description='$description', product_image='$filename' 
            WHERE product_id='$product_id'";
} else {

    $sql = "UPDATE products 
            SET product_name='$product_name', price='$price', description='$description' 
            WHERE product_id='$product_id'";
}

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
    header("Location: http://localhost/Ecommerce-Website/brief4/dashboard.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
