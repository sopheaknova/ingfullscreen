<?php
/**
 * Theme short codes
 * Containes short codes for layout columns, tabs, accordion, slider, carousel, posts, etc.
 */

add_action( 'wp_enqueue_scripts', 'add_script_style_sc' );

function add_script_style_sc() {
	if(!is_admin()){
		wp_enqueue_script( 'shortcode-js',    SP_BASE_URL . 'library/shortcodes/js/shortcodes.js', array( 'jquery-ui-core', 'jquery-ui-tabs', 'jquery-ui-accordion', 'custom-scripts' ), null, true );
		wp_enqueue_style( 'shortcode', SP_BASE_URL . 'library/shortcodes/css/shortcodes.css', false, '1.0' );
	}
	
}

// Register and initialize short codes
function sp_add_shortcodes() {
	add_shortcode( 'col', 'col' );
	add_shortcode( 'accordion', 'sp_accordion_shortcode' );
	add_shortcode( 'accordion_section', 'sp_accordion_section_shortcode' );	
	add_shortcode( 'toggle', 'sp_toggle_shortcode' );
	add_shortcode( 'tabgroup', 'sp_tabgroup_shortcode' );
	add_shortcode( 'tab', 'sp_tabs_shortcode' );
	add_shortcode( 'callout_box', 'sp_callout_shortcode' );
	add_shortcode( 'hr', 'sp_hr_shortcode' );
	add_shortcode( 'btn', 'sp_btn_shortcode' );
	add_shortcode( 'email_encoder', 'sp_email_encoder' );
	add_shortcode( 'team_sc', 'team_sc' );
	add_shortcode( 'projects_grid', 'projects_grid' );
	add_shortcode( 'gallery_sc', 'gallery_sc' );
}
add_action( 'init', 'sp_add_shortcodes' );

// Helper function for removing automatic p and br tags from nested short codes
function return_clean( $content, $p_tag = false, $br_tag = false )
{
	$content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content );

	if ( $br_tag )
		$content = preg_replace( '#<br \/>#', '', $content );

	if ( $p_tag )
		$content = preg_replace( '#<p>|</p>#', '', $content );

	return do_shortcode( shortcode_unautop( trim( $content ) ) );
}

/*--------------------------------------------------------------------------------------*/
/* 	Columns																				*/
/*--------------------------------------------------------------------------------------*/
function col( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'type' => 'full'
	), $atts ) );
	$out = '<div class="column ' . $type . '">' . return_clean( $content ) . '</div>';
	if ( strpos( $type, 'last' ) )
		$out .= '<div class="clear"></div>';
	return $out;
}

/*--------------------------------------------------------------------------------------*/
/* 	Accordion																			*/
/*--------------------------------------------------------------------------------------*/

// Main accordion container
function sp_accordion_shortcode($atts, $content = null) {
	return '<div class="accordion-container clearfix">' . return_clean($content) . '</div>';
}

// Accordion section
function sp_accordion_section_shortcode($atts, $content = null) {

	extract(shortcode_atts(array(
		'title' => 'Title Goes Here',		
	), $atts));

	return '<div class="accordion"><div class="accordion-title"><div class="plus"></div><h5>' . $title . '</h5></div><div class="inner-content-sc">' . return_clean($content) . '</div></div>';
	
}

/*--------------------------------------------------------------------------------------*/
/* 	Toggle Content																		*/
/*--------------------------------------------------------------------------------------*/

function sp_toggle_shortcode($atts, $content = null) {

	extract(shortcode_atts(array(
		'title' => 'Title Goes Here',
	), $atts));
	
	return '<div class="toggle clearfix"><div class="toggle-title"><div class="plus"></div><h5>' . $title . '</h5></div><div class="inner-content-sc">' .  return_clean($content) . '</div></div>';

}

/*--------------------------------------------------------------------------------------*/
/* 	Tabs																				*/
/*--------------------------------------------------------------------------------------*/

