<?php
/**  Home URI */
define('BASE_URI', 'http://' .  $_SERVER['HTTP_HOST']);

/**  Image directory URI */
define('IMAGE_URI', BASE_URI . '/assets/images/');

/**  Style directory URI */
define('STYLE_URI', BASE_URI . '/assets/css/');

/**  Style directory URI */
define('SCRIPT_URI', BASE_URI . '/assets/js/');

/**  Fonts directory URI */
define('FONTS_URI', BASE_URI . '/assets/fonts/');

/**  Base directory Path */
define('BASE_PATH', dirname(__FILE__) );

/**  library directory Path */
define('LIB_PATH', BASE_PATH . '/inc/library/' );

/**  Includes directory Path */
define('CLASS_PATH', BASE_PATH . '/inc/class/' );

/**  Includes directory Path */
define('INC_PATH', BASE_PATH . '/inc/' );

/**  Gloabl js file Path */
define('GLOBAL_JS', INC_PATH . 'global-script.php' );

/**  Ajax on forms enable or disabled */
define('IS_AJAX', true );

/**  Currenty Symbol */
define('CURR_SY', '&euro;' );

/**  Currenty Symbol */
define( 'SESS_ID', session_id() );