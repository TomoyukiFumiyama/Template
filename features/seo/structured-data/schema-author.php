<?php
/**
 * Author profile schema generator.
 */
if ( ! defined( 'ABSPATH' ) ) {
        exit;
}

if ( ! function_exists( 'mytheme_structured_data_schema_author_profile' ) ) {
        /**
         * Outputs a ProfilePage schema whose main entity is the requested author.
         *
         * @return array|null
         */
        function mytheme_structured_data_schema_author_profile() {
                if ( ! is_author() ) {
                        return null;
                }

                $author = get_queried_object();
                if ( ! $author instanceof WP_User ) {
                        return null;
                }

                $author_id     = (int) $author->ID;
                $person_schema = MyTheme_Structured_Data_Generator::get_author_schema( null, $author_id );
                if ( empty( $person_schema ) || empty( $person_schema['name'] ) ) {
                        return null;
                }

                $profile_url = isset( $person_schema['url'] ) ? $person_schema['url'] : get_author_posts_url( $author_id );
                $page_name   = sprintf( __( '%s - Author Profile', 'mytheme' ), $person_schema['name'] );

                $schema = array(
                        '@context'   => 'https://schema.org',
                        '@type'      => 'ProfilePage',
                        'name'       => MyTheme_Structured_Data_Generator::sanitize_text( $page_name ),
                        'url'        => $profile_url,
                        'mainEntity' => $person_schema,
                );

                if ( ! empty( $person_schema['description'] ) ) {
                        $schema['description'] = $person_schema['description'];
                }

                return apply_filters( 'mytheme_structured_data_author_profile', $schema, $author_id );
        }
}
