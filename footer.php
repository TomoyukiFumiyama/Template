<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
    <footer class="footer-wrapper">
      <div class="footer-container">
        <h2 class="footer-logo-wrapper">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer-logo-link"><img src="<?php echo get_template_directory_uri();?>/assets/logo-lthree-w.svg" alt="" class="footer-logo" /></a>
        </h2>
        <nav class="footer-nav">
          <ul class="footer-nav-list">
            <li class="footer-nav-item">
              <a href="<?php echo esc_url( home_url( '/' ) ); ?>aboutus" class="footer-nav-link">Who We Are</a>
            </li>
            <li class="footer-nav-item">
              <a href="<?php echo esc_url( home_url( '/' ) ); ?>services" class="footer-nav-link">Our Offer</a>
            </li>
            <li class="footer-nav-item">
              <a href="<?php echo esc_url( home_url( '/' ) ); ?>portfolio" class="footer-nav-link">Customer Reference</a>
            </li>
            <li class="footer-nav-item">
              <a href="<?php echo esc_url( home_url( '/' ) ); ?>contactus" class="footer-nav-link">Contact</a>
            </li>
          </ul>
        </nav>

        <sub class="copy-right">Copyright 2023 L-THREE All Rights Reserved.</sub>
      </div>
    </footer>

    <?php wp_footer(); ?>
  </body>
</html>
