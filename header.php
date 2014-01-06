<?php 
	global $smof_data;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
	<title><?php wp_title('|', true, 'right'); ?></title>

	<?php if ( isset($smof_data['theme_favicon']) && $smof_data['theme_favicon'] ) : ?>
	<link rel="shortcut icon" href="<?php echo SP_BASE_URL; ?>favicon.ico" type="image/x-icon" />
	<?php endif; ?>
	
	<!-- add feeds, pingback and stuff-->
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS Feed" href="<?php echo ($smof_data['feedburner'] == '') ? bloginfo( 'rss2_url' ) :  $smof_data['feedburner']; ?>" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php wp_head(); ?>

	<?php 
		$img_background = rwmb_meta( 'sp_background_page', $args = array('type' => 'plupload_image', 'size' => 'large') ); 
		$slide_background = '';
	?>

</head>

<body <?php body_class(); ?>>
<div id="page">

	<header id="header">
		<div class="container clearfix">
            <div class="brand" role="banner">
                <?php if( !is_singular() ) echo '<h1>'; else echo '<h2>'; ?>
                
                <a  href="<?php echo home_url() ?>/"  title="<?php echo esc_attr( get_bloginfo('name', 'display') ); ?>">
                    <?php if( isset($smof_data['theme_logo']) && $smof_data['theme_logo'] ) : ?>
                    <img src="<?php echo $smof_data['theme_logo']; ?>" alt="<?php echo esc_attr( get_bloginfo('name', 'display') ); ?>" />
                    <?php else: ?>
                    <span><?php bloginfo( 'name' ); ?></span>
                    <?php endif; ?>
                </a>
                
                <?php if( !is_singular() ) echo '</h1>'; else echo '</h2>'; ?>
            </div><!-- end .brand -->
            
            <?php if( !(is_page_template("template-underconstruction.php")) ) { ?>
            <nav id="main-nav" class="primary-nav" role="navigation">
	        	<?php echo sp_main_navigation(); ?>
			</nav><!-- #main-nav -->
			<?php } ?>
            
		</div><!-- end .container .clearfix -->
    </header><!-- end #header -->