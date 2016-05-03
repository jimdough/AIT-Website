<?php
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Pro Functions
 *
 * Functions for the pro theme
 *
 * Please do not edit this file. This file is part of the CyberChimps Framework and all modifications
 * should be made in a child theme.
 *
 * @category Responsive Pro
 * @package  Responsive Pro
 * @since    1.0
 * @author   CyberChimps
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.cyberchimps.com/
 */

/**
 * Check for theme updates
 */
require_once( get_template_directory() . '/pro/update.php' );
new WPUpdatesThemeUpdater( 'http://wp-updates.com/api/1/theme', 311, basename( get_template_directory() ) );

/**
 *
 * Remove core options styling and add pro options styling
 *
 * @return null
 */
function responsive_pro_admin_enqueue_scripts( $hook_suffix ) {
    $template_directory_uri = get_template_directory_uri();

    wp_dequeue_style( 'responsive-theme-options' );
    wp_enqueue_style( 'responsive-pro-theme-options', $template_directory_uri . '/pro/options/lib/css/options.css', false, '1.0' );
    wp_enqueue_media();
    wp_enqueue_script( 'responsive-pro-options-js', $template_directory_uri . '/pro/options/lib/js/options-scripts.js', false, '1.0' );
}

add_action( 'admin_print_styles-appearance_page_theme_options', 'responsive_pro_admin_enqueue_scripts' );

/**
 * Enqueue responsive pro styles and scripts
 *
 * @return void
 */
function responsive_pro_scripts() {
    wp_enqueue_style( 'pro-css', get_template_directory_uri() . '/pro/lib/css/style.css', false, '1.0' );
}

add_action( 'wp_enqueue_scripts', 'responsive_pro_scripts' );

/**
 * Remove the cyberchimps upgrade bar from options
 */
remove_action( 'responsive_theme_options', 'responsive_upgrade_bar', 1 );

/**
 * Remove the options core header links
 */
remove_action( 'responsive_theme_options', 'responsive_theme_support', 2 );

/**
 * Print the option links to the options page header
 */
function responsive_pro_theme_support() {
    ?>

    <div id="header-links-wrapper" class="grid col-940">
        <div class="header-links">

            <a class="button" href="<?php echo esc_url( 'http://themeid.com/docs/', 'responsive' ); ?>" title="<?php esc_attr_e( 'Instructions', 'responsive' ); ?>" target="_blank">
                <?php _e( 'Instructions', 'responsive' ); ?></a>

            <a class="button button-primary" href="<?php echo esc_url( 'http://themeid.com/support/', 'responsive' ); ?>" title="<?php esc_attr_e( 'Help', 'responsive' ); ?>" target="_blank">
                <?php _e( 'Help', 'responsive' ); ?></a>

            <a class="button" href="<?php echo esc_url( 'https://webtranslateit.com/en/projects/3598-Responsive-Theme', 'responsive' ); ?>" title="<?php esc_attr_e( 'Translate', 'responsive' ); ?>"
               target="_blank">
                <?php _e( 'Translate', 'responsive' ); ?></a>

            <a class="button" href="<?php echo esc_url( 'http://themeid.com/showcase/', 'responsive' ); ?>" title="<?php esc_attr_e( 'Showcase', 'responsive' ); ?>" target="_blank">
                <?php _e( 'Showcase', 'responsive' ); ?></a>

            <a class="button" href="<?php echo esc_url( 'http://themeid.com/themes/', 'responsive' ); ?>" title="<?php esc_attr_e( 'More Themes', 'responsive' ); ?>" target="_blank">
                <?php _e( 'More Themes', 'responsive' ); ?></a>

        </div>
    </div>

<?php
}

add_action( 'responsive_theme_options', 'responsive_pro_theme_support', 3 );

/**
 * Adds favicon to header
 */
function responsive_pro_favicon() {
    global $responsive_options;
    $favicon = ( isset( $responsive_options['favicon'] ) ) ? $responsive_options['favicon'] : false;

    if( $favicon && $favicon != '' ) : ?>
        <link rel="shortcut icon" href="<?php echo esc_url( $favicon ); ?>" type="image/x-icon"/>
    <?php
    endif;
}