// Main Tabgroup
function sp_tabgroup_shortcode($atts, $content = null) {

	$GLOBALS['tab_count'] = 0;

	do_shortcode($content);

	if (is_array($GLOBALS['tabs'])) {
	
		$i = 1;
		foreach ($GLOBALS['tabs'] as $tab) {
			$tabs[] = '<li><a href="#tabs-' . $i . '">' . $tab['title'] . '</a></li>';
			$panels[] = '<div id="tabs-' . $i . '">' . $tab['content'] . '</div>';
			$i++;
		}

		$return = "\n" . '<div class="tabgroup clearfix"><ul class="tabs clearfix">' .implode("\n", $tabs) . '</ul>' . "\n" . '' . implode("\n", $panels) . '</div>' . "\n";
	
	}
	
	return $return;

}

// Individual Tabs
function sp_tabs_shortcode($atts, $content = null) {

	extract(shortcode_atts(array(
		'title' => 'Tab %d'
	), $atts));

	$x = $GLOBALS['tab_count'];
	$GLOBALS['tabs'][$x] = array('title' => sprintf($title, $GLOBALS['tab_count']), 'content' => $content);

	$GLOBALS['tab_count']++;
	
}

/*--------------------------------------------------------------------------------------*/
/* 	Callout Box																			*/
/*--------------------------------------------------------------------------------------*/
function sp_callout_shortcode($atts, $content = null) {

	extract(shortcode_atts(array(
		'title'			=> '',
		'button_name'	=> '',
		'button_link'	=> '',
		'button_color'	=> 'standard',
		'button_size'	=> '',
		'button_type'	=> ''
	), $atts));
	
	$output = '';
	
	$output .= '<div class="callout-box clearfix"><div class="detail left"><h4>' . $title . '</h4>';
	$output .= return_clean( $content );
	$output .= '</div><div class="right"><a href="' . $button_link . '" class="sc-button ' . $button_size . ' ' . $button_type . ' ' . $button_color . '">' . $button_name . '</a></div>';
	
	$output .= '</div>';

	return $output;

}

/*--------------------------------------------------------------------------------------*/
/* 	Devide																				*/
/*--------------------------------------------------------------------------------------*/

function sp_hr_shortcode($atts, $content = null) {
	
	extract(shortcode_atts(array(
		'style' => 'dashed',
		'margin_top' => '40',
		'margin_bottom' => '40',
	), $atts));
	
	return '<hr class="' .$style . '" style="margin-top:' . $margin_top . 'px;margin-bottom:' . $margin_bottom . 'px;" />';
	
}

/*--------------------------------------------------------------------------------------*/
/* 	Button																				*/
/*--------------------------------------------------------------------------------------*/

function sp_btn_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'link'		=> '',
		'color'		=> 'standard',
		'size'		=> '',
		'type'		=> '',
		'target'	=> '_self',
	), $atts ) );
	$color_class = ( $color == '' ) ? '' : $color;
	$size_class = ( ( $size != '' ) ) ? $size : '';
	if ( $target == '_blank' ) {
		return '<a href="' . $link . '" class="sc-button ' . $color_class . ' ' . $size_class . ' ' . $type . '" target="_blank">' . return_clean( $content ) . '</a>';
	}
	else
	{
		return '<a href="' . $link . '" class="sc-button ' . $color_class . ' ' . $size_class . ' ' . $type . '">' . return_clean( $content ) . '</a>';
	}
}

/*--------------------------------------------------------------------------------------*/
/* 	Email encoder																		*/
/*--------------------------------------------------------------------------------------*/

function sp_email_encoder($atts, $content = null){
	extract(shortcode_atts(array(
		'email' 	=> 'name@domainname.com',
		'subject'	=> 'General Inquirie'
	), $atts));

	return '<a href="mailto:' . antispambot($email) . '?subject=' . $subject . '">' . antispambot($email) . '</a>';
}

/*--------------------------------------------------------------------------------------*/
/* 	Insert Post																			*/
/*--------------------------------------------------------------------------------------*/

