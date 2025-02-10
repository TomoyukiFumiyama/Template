<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php get_header(); ?>
<main id="main-content" class="main-content">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <h1><?php the_title(); ?></h1>
      <?php the_excerpt(); ?>
  <?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>