add_action( 'wp_head', 'responsive_pro_favicon', 2 );
add_action( 'admin_head', 'responsive_pro_favicon', 2 );

// add apple touch icon
function responsive_pro_apple() {
    global $responsive_options;
    $apple = ( isset( $responsive_options['apple_touch_icon'] ) ) ? $responsive_options['apple_touch_icon'] : false;
    if( $apple && $apple != '' ): ?>
        <link rel="apple-touch-icon" href="<?php echo esc_url( $apple ); ?>"/>
    <?php
    endif;
}

add_action( 'wp_head', 'responsive_pro_apple', 2 );

/**
 * remove responsive free woocommerce wrappers
 */
remove_action( 'woocommerce_before_main_content', 'responsive_woocommerce_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'responsive_woocommerce_wrapper_end', 10 );

/*
 * add responsive pro woocommerce wrappers
 */
add_action( 'woocommerce_before_main_content', 'responsive_pro_woocommerce_wrapper', 10 );
add_action( 'woocommerce_after_main_content', 'responsive_pro_woocommerce_wrapper_end', 10 );

/**
 * Creates starting woocommerce wrapper that allows the user to use the page
 * templates on the shop page. Not all page layouts work and will default to right
 * sidebar display
 */
function responsive_pro_woocommerce_wrapper() {
    $template_name = get_post_meta( get_option( 'woocommerce_shop_page_id' ), '_wp_page_template', true );

    switch( $template_name ) {
        case 'default':
            echo '<div id="content woocommerce" class="grid col-620">';
            break;
        case 'blog.php':
            echo '<div id="content-woocommerce" class="grid col-620">';
            break;
        case 'blog-excerpt.php':
            echo '<div id="content-woocommerce" class="grid col-620">';
            break;
        case 'content-sidebar-page.php':
            echo '<div id="content-woocommerce" class="grid col-620">';
            break;
        case 'content-sidebar-half-page.php':
            echo '<div id="content-woocommerce" class="grid col-460">';
            break;
        case 'full-width-page.php':
            echo '<div id="content-woocommerce" class="grid col-940">';
            break;
        case 'landing-page.php':
            echo '<div id="content-woocommerce" class="grid col-620">';
            break;
        case 'sidebar-content-page.php':
            echo '<div id="content-woocommerce" class="grid-right col-620 fit">';
            break;
        case 'sidebar-content-half-page.php':
            echo '<div id="content-woocommerce" class="grid-right col-460 fit">';
            break;
        case 'sitemap.php':
            echo '<div id="content-woocommerce" class="grid col-620">';
            break;
        default:
            echo '<div id="content-woocommerce" class="grid col-620">';
            break;
    }
}

/**
 * Creates ending woocommerce wrapper that allows the user to use the page
 * templates on the shop page. Not all page layouts work and will default to right
 * sidebar display
 */
function responsive_pro_woocommerce_wrapper_end() {
    echo '</div><!-- end of #content-woocommerce -->';
    $template_file = get_post_meta( get_option( 'woocommerce_shop_page_id' ), '_wp_page_template', true );
    $template_name = substr( $template_file, 0, -4 );
    switch( $template_name ) {
        case 'default':
            get_sidebar();
            break;
        case 'blog.php':
            get_sidebar();
            break;
        case 'blog-excerpt.php':
            get_sidebar();
            break;
        case 'content-sidebar-page.php':
            get_sidebar( 'right' );
            break;
        case 'content-sidebar-half-page.php':
            get_sidebar( 'right-half' );
            break;
        case 'full-width-page.php':
            break;
        case 'landing-page.php':
            get_sidebar();
            break;
        case 'sidebar-content-page.php':
            get_sidebar( 'left' );
            break;
        case 'sidebar-content-half-page.php':
            get_sidebar( 'left-half' );
            break;
        case 'sitemap.php':
            get_sidebar();
            break;
        default:
            get_sidebar();
            break;
    }
}

// Return value of the supplied responsive pro theme option.
function responsive_pro_get_option( $option, $default = false ) {
    global $responsive_options;

    // If the option is set then return it's value, otherwise return false.
    if( isset( $responsive_options[$option] ) ) {
        return $responsive_options[$option];
    }

    return $default;
}

//Prints HTML with meta information for the current post date/time.
if( !function_exists( 'responsive_pro_posted_on' ) ) {

    function responsive_pro_posted_on() {

        // Get value of post byline date toggle option from theme option for different pages
        if( is_single() ) {
            $show_date = responsive_pro_get_option( 'single_byline_date' );
        }
        elseif( is_archive() ) {
            $show_date = responsive_pro_get_option( 'archive_byline_date' );
        }
        else {
            $show_date = responsive_pro_get_option( 'blog_byline_date' );
        }

        // Get all data related to date.
        $date_url   = esc_url( get_permalink() );
        $date_title = esc_attr( get_the_time() );
        $date_time  = esc_attr( get_the_time() );
        $date_time  = esc_attr( get_the_date( 'c' ) );
        $date       = esc_html( get_the_date() );

        // Set the HTML for date link.
        $posted_on = __( 'Posted on ', 'responsive' ) .
            '<a href="' . $date_url . '" title="' . $date_title . '" rel="bookmark">
				<time class="entry-date" datetime="' . $date_time . '">' . $date . '</time>
			</a>';

        // If post byline date toggle is on then print HTML for date link.
        if( $show_date ) {
            echo $posted_on;
        }
    }
}

// Prints HTML for author link of the post.
if( !function_exists( 'responsive_pro_posted_by' ) ) {
    function responsive_pro_posted_by() {

        // Get value of post byline author toggle option from theme option for different pages
        if( is_single() ) {
            $show_author = responsive_pro_get_option( 'single_byline_author' );
        }
        elseif( is_archive() ) {
            $show_author = responsive_pro_get_option( 'archive_byline_author' );
        }
        else {
            $show_author = responsive_pro_get_option( 'blog_byline_author' );
        }

        // Get url of all author archive( the page will contain all posts by the author).
        $auther_posts_url = esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );

        // Set author title text which will appear on hover over the author link.
        $auther_link_title = esc_attr( sprintf( __( 'View all posts by %s', 'responsive' ), get_the_author() ) );

        // Set the HTML for author link.
        $posted_by = '
			<span class="byline">
				' . __( ' by ', 'responsive' ) . '
				<span class="author vcard">
					<a class="url fn n" href="' . $auther_posts_url . '" title="' . $auther_link_title . '" rel="author">
						' . esc_html( get_the_author() ) . '
					</a>
				</span>
			</span>';

        // If post byline author toggle is on then print HTML for author link.
        if( $show_author ) {
            echo $posted_by;
        }
    }
}

