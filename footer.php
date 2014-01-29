<?php global $smof_data; ?>   	
	<?php if( !is_page_template("template-underconstruction.php") ) { ?>

	<?php $disable_content = get_post_meta($post->ID, 'sp_diable_content_box', true); ?>

	<footer id="footer" class="clearfix">
		<div class="join-social">
		<?php
			if ($smof_data['is_social'])
                sp_get_social( 'yes' , '24' , 'tooldown' , false );
        ?>
		</div>
			
		<div class="quick-support">
			<?php if ( $smof_data['call_label'] ) : ?>
			<span><?php echo $smof_data['call_label']; ?></span>
			<?php endif; ?>
			<?php if ( $smof_data['call_number'] ) : ?>
			<span class="call-us"><?php echo $smof_data['call_number']; ?></span>
			<?php endif; ?>
		</div>

		<?php if ( $smof_data['footer_text'] ) : ?>
		<div class="copyright"><?php echo $smof_data['footer_text']; ?></div>
		<?php endif; ?>

		
	</footer>
	<!-- #footer -->
	<?php } ?>

</div>
<!-- #page -->

<?php if( !is_page_template('template-contact-map.php') ) { ?>
<!-- <div class="bg-overlay"></div> -->

<?php 
	$img_background = rwmb_meta( 'sp_background_page', $args = array('type' => 'plupload_image', 'size' => 'supersized-thumb') );
	$disable_content = get_post_meta($post->ID, 'sp_diable_content_box', true); 
?>	
	<?php if (count($img_background) > 1) : ?>
	<!--Arrow Navigation-->
	<div id="slide-nav">
	<a id="prevslide" class="load-item"></a>
	<a id="nextslide" class="load-item"></a>
	</div>
	<?php if ($disable_content) : ?>	
	<!--Thumbnail Navigation-->
	<div id="prevthumb"></div>
	<div id="nextthumb"></div>

	<div id="thumb-tray" class="load-item">
		<div id="thumb-back"></div>
		<div id="thumb-forward"></div>
	</div>

	<!--Time Bar-->
	<div id="progress-back" class="load-item">
		<div id="progress-bar"></div>
	</div>

	<!--Control Bar-->
	<div id="controls-wrapper" class="load-item">
		<div id="controls">
			
			<a id="play-button"><img id="pauseplay" src="<?php echo SP_ASSETS_THEME; ?>images/supersized/pause.png"/></a>
		
			<!--Slide counter-->
			<div id="slidecounter">
				<span class="slidenumber"></span> / <span class="totalslides"></span>
			</div>
			
			<!--Slide captions displayed here-->
			<div id="slidecaption"></div>
			
			<!--Thumb Tray button-->
			<a id="tray-button"><img id="tray-arrow" src="<?php echo SP_ASSETS_THEME; ?>images/supersized/button-tray-down.png"/></a>
			
		</div>
	</div>

	<?php endif; //end disable content ?>

	<?php endif; //end once background image ?>

<?php } //template contact map ?>

<?php wp_footer(); ?>
</body>
</html>