function insert_posts( $atts ) {
	extract( shortcode_atts( array(
		'query_type'		=> 'category',
		'cats'				=> '-1',
		'posts'				=> '',
		'pages'				=> '',
		'tags'				=> '',
		'post_type'			=> '',
		'taxonomy'			=> 'category',
		'terms'				=> '',
		'order'				=> 'desc',
		'orderby'			=> 'date',
		'num'				=> '4',
		'display_style'		=> 'one-col',
		'offset'			=> '0',
		'excerpt_length'	=> '140',
		'hide_excerpt'		=> 'false',
		'hide_meta'			=> 'false'
	), $atts ) );

	if ( 'posts' == $query_type ) {
		$custom_args = array(
			'posts_per_page'		=> $num,
			'order'					=> $order,
			'orderby'				=> $orderby,
			'post__in'				=> explode( ',', $posts ),
			'offset'				=> $offset,
			'post_status'			=> 'publish',
			'ignore_sticky_posts'	=> 1
		);
	}
	elseif ( 'pages' == $query_type ) {
		$custom_args = array(
			'post_type'				=> 'page',
			'posts_per_page'		=> $num,
			'order'					=> $order,
			'orderby'				=> $orderby,
			'post__in'				=> explode( ',', $pages ),
			'offset'				=> $offset,
			'post_status'			=> 'publish',
			'ignore_sticky_posts'	=> 1
		);
	}
	elseif ( 'tags' == $query_type ) {
		$custom_args = array(
			'posts_per_page'		=> $num,
			'order'					=> $order,
			'orderby'				=> $orderby,
			'tag'					=> $tags,
			'offset'				=> $offset,
			'post_status'			=> 'publish',
			'ignore_sticky_posts'	=> 1
		);
	}
	elseif ( 'cpt' == $query_type ) {
		$custom_args = array(
			'post_type'				=> $post_type,
			'posts_per_page'		=> $num,
			'order'					=> $order,
			'orderby'				=> $orderby,
			'tax_query' 			=> array(
											array(
												'taxonomy'	=> $taxonomy,
												'field'		=> 'slug',
												'terms'		=> explode( ',', $terms )
											)
										),
			'offset'				=> $offset,
			'post_status'			=> 'publish',
			'ignore_sticky_posts'	=> 1
		);
	}
	else {
		$custom_args = array(
			'posts_per_page' 		=> $num,
			'order' 				=> $order,
			'orderby' 				=> $orderby,
			'cat' 					=> $cats,
			'offset' 				=> $offset,
			'post_status'			=> 'publish',
			'ignore_sticky_posts'	=> 1
		);
	}
	$custom_query = new WP_Query( $custom_args );
    if ( $custom_query->have_posts() ) :
		$count = 1;
		$fclass = '';
		$lclass = '';
		if( $display_style == 'two-col' ) {
			$out = '<ul class="two-col clear">';
		}
		elseif ( $display_style == 'three-col' ) {
			$out = '<ul class="three-col clear">';
		}
		elseif ( $display_style == 'list-small' || $display_style == 'list-plain' ) {
			$out = '<ul class="post-list">';
		}
		else
			$out = '';

		while ( $custom_query->have_posts() ) :
			$custom_query->the_post();
			global $multipage;
			$multipage = 0;
			$time = get_the_time( get_option( 'date_format' ) );
			$permalink = get_permalink();
			$title = get_the_title();
			$excerpt = ( $hide_excerpt == 'true' ) ? '' : sprintf( '<p class="post-excerpt">%1$s</p>', short( get_the_excerpt(), $excerpt_length ) );
			$postID = get_the_ID();
			$num_comments = get_comments_number();
			if ( comments_open() ) {
				if ( $num_comments == 0 ) {
					$comments = __( '0 Comments', 'sp' );
				}
				elseif ( $num_comments > 1 ) {
					$comments = $num_comments . __( ' Comments', 'sp' );
				}
				else {
					$comments = __( '1 Comment', 'sp' );
				}
				$write_comments = sprintf( __( '<span class="sep"> | </span><a href="%1$s" title="Comment on %3$s">%2$s</a>', 'sp' ), get_comments_link(), $comments, $title );
			}
			else {
				$write_comments = '';
			}
			$post_meta = ( $hide_meta == 'true' ) ? '' : sprintf( '<span class="entry-meta"><a href="%1$s" title="%2$s"><time class="entry-date" datetime="%3$s">%4$s</time></a>%5$s</span>',
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			$write_comments );
			
			$post_meta_big = ( $hide_meta == 'true' ) ? '' : sprintf( '<span class="entry-meta"><a href="%1$s" title="%2$s"><time class="entry-date" datetime="%3$s">%4$s</time></a> | %5$s%6$s</span>',
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			get_the_category_list( ', ' ),
			$write_comments );
			
			$no_meta_class = ( 'true' == $hide_excerpt && 'true' == $hide_meta ) ? 'no-meta' : '';

			if ( has_post_thumbnail() ) {
				if ( $display_style == 'list-small' ) {
					$img = wp_get_attachment_image_src( get_post_thumbnail_id( $GLOBALS['post']->ID ), 'list_small_thumb' );
				}
				elseif ( $display_style == 'list-big' ) {
					$img = wp_get_attachment_image_src( get_post_thumbnail_id( $GLOBALS['post']->ID ), 'list_big_thumb' );
				}
				elseif ( $display_style == 'two-col' ) {
					$img = wp_get_attachment_image_src( get_post_thumbnail_id( $GLOBALS['post']->ID ), 'two_col_thumb' );
				}
				elseif ( $display_style == 'three-col' ) {
					$img = wp_get_attachment_image_src( get_post_thumbnail_id( $GLOBALS['post']->ID ), 'three_col_thumb' );
				}
				else {
					$img = wp_get_attachment_image_src( get_post_thumbnail_id( $GLOBALS['post']->ID ), 'size_max' );
				}
				$thumbnail = $img[0];
				$thumbclass = '';
				if ( $display_style == 'list-big') {
					$thumblink = sprintf( '<div class="entry-list-left"><div class="entry-thumb"><a href="%1$s" title="%2$s"><img src="%3$s" alt="%2$s" title="%2$s"/></a></div></div>', $permalink, $title, $thumbnail );
				}
				else {
					$thumblink = sprintf( '<div class="post-thumb"><a href="%1$s" title="%2$s"><img src="%3$s" alt="%2$s" title="%2$s"/></a></div>', $permalink, $title, $thumbnail );
				}
			}
			else {
				$thumblink = '';
				if ( $display_style == 'list-big' || $display_style == 'list-small' )
					$thumbclass = 'no-image';
			}
			if ( 'video' == get_post_format() && $display_style != 'list-small' ) {
				$post_opts = get_post_meta( $GLOBALS['post']->ID, 'post_options', true );
				$pf_video = ! empty( $post_opts['pf_video'] ) ? $post_opts['pf_video'] : '';
				global $wp_embed;
				$post_embed = $wp_embed->run_shortcode( '[embed]' . $pf_video . '[/embed]' );
				if ( '' != $pf_video ) {
					if ( $display_style == 'list-big' ) {
						$thumblink = sprintf( '<div class="entry-list-left"><div class="embed-wrap">%1$s</div></div>', $post_embed );
						$thumbclass = '';
					}
					else
						$thumblink = sprintf( '<div class="embed-wrap">%1$s</div>', $post_embed );
				}
			}
			if( $display_style == 'two-col' ) {
				$fclass = ( 0 == ( ( $count - 1 ) % 2 ) ) ? ' first-grid' : '';
				$lclass = ( 0 == ( $count % 2 ) ) ? ' last-grid' : '';
				$format = '<li class="post-%1$s entry-grid %2$s%3$s">%4$s<div class="entry-content %9$s"><h3><a href="%5$s" title="%6$s">%6$s</a></h3>%7$s%8$s</div></li>';
				$out .= sprintf ( $format, $postID, $fclass, $lclass, $thumblink, $permalink, $title, $excerpt, $post_meta_big, $no_meta_class );
				$count++;
			}
			elseif ( $display_style == 'three-col' ) {
				$fclass = ( 0 == ( ( $count - 1 ) % 3 ) ) ? ' first-grid' : '';
				$lclass = ( 0 == ( $count % 3 ) ) ? ' last-grid' : '';
				$format = '<li class="post-%1$s entry-grid %2$s%3$s">%4$s<div class="entry-content %9$s"><h3><a href="%5$s" title="%6$s">%6$s</a></h3>%7$s%8$s</div></li>';
				$out .= sprintf ( $format, $postID, $fclass, $lclass, $thumblink, $permalink, $title, $excerpt, $post_meta, $no_meta_class );
				$count++;
			}
			elseif ( $display_style == 'list-big' ) {
				$format = '<div class="post-%1$s entry-list clear">%2$s<div class="entry-list-right %3$s"><h3><a href="%4$s" title="%5$s">%5$s</a></h3>%6$s%7$s</div></div>';
				$out .= sprintf ( $format, $postID, $thumblink, $thumbclass, $permalink, $title, $excerpt, $post_meta_big );
			}
			elseif ( $display_style == 'list-small' ) {
				$format = '<li>%1$s<div class="post-content %2$s"><h3><a href="%3$s" title="%4$s">%4$s</a></h3>%5$s</div></li>';
				$out .= sprintf ( $format, $thumblink, $thumbclass, $permalink, $title, $post_meta );
			}
			elseif ( $display_style == 'list-plain' ) {
				$format = '<li><h4><a href="%1$s" title="%2$s">%2$s</a></h4>%3$s</li>';
				$out .= sprintf ( $format, $permalink, $title, $post_meta );
			}
			else {
				$format = '<div class="one-col post-%1$s entry-grid">%2$s<div class="entry-content %7$s"><h3><a href="%3$s" title="%4$s">%4$s</a></h3>%5$s%6$s</div></div>';
				$out .= sprintf ( $format, $postID, $thumblink, $permalink, $title, $excerpt, $post_meta_big, $no_meta_class );
			}
		endwhile;
		if ( $display_style != 'one-col' && $display_style != 'list-big' )
			$out .= '</ul>';
		return $out;
	endif;
	wp_reset_query();
	wp_reset_postdata(); // Restore global post data
} 


function posts_slider( $atts ) {
	extract( shortcode_atts( array(
		'query_type'		=> 'category',
		'cats'				=> '-1',
		'posts'				=> '',
		'pages'				=> '',
		'tags'				=> '',
		'post_type'			=> '',
		'taxonomy'			=> 'category',
		'terms'				=> '',
		'order'				=> 'desc',
		'orderby'			=> 'date',
		'num'				=> '2',
		'offset'			=> '0',
		'effect'			=> 'fade',
		'easing'			=> 'swing',
		'speed'				=> '600',
		'timeout'			=> '4000',
		'animationloop'		=> 'false',
		'smoothheight'		=> 'true',
		'controlnav'		=> 'true',
		'directionnav'		=> 'true',
		'excerpt_length'	=> '140',
		'hide_excerpt'		=> 'false',
		'hide_meta'			=> 'false'
	), $atts ) );

	if ( 'posts' == $query_type ) {
		$custom_args = array(
			'posts_per_page'		=> $num,
			'order'					=> $order,
			'orderby'				=> $orderby,
			'post__in'				=> explode( ',', $posts ),
			'offset'				=> $offset,
			'post_status'			=> 'publish',
			'ignore_sticky_posts'	=> 1
		);
	}
	elseif ( 'pages' == $query_type ) {
		$custom_args = array(
			'post_type'				=> 'page',
			'posts_per_page'		=> $num,
			'order'					=> $order,
			'orderby'				=> $orderby,
			'post__in'				=> explode( ',', $pages ),
			'offset'				=> $offset,
			'post_status'			=> 'publish',
			'ignore_sticky_posts'	=> 1
		);
	}
	elseif ( 'tags' == $query_type ) {
		$custom_args = array(
			'posts_per_page'		=> $num,
			'order'					=> $order,
			'orderby'				=> $orderby,
			'tag'					=> $tags,
			'offset'				=> $offset,
			'post_status'			=> 'publish',
			'ignore_sticky_posts'	=> 1
		);
	}
	elseif ( 'cpt' == $query_type ) {
		$custom_args = array(
			'post_type'				=> $post_type,
			'posts_per_page'		=> $num,
			'order'					=> $order,
			'orderby'				=> $orderby,
			'tax_query' 			=> array(
											array(
												'taxonomy'	=> $taxonomy,
												'field'		=> 'slug',
												'terms'		=> explode( ',', $terms )
											)
										),
			'offset'				=> $offset,
			'post_status'			=> 'publish',
			'ignore_sticky_posts'	=> 1
		);
	}
	else {
		$custom_args = array(
			'posts_per_page' 		=> $num,
			'order' 				=> $order,
			'orderby' 				=> $orderby,
			'cat' 					=> $cats,
			'offset' 				=> $offset,
			'post_status'			=> 'publish',
			'ignore_sticky_posts'	=> 1
		);
	}
	$custom_query = new WP_Query( $custom_args );
    if ( $custom_query->have_posts() ) :
		$slider_id = 'slider-' . rand( 2, 20000 );
		if ( 'false' == $directionnav && 'false' == $controlnav ) {
			$controls_container = "''";
			$container_markup = '';
		}
		else {
			$controls_container = '"#' . $slider_id . '-controls"';
			$container_markup = '<div class="flex-controls-container main-slider" id="' . $slider_id . '-controls"></div>';
		}
		$out = '<script type="text/javascript">
			jQuery(window).load(function(){
				jQuery("#' . $slider_id . '").flexslider({
					animation: "' . $effect . '",
					easing: "' . $easing . '",
					animationSpeed:' . $speed . ',
					slideshowSpeed:' . $timeout . ',
					selector: ".slides > .slide",
					pauseOnAction: true,
					smoothHeight: ' . $smoothheight . ',
					controlNav: ' . $controlnav . ',
					directionNav: ' . $directionnav . ',
					useCSS: false,
					prevText: "' . __( 'Prev', 'sp') . '",
					nextText: "' . __( 'Next', 'sp') . '",
					controlsContainer: ' . $controls_container . ',
					animationLoop: ' . $animationloop . ',
					start: function(slider) {
						jQuery(slider).removeClass("flex-loading");
					}
				});
			})
		</script>';
		$slides = '';
		while ( $custom_query->have_posts() ) :
			$custom_query->the_post();
			global $multipage;
			$multipage = 0;
			$time = get_the_time( get_option( 'date_format' ) );
			$permalink = get_permalink();
			$title = get_the_title();
			$excerpt = ( $hide_excerpt == 'true' ) ? '' : sprintf( '<p class="slide-excerpt">%1$s</p>', short( get_the_excerpt(), $excerpt_length ) );
			$postID = get_the_ID();
			$num_comments = get_comments_number();
			if ( comments_open() ) {
				if ( $num_comments == 0 ) {
					$comments = __( '0 Comments', 'sp' );
				} elseif ( $num_comments > 1 ) {
					$comments = $num_comments . __( ' Comments', 'sp' );
				} else {
					$comments = __( '1 Comment', 'sp' );
				}
				$write_comments = sprintf( __( '<span class="sep"> | </span><a href="%1$s" title="Comment on %3$s">%2$s</a>', 'sp' ), get_comments_link(), $comments, $title );
			}
			else {
				$write_comments = '';
			}
			$post_meta = ( $hide_meta == 'true' ) ? '' : sprintf( '<span class="entry-meta"><a href="%1$s" title="%2$s"><time class="entry-date" datetime="%3$s">%4$s</time></a> | %5$s%6$s</span>',
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			get_the_category_list( ', ' ),
			$write_comments
			);
			if ( has_post_thumbnail() ) {
				$img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $GLOBALS['post']->ID ), 'posts_slider_thumb' );
				$thumbnail = $img_src[0];
				$thumblink = sprintf( '<a class="slide-image" href="%1$s" title="%2$s"><img src="%3$s" alt="%2$s" title="%2$s"/></a>', $permalink, $title, $thumbnail );
			}
			else
				$thumblink = '';
			$no_meta_class = ( 'true' == $hide_excerpt && 'true' == $hide_meta ) ? 'no-meta' : '';
			$format = '<div class="slide">%1$s<div class="flex-caption %6$s"><h2><a href="%2$s" title="%3$s">%3$s</a></h2>%4$s%5$s</div></div>';
			$slides .= sprintf( $format, $thumblink, $permalink, $title, $excerpt, $post_meta, $no_meta_class );
		endwhile;
		$out .= '<div class="flexslider flex-loading" id="' . $slider_id . '"><div class="slides">' . $slides . '</div></div>' . $container_markup;
		return $out;
	endif;
	wp_reset_query();
	wp_reset_postdata(); // Restore global post data
}

