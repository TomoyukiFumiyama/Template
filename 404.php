<?php
/**
 * @package YourTheme
 */

status_header( 404 );
nocache_headers();

get_header();
?>

<?php
// GTM / dataLayer（GTMが先に読み込まれていても、後から読み込まれても動くようにする）
?>
<script>
  window.dataLayer = window.dataLayer || [];
  window.dataLayer.push({
    event: 'page_not_found',
    http_status: 404,
    requested_url: window.location.href,
    requested_path: window.location.pathname + window.location.search,
    referrer: document.referrer || '',
    page_title: document.title || ''
  });
</script>

<main id="primary" class="site-main site-404" role="main">
  <div class="site-404__inner">

    <header class="site-404__header">
      <p class="site-404__code" aria-hidden="true">404</p>

      <h1 class="site-404__title">
        <?php echo esc_html__( 'ページが見つかりませんでした', 'yourtheme' ); ?>
      </h1>

      <p class="site-404__lead">
        <?php echo esc_html__( 'URLが間違っているか、ページが移動・削除された可能性があります。', 'yourtheme' ); ?>
      </p>
    </header>

    <section class="site-404__actions" aria-label="<?php echo esc_attr__( '次の操作', 'yourtheme' ); ?>">
      <form class="site-404__searchform" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <label class="site-404__label" for="site-404-search">
          <?php echo esc_html__( 'サイト内検索', 'yourtheme' ); ?>
        </label>

        <div class="site-404__searchrow">
          <input
            id="site-404-search"
            class="site-404__searchinput"
            type="search"
            name="s"
            placeholder="<?php echo esc_attr__( 'キーワードを入力', 'yourtheme' ); ?>"
            autocomplete="off"
          />
          <button class="site-404__searchbutton" type="submit">
            <?php echo esc_html__( '検索', 'yourtheme' ); ?>
          </button>
        </div>
      </form>

      <div class="site-404__buttons">
        <a class="site-404__button site-404__button--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">
          <?php echo esc_html__( 'トップへ戻る', 'yourtheme' ); ?>
        </a>

        <a class="site-404__button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
          <?php echo esc_html__( 'お問い合わせ', 'yourtheme' ); ?>
        </a>
      </div>
    </section>

    <section class="site-404__links" aria-label="<?php echo esc_attr__( 'よく見られているページ', 'yourtheme' ); ?>">
      <h2 class="site-404__subtitle">
        <?php echo esc_html__( 'よく見られているページ', 'yourtheme' ); ?>
      </h2>

      <?php if ( has_nav_menu( 'menu-404' ) ) : ?>
        <nav class="site-404__nav" aria-label="<?php echo esc_attr__( '主要ページ', 'yourtheme' ); ?>">
          <?php
          wp_nav_menu(
            array(
              'theme_location' => 'menu-404',
              'container'      => false,
              'menu_class'     => 'site-404__list',
              'depth'          => 1,
              'fallback_cb'    => false,
            )
          );
          ?>
        </nav>
      <?php else : ?>
        <nav class="site-404__nav" aria-label="<?php echo esc_attr__( '主要ページ', 'yourtheme' ); ?>">
          <ul class="site-404__list">
            <li class="site-404__item"><a class="site-404__link" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html__( 'トップ', 'yourtheme' ); ?></a></li>
            <li class="site-404__item"><a class="site-404__link" href="<?php echo esc_url( home_url( '/services/' ) ); ?>"><?php echo esc_html__( 'サービス', 'yourtheme' ); ?></a></li>
            <li class="site-404__item"><a class="site-404__link" href="<?php echo esc_url( home_url( '/case/' ) ); ?>"><?php echo esc_html__( '事例', 'yourtheme' ); ?></a></li>
            <li class="site-404__item"><a class="site-404__link" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php echo esc_html__( 'ブログ', 'yourtheme' ); ?></a></li>
            <li class="site-404__item"><a class="site-404__link" href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php echo esc_html__( '会社概要', 'yourtheme' ); ?></a></li>
            <li class="site-404__item"><a class="site-404__link" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php echo esc_html__( 'お問い合わせ', 'yourtheme' ); ?></a></li>
          </ul>
        </nav>
      <?php endif; ?>
    </section>

    <section class="site-404__help" aria-label="<?php echo esc_attr__( '補足', 'yourtheme' ); ?>">
      <h2 class="site-404__subtitle">
        <?php echo esc_html__( '解決しない場合', 'yourtheme' ); ?>
      </h2>
      <p class="site-404__text">
        <?php echo esc_html__( 'お探しのページが特定できる場合は、URLを添えてお問い合わせください。', 'yourtheme' ); ?>
      </p>
    </section>

  </div>
</main>

<?php
get_footer();
