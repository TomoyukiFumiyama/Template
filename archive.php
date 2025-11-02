<?php get_header();?>

<main id="main" class="site-main">

    <header class="archive-header">
        <?php
        // H1タグとしてアーカイブタイトルを表示
        the_archive_title( '<h1 class="page-title">', '</h1>' );

        // カテゴリーやタグの説明（導入コンテンツ）を表示
        // この内容はWordPress管理画面の「投稿 > カテゴリー」などから編集できます。
        the_archive_description( '<div class="archive-description">', '</div>' );
       ?>
    </header>

    <?php if ( have_posts() ) :?>

        <div class="articles-list">

            <?php
            // WordPressループ開始
            while ( have_posts() ) :
                the_post();
               ?>

                <article id="post-<?php the_ID();?>" <?php post_class( 'article-item' );?>>
                    
                    <div class="article-thumbnail">
                        <a href="<?php the_permalink();?>">
                            <?php
                            // アイキャッチ画像
                            // loading="lazy" はCLSを防ぐために width/height と共に自動付与されます (WP 5.5+)
                            // 'medium_large' は適切なサイズを指定してください。
                            if ( has_post_thumbnail() ) {
                                the_post_thumbnail( 'medium_large', );
                            }
                           ?>
                        </a>
                    </div>

                    <header class="article-header">
                        <?php
                        // H2見出しとして記事タイトルとリンクを表示
                        the_title( sprintf( '<h2 class="article-title"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' );
                       ?>
                    </header>

                    <div class="article-summary">
                        <?php the_excerpt(); // 記事の抜粋を表示?>
                    </div>

                </article>

            <?php endwhile;?>

        </div><?php
        // ページネーション（ページ送り）
        // ユーザビリティとクローラビリティ（自己参照canonical）のために重要
        the_posts_pagination(
            [
                'prev_text' => '<span>&laquo;</span> 前へ',
                'next_text' => '次へ <span>&raquo;</span>',
                'mid_size'  => 2,
            ]
        );
       ?>

    <?php else :?>

        <p>該当する記事が見つかりませんでした。</p>

    <?php endif;?>

</main>

<?php get_sidebar();?>
<?php get_footer();?>
