<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primary" class="site-main blog-index-main">
	<?php if ( have_posts() ) : ?>
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Blog', 'yzrh' ); ?></h1>
		</header>

		<div class="post-list">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/post-list-item' ); ?>
			<?php endwhile; ?>
		</div>

		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p><?php esc_html_e( '投稿がまだありません。', 'yzrh' ); ?></p>
	<?php endif; ?>
</main>

<?php
get_sidebar();
get_footer();
