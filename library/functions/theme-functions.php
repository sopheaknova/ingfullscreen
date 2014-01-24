<?php


/* ---------------------------------------------------------------------- */
/*	Show main and footer navigation
/* ---------------------------------------------------------------------- */

if( !function_exists('sp_main_navigation')) {

	function sp_main_navigation() {
		
		// set default main menu if wp_nav_menu not active
		if ( function_exists ( 'wp_nav_menu' ) )
			wp_nav_menu( array(
				'container'      => false,
				'menu_class'	 => 'nav-menu',
				'theme_location' => 'primary',
				'fallback_cb' => 'sp_main_nav_fallback'
				) );
		else
			sp_main_nav_fallback();	
	}
}

if (!function_exists('sp_main_nav_fallback')) {
	
	function sp_main_nav_fallback() {
    	
		$menu_html = '<ul class="nav-menu clear">';
		$menu_html .= '<li><a href="'.admin_url('nav-menus.php').'">'.esc_html__('Add Main menu', SP_TEXT_DOMAIN).'</a></li>';
		$menu_html .= '</ul>';
		echo $menu_html;
		
	}
	
}

/* ---------------------------------------------------------------------- */
/*	Makes some changes to the <title> tag, by filtering the output of wp_title()
/* ---------------------------------------------------------------------- */

function sp_filter_wp_title( $title, $separator ) {

	if ( is_feed() ) return $title;

	global $paged, $page;

	if ( is_search() ) {
		$title = sprintf(__('Search results for %s', SP_TEXT_DOMAIN), '"' . get_search_query() . '"');

		if ( $paged >= 2 )
			$title .= " $separator " . sprintf(__('Page %s', SP_TEXT_DOMAIN), $paged);

		$title .= " $separator " . get_bloginfo('name', 'display');

		return $title;
	}

	$title .= get_bloginfo('name', 'display');
	$site_description = get_bloginfo('description', 'display');

	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $separator " . $site_description;

	if ( $paged >= 2 || $page >= 2)
		$title .= " $separator " . sprintf(__('Page %s', SP_TEXT_DOMAIN), max($paged, $page) );

	return $title;

}
add_filter('wp_title', 'sp_filter_wp_title', 10, 2);


/* ---------------------------------------------------------------------- */
/*	Add rel=wp-prettyPhoto on each image of page and post
/* ---------------------------------------------------------------------- */

// Determine whether WP-prettyPhoto plugin is acivated and assign the result to a constant
defined('WP_PRETTY_PHOTO_PLUGIN_ACTIVE')
        || define('WP_PRETTY_PHOTO_PLUGIN_ACTIVE', class_exists( 'WP_prettyPhoto' ) );


