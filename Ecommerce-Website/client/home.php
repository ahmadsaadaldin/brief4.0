<!-- /*
* Bootstrap 5
* Template Name: Furni
* Template Author: Untree.co
* Template URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
<?php
session_start();
unset($_SESSION['cart']);
if (!isset($_SESSION['cart_items'])) {
	$_SESSION['cart_items'] = [];
	$_SESSION['cart_total'] = 0;
	$_SESSION['cart_num_of_items'] = 0;
}
var_dump($_SESSION);
?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
	<link href="css/tiny-slider.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<title>Home </title>
	<link rel="stylesheet" href="home.css">
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

			<ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5 d-flex align-items-center">
				<li><a class="nav-link" href="<?php if (isset($_SESSION['user_id'])) {
													echo "http://localhost/ecommerce-Website/client/user.php?id={$_SESSION['user_id']}";
												} else {
													echo "http://localhost/ecommerce-Website/reg/login.php";
												}
												?>
												 "><i class="fa-regular fa-user"></i></a></li>
				<li><a class="nav-link position-relative" href="<?php if (isset($_SESSION['user_id'])) {
													echo "http://localhost/ecommerce-Website/client/cart.php";
												} else {
													echo "http://localhost/ecommerce-Website/reg/login.php";
												}
												?>"><i class="fa-solid fa-cart-shopping"></i><span class="position-absolute top-0 start-100  "><?php echo $_SESSION['cart_num_of_items'] ?></span></a></li>
			</ul>
		</div>
	</div>
</nav>

	<!-- End Header/Navigation -->

	<!-- Start Hero Section -->
	<div class="hero">
		<div class="container">
			<div class="row justify-content-between">
				<div class="col-lg-5">
					<div class="intro-excerpt">
						<h1>Furni Online <span clsas="d-block">Furniture Store</span></h1>
						<p class="mb-4">Discover a world of style, comfort, and quality with our curated collection of furniture pieces designed to transform your home.</p>
						<p><a href="products.php" class="btn btn-secondary me-2">Shop Now</a></p>
					</div>
				</div>
				<div class="col-lg-7">
					<div class="hero-img-wrap">
						<img src="images/couch.png" class="img-fluid">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Hero Section -->

	<!-- Start Product Section -->
	<div class="product-section">
		<div class="container">
			<div class="row">

				<!-- Start Column 1 -->
				<div class="col-md-12 col-lg-3 mb-5 mb-lg-0">
					<h2 class="mb-4 section-title">Items on Sale</h2>
					<h2 class="mb-4 section-title" style="color:red;">Up to 20% OFF</h2>
					<p class="mb-4">Don't miss out on our incredible furniture sale! Now is the perfect time to upgrade your home with stunning pieces at unbeatable prices. </p>

				</div>
				<!-- End Column 1 -->

				<?php
				$products_url = "http://127.0.0.1/Ecommerce-Website/brief4/get_products.php";
				$products = file_get_contents($products_url);
				$products = json_decode($products, true);
				// var_dump($products);

				foreach ($products as $product) {
					if ($product['onsale'] == 1) {
						echo "<div class='col-12 col-md-4 col-lg-3 mb-5 mb-md-0'>
              <div class='product-card'>
                <a class='product-item' href='http://localhost/Ecommerce-Website/client/product_details.php?id={$product['product_id']}'>
                  <img src='../brief4/product_images/{$product['product_image']}' class='img-fluid product-thumbnail'>
                  <h3 class='product-title'>{$product['product_name']}</h3>
                  <strong class='product-price'><s style='color : red'>&#36; " . $product['price'] * 1.2 . "</s>  &#36; {$product['price']}</strong>
                </a>
                <a href='http://localhost/Ecommerce-Website/client/product_details.php?id={$product['product_id']}' class='btn btn-primary mt-2 d-block'>View Details</a>
              </div>
            </div>";
					}
				}
				?>
			</div>
		</div>
	</div>
	<!-- End Product Section -->

	<!-- Start Why Choose Us Section -->
	<div class="why-choose-section">
		<div class="container">
			<div class="row justify-content-between">
				<div class="col-lg-6">
					<h2 class="section-title">Why Choose Us</h2>
					<p>At Furni, we believe that every home deserves beautiful, high-quality furniture that reflects your unique style and personality. Here is why we stand out from the rest</p>

					<div class="row my-5">
						<div class="col-6 col-md-6">
							<div class="feature">
								<div class="icon">
									<img src="images/truck.svg" alt="Image" class="imf-fluid">
								</div>
								<h3>Quality Craftsmanship:</h3>
								<p>Our furniture is crafted with precision and care using the finest materials.</p>
							</div>
						</div>

						<div class="col-6 col-md-6">
							<div class="feature">
								<div class="icon">
									<img src="images/bag.svg" alt="Image" class="imf-fluid">
								</div>
								<h3>Affordable Luxury:</h3>
								<p>We believe in offering premium furniture at prices that won't break the bank.</p>
							</div>
						</div>

						<div class="col-6 col-md-6">
							<div class="feature">
								<div class="icon">
									<img src="images/support.svg" alt="Image" class="imf-fluid">
								</div>
								<h3>Exclusive Designs:</h3>
								<p>Our team of designers works tirelessly to bring you exclusive collections that you won’t find anywhere else.</p>
							</div>
						</div>

						<div class="col-6 col-md-6">
							<div class="feature">
								<div class="icon">
									<img src="images/return.svg" alt="Image" class="imf-fluid">
								</div>
								<h3>Sustainable Practices:</h3>
								<p>We are committed to sustainability and eco-friendly practices.</p>
							</div>
						</div>

					</div>
				</div>

				<div class="col-lg-5">
					<div class="img-wrap">
						<img src="images/why-choose-us-img.jpg" alt="Image" class="img-fluid">
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- End Why Choose Us Section -->

	<!-- Start We Help Section -->
	<div class="we-help-section">
		<div class="container">
			<div class="row justify-content-between">
				<div class="col-lg-7 mb-5 mb-lg-0">
					<div class="imgs-grid">
						<div class="grid grid-1"><img src="images/img-grid-1.jpg" alt="Untree.co"></div>
						<div class="grid grid-2"><img src="images/img-grid-2.jpg" alt="Untree.co"></div>
						<div class="grid grid-3"><img src="images/img-grid-3.jpg" alt="Untree.co"></div>
					</div>
				</div>
				<div class="col-lg-5 ps-lg-5">
					<h2 class="section-title mb-4">We Help You Make Modern Interior Design</h2>
					<p>Transform your living space into a modern masterpiece with Furni. Our expertly curated furniture collections and design services make it easy to achieve the contemporary look you have always dreamed of. Here is how we can help you create a stunning modern interior:</p>

					<ul class="list-unstyled custom-list my-4">
						<li>Our selection of modern furniture is designed to reflect the latest trends.</li>
						<li>Not sure where to start? Our team of design experts is here to guide you.</li>
						<li>Modern design is all about clean lines and quality finishes. Our furniture is made from premium materials, ensuring both durability and a luxurious feel.</li>
						<li>Whether you prefer a bold, industrial look or a soft, Scandinavian vibe, our diverse range of modern furniture can be tailored to fit your personal style.</li>
					</ul>

				</div>
			</div>
		</div>
	</div>
	<!-- End We Help Section -->


	<!-- End Popular Product -->

	<!-- Start Testimonial Slider -->

	<!-- END item -->


	<!-- End Testimonial Slider -->

	<!-- Start Blog Section -->

	<!-- End Blog Section -->

	<!-- Start Footer Section -->
	<footer class="footer-section">
		<div class="container relative">

			<div class="sofa-img">
				<img src="images/sofa.png" alt="Image" class="img-fluid">
			</div>

			<div class="row">
				<div class="col-lg-8">
					<div class="subscription-form">
						<h3 class="d-flex align-items-center"><span class="me-1"><img src="images/envelope-outline.svg" alt="Image" class="img-fluid"></span><span>Subscribe to Newsletter</span></h3>

						<form action="#" class="row g-3">
							<div class="col-auto">
								<input type="text" class="form-control" placeholder="Enter your name">
							</div>
							<div class="col-auto">
								<input type="email" class="form-control" placeholder="Enter your email">
							</div>
							<div class="col-auto">
								<button class="btn btn-primary">
									<span class="fa fa-paper-plane"></span>
								</button>
							</div>
						</form>

					</div>
				</div>
			</div>

			<div class="row g-5 mb-5">
				<div class="col-lg-4">
					<div class="mb-4 footer-logo-wrap"><a href="#" class="footer-logo">Furni<span>.</span></a></div>
					<p class="mb-4">Discover a world of style, comfort, and quality with our curated collection of furniture pieces designed to transform your home.</p>

					<ul class="list-unstyled custom-social">
						<li><a href="#"><span class="fa fa-brands fa-facebook-f"></span></a></li>
						<li><a href="#"><span class="fa fa-brands fa-twitter"></span></a></li>
						<li><a href="#"><span class="fa fa-brands fa-instagram"></span></a></li>
						<li><a href="#"><span class="fa fa-brands fa-linkedin"></span></a></li>
					</ul>
				</div>

				<div class="col-lg-8">
					<div class="row links-wrap">
						<div class="col-6 col-sm-6 col-md-3">
							<ul class="list-unstyled">
								<li><a href="#">About us</a></li>
								<li><a href="#">Services</a></li>
								<li><a href="#">Blog</a></li>
								<li><a href="#">Contact us</a></li>
							</ul>
						</div>

						<div class="col-6 col-sm-6 col-md-3">
							<ul class="list-unstyled">
								<li><a href="#">Support</a></li>
								<li><a href="#">Knowledge base</a></li>
								<li><a href="#">Live chat</a></li>
							</ul>
						</div>

						<div class="col-6 col-sm-6 col-md-3">
							<ul class="list-unstyled">
								<li><a href="#">Jobs</a></li>
								<li><a href="#">Our team</a></li>
								<li><a href="#">Leadership</a></li>
								<li><a href="#">Privacy Policy</a></li>
							</ul>
						</div>

						<div class="col-6 col-sm-6 col-md-3">
							<ul class="list-unstyled">
								<li><a href="#">Nordic Chair</a></li>
								<li><a href="#">Kruzo Aero</a></li>
								<li><a href="#">Ergonomic Chair</a></li>
							</ul>
						</div>
					</div>
				</div>

			</div>

			<div class="border-top copyright">
				<div class="row pt-4">
					<div class="col-lg-6">
						<p class="mb-2 text-center text-lg-start">Copyright &copy;<script>
								document.write(new Date().getFullYear());
							</script>. All Rights Reserved. &mdash; Designed with love by <a href="https://untree.co">Untree.co</a> Distributed By <a hreff="https://themewagon.com">ThemeWagon</a> <!-- License information: https://untree.co/license/ -->
						</p>
					</div>

					<div class="col-lg-6 text-center text-lg-end">
						<ul class="list-unstyled d-inline-flex ms-auto">
							<li class="me-4"><a href="#">Terms &amp; Conditions</a></li>
							<li><a href="#">Privacy Policy</a></li>
						</ul>
					</div>

				</div>
			</div>

		</div>
	</footer>
	<!-- End Footer Section -->


	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="js/tiny-slider.js"></script>
	<script src="js/custom.js"></script>
</body>

</html>