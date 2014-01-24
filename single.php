<?php
/**
 * The template for displaying all pages.
 */

get_header(); ?>

<?php if ($post->post_type == 'sp_project'): ?>
<div id="content">
	<div class="container clearfix">
		<div id="main" class="min">
    	<?php get_template_part('includes/loop', 'project'); ?>
		</div>
	<!-- .$page_layout -->
	</div>
	<!-- .inner-content -->
</div>
<!-- #content -->
<?php get_sidebar(); ?>

<?php else : ?>
<?php 
	$page_layout = get_post_meta($post->ID, 'sp_page_layout', true);
	$disable_content = get_post_meta($post->ID, 'sp_diable_content_box', true);
	if ( '1col' != $page_layout )
		$page_layout = 'min';
	else
		$page_layout = 'full-width';
?>	
<div id="content">
	<div class="container clearfix">
		<div id="main" class="<?php echo $page_layout; ?>">
    	<?php get_template_part( 'includes/loop', 'index' ); ?>
		</div><!-- .$page_layout -->
		<?php get_sidebar(); ?>
		<?php get_template_part( 'includes/social-icons' ); ?>
	</div>
	<!-- .container -->
</div>
<!-- #content -->
<?php endif; ?>	

<?php get_footer(); ?>