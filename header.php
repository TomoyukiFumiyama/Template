<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<!DOCTYPE html>
<html <?php language_attributes();?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' );?>">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0" />
		<?php wp_head(); ?>
	</head>

	<body <?php body_class();?>>
<?php wp_body_open();?>
		<header class="global-header-wrapper">
			<div class="global-header-container">
				<div class="global-header">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header-nav-link"><img src="<?php echo get_template_directory_uri();?>/assets/logo-xxxxxxxxx.svg" alt="" class="global-header-image" /></a>
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