//add meta entry category to single post, archive and blog list if set in options
if( !function_exists( 'responsive_pro_posted_in' ) ) {
    function responsive_pro_posted_in() {

        // Get value of post byline categories toggle option from theme option for different pages
        if( is_single() ) {
            $show_categories = responsive_pro_get_option( 'single_byline_categories' );
        }
        elseif( is_archive() ) {
            $show_categories = responsive_pro_get_option( 'archive_byline_categories' );
        }
        else {
            $show_categories = responsive_pro_get_option( 'blog_byline_categories' );
        }

        if( $show_categories ) {
            $categories_list = get_the_category_list( ', ' );
            if( $categories_list ) {
                $cats = sprintf( __( 'Posted in', 'responsive' ) . ' %1$s', $categories_list );
                ?>
                <span class="cat-links">
					<?php echo $cats; ?>
				</span>
            <?php
            }
        }
    }
}

//add meta entry tags to single post, archive and blog list if set in options
if( !function_exists( 'responsive_pro_post_tags' ) ) {
    function responsive_pro_post_tags() {

        // Get value of post byline tags toggle option from theme option for different pages
        if( is_single() ) {
            $show_tags = responsive_pro_get_option( 'single_byline_tags' );
        }
        elseif( is_archive() ) {
            $show_tags = responsive_pro_get_option( 'archive_byline_tags' );
        }
        else {
            $show_tags = responsive_pro_get_option( 'blog_byline_tags' );
        }

        if( $show_tags ) {
            $tags_list = get_the_tag_list( '', ', ' );
            if( $tags_list ) {
                $tags = sprintf( __( 'Tags:', 'responsive' ) . ' %1$s', $tags_list );
                ?>
                <span class="taglinks">
					<?php echo apply_filters( 'cyberchimps_post_tags', $tags ); ?>
				</span>
            <?php
            }
        }
    }
}

