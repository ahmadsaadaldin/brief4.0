<?php
session_start();
$product_id = $_GET['product_id'];
array_diff($_SESSION['cart'], [$product_id]);
