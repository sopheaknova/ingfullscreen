<?php
/**
 * The template for displaying all pages.
 */

get_header(); ?>

<?php
	$page_layout = get_post_meta($post->ID, 'sp_page_layout', true);
	$disable_content = get_post_meta($post->ID, 'sp_diable_content_box', true);

	if ( '1col' != $page_layout )
		$page_layout = 'min';
	else
		$page_layout = 'full-width';
?>

<?php if (!$disable_content) : ?>
<div id="content">
	<div class="container clearfix">
		<div id="main" class="<?php echo $page_layout; ?>">
    	<?php get_template_part( 'includes/loop', 'page' ); ?>
	    </div><!-- #main .$page_layout -->	
	    <?php get_sidebar(); ?>
	    <?php 
	    if ($page_layout == 'min') { 
	    	get_template_part( 'includes/social-icons' ); 
	    }
	    ?>
	</div><!-- .container -->
	
</div>
<!-- #content -->
<?php endif; ?>
<?php get_footer(); ?>