//add meta entry comments count link to single post, archive and blog list if set in options
if( !function_exists( 'responsive_pro_comments_link' ) ) {
    function responsive_pro_comments_link() {

        // Get value of post byline tags toggle option from theme option for different pages
        if( is_single() ) {
            $show_comments_link = responsive_pro_get_option( 'single_byline_comments' );
        }
        elseif( is_archive() ) {
            $show_comments_link = responsive_pro_get_option( 'archive_byline_comments' );
        }
        else {
            $show_comments_link = responsive_pro_get_option( 'blog_byline_comments' );
        }

        if( $show_comments_link && comments_open() ) {
            ?>
            <span class="comments-link">
				<span class="mdash">&mdash;</span>
                <?php comments_popup_link( __( 'No Comments &darr;', 'responsive' ), __( '1 Comment &darr;', 'responsive' ), __( '% Comments &darr;', 'responsive' ) ); ?>
			</span>
        <?php
        }
    }
}

// Display featured image if toggle is on.
if( !function_exists( 'responsive_pro_featured_image' ) ) {
    function responsive_pro_featured_image() {

        // Get value of post byline tags toggle option from theme option for different pages
        if( is_single() ) {
            $show_image = responsive_pro_get_option( 'single_featured_images' );
        }
        elseif( is_archive() ) {
            $show_image = responsive_pro_get_option( 'archive_featured_images' );
        }
        else {
            $show_image = responsive_pro_get_option( 'blog_featured_images' );
        }

        if( $show_image && has_post_thumbnail() ) {
            ?>
            <div class="featured-image">
                <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'responsive' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
                    <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'alignleft' ) ); ?>
                </a>
            </div>
        <?php
        }
    }
}

// Set defaults of responsive pro theme options.
function responsive_pro_option_defaults( $defaults ) {
    $defaults['blog_post_excerpts']        = 1;
    $defaults['blog_featured_images']      = 1;
    $defaults['blog_byline_author']        = 1;
    $defaults['blog_byline_categories']    = 1;
    $defaults['blog_byline_date']          = 1;
    $defaults['blog_byline_comments']      = 1;
    $defaults['blog_byline_tags']          = 1;
    $defaults['single_featured_images']    = 1;
    $defaults['single_byline_author']      = 1;
    $defaults['single_byline_categories']  = 1;
    $defaults['single_byline_date']        = 1;
    $defaults['single_byline_comments']    = 1;
    $defaults['single_byline_tags']        = 1;
    $defaults['archive_post_excerpts']     = 1;
    $defaults['archive_featured_images']   = 1;
    $defaults['archive_byline_author']     = 1;
    $defaults['archive_byline_categories'] = 1;
    $defaults['archive_byline_date']       = 1;
    $defaults['archive_byline_comments']   = 1;
    $defaults['archive_byline_tags']       = 1;
    $defaults['search_post_excerpts']      = 1;
    $defaults['font_size']                 = '14';
    $defaults['heading_colorpicker']       = '';
    $defaults['text_colorpicker']          = '';
    $defaults['link_colorpicker']          = '';
    $defaults['link_hover_colorpicker']    = '';
    $defaults['font_heading']              = 'Arial, Helvetica, sans-serif';
    $defaults['google_font_heading']       = '';
    $defaults['font_text']                 = 'Arial, Helvetica, sans-serif';
    $defaults['google_font_text']          = '';
    $defaults['skin']                      = 'default';
    $defaults['blog_post_title_text']      = 'Blog';

    return $defaults;
}

add_filter( 'responsive_option_defaults', 'responsive_pro_option_defaults' );

/**
 * This function adds theme's breadcrumb style for the required woocommerce pages.
 */
function responsive_woo_breadcrumbs( $defaults ) {

    $defaults['delimiter']   = ' <span class="chevron">&#8250;</span> ';
    $defaults['wrap_before'] = '<div class="breadcrumb-list">';
    $defaults['wrap_after']  = '</div>';

    return $defaults;

}

add_filter( 'woocommerce_breadcrumb_defaults', 'responsive_woo_breadcrumbs', 10, 1 );

