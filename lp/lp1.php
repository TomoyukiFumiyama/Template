<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>

<main>
  <?php get_template_part('parts/section', 'hero'); ?>
  <?php get_template_part('parts/section', 'features'); ?>
  <?php get_template_part('parts/section', 'contact'); ?>
</main>

<?php 
get_footer();