// if the WP-prettyPhoto plugin is not active handle rel="wp-prettyPhoto" in links for the prettyPhoto integrated script (if enabled)
if ( !WP_PRETTY_PHOTO_PLUGIN_ACTIVE ) {
    /**
     * Insert rel="wp-prettyPhoto" to all links for images, movie, YouTube and iFrame. 
     * This function will ignore links where you have manually entered your own rel reference.
     * @param string $content Post/page contents
     * @return string Prettified post/page contents
     * @link http://0xtc.com/2008/05/27/auto-lightbox-function.xhtml
     * @access public
      */
    function autoinsert_rel_prettyPhoto ($content) {
        global $post;
        $rel = 'wp-prettyPhoto';
        $image_match = '\.bmp|\.gif|\.jpg|\.jpeg|\.png';
        $movie_match = '\.mov.*?';
        $swf_match = '\.swf.*?';
        $youtube_match = 'http:\/\/www\.youtube\.com\/watch\?v=[A-Za-z0-9]*';
        $iframe_match = '.*iframe=true.*';
        $pattern[0] = "/<a(.*?)href=('|\")([A-Za-z0-9\/_\.\~\:-]*?)(".$image_match."|".$movie_match."|".$swf_match."|".$youtube_match."|".$iframe_match.")('|\")([^\>]*?)>/i";
        $pattern[1] = "/<a(.*?)href=('|\")([A-Za-z0-9\/_\.\~\:-]*?)(".$image_match."|".$movie_match."|".$swf_match."|".$youtube_match."|".$iframe_match.")('|\")(.*?)(rel=('|\")".$rel."(.*?)('|\"))([ \t\r\n\v\f]*?)((rel=('|\")".$rel."(.*?)('|\"))?)([ \t\r\n\v\f]?)([^\>]*?)>/i";
        $replacement[0] = '<a$1href=$2$3$4$5$6 rel="'.$rel.'['.$post->ID.']">';
        $replacement[1] = '<a$1href=$2$3$4$5$6$7>';
        $content = preg_replace($pattern, $replacement, $content);
        return $content;
    }
    add_filter('the_content', 'autoinsert_rel_prettyPhoto');
    add_filter('the_excerpt', 'autoinsert_rel_prettyPhoto');


    // Add the 'wp-prettyPhoto' rel attribute to the default WP gallery links
    function gallery_prettyPhoto ($content) {
            // add checks if you want to add prettyPhoto on certain places (archives etc).
            return str_replace("<a", "<a rel='wp-prettyPhoto[gallery]'", $content);
    }
    add_filter( 'wp_get_attachment_link', 'gallery_prettyPhoto');
}

/* ---------------------------------------------------------------------- */
/*	Output archive search result message
/* ---------------------------------------------------------------------- */

if(!function_exists('sp_result_archive'))
{
	/**
	 *  checks which archive we are viewing and returns the archive string
	 */

	function sp_result_archive()
	{
		$output = "";

		if ( is_category() )
		{
			$output = __('Archive for category:',SP_TEXT_DOMAIN)." ".single_cat_title('',false);
		}
		elseif (is_day())
		{
			$output = __('Archive for date:',SP_TEXT_DOMAIN)." ".get_the_time( __('F jS, Y',SP_TEXT_DOMAIN) );
		}
		elseif (is_month())
		{
			$output = __('Archive for month:',SP_TEXT_DOMAIN)." ".get_the_time( __('F, Y',SP_TEXT_DOMAIN) );
		}
		elseif (is_year())
		{
			$output = __('Archive for year:',SP_TEXT_DOMAIN)." ".get_the_time( __('Y',SP_TEXT_DOMAIN) );
		}
		elseif (is_search())
		{
			global $wp_query;
			if(!empty($wp_query->found_posts))
			{
				if($wp_query->found_posts > 1)
				{
					$output =  $wp_query->found_posts ." ". __('search results for:',SP_TEXT_DOMAIN)." ".esc_attr( get_search_query() );
				}
				else
				{
					$output =  $wp_query->found_posts ." ". __('search result for:',SP_TEXT_DOMAIN)." ".esc_attr( get_search_query() );
				}
			}
			else
			{
				if(!empty($_GET['s']))
				{
					$output = __('Search results for:',SP_TEXT_DOMAIN)." ".esc_attr( get_search_query() );
				}
				else
				{
					$output = __('To search the site please enter a valid term',SP_TEXT_DOMAIN);
				}
			}

		}
		elseif (is_author())
		{
			$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
			$output = __('Author Archive',SP_TEXT_DOMAIN)." ";

			if(isset($curauth->nickname)) $output .= __('for:',SP_TEXT_DOMAIN)." ".$curauth->nickname;

		}
		elseif (is_tag())
		{
			$output = __('Tag Archive for:',SP_TEXT_DOMAIN)." ".single_tag_title('',false);
		}
		elseif(is_tax())
		{
			$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
			$output = __('Archive for:',SP_TEXT_DOMAIN)." ".$term->name;
		}
		else
		{
			$output = __('Archives',SP_TEXT_DOMAIN)." ";
		}

		if (isset($_GET['paged']) && !empty($_GET['paged']))
		{
			$output .= " (".__('Page',SP_TEXT_DOMAIN)." ".$_GET['paged'].")";
		}

		return $output;
	}
}

