# PLANS: オリジナルテーマ内での JSON-LD 構造化データ実装計画

この PLANS.md は、Codex が  
「オリジナルテーマ内で JSON-LD 構造化データ（ブログ記事・ブログ一覧・筆者ページ）を実装する」  
際の具体的な作業計画を定義する。

AGENTS.md の方針に従い、以下のステップで作業を進めること。

---

## 1. 全体フロー（High-level Flow）

1. テーマ構造と対象テンプレートの確認
2. JSON-LD 出力用の共通ファイル・関数の作成
3. 単一投稿ページ用 `BlogPosting` JSON-LD の実装
4. ブログ一覧ページ用 `ItemList`（＋`Blog`）JSON-LD の実装
5. 筆者ページ用 `Person` JSON-LD の実装
6. 条件分岐と `wp_head` へのフック設定
7. テスト（実ページでの確認・構造化データテストツール）
8. リファクタリング・コメント付与・簡易ドキュメント作成

---

## 2. 対象テンプレートと出力場所の整理

### Step 1: テーマ構造の確認

- 使用テーマの以下テンプレートを確認する：
  - 単一投稿：`single.php` または `single-post.php`
  - ブログ一覧：`home.php` / `index.php` / `archive.php` のどれが実際のブログ一覧を担っているか
  - 筆者ページ：`author.php` の有無と構造
- 実際に表示されている URL とテンプレートを照合し、  
  どのページを「ブログ記事」「ブログ一覧」「筆者ページ」と見なすかを決める

### Step 2: JSON-LD を出力する場所の決定

- 共通関数を定義するファイル：
  - `functions.php` に直接書くか、`inc/jsonld.php` 等の専用ファイルを作成する
- 出力のトリガー：
  - `add_action( 'wp_head', 'mytheme_output_jsonld' );` のように `wp_head` へフックする

---

## 3. JSON-LD 共通処理の実装

### Step 3: 共通ファイルとエントリ関数

1. `inc/jsonld.php` のようなファイルを作成し、`functions.php` から読み込む：

   ```php
   // functions.php
   require_once get_template_directory() . '/inc/jsonld.php';
````

2. `inc/jsonld.php` に以下のベース関数を定義：

   ```php
   <?php
   if ( ! defined( 'ABSPATH' ) ) {
       exit;
   }

   function mytheme_output_jsonld() {
       if ( is_single() && get_post_type() === 'post' ) {
           mytheme_jsonld_blogposting();
       } elseif ( is_home() || is_archive() ) {
           mytheme_jsonld_blog_itemlist();
       } elseif ( is_author() ) {
           mytheme_jsonld_author_person();
       }
   }
   add_action( 'wp_head', 'mytheme_output_jsonld' );
   ```

3. `mytheme_jsonld_blogposting()`, `mytheme_jsonld_blog_itemlist()`,
   `mytheme_jsonld_author_person()` は後続ステップで実装する。

---

## 4. 単一投稿用 BlogPosting の実装

### Step 4: BlogPosting 用関数の実装

1. `mytheme_jsonld_blogposting()` を `inc/jsonld.php` に定義する。

2. 現在の投稿情報を取得：

   * 投稿 ID: `get_the_ID()`
   * タイトル: `get_the_title()`
   * 抜粋または本文冒頭: `get_the_excerpt()` などを `wp_strip_all_tags()` で整形
   * 公開日: `get_the_date( DATE_W3C )`
   * 更新日: `get_the_modified_date( DATE_W3C )`
   * URL: `get_permalink()`
   * アイキャッチ画像 URL: `get_the_post_thumbnail_url( get_the_ID(), 'full' )`
   * 著者情報:

     * `get_the_author_meta( 'display_name' )`
     * `get_author_posts_url()` など

3. `BlogPosting` 用の PHP 配列を構築：

   * `@context` = `https://schema.org`
   * `@type` = `BlogPosting`
   * `mainEntityOfPage` = ページ URL
   * `headline` = タイトル
   * `description` = 抜粋など
   * `image` = アイキャッチ（存在する場合のみ）
   * `author` = `Person` オブジェクト
   * `publisher` = `Organization` オブジェクト（サイト名とロゴを含める場合はテーマ側で定義）
   * `datePublished` / `dateModified`
   * `url`