/**
 * This function removes the bbpress breadcrumbs as they are duplicate to the themes breadcrumbs.
 */
function responsive_remove_bbp_breadcrumbs( $trail, $crumbs, $r ) {

    $crumbs = '';

    return $crumbs;

}

add_filter( 'bbp_get_breadcrumb', 'responsive_remove_bbp_breadcrumbs', 10, 3 );

/**
 * Creates an array with friendly font name and the param
 *
 * @param $font
 *
 * @return array
 */
function responsive_google_font( $font = '' ) {
    if( $font != '' ) {
        // Capitalize the first letter of each word to follow Google Font's naming convention
        $google['font']  = ucwords( $font );
        $google['param'] = trim( str_replace( ' ', '+', $google['font'] ) );

        return $google;
    }
    else {
        return null;
    }
}

// creates body styles from options
function responsive_customize_styles() {

    // get the options
    $responsive_options = responsive_get_options();

    // set the variables
    $font_size           = get_theme_mod( 'responsive_font_size' );
    $heading_color       = get_theme_mod( 'responsive_heading_colorpicker' );
    $text_color          = get_theme_mod( 'responsive_text_colorpicker' );
    $link_color          = get_theme_mod( 'responsive_link_colorpicker' );
    $link_hover_color    = get_theme_mod( 'responsive_link_hover_colorpicker' );
    $font_heading        = get_theme_mod( 'responsive_font_heading' );
    $google_font_heading = ( get_theme_mod( 'responsive_google_font_heading' ) != '' ) ? responsive_google_font( get_theme_mod( 'responsive_google_font_heading' ) ) : '';
    $font_text           = get_theme_mod( 'responsive_font_text' );
    $google_font_text    = ( get_theme_mod( 'responsive_google_font_text' ) != '' ) ? responsive_google_font( get_theme_mod( 'responsive_google_font_text' ) ) : '';

    // create a string to add to the google font stylesheet call
    $google_param = ( $google_font_heading != '' ) ? $google_font_heading['param'] : '';
    $google_param .= ( $google_font_heading != '' && $google_font_text != '' ) ? '|' : '';
    $google_param .= ( $google_font_text != '' ) ? $google_font_text['param'] : '';

    if( $google_font_heading != '' && $font_heading == 'google' || $google_font_text != '' && $font_text == 'google' ) {
        ?>
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo $google_param; ?>">
    <?php
    }?>
    <style type="text/css" id="customizer_styles">
        <?php
        /**
         * Body styles
         */
        ?>
        body {
        <?php
        if( $text_color != '' ) {?> color: <?php echo esc_html( $text_color ); ?>;
        <?php }
        if( $font_text != 'google' ) { ?> font-family: <?php echo esc_html( $font_text ); ?>;
        <?php }
        elseif( $google_font_text != '' ) {?> font-family: '<?php echo esc_html( $google_font_text['font'] ); ?>';
        <?php }
        if( $font_size != '' ) {?> font-size: <?php echo absint( $font_size ); ?>px;
        <?php } ?>
        }

        <?php
        /**
         * Heading styles
         */
        if( $heading_color != '' || $google_font_heading != '' || $font_heading != '' ) { ?>
        h1, h2, h3, h4, h5, h6, .widget-title {
        <?php
        if( $heading_color != '' ) { ?> color: <?php echo esc_html( $heading_color ); ?>;
        <?php
        }
        if( $font_heading != 'google' ) { ?> font-family: <?php echo esc_html( $font_heading ); ?>;
        <?php
        }
        elseif( $google_font_heading != '' ) {?> font-family: '<?php echo esc_html( $google_font_heading['font'] ); ?>';
        <?php } ?>
        }

        <?php
        }
        /**
         * Link Styles
         */
        if( $link_color != '' ) { ?>
        a {
            color: <?php echo esc_html( $link_color ); ?>;
        }

        <?php }
        if( $link_hover_color != '' ) { ?>
        a:hover {
            color: <?php echo esc_html( $link_hover_color ); ?>;
        }

        <?php
        /**
         * Buttons
         */
        }
        if( $font_text != '' ) { ?>
        input[type='reset'], input[type='button'], input[type='submit'] {
        <?php
            if( $font_text != 'google' ) { ?> font-family: <?php echo esc_html( $font_text ); ?>;
        <?php }
            elseif( $google_font_text != '' ) {?> font-family: '<?php echo esc_html( $google_font_text['font'] ); ?>';
        <?php
            }?>
        }
        <?php
    }?>
    </style>
<?php
}

