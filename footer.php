<?php global $smof_data; ?>   	

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

</div>
<!-- #page -->

<?php 
	$img_background = rwmb_meta( 'sp_background_page', $args = array('type' => 'plupload_image', 'size' => 'supersized-thumb') );
?>	
	<?php if (count($img_background) > 1) : ?>
	<!--Arrow Navigation-->
	<div id="slide-nav">
	<a id="prevslide" class="load-item"></a>
	<a id="nextslide" class="load-item"></a>
	</div>
	<?php endif; //end once background image ?>

<?php wp_footer(); ?>
</body>
</html>