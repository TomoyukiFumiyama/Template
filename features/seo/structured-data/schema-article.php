<?php
/**
 * Article schema generator.
 */
if ( ! defined( 'ABSPATH' ) ) {
        exit;
}

if ( ! function_exists( 'mytheme_structured_data_schema_article' ) ) {
        function mytheme_structured_data_schema_article() {
                if ( ! is_singular( 'post' ) ) {
                        return null;
                }

                $post_id = get_queried_object_id();
                if ( ! $post_id ) {
                        return null;
                }

                $schema = array(
                        '@context'         => 'https://schema.org',
                        '@type'            => 'Article',
                        'mainEntityOfPage' => get_permalink( $post_id ),
                        'headline'         => get_the_title( $post_id ),
                        'description'      => MyTheme_Structured_Data_Generator::get_post_description( $post_id ),
                        'datePublished'    => get_the_date( DATE_W3C, $post_id ),
                        'dateModified'     => get_the_modified_date( DATE_W3C, $post_id ),
                        'author'           => MyTheme_Structured_Data_Generator::get_author_schema( $post_id ),
                        'publisher'        => MyTheme_Structured_Data_Generator::get_publisher_schema(),
                );

                $image = MyTheme_Structured_Data_Generator::get_post_image_object( $post_id );
                if ( $image ) {
                        $schema['image'] = $image;
                }

                return apply_filters( 'mytheme_structured_data_article', $schema, $post_id );
        }
}
