<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php get_header(); ?>
<div class="l-wrapper">

    <div class="l-single-wrapper">
        <div class="p-guidelines">
            <div class="c-row">

                <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class('p-article'); ?>>
                    <header class="p-article__header">
                        <img class="p-article__image--recruit" src="<?php echo get_template_directory_uri(); ?>/assets/images/recruit.webp" alt="recruit">
                        <div class="p-article__title"><?php the_title(); ?></div>
                    </header>

                    <div class="p-news__pic">
                        <a href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium'); ?>
                            <?php endif; ?>
                        </a>
                    </div>

                    <div class="p-article__body">
                        <div class="p-article__content">
                            <?php the_content(); ?>
                        </div>
                    </div>

                    <div class="p-post-links">
                        <div class="p-post-links__item p-post-links__item--prev"><?php previous_post_link('<i class="fa-solid fa-caret-left"></i>&emsp;%link','%title',true); ?></div>
                        <div class="p-post-links__item p-post-links__item--next"><?php next_post_link('%link&emsp;<i class="fa-solid fa-caret-right"></i>','%title',true); ?></div>
                    </div>

                    <div class="p-btn-set u-fadein">
                        <a class="c-btn c-btn--primary" href="#">この仕事に興味がある！</a>
                    </div>
                </article>

                <?php endwhile; ?>
                <?php endif; ?>

            </div>
        </div>
    </div>

</div>

<?php get_footer(); ?>
