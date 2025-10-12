<?php
/**
 * Security hardening bootstrap.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/security-hardening.php';

MyTheme_Security_Hardening::init();
