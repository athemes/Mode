<?php
/**
 * Mode functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Mode
 */

if ( ! function_exists( 'mode_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function mode_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Mode, use a find and replace
		 * to change 'mode' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'mode', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		add_image_size( 'mode-medium-thumb', 400 );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'mode' ),
			'footer-menu' => esc_html__( 'Footer', 'mode' ),
			'menu-social-header' => esc_html__( 'Social Header', 'mode' ),
			'menu-social-footer' => esc_html__( 'Social Footer', 'mode' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'mode_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'mode_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function mode_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'mode_content_width', 640 );
}
add_action( 'after_setup_theme', 'mode_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function mode_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'mode' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'mode' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Instagram', 'mode' ),
		'id'            => 'footer-instagram',
		'description'   => '',
		'before_widget' => '<div id="mo-footer-instagram" class="mo-instagram-feed mo-instagram-feed--widget js-mo-widget-instagram-feed owl-carousel owl-theme">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_widget( 'Mode_Social' );
	register_widget( 'Mode_Sidebar_Posts' );
	register_widget( 'Mode_Author' );
}
add_action( 'widgets_init', 'mode_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function mode_scripts() {

	wp_enqueue_style( 'mode-fonts', '//fonts.googleapis.com/css?family=Playfair+Display:400,400i,700|Work+Sans:300,400,500,600', array(), null );

	wp_enqueue_style( 'mode-style', get_stylesheet_uri() );

	wp_dequeue_style('mode-font-awesome');

	wp_enqueue_style( 'mode-icons', get_template_directory_uri() . '/fonts/font-awesome-essential.css' );

	wp_enqueue_script( 'mode-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'mode-owl-script', get_template_directory_uri() . '/js/owl.carousel.js', array('jquery'),'2.3.2', true );

	wp_enqueue_script( 'mode-main', get_template_directory_uri() . '/js/main.js', array('jquery'), '20180208', true );

	wp_enqueue_script( 'mode-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_style( 'mode-owl-css', get_template_directory_uri() . '/css/owl.carousel.css' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'mode_scripts' );

/**
 * Enqueue Bootstrap
 */
function mode_enqueue_bootstrap() {
	wp_enqueue_style( 'mode-bootstrap', get_template_directory_uri() . '/css/bootstrap/bootstrap.min.css', array(), true );
}
add_action( 'wp_enqueue_scripts', 'mode_enqueue_bootstrap', 9 );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/footer-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load Woocommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Widgets
 */
require get_template_directory() . '/widgets/class-mode-social.php';
require get_template_directory() . '/widgets/class-mode-sidebar-posts.php';
require get_template_directory() . '/widgets/class-mode-author.php';

/**
 * Recommend plugins
 */
require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'mode_recommended_plugins' );
function mode_recommended_plugins() {

    $plugins[] = array(
		'name'               => 'Contact Form 7',
		'slug'               => 'contact-form-7',
		'required'           => false,
    );

    $plugins[] = array(
		'name'               => 'MailChimp for WordPress',
		'slug'               => 'mailchimp-for-wp',
		'required'           => false,
	); 
	
	$plugins[] = array(
		'name'               => 'WP Instagram Widget',
		'slug'               => 'wp-instagram-widget',
		'required'           => false,
	);

    $plugins[] = array(
		'name'               => 'Kirki',
		'slug'               => 'kirki',
		'required'           => false,
    );      

    tgmpa( $plugins);

}