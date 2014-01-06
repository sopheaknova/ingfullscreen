<?php
/**
 * The template for displaying all pages.
 */

get_header(); ?>

    <div id="content">
	<div class="inner-content">
		<div class="min">
        <header class="entry-header">
        	
        	<?php
        	// Get the author name for the author archive page
			if (get_query_var('author_name')) {
				$curauth = get_user_by('login', $author_name);
			}
			else {
				$curauth = get_userdata(get_query_var('author'));
			}
        	?>
        	
        	<?php if ( have_posts() ): ?>
				
				<h3 class="archive-title">
					<?php
						if ( is_day() ) :
							printf( __( 'Daily Archives: %s', SP_TEXT_DOMAIN ), '<span>' . get_the_date() . '</span>' );
						elseif ( is_month() ) :
							printf( __( 'Monthly Archives: %s', SP_TEXT_DOMAIN ), '<span>' . get_the_date( 'F Y' ) . '</span>' );
						elseif ( is_year() ) :
							printf( __( 'Yearly Archives: %s', SP_TEXT_DOMAIN ), '<span>' . get_the_date( 'Y' ) . '</span>' );
						elseif ( is_category() ) :
							single_cat_title();
						elseif ( is_author() ) :
							echo __( 'All posts by: ', SP_TEXT_DOMAIN ) . '<span>' . $curauth->display_name . '</span>';
						elseif (isset($_GET['paged']) && !empty($_GET['paged'])) :
							_e( 'Blog Archives', SP_TEXT_DOMAIN );
						endif;
					?>
				</h3>

				<?php rewind_posts(); ?>
				
			<?php else: ?>
			
					<h3 class="archive-title"><?php _e( 'Nothing Found', SP_TEXT_DOMAIN ); ?></h3>

			<?php endif; ?>

        </header><!-- end .page-header -->
        <div class="entry-content">
		<?php 
		if ( have_posts() ) :
			while ( have_posts() ) :
			the_post(); ?>
			<div class="archive-post-items">
			<h5>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
			</h5>
			<div class="entry-meta"><?php sp_post_meta(); ?></div>
			<?php 
			if (is_single()) the_content(); 
			else the_excerpt();
			?>
			</div> <!-- archive-post-items -->
		<?php 
			endwhile; 
		endif; ?>
		</div><!-- .entry-content -->
			
		
		</div> <!-- .mini -->		
		</div> <!-- .inner-content -->		
        
    </div><!-- #main -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
