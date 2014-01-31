<?php
/**
 * The template for displaying all pages.
 */

get_header(); ?>

<?php 
	$page_layout = get_post_meta($post->ID, 'sp_page_layout', true);
	if ( '1col' != $page_layout )
		$page_layout = 'min';
	else
		$page_layout = 'full-width';
?>	
<div id="content">
	<div class="container clearfix">
		<div id="main" class="<?php echo $page_layout; ?>">
    	<?php if ($post->post_type == 'sp_project') {
    		get_template_part('includes/loop', 'project');
    	} else {
    		get_template_part( 'includes/loop', 'index' ); 
    	}?>
		</div><!-- .$page_layout -->
		<?php get_sidebar(); ?>
		<?php get_template_part( 'includes/social-icons' ); ?>
	</div><!-- .container -->
</div><!-- #content -->

<?php get_footer(); ?>