add_action( 'wp_head', 'responsive_customize_styles', 100 );

/**
 * Create stylesheet for skins
 *
 * @print stylesheet
 */
function responsive_pro_skin() {
    // Get skin option
    $skin = get_theme_mod( 'responsive_skin', 'default' );

    if( $skin && $skin != 'default' ) {
        ?>
        <link rel="stylesheet" id="responsive_skin" type="text/css" href="<?php echo get_template_directory_uri(); ?>/pro/lib/css/skins/<?php echo urlencode( $skin ); ?>.css">
    <?php
    }
}

add_action( 'wp_head', 'responsive_pro_skin', 50 );

/**
 * Add custom mobile menu title to header
 */
if( !function_exists( 'responsive_custom_mobile_menu_title' ) ) :
    function responsive_custom_mobile_menu_title() {

        global $responsive_options;

        if( isset( $responsive_options['custom_mobile_menu_title'] ) && $responsive_options['custom_mobile_menu_title'] != '' ) {
            echo '<span class="custom-mobile-menu-title">' . esc_html( $responsive_options['custom_mobile_menu_title'] ) . '</span>';
        }

    }
endif;

add_action( 'responsive_header_bottom', 'responsive_custom_mobile_menu_title' );

// Excerpt more text.
function responsive_pro_excerpt_more_text( $more ) {
    global $post;

    // Get the excerpt more text from option.
    $text = responsive_pro_get_option( 'excerpts_text', 'Read More...' );
    $text = $text == '' ? 'Read More...' : $text;

    $more = '<p><a class="excerpt-more blog-excerpt" href="' . get_permalink( $post->ID ) . '">' . esc_html( $text ) . '</a></p>';

    return $more;

}

// Excerpt more length.
function responsive_pro_excerpt_more_length( $length ) {
    global $post;

    // Get the excerpt more length from option.
    $length = responsive_pro_get_option( 'excerpts_length', 50 );
    $length = $length == "" ? 50 : $length;

    return $length;
}

/**
 * Add link to theme options in Admin bar.
 */
function responsive_pro_admin_bar_link() {
    global $wp_admin_bar;

    $wp_admin_bar->add_menu( array(
                                 'id'    => 'responsive_pro_theme_option',
                                 'title' => __( 'Responsive Pro Options', 'responsive' ),
                                 'href'  => admin_url( 'themes.php?page=theme_options' )
                             ) );
}

add_action( 'admin_bar_menu', 'responsive_pro_admin_bar_link', 133 );

/**
 * Site Verification and Webmaster Tools
 * If user sets the code we're going to display meta verification
 * And if left blank let's not display anything at all in case there is a plugin that does this
 */

function responsive_google_verification() {
    global $responsive_options;
    if (!empty($responsive_options['google_site_verification'])) {
        echo '<meta name="google-site-verification" content="' . $responsive_options['google_site_verification'] . '" />' . "\n";
    }
}

add_action('wp_head', 'responsive_google_verification');

function responsive_bing_verification() {
    global $responsive_options;
    if (!empty($responsive_options['bing_site_verification'])) {
        echo '<meta name="msvalidate.01" content="' . $responsive_options['bing_site_verification'] . '" />' . "\n";
    }
}

add_action('wp_head', 'responsive_bing_verification');

function responsive_yahoo_verification() {
    global $responsive_options;
    if (!empty($responsive_options['yahoo_site_verification'])) {
        echo '<meta name="y_key" content="' . $responsive_options['yahoo_site_verification'] . '" />' . "\n";
    }
}

add_action('wp_head', 'responsive_yahoo_verification');

function responsive_site_statistics_tracker() {
    global $responsive_options;
    if (!empty($responsive_options['site_statistics_tracker'])) {
        echo $responsive_options['site_statistics_tracker'];
    }
}

add_action('wp_head', 'responsive_site_statistics_tracker');