<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0" />
		<link rel="preconnect" href="https://fonts.googleapis.com" />
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet" />
		<?php wp_head(); ?>
	</head>

	<body class="page">
		<header class="global-header-wrapper">
			<div class="global-header-container">
				<div class="global-header">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header-nav-link"><img src="<?php echo get_template_directory_uri();?>/assets/logo-lthree-w.svg" alt="" class="global-header-image" /></a>
				</div>
				<nav class="header-nav">
					<ul class="header-nav-list">
						<li class="header-nav-item">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>aboutus" class="header-nav-link">Who We Are</a>
						</li>
						<li class="header-nav-item">
							<p class="header-nav-link">Our Offer</p>
							<ul class="dropdown-menu">
								<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>services">Services</a></li>
								<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>solutions">Solutions</a></li>
							</ul>
						</li>
						<li class="header-nav-item">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>portfolio" class="header-nav-link">Customer Reference</a>
						</li>
						<li class="header-nav-item label-contact">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>contactus" class="header-nav-link">Contact Us</a>
						</li>
					</ul>
				</nav>
			</div>
		</header>