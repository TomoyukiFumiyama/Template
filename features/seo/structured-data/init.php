<?php
/**
 * Structured data bootstrap.
 */
if ( ! defined( 'ABSPATH' ) ) {
        exit;
}

require_once __DIR__ . '/class-structured-data-generator.php';
require_once __DIR__ . '/schema-website.php';
require_once __DIR__ . '/schema-organization.php';
require_once __DIR__ . '/schema-breadcrumbs.php';
require_once __DIR__ . '/schema-article.php';
require_once __DIR__ . '/schema-service.php';

MyTheme_Structured_Data_Generator::register_schema( 'mytheme_structured_data_schema_website' );
MyTheme_Structured_Data_Generator::register_schema( 'mytheme_structured_data_schema_organization' );
MyTheme_Structured_Data_Generator::register_schema( 'mytheme_structured_data_schema_breadcrumbs' );
MyTheme_Structured_Data_Generator::register_schema( 'mytheme_structured_data_schema_article' );
MyTheme_Structured_Data_Generator::register_schema( 'mytheme_structured_data_schema_service' );

MyTheme_Structured_Data_Generator::init();
