<?php get_header();?>

<main id="main" class="site-main">

    <?php
    // WordPressループ開始
    while ( have_posts() ) :
        the_post();
       ?>

        <article id="post-<?php the_ID();?>" <?php post_class( 'entry-content' );?>>

            <header class="entry-header">
                <?php
                // ここにパンくずリストのHTMLを配置 (例: my_theme_breadcrumbs();)
                // JSON-LDスキーマは functions.php で出力済み
               ?>

                <?php
                // H1見出しとして記事タイトルを表示
                the_title( '<h1 class="entry-title">', '</h1>' );
               ?>

                <div class="entry-meta">
                    <span class="published-date">公開日: <time datetime="<?php echo esc_attr( get_the_date( 'c' ) );?>"><?php echo esc_html( get_the_date() );?></time></span>
                    <span class="modified-date">更新日: <time datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) );?>"><?php echo esc_html( get_the_modified_date() );?></time></span>
                    <span class="author">著者: <?php the_author_posts_link();?></span>
                </div>
            </header>

            <div class="entry-thumbnail">
                <?php
                // アイキャッチ画像
                // LCP（最大コンテンツの描画）に影響するため、遅延読み込み(lazy-load)は非推奨の場合も
                // 'full' または 'large' を指定
                if ( has_post_thumbnail() ) {
                    the_post_thumbnail( 'large' ); //
                }
               ?>
            </div>

            <div class="entry-body">
                <?php
                // 記事本文
                // この中にH2, H3などの見出し、内部リンク、画像が含まれます
                the_content();
               ?>
            </div>

            <footer class="entry-footer">
                <?php
                // === 著者情報ボックス (E-E-A-Tの信頼性シグナル) ===
                //
               ?>
                <div class="author-profile-box">
                    <div class="author-avatar">
                        <?php
                        // 著者のアバター（Gravatar）を表示
                        echo get_avatar( get_the_author_meta( 'user_email' ), 120 ); //
                       ?>
                    </div>
                    <div class="author-info">
                        <h4 class="author-name">
                            <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );?>">
                                <?php echo esc_html( get_the_author_meta( 'display_name' ) ); //?>
                            </a>
                        </h4>
                        <p class="author-description">
                            <?php echo esc_html( get_the_author_meta( 'description' ) ); //?>
                        </p>
                        <div class="author-social-links">
                            <?php // 任意: get_the_author_meta('twitter') などでSNSリンクを追加?>
                        </div>
                    </div>
                </div>
            </footer>

        </article>

    <?php endwhile;?>

</main>

<?php get_sidebar();?>
<?php get_footer();?>
