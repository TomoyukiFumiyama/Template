<?php
/**
 * Core JSON-LD structured data generator.
 */
if ( ! defined( 'ABSPATH' ) ) {
        exit;
}

if ( ! class_exists( 'MyTheme_Structured_Data_Generator' ) ) {
        class MyTheme_Structured_Data_Generator {
                /**
                 * Registered schema callbacks.
                 *
                 * @var array
                 */
                protected static $schema_callbacks = array();

                /**
                 * Bootstraps the structured data output.
                 */
                public static function init() {
                        add_action( 'wp_head', array( __CLASS__, 'render' ), 5 );
                }

                /**
                 * Registers a schema generator callback.
                 *
                 * @param callable $callback Schema generator callback.
                 */
                public static function register_schema( $callback ) {
                        if ( ! is_callable( $callback ) ) {
                                return;
                        }

                        if ( ! in_array( $callback, self::$schema_callbacks, true ) ) {
                                self::$schema_callbacks[] = $callback;
                        }
                }

                /**
                 * Outputs JSON-LD script tags to the head.
                 */
                public static function render() {
                        if ( is_admin() ) {
                                return;
                        }

                        $schemas = array();
                        foreach ( self::get_schema_callbacks() as $callback ) {
                                $schema = call_user_func( $callback );
                                if ( ! empty( $schema ) ) {
                                        $schemas[] = $schema;
                                }
                        }

                        if ( empty( $schemas ) ) {
                                return;
                        }

                        foreach ( $schemas as $schema ) {
                                echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        }
                }

                /**
                 * Returns the registered schema callbacks.
                 *
                 * @return array
                 */
                protected static function get_schema_callbacks() {
                        $callbacks = self::$schema_callbacks;

                        /**
                         * Filters the callbacks used to build JSON-LD schemas.
                         *
                         * @param array $callbacks Registered callbacks.
                         */
                        return apply_filters( 'mytheme_structured_data_schema_callbacks', $callbacks );
                }

                /**
                 * Provides a short text summary for the given post.
                 *
                 * @param int $post_id Post ID.
                 * @return string
                 */
                public static function get_post_description( $post_id ) {
                        $excerpt = get_the_excerpt( $post_id );
                        if ( $excerpt ) {
                                return wp_strip_all_tags( $excerpt );
                        }

                        $content = get_post_field( 'post_content', $post_id );
                        $content = wp_strip_all_tags( $content );

                        return wp_trim_words( $content, 55 );
                }

                /**
                 * Retrieves the primary category for breadcrumb trails.
                 *
                 * @param int $post_id Post ID.
                 * @return WP_Term|null
                 */
                public static function get_primary_category( $post_id ) {
                        $categories = get_the_category( $post_id );
                        if ( empty( $categories ) ) {
                                return null;
                        }

                        $primary = $categories[0];

                        /**
                         * Filters the primary category used in structured data breadcrumbs.
                         *
                         * @param WP_Term $primary Primary category.
                         * @param int     $post_id Post ID.
                         */
                        return apply_filters( 'mytheme_structured_data_primary_category', $primary, $post_id );
                }

                /**
                 * Returns author information for Article schemas.
                 *
                 * @param int $post_id Post ID.
                 * @return array
                 */
                public static function get_author_schema( $post_id ) {
                        $author_id = get_post_field( 'post_author', $post_id );

                        $schema = array(
                                '@type' => 'Person',
                                'name'  => get_the_author_meta( 'display_name', $author_id ),
                        );

                        return apply_filters( 'mytheme_structured_data_author', $schema, $post_id, $author_id );
                }

                /**
                 * Returns the publisher structure for articles and services.
                 *
                 * @return array
                 */
                public static function get_publisher_schema() {
                        $schema = array(
                                '@type' => 'Organization',
                                'name'  => get_bloginfo( 'name' ),
                                'url'   => home_url( '/' ),
                        );

                        $logo = self::get_logo_object();
                        if ( $logo ) {
                                $schema['logo'] = $logo;
                        }

                        return apply_filters( 'mytheme_structured_data_publisher', $schema );
                }

                /**
                 * Returns an ImageObject representing the site logo.
                 *
                 * @return array|null
                 */
                public static function get_logo_object() {
                        $logo_id = get_theme_mod( 'custom_logo' );
                        if ( $logo_id ) {
                                $image = wp_get_attachment_image_src( $logo_id, 'full' );
                                if ( $image ) {
                                        return array(
                                                '@type'  => 'ImageObject',
                                                'url'    => $image[0],
                                                'width'  => isset( $image[1] ) ? (int) $image[1] : null,
                                                'height' => isset( $image[2] ) ? (int) $image[2] : null,
                                        );
                                }
                        }

                        $site_icon = get_site_icon_url();
                        if ( $site_icon ) {
                                return array(
                                        '@type' => 'ImageObject',
                                        'url'   => $site_icon,
                                );
                        }

                        return null;
                }

                /**
                 * Returns an ImageObject for the post thumbnail, if available.
                 *
                 * @param int $post_id Post ID.
                 * @return array|null
                 */
                public static function get_post_image_object( $post_id ) {
                        $thumbnail_id = get_post_thumbnail_id( $post_id );
                        if ( ! $thumbnail_id ) {
                                return null;
                        }

                        $image = wp_get_attachment_image_src( $thumbnail_id, 'full' );
                        if ( ! $image ) {
                                return null;
                        }

                        return array(
                                '@type'  => 'ImageObject',
                                'url'    => $image[0],
                                'width'  => isset( $image[1] ) ? (int) $image[1] : null,
                                'height' => isset( $image[2] ) ? (int) $image[2] : null,
                        );
                }

                /**
                 * Determines whether the current page represents a service.
                 *
                 * @return bool
                 */
                public static function is_service_page() {
                        if ( ! is_page() ) {
                                return false;
                        }

                        $post_id = get_queried_object_id();
                        if ( ! $post_id ) {
                                return false;
                        }

                        $is_service = false;

                        $slug = get_post_field( 'post_name', $post_id );
                        if ( 'services' === $slug ) {
                                $is_service = true;
                        }

                        $template = get_page_template_slug( $post_id );
                        if ( ! $is_service && $template && false !== strpos( $template, 'service' ) ) {
                                $is_service = true;
                        }

                        /**
                         * Filters whether the current page should be treated as a service page.
                         *
                         * @param bool $is_service Detected state.
                         * @param int  $post_id    Page ID.
                         */
                        return (bool) apply_filters( 'mytheme_structured_data_is_service_page', $is_service, $post_id );
                }
        }
}
