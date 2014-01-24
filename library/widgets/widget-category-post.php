<?php

class sp_widget_category_post extends WP_Widget {

	function __construct() {
		
		$id     = 'sp-widget-categort-posts';
		$prefix = SP_THEME_NAME . ': ';
		$name   = '<span>' . $prefix . __( 'Category Posts', 'sptheme_widget' ) . '</span>';
		$widget_ops = array(
			'classname'   => 'sp-widget-categort-posts',
			'description' => __( 'A widget show posts by category','sptheme_widget' )
			);
		$control_ops = array();

		parent::__construct( $id, $name, $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', $instance['cat_posts_title'] );
		$no_of_posts = $instance['no_of_posts'];
		$cats_id = $instance['cats_id'];
		$thumb = $instance['thumb'];
		$thumb_width = $instance['thumb_width'];
		$thumb_height = $instance['thumb_height'];
		$show_desc = $instance['show_desc'];
		$desc_length = $instance['desc_length'];

		echo $before_widget;
			echo $before_title;
			echo $title ; ?>
		<?php echo $after_title; ?>
		
		<?php sp_last_posts_cat($no_of_posts , $thumb , $cats_id, $thumb_width, $thumb_height, $show_desc, $desc_length); ?>	
		
	<?php 
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['cat_posts_title'] = strip_tags( $new_instance['cat_posts_title'] );
		$instance['no_of_posts'] = strip_tags( $new_instance['no_of_posts'] );
		
		$instance['cats_id'] = implode(',' , $new_instance['cats_id']  );

		$instance['thumb'] = strip_tags( $new_instance['thumb'] );
		$instance['thumb_width'] = strip_tags( $new_instance['thumb_width']);
		$instance['thumb_height'] = strip_tags( $new_instance['thumb_height']);

		$instance['show_desc'] = strip_tags( $new_instance['show_desc']);
		$instance['desc_length'] = strip_tags( $new_instance['desc_length']);

		return $instance;
	}

	function form( $instance ) {
		$defaults = array( 'cat_posts_title' =>__( 'Category Posts' , 'sptheme_widget'), 'no_of_posts' => '5' , 'cats_id' => '1' , 'thumb' => 'true', 'thumb_width' => '60', 'thumb_height' => '60', 'show_desc' => 'true', 'desc_length' => '80' );
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		$categories_obj = get_categories();
		$categories = array();

		foreach ($categories_obj as $pn_cat) {
			$categories[$pn_cat->cat_ID] = $pn_cat->cat_name;
		}
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'cat_posts_title' ); ?>">Title : </label>
			<input id="<?php echo $this->get_field_id( 'cat_posts_title' ); ?>" name="<?php echo $this->get_field_name( 'cat_posts_title' ); ?>" value="<?php echo $instance['cat_posts_title']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'no_of_posts' ); ?>">Number of posts to show: </label>
			<input id="<?php echo $this->get_field_id( 'no_of_posts' ); ?>" name="<?php echo $this->get_field_name( 'no_of_posts' ); ?>" value="<?php echo $instance['no_of_posts']; ?>" type="text" size="3" />
		</p>
		<p>
			<?php $cats_id = explode ( ',' , $instance['cats_id'] ) ; ?>
			<label for="<?php echo $this->get_field_id( 'cats_id' ); ?>">Category : </label>
			<select multiple="multiple" id="<?php echo $this->get_field_id( 'cats_id' ); ?>[]" name="<?php echo $this->get_field_name( 'cats_id' ); ?>[]">
				<?php foreach ($categories as $key => $option) { ?>
				<option value="<?php echo $key ?>" <?php if ( in_array( $key , $cats_id ) ) { echo ' selected="selected"' ; } ?>><?php echo $option; ?></option>
				<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'thumb' ); ?>">Display Thumbinals : </label>
			<input id="<?php echo $this->get_field_id( 'thumb' ); ?>" name="<?php echo $this->get_field_name( 'thumb' ); ?>" value="<?php echo ( $instance['thumb'] ) ? 'true' : 'false'; ?>" <?php if( $instance['thumb'] ) echo 'checked="checked"'; ?> type="checkbox" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'thumb_width' ); ?>">Width: </label>
			<input id="<?php echo $this->get_field_id( 'thumb_width' ); ?>" name="<?php echo $this->get_field_name( 'thumb_width' ); ?>" value="<?php echo $instance['thumb_width']; ?>" type="text" size="3" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'thumb_height' ); ?>">Height: </label>
			<input id="<?php echo $this->get_field_id( 'thumb_height' ); ?>" name="<?php echo $this->get_field_name( 'thumb_height' ); ?>" value="<?php echo $instance['thumb_height']; ?>" type="text" size="3" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'show_desc' ); ?>">Display short description : </label>
			<input id="<?php echo $this->get_field_id( 'show_desc' ); ?>" name="<?php echo $this->get_field_name( 'show_desc' ); ?>" value="<?php echo ( $instance['show_desc'] ) ? 'true' : 'false'; ?>" <?php if( $instance['show_desc'] ) echo 'checked="checked"'; ?> type="checkbox" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'desc_length' ); ?>">Description Length: </label>
			<input id="<?php echo $this->get_field_id( 'desc_length' ); ?>" name="<?php echo $this->get_field_name( 'desc_length' ); ?>" value="<?php echo $instance['desc_length']; ?>" type="text" size="3" />
		</p>

	<?php
	}
}