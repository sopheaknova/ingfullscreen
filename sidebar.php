<?php
/**
 * The sidebar containing the main widget area.
 */

global $post;
?>
	<?php
		if ( is_single() || is_page() || is_singular('sp_project') ) {
		
		$layout_type = get_post_meta($post->ID, 'sp_page_layout', true);
		$sidebar_choice = get_post_meta($post->ID, 'sp_selected_sidebar', true);
	?>

	<?php if( ($sidebar_choice != "" ) && ( $layout_type !="1col") ) { ?>
	<aside id="sidebar" class="widget-area" role="complementary">
	<?php
		if ( is_active_sidebar( $sidebar_choice ) ) :
			dynamic_sidebar( $sidebar_choice );
		else:
	?>
		<div class="non-widget widget">
		    <h5><?php _e('About Default Sidebar'); ?></h5>
		    <p class="noside"><?php _e('To edit this sidebar, go to admin backend\'s <strong><em>Appearance -&gt; Widgets</em></strong> and place widgets into the <strong><em>Default Sidebar</em></strong> Area', SP_TEXT_DOMAIN); ?></p>
		</div>
	<?php endif; ?>	
	</aside> <!--End #Sidebar-->
	<?php } 	 
		} 
	?>