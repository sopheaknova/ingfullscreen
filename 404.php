<?php
/**
 * 404 pages.
 */

get_header(); ?>
<div id="content">
	<div class="inner-content">
		<div class="min">
			<center>
			<article id="post-0" class="post no-results not-found">
			<header class="entry-header">
				<h1 class="entry-title"><?php _e( 'Uh oh 404 Error, we’ve lost that page!', SP_TEXT_DOMAIN ); ?></h1>
			</header>
			<div class="entry-content">
				
				<?php get_template_part('includes/error404'); ?>
				
			</div><!-- .entry-content -->
			</article><!-- #post-0 -->
			</center>
			
    </div>
	<!-- .$page_layout -->
	</div>
	<!-- .inner-content -->
</div>
<!-- #content -->
<?php get_footer(); ?>
