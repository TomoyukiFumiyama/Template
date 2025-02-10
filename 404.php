<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php get_header(); ?>
<main id="main-content" class="main-content">
  <section class="error-page">
    <div class="error-header">
      <h1 class="error-title">ページが見つかりません</h1>
      <p class="error-description">お探しのページは、移動または削除された可能性があります。</p>
    </div>
    <div class="error-navigation">
      <p class="search-instructions">下記のボタンからトップページに戻ってください。</p>
      <div class="button-wrapper">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="back-home-button">トップページに戻る</a>
      </div>
    </div>
  </section>
</main>
<?php get_footer(); ?>