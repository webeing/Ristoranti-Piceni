<?php
/**
 * The Header for our theme.
 *
 * @package WordPress
 * @subpackage Ristoranti Piceni
 * @since Ristoranti Piceni 1.0
 */
?><!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?> xmlns:fb="http://www.facebook.com/2008/fbml">
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?> xmlns:fb="http://www.facebook.com/2008/fbml">
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?> xmlns:fb="http://www.facebook.com/2008/fbml">
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?> xmlns:fb="http://www.facebook.com/2008/fbml">
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
    <title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'rp' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.png"/> 
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js" type="text/javascript"></script>
<![endif]-->
<script type="text/javascript">
    <?php
        /*
         * Ristoranti Piceni JS Global variable Init
         */
    ?>

    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    var template_url = '<?php echo get_bloginfo('template_url') ?>';

</script>

<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	wp_head();
?>
</head>

<body <?php body_class(); ?>>

<div id="fb-root"></div>

	<div class="wrap">
	<header id="branding" role="banner" class="row">
		<hgroup class="left">
			<h1 id="site-title"><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<img itemprop="logo" src="<?php bloginfo( 'template_url' ); ?>/images/ristorantipiceni-logo.png" alt="<?php bloginfo('name'); ?>"/></a></span></h1>
			<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
		</hgroup>
		
		<div id="secondary-nav" class="right">
			<nav id="static-nav" class="right">
				<?php wp_nav_menu( array( 'theme_location' => 'static' ) ); ?>
			</nav>
			<nav id="social-top" class="right">
				<?php wp_nav_menu( array( 'theme_location' => 'social' ) ); ?>
				<!--<ul>
					<li><a href="#" title="">facebook</a></li>
					<li><a href="#" title="">flickr</a></li>
				</ul>-->
			</nav>
		</div>
		
		<div class="clear"></div>
		
		<div id="navigation">
			<nav id="primary-nav">
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</nav>
			<?php get_search_form(); ?>
			
			<div class="clear"></div>
		</div>
	</header><!-- #branding -->
	<!-- end header -->

    <?php
        // Slider Section
        get_template_part( 'section', 'slider' );

    ?>


