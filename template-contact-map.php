<?php
/*
Template Name: Contact Google Map
*/
?>

<?php get_header(); ?>

<?php 
	//Past meta value into var
	$map_locations = get_post_meta($post->ID, 'sp_contact_map', true); 
	$map_loc = explode(',', $map_locations);
	$longitude_center = $map_loc[1] - 0.04;// Variable to align the marker on the right side of the map, instead of the center
?>
<!-- Begin Google Map -->
<div id="map-container">
	<div class="map-inner">

	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript">					
	  jQuery(document).ready(function ($)
		{
			
			var map_styles = [
				{
					// Style the map with the custom hue
					stylers: [
						{ "hue":"#0C4DA2" }
					]
				},
				{
					// Remove road labels
					featureType:"road",
					elementType:"labels",
					stylers: [
						{ "visibility":"off" }
					]
				},
				{
					// Style the road
					featureType:"road",
					elementType:"geometry",
					stylers: [
						{ "lightness":100 },
						{ "visibility":"simplified" }
					]
				}
			];;
			
			var mapOptions = {	
				center: new google.maps.LatLng(<?php echo $map_loc[0] . ',' . $longitude_center; ?>),
				zoomControlOptions: {
			        style: google.maps.ZoomControlStyle.LARGE,
			        position: google.maps.ControlPosition.LEFT_CENTER
			    },
			    panControlOptions: {
			        position: google.maps.ControlPosition.LEFT_CENTER
			    },
				streetViewControl:false,
				zoom:14,
				mapTypeControlOptions: {
					mapTypeIds:[]
				}
			}
			var map = new google.maps.Map(document.getElementById("single-map-canvas"), mapOptions);

			var styledMap = new google.maps.StyledMapType(map_styles, { name:"Contact Map" });

			map.mapTypes.set('Contact Map', styledMap);
			map.setMapTypeId('Contact Map');
			
			
			var image = '<?php echo SP_ASSETS_THEME ;?>' + 'images/google-map-marker.png'; // Marker image

			var marker = new google.maps.Marker({
				position: new google.maps.LatLng(<?php echo $map_loc[0] . ',' . $map_loc[1]; ?>), 
				map: map,
				icon:image,
				animation: google.maps.Animation.DROP
			});
		});
	</script>

	<div id="single-map-canvas" class="google-map-img-reset" style="width:100%; height: 450px;"></div>

	<!-- Begin Contact Information -->
	<div id="map-info">
		<?php 
		if ( have_posts() ) :
			while ( have_posts() ) :
			the_post(); ?>	
		
		<div class="contact-container">
			<?php the_content(); ?>
		</div>
		
		<?php
			// Get the marker position from the theme options, so we can create a link to Google Maps
			$latitude = $map_loc[0];
			$longitude = $map_loc[1];
		?>
		<div class="directions-container">
			<a href="https://maps.google.com/?saddr=&daddr=<?php echo esc_html($latitude); ?>,<?php echo esc_html($longitude); ?>" class="button awesome small square grey" target="_blank"><span class="icon-map-marker"></span><?php _e('Get Directions', SP_TEXT_DOMAIN); ?></a>
		</div>
		<!-- End Contact Information -->
		<?php endwhile;
		else : ?>
			<?php get_template_part('includes/error404'); ?>
		<?php endif; ?>
			
	</div>
	<!-- .map-info -->

	</div>
	<!-- .map-inner -->
</div>
<!-- End Google Map -->
		
<?php get_footer(); ?>