function team_sc( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'team_photo' => null,
		'name' => null,
		'position' => null
	), $atts ) );
	$out .= '<div class="team-item">';
	$out .= '<img src="' . $team_photo . '" class="alignnone" />';
	$out .= '<h5>' . $name . '<span class="position">' . $position . '</span></h5>';
	$out .= return_clean( $content );
	$out .= '</div>';
	return $out;
}

function projects_grid( $atts, $content = null ){

	extract( shortcode_atts( array(
		'limit'			=> 6,
		'project_term'	=> null,
		'phase_term'	=> null,
		'orderby'		=> 'menu_order'
	), $atts ) );

	if ( $limit == 0 )
		$limit = -1;

	$args = array(
		'posts_per_page' 	=> (int) $limit,
		'post_type' 		=> 'sp_project',
		'orderby' 			=> $orderby,
		'tax_query' 		=> array(
							'relation' => 'AND',
							array(	
								'taxonomy' 	=> 'sp_project_name_ct',
								'field' 	=> 'term_id',
								'terms' 	=> $project_term 
							),
							array(	
								'taxonomy' 	=> 'sp_phase_ct',
								'field' 	=> 'term_id',
								'terms' 	=> $phase_term
							)
		)
	);

	$custom_query = new WP_Query($args);
		
	if ($custom_query->have_posts()) :

		$col ='one-third';
		$output = '';
		$count = 1;
		
		$output .= '<div class="gallery-projects">';
		
		while ($custom_query->have_posts()) :
			$custom_query->the_post();

		($count % 3) ? $col = 'one-third' : $col = 'one-third last';
		
		$output .= '<div class="project-item ' . $col . '">';
		$output .= '<a href="'.get_permalink().'">';
		$output .= '<div class="project-info"><h2>' . get_the_title() . '</h2></div>';
		$output .= '<div class="project-background"></div>';
		$output .= '<img src="' . sp_post_thumbnail('project-thumb') . '" />';
		$output .= '</a>';
		$output .= '</div>';

		$count++;
		endwhile;
		
		$output .= '</div>';
		
	endif;
	
	wp_reset_postdata(); // Restore global post data
	
	return $output;

}

