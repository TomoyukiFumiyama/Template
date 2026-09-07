<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primary" class="site-main archive-main">
	<header class="archive-header">
		<?php
		the_archive_title( '<h1 class="page-title">', '</h1>' );
		the_archive_description( '<div class="archive-description">', '</div>' );
		?>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="archive-post-list">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php
				get_template_part(
					'template-parts/post-list-item',
					null,
					array(
						'article_class'   => 'archive-post-item',
						'thumbnail_class' => 'archive-post-thumb',
						'title_class'     => 'archive-post-title',
						'excerpt_class'   => 'archive-post-excerpt',
					)
				);
				?>
			<?php endwhile; ?>
		</div>

		<?php
		the_posts_pagination(
			array(
				'prev_text' => '<span>&laquo;</span> ' . esc_html__( '前へ', 'yzrh' ),
				'next_text' => esc_html__( '次へ', 'yzrh' ) . ' <span>&raquo;</span>',
				'mid_size'  => 2,
			)
		);
		?>
	<?php else : ?>
		<p><?php esc_html_e( '該当する記事が見つかりませんでした。', 'yzrh' ); ?></p>
	<?php endif; ?>
</main>

<?php
if ( yzrh_get_setting( 'display_show_sidebar_archive', true ) ) {
	get_sidebar();
}
get_footer();