/* ---------------------------------------------------------------------- */
/*	Displays a page pagination
/* ---------------------------------------------------------------------- */

if ( !function_exists('sp_pagination') ) {

	function sp_pagination( $pages = '', $range = 2 ) {

		$showitems = ( $range * 2 ) + 1;

		global $paged, $wp_query;

		if( empty( $paged ) )
			$paged = 1;

		if( $pages == '' ) {

			$pages = $wp_query->max_num_pages;

			if( !$pages )
				$pages = 1;

		}

		if( 1 != $pages ) {

			$output = '<nav class="pagination">';

			// if( $paged > 2 && $paged >= $range + 1 /*&& $showitems < $pages*/ )
				// $output .= '<a href="' . get_pagenum_link( 1 ) . '" class="next">&laquo; ' . __('First', 'sptheme_admin') . '</a>';

			if( $paged > 1 /*&& $showitems < $pages*/ )
				$output .= '<a href="' . get_pagenum_link( $paged - 1 ) . '" class="next">&larr; ' . __('Previous', SP_TEXT_DOMAIN) . '</a>';

			for ( $i = 1; $i <= $pages; $i++ )  {

				if ( 1 != $pages && ( !( $i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems ) )
					$output .= ( $paged == $i ) ? '<span class="current">' . $i . '</span>' : '<a href="' . get_pagenum_link( $i ) . '">' . $i . '</a>';

			}

			if ( $paged < $pages /*&& $showitems < $pages*/ )
				$output .= '<a href="' . get_pagenum_link( $paged + 1 ) . '" class="prev">' . __('Next', SP_TEXT_DOMAIN) . ' &rarr;</a>';

			// if ( $paged < $pages - 1 && $paged + $range - 1 <= $pages /*&& $showitems < $pages*/ )
				// $output .= '<a href="' . get_pagenum_link( $pages ) . '" class="prev">' . __('Last', 'sptheme_admin') . ' &raquo;</a>';

			$output .= '</nav>';

			return $output;

		}

	}

}

/* ---------------------------------------------------------------------- */
/*	Adjust display of excerpt and excerpt_lenght
/* ---------------------------------------------------------------------- */

add_filter( 'excerpt_length', 'sp_excerpt_length' );
function sp_excerpt_length( $length ) {
    $length = '22';
 
    return $length;
}

add_filter( 'excerpt_more', 'sp_excerpt_more' );
function sp_excerpt_more( $more ) {
    $more = ' ...';
 
    return $more;
}

/* ---------------------------------------------------------------------- */
/*	Get Post image
/* ---------------------------------------------------------------------- */

if( !function_exists('sp_post_image')) {

	function sp_post_image($size = 'thumbnail'){
		global $post;
		$image = '';
		
		//get the post thumbnail;
		$image = sp_post_thumbnail($size);
		if ($image) return $image;
		
		//if the post is video post and haven't a feutre image
		$post_type = get_post_format($post->ID);
		//$vId = get_post_meta($post->ID, 'sp_video_id', true);
		$video_url = get_post_meta($post->ID, 'sp_video_id', true);
		
		if($post_type == 'video')
			$image = sp_get_video_img($video_url);
		
		if($post_type == 'audio') 
			$image = SP_ASSETS_THEME . 'images/sound-post-thumb.gif'; // use placeholder image or sound icon
						
		if ($image) return $image;
		
		//If there is still no image, get the first image from the post
		return sp_get_first_image();
	}
		

}

/* ---------------------------------------------------------------------- */
/*	Get Post Thumbnail
/* ---------------------------------------------------------------------- */
if( !function_exists('sp_post_thumbnail')) {

	function sp_post_thumbnail($size = 'thumbnail'){
		global $post;
		$thumb = '';
		
		//get the post thumbnail;
		$thumb_id = get_post_thumbnail_id($post->ID);
		$thumb_url = wp_get_attachment_image_src($thumb_id, $size);
		$thumb = $thumb_url[0];
		if ($thumb) return $thumb;
	}
		

}

/* ---------------------------------------------------------------------- */
/*	Get first image in post
/* ---------------------------------------------------------------------- */
if( !function_exists('sp_get_first_image')) {
	
	function sp_get_first_image() {
		global $post, $posts;
		$first_img = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		$first_img = $matches[1][0];
		
		return $first_img;
	}
}

/* ---------------------------------------------------------------------- */
/*	Full Meta post entry
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_post_meta' ) ) {
	function sp_post_meta() {
		
		printf( __('<time class="entry-date" datetime="%1$s">%2$s</time>', SP_TEXT_DOMAIN),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);
	}
}

/* ---------------------------------------------------------------------- */
/*	Mini Meta post entry
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_meta_mini' ) ) {
	function sp_meta_mini() {
		printf( __( '<a href="%1$s" title="%2$s"><time class="entry-date" datetime="%3$s">%4$s</time></a>', SP_TEXT_DOMAIN ),
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
			//get_the_category_list( ', ' )
		);
		if ( comments_open() ) : ?>
				<span class="sep"><?php _e( ' | ', SP_TEXT_DOMAIN ); ?></span>
				<span class="comments-link"><?php comments_popup_link( '<span class="leave-reply">' . __( '0 Comments', SP_TEXT_DOMAIN ) . '</span>', __( '1 Comment', SP_TEXT_DOMAIN ), __( '% Comments', SP_TEXT_DOMAIN ) ); ?></span>
		<?php endif; // End if comments_open()
	}
}	

/* ---------------------------------------------------------------------- */
/*	Facebook Like Thumbnails
/* ---------------------------------------------------------------------- */

// Add the correct blog thumbnails to the Facebook Like button on the blog
if (!function_exists('sp_facebook_thumb')) {

	function sp_facebook_thumb() {
		
		// Add the code only to single posts and when the share options are enabled in the Theme Options
		if (is_singular('post')) {
		
			global $post;

			$thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail');
			echo '<meta property="og:image" content="' . esc_attr($thumbnail_src[0]) . '" />';
		
		}
		
	}
	
	add_action('wp_head', 'sp_facebook_thumb');

}

/* ---------------------------------------------------------------------- */
/*	Embeded add video from youtube, vimeo and dailymotion
/* ---------------------------------------------------------------------- */
function sp_get_video_img($url) {
	
	$video_url = @parse_url($url);
	$output = '';

	if ( $video_url['host'] == 'www.youtube.com' || $video_url['host']  == 'youtube.com' ) {
		parse_str( @parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
		$video_id =  $my_array_of_vars['v'] ;
		$output .= 'http://img.youtube.com/vi/'.$video_id.'/0.jpg';
	}elseif( $video_url['host'] == 'www.youtu.be' || $video_url['host']  == 'youtu.be' ){
		$video_id = substr(@parse_url($url, PHP_URL_PATH), 1);
		$output .= 'http://img.youtube.com/vi/'.$video_id.'/0.jpg';
	}
	elseif( $video_url['host'] == 'www.vimeo.com' || $video_url['host']  == 'vimeo.com' ){
		$video_id = (int) substr(@parse_url($url, PHP_URL_PATH), 1);
		$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_id.php"));
		$output .=$hash[0]['thumbnail_large'];
	}
	elseif( $video_url['host'] == 'www.dailymotion.com' || $video_url['host']  == 'dailymotion.com' ){
		$video = substr(@parse_url($url, PHP_URL_PATH), 7);
		$video_id = strtok($video, '_');
		$output .='http://www.dailymotion.com/thumbnail/video/'.$video_id;
	}

	return $output;
	
}

/* ---------------------------------------------------------------------- */
/*	Embeded add video from youtube, vimeo and dailymotion
/* ---------------------------------------------------------------------- */
function sp_add_video ($url, $width = 620, $height = 349) {

	$video_url = @parse_url($url);
	$output = '';

	if ( $video_url['host'] == 'www.youtube.com' || $video_url['host']  == 'youtube.com' ) {
		parse_str( @parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
		$video =  $my_array_of_vars['v'] ;
		$output .='<iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$video.'?rel=0" frameborder="0" allowfullscreen></iframe>';
	}
	elseif( $video_url['host'] == 'www.youtu.be' || $video_url['host']  == 'youtu.be' ){
		$video = substr(@parse_url($url, PHP_URL_PATH), 1);
		$output .='<iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$video.'?rel=0" frameborder="0" allowfullscreen></iframe>';
	}
	elseif( $video_url['host'] == 'www.vimeo.com' || $video_url['host']  == 'vimeo.com' ){
		$video = (int) substr(@parse_url($url, PHP_URL_PATH), 1);
		$output .='<iframe src="http://player.vimeo.com/video/'.$video.'" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
	}
	elseif( $video_url['host'] == 'www.dailymotion.com' || $video_url['host']  == 'dailymotion.com' ){
		$video = substr(@parse_url($url, PHP_URL_PATH), 7);
		$video_id = strtok($video, '_');
		$output .='<iframe frameborder="0" width="'.$width.'" height="'.$height.'" src="http://www.dailymotion.com/embed/video/'.$video_id.'"></iframe>';
	}

	return $output;
}

/* ---------------------------------------------------------------------- */
/*	Embeded soundcloud
/* ---------------------------------------------------------------------- */

function sp_soundcloud($url , $autoplay = 'false' ) {
	return '<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url='.$url.'&amp;auto_play='.$autoplay.'&amp;show_artwork=true"></iframe>';
}

/* ---------------------------------------------------------------------- */
/*	Post multiple images slideshow
/* ---------------------------------------------------------------------- */

if (!function_exists('sp_post_slider')) {

	function sp_post_slider($post_id, $size) { ?>
	
		<script type="text/javascript">
			jQuery(window).load(function() {
				jQuery('#gallery-slider-<?php echo $post_id; ?> .flexslider').flexslider({
					smoothHeight:false,
					slideshow:false,
					animationSpeed:400,
					controlNav:false,
					start:function(slider) {
						jQuery('.gallery-slider').removeClass('slider-loading');
					}
				});
			});
		</script>

		<?php
		$args = array(
			'post_type' => 'attachment',
			'numberposts' => -1, // Get all uploaded images
			'post_status' => null,
			'post_parent' => $post_id,
			'post_mime_type' => 'image',
			'orderby' => 'menu_order',

			// Exclude featured image
			'exclude' => get_post_thumbnail_id()
		);

		$attachments = get_posts($args);
		
		echo "<div id='gallery-slider-$post_id' class='slider-loading gallery-slider'><div class='flexslider'>";
		
		if (!empty($attachments)) {
			echo '<ul class="slides">';
			foreach ($attachments as $attachment) {
				$src = wp_get_attachment_image_src($attachment->ID, $size);
				echo "<li><img src='$src[0]' width='$src[1]' height='$src[2]' alt='' /></li>";
			}
			echo '</ul>';
		}
		
		echo '</div></div>';

	}

}

/* ---------------------------------------------------------------------- */
/*	Get Most Racent posts from Category
/* ---------------------------------------------------------------------- */
function sp_last_posts_cat($numberOfPosts = 5 , $thumb = true , $cats = 1, $thumb_width = 60, $thumb_height = 60, $show_desc = true, $desc_length = 80){
	global $post;
	$orig_post = $post;
	
	( is_single() ) ? $exclude = $post->ID : $exclude = false;
		
	if ($exclude)
		$lastPosts = get_posts('category='.$cats.'&numberposts='.$numberOfPosts.'&exclude='.$exclude);
	else
		$lastPosts = get_posts('category='.$cats.'&numberposts='.$numberOfPosts);	
		
?>
	<ul>
	<?php 
	  foreach($lastPosts as $post): setup_postdata($post); 
		$img_url = sp_post_image('medium');
		$image = aq_resize($img_url, $thumb_width, $thumb_height, true);	
		if (empty($image)) $image = $img_url;		
	?>
		<li<?php echo ($thumb) ? ' class="thumb"' : '' ?>>
			<a href="<?php the_permalink(); ?>" title="<?php printf( __( 'Permalink to %s', SP_TEXT_DOMAIN ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
			<?php if ($image && $thumb) { ?>
			<div class="post-thumbnail">
				<img src="<?php echo $image; ?>" class="wp-post-image" width="<?php echo $thumb_width; ?>" height="<?php echo $thumb_height; ?>" />
	        </div><!-- post-thumbnail /-->
	        <?php } ?>
			<?php the_title();?>
			</a>
			<div class="entry-meta"><?php echo sp_post_meta(); ?></div>
			<?php if ( $show_desc ) { ?>
			<div class="post-desc">
				<?php the_excerpt(); ?>
				<a class="learn-more" href="<?php the_permalink(); ?>"><?php echo _e('Learn more', SP_TEXT_DOMAIN );?></a>
			</div>
			<?php } ?>
		</li>
<?php endforeach; ?>	
	</ul>
	<div class="clear"></div>
<?php
	$post = $orig_post;
	wp_reset_postdata();
}

/* ---------------------------------------------------------------------- */
/*	Supersized - Fullscreen background images
/* ---------------------------------------------------------------------- */

if (!function_exists('sp_supersized_background_page')) {

	function sp_supersized_background_page() {
	
		// Load load all page excerpt contact and 404error page
		if ( !is_page_template('template-contact-map.php') ){ ?>
		
		<?php	
			$img_background = rwmb_meta( 'sp_background_page', $args = array('type' => 'plupload_image', 'size' => 'supersized-thumb') ); 
			$disable_content = get_post_meta(get_the_ID(), 'sp_diable_content_box', true);
			$slide_background = '';
		?>	
			<script type="text/javascript">
			jQuery(function($){
				
				jQuery.supersized({
				
				<?php if (count($img_background) > 1) : ?>		
					// Functionality
					slideshow               :   1,			// Slideshow on/off
					autoplay				:	1,			// Slideshow starts playing automatically
					start_slide             :   1,			// Start slide (0 is random)
					image_path				:	'<?php echo SP_ASSETS_THEME; ?>assets/images/supersized/',
					stop_loop				:	0,			// Pauses slideshow on last slide
					random					: 	0,			// Randomize slide order (Ignores start slide)
					slide_interval          :   8000,		// Length between transitions
					transition              :   1, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
					transition_speed		:	1000,		// Speed of transition
					new_window				:	1,			// Image links open in new window/tab
					pause_hover             :   0,			// Pause slideshow on hover
					keyboard_nav            :   1,			// Keyboard navigation on/off
					performance				:	1,			// 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
					image_protect			:	1,			// Disables image dragging and right click with Javascript
															   
					// Size & Position						   
					min_width		        :   0,			// Min width allowed (in pixels)
					min_height		        :   0,			// Min height allowed (in pixels)
					vertical_center         :   0,			// Vertically center background
					horizontal_center       :   0,			// Horizontally center background
					fit_always				:	0,			// Image will never exceed browser width or height (Ignores min. dimensions)
					fit_portrait         	:   1,			// Portrait images will not exceed browser height
					fit_landscape			:   0,			// Landscape images will not exceed browser width
															   
					// Components							
					slide_links				:	'blank',	// Individual links for each slide (Options: false, 'number', 'name', 'blank')
					thumb_links				:	1,			// Individual thumb links for each slide
					thumbnail_navigation    :   0,			// Thumbnail navigation
					slides 					:  	[			// Slideshow Images
											<?php 
											foreach ( $img_background as $image ){
												$slide_background .= '{image : \'' . $image["full_url"] . '\', title: \'' . $image["title"] . '\', thumb: \'' . $image["url"] . '\'},';
											} 
												$slide_background = substr($slide_background, 0, -1); 
												echo $slide_background;
											?>
												]
				<?php else: ?>
					slides 					:  	[			// once background image
												<?php 
												foreach ( $img_background as $image ){
													$slide_background .= '{image : \'' . $image["full_url"] . '\', title: \'' . $image["title"] . '\', thumb: \'' . $image["url"] . '\'},';
												} 
													$slide_background = substr($slide_background, 0, -1); 
													echo $slide_background;
												?>
												]
				<?php endif; ?>								
					
				});
			
			<?php if ($disable_content) : ?>
				$('#slide-nav').show();
			<?php else : ?>	
				$('#slide-nav').hide();
			<?php endif; ?>
			
			});
			</script>
		
		<?php
		}
	
	}
	
	add_action('wp_head', 'sp_supersized_background_page');

}

/*-----------------------------------------------------------------------------------*/
/* Social 
/*-----------------------------------------------------------------------------------*/
function sp_get_social($newtab='yes', $icon_size='32', $tooltip='ttip' , $flat = false){
	
	global $smof_data;
		
	if ($newtab == 'yes') $newtab = "target=\"_blank\"";
	else $newtab = '';
		
	$icons_path =  SP_ASSETS_THEME . 'images/socialicons';
		
		?>
		<div class="social-icons icon_<?php echo $icon_size; ?>">
		<?php
		// RSS
		if ( !$smof_data['rss_icon'] ){
		if ( $smof_data['rss_url'] != '' && $smof_data['rss_url'] != ' ' ) $rss = $smof_data['rss_url'] ;
		else $rss = get_bloginfo('rss2_url'); 
			?><a class="<?php echo $tooltip; ?> rss-tieicon" title="Rss" href="<?php echo $rss ; ?>" <?php echo $newtab; ?>><?php if( !$flat) : ?><img src="<?php echo $icons_path; ?>/rss.png" alt="RSS"  /><?php endif; ?></a><?php 
		}
		// Google+
		if ( !empty($smof_data['social_google_plus']) && $smof_data['social_google_plus'] != ' ' ) {
			?><a class="<?php echo $tooltip; ?> google-tieicon" title="Google+" href="<?php echo $smof_data['social_google_plus']; ?>" <?php echo $newtab; ?>><?php if( !$flat) : ?><img src="<?php echo $icons_path; ?>/google_plus.png" alt="Google+"  /><?php endif; ?></a><?php 
		}
		// Facebook
		if ( !empty($smof_data['social_facebook']) && $smof_data['social_facebook'] != ' ' ) {
			?><a class="<?php echo $tooltip; ?> facebook-tieicon" title="Facebook" href="<?php echo $smof_data['social_facebook']; ?>" <?php echo $newtab; ?>><?php if( !$flat) : ?><img src="<?php echo $icons_path; ?>/facebook.png" alt="Facebook"  /><?php endif; ?></a><?php 
		}
		// Twitter
		if ( !empty($smof_data['social_twitter']) && $smof_data['social_twitter'] != ' ') {
			?><a class="<?php echo $tooltip; ?> twitter-tieicon" title="Twitter" href="<?php echo $smof_data['social_twitter']; ?>" <?php echo $newtab; ?>><?php if( !$flat) : ?><img src="<?php echo $icons_path; ?>/twitter.png" alt="Twitter"  /><?php endif; ?></a><?php
		}		
		// Pinterest
		if ( !empty($smof_data['social_pinterest']) && $smof_data['social_pinterest'] != ' ') {
			?><a class="<?php echo $tooltip; ?> pinterest-tieicon" title="Pinterest" href="<?php echo $smof_data['social_pinterest']; ?>" <?php echo $newtab; ?>><?php if( !$flat) : ?><img src="<?php echo $icons_path; ?>/pinterest.png" alt="MySpace"  /><?php endif; ?></a><?php
		}
		// LinkedIN
		if ( !empty($smof_data['social_linkedin']) && $smof_data['social_linkedin'] != ' ' ) {
			?><a class="<?php echo $tooltip; ?> linkedin-tieicon" title="LinkedIn" href="<?php echo $smof_data['social_linkedin']; ?>" <?php echo $newtab; ?>><?php if( !$flat) : ?><img  src="<?php echo $icons_path; ?>/linkedin.png" alt="LinkedIn"  /><?php endif; ?></a><?php
		}
		// YouTube
		if ( !empty($smof_data['social_youtube']) && $smof_data['social_youtube'] != ' ' ) {
			?><a class="<?php echo $tooltip; ?> youtube-tieicon" title="Youtube" href="<?php echo $smof_data['social_youtube']; ?>" <?php echo $newtab; ?>><?php if( !$flat) : ?><img  src="<?php echo $icons_path; ?>/youtube.png" alt="YouTube"  /><?php endif; ?></a><?php
		}
		// Skype
		if ( !empty($smof_data['social_skype']) && $smof_data['social_skype'] != ' ' ) {
			?><a class="<?php echo $tooltip; ?> skype-tieicon" title="Skype" href="<?php echo $smof_data['social_skype']; ?>" <?php echo $newtab; ?>><?php if( !$flat) : ?><img  src="<?php echo $icons_path; ?>/skype.png" alt="Skype"  /><?php endif; ?></a><?php
		}
		// Delicious 
		if ( !empty($smof_data['social_delicious']) && $smof_data['social_delicious'] != ' ' ) {
			?><a class="<?php echo $tooltip; ?> delicious-tieicon" title="Delicious" href="<?php echo $smof_data['social_delicious']; ?>" <?php echo $newtab; ?>><?php if( !$flat) : ?><img  src="<?php echo $icons_path; ?>/delicious.png" alt="Delicious"  /><?php endif; ?></a><?php
		}
		// Vimeo
		if ( !empty($smof_data['social_vimeo']) && $smof_data['social_vimeo'] != ' ' ) {
			?><a class="<?php echo $tooltip; ?> vimeo-tieicon" title="Vimeo" href="<?php echo $smof_data['social_vimeo']; ?>" <?php echo $newtab; ?>><?php if( !$flat) : ?><img  src="<?php echo $icons_path; ?>/vimeo.png" alt="Vimeo"  /><?php endif; ?></a><?php
		}
		// instagram
		if ( !empty( $smof_data['social_instagram'] ) && $smof_data['social_instagram'] != ' ' ) {
			?><a class="<?php echo $tooltip; ?> instagram-tieicon" title="instagram" href="<?php echo $smof_data['social_instagram']; ?>" <?php echo $newtab; ?>><?php if( !$flat) : ?><img  src="<?php echo $icons_path; ?>/instagram.png" alt="instagram"  /><?php endif; ?></a><?php
		}
?>
	</div>

<?php
}

/*-----------------------------------------------------------------------------------*/
/* Show a total share counter (FB, Twitter, G+)
/*-----------------------------------------------------------------------------------*/
function social_shares( $socials ) {
    $url = get_permalink( $post_id ); 
    $json = file_get_contents("http://api.sharedcount.com/?url=" . rawurlencode($url));
    $counts = json_decode($json, true);
    if ($socials == "twitter") {
    	$totalcounts= $counts["Twitter"]; 
    } elseif ( $socials == "facebook" ) {	
		$totalcounts = $counts["Facebook"]["total_count"];
	} elseif ( $socials == "google_plus" ) {
		$totalcounts = $counts["GooglePlusOne"];
	}
    echo $totalcounts;
}