function gallery_sc( $atts, $content = null ){

	extract( shortcode_atts( array(
		'album' => null,
	), $atts ) );

	$args = array(
		'post_type' => 'sp_gallery',
		'p'			=> $album
	);

	$custom_query = new WP_Query($args);
		
	if ($custom_query->have_posts()) :

		$col ='one-third';
		$output = '';
		$count = 1;
		
		$output .= '<div class="gallery-projects">';

		while ($custom_query->have_posts()) :
			$custom_query->the_post();

			$post_gallery = rwmb_meta( 'sp_gallery_album', $args = array('type' => 'plupload_image', 'size' => 'project-thumb') ); 
			
			foreach ( $post_gallery as $image ){

			($count % 3) ? $col = 'one-third' : $col = 'one-third last';
	
			$output .= '<div class="project-item ' . $col . '">';
			$output .= '<a href="'.$image["full_url"].'" rel="wp-prettyPhoto['.get_the_id().']">';
			$output .= '<div class="project-info"><h2>' . $image["title"] . '</h2></div>';
			$output .= '<div class="project-background"></div>';
			$output .= '<img src="' . $image["url"] . '" />';
			$output .= '</a>';
			$output .= '</div>';
			
			$count++;
			}

		endwhile;

		$output .= '</div>';
		
	endif;
	
	wp_reset_postdata(); // Restore global post data
	
	return $output;

}

?>