4. `json_encode()` でエンコードし、`<script type="application/ld+json">` で出力：

   ```php
   echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>';
   ```

---

## 5. ブログ一覧用 ItemList / Blog の実装

### Step 5: 一覧ページでの ItemList 実装

1. `mytheme_jsonld_blog_itemlist()` を定義。

2. 現在のクエリ（`$wp_query`）または `have_posts()` ループを用いて、表示されている投稿リストを取得。

3. 各投稿ごとに以下の情報を取得：

   * タイトル
   * 投稿 URL
   * 一覧内での位置（1 からの連番）

4. `ItemList` の配列を構築：

   * `@context` = `https://schema.org`
   * `@type` = `ItemList`
   * `itemListElement` = `ListItem` の配列

     * 各要素に `@type = ListItem`, `position`, `url`, `name` を持たせる

5. 必要であれば同時に `Blog` オブジェクトも作成：

   * `@type` = `Blog`
   * `name` = ブログ名（`get_bloginfo( 'name' )`）
   * `description` = `get_bloginfo( 'description' )` 等
   * `url` = ブログトップ URL

6. `ItemList` と `Blog` を配列の配列としてまとめ、`json_encode()` して出力する。

---

## 6. 筆者ページ用 Person の実装

### Step 6: Person JSON-LD の実装

1. `mytheme_jsonld_author_person()` を定義。

2. 現在表示中の著者 ID を取得：

   * `get_queried_object()` から `ID` を取得するか、`get_the_author_meta()` を利用

3. 著者情報を取得：

   * `display_name`（名前）
   * `user_description`（プロフィール文）
   * `user_url`（個人サイトなど）
   * `get_avatar_url( $author_id )`（プロフィール画像）

4. `Person` 配列を構築：

   * `@context` = `https://schema.org`
   * `@type` = `Person`
   * `name`
   * `description`
   * `image`
   * `url`
   * `sameAs`（SNS 等がある場合は配列で）

5. 必要に応じて `ProfilePage` も構築：

   * `@type` = `ProfilePage`
   * `mainEntity` = 上記 `Person` オブジェクト

6. `json_encode()` し、`<script type="application/ld+json">` で出力。

---

## 7. テスト・検証フェーズ

### Step 7: ページごとの表示確認

1. 実際のサイトで以下のページを開き、HTML ソースを確認する：

   * 任意のブログ記事ページ
   * ブログ一覧ページ（トップまたはアーカイブ）
   * 筆者ページ（author ページ）

2. それぞれの `<head>` 内に、期待する JSON-LD スクリプトが出力されているかを確認する。

### Step 8: 構造化データテストツールによる検証

1. Google のリッチリザルトテスト等に URL を入力。
2. `BlogPosting` / `ItemList` / `Person` が認識され、エラーや重大な警告が出ていないか確認。
3. 必要に応じてプロパティを追加・削除して調整する。

---

## 8. リファクタリング・ドキュメント整備

### Step 9: コード整理とコメント

* 関数名・変数名を見直し、テーマの命名規則に合わせる
* 各関数の冒頭に「何を出力する関数か」を PHPDoc コメントで明記
* `AGENTS.md` / `PLANS.md` と実装の間に齟齬がないか確認

### Step 10: 管理者向けメモ

* 今後 JSON-LD を拡張したい場合の手順を簡易ドキュメントにまとめる：

  * 新しいスキーマを追加するときの方針
  * テスト方法
  * 影響範囲（どのテンプレートに影響するか）

---

## 9. 完了条件（Acceptance Criteria）

* [ ] 単一投稿ページで `BlogPosting` JSON-LD が正しく出力されている
* [ ] ブログ一覧ページで `ItemList`（＋必要に応じて `Blog`） JSON-LD が出力されている
* [ ] 筆者ページで `Person` JSON-LD（または `ProfilePage`＋`Person`）が出力されている
* [ ] すべての JSON-LD が有効な JSON であり、構造化データテストツールでエラーが出ない
* [ ] 不要なページ（固定ページなど）で誤った JSON-LD が出力されていない
* [ ] コードが専用ファイルまたは関数に集約されており、メンテナンスしやすい

```


もっと細かく「具体的な PHP コードまで全部書いた版」が欲しければ、そのまま続きで用意します。
```
