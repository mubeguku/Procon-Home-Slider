<?php
/**
 * Plugin Name: PR Home Slider
 * Description: Procon Home Page Slider
 * Version: 1.0
 * Text Domain: pr-slider
 */


class prSlider {

	function __construct(){

		add_action( 'init', [$this, 'pr_slider'], 0 );

	}

	// Register Slider Post Type
	public static function pr_slider() {

		$labels = array(
			'name'                  => _x( 'Slides', 'Post Type General Name', 'pr_slider' ),
			'singular_name'         => _x( 'Slide', 'Post Type Singular Name', 'pr_slider' ),
			'menu_name'             => __( 'Slides', 'pr_slider' ),
			'name_admin_bar'        => __( 'Slides', 'pr_slider' ),
			'archives'              => __( 'Item Archives', 'pr_slider' ),
			'parent_item_colon'     => __( 'Parent Item:', 'pr_slider' ),
			'all_items'             => __( 'All Items', 'pr_slider' ),
			'add_new_item'          => __( 'Add New Item', 'pr_slider' ),
			'add_new'               => __( 'Add New', 'pr_slider' ),
			'new_item'              => __( 'New Item', 'pr_slider' ),
			'edit_item'             => __( 'Edit Item', 'pr_slider' ),
			'update_item'           => __( 'Update Item', 'pr_slider' ),
			'view_item'             => __( 'View Item', 'pr_slider' ),
			'search_items'          => __( 'Search Item', 'pr_slider' ),
			'not_found'             => __( 'Not found', 'pr_slider' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'pr_slider' ),
			'featured_image'        => __( 'Featured Image', 'pr_slider' ),
			'set_featured_image'    => __( 'Set featured image', 'pr_slider' ),
			'remove_featured_image' => __( 'Remove featured image', 'pr_slider' ),
			'use_featured_image'    => __( 'Use as featured image', 'pr_slider' ),
			'insert_into_item'      => __( 'Insert into item', 'pr_slider' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'pr_slider' ),
			'items_list'            => __( 'Items list', 'pr_slider' ),
			'items_list_navigation' => __( 'Items list navigation', 'pr_slider' ),
			'filter_items_list'     => __( 'Filter items list', 'pr_slider' ),
		);
		$args = array(
			'label'                 => __( 'Slide', 'pr_slider' ),
			'description'           => __( 'PR Slider', 'pr_slider' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', ),
			//'taxonomies'            => array( 'category' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,		
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
		);
		register_post_type( 'pr_slider', $args );

	}

	public static function display() {
		 
		$query = new WP_Query( array( 
			'post_type' => 'pr_slider'
		) );
		 
		if ( $query->have_posts() ) : ?>

		<div class="slider-home">
	    	<div class="slider-home__nav-top hidden-xs">
				<div class="slider center slider-nav-top">
					<?php $count = 0; while ( $query->have_posts() ) : $query->the_post(); $count++ ?>
						<div><div class="slider-number"><?php echo sprintf( '%02d', $count ); ?></div></div>
					<?php 
						endwhile;
						wp_reset_postdata(); 
					?>	
				</div>
			</div>
			<div class="slider slider-for slider-home">
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>	
					<div>
						<?php $full_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ) ?>
						<div class="slide-img" style="background-image: url('<?php if ( ! empty( $full_image_url[0] ) ) { echo esc_url( $full_image_url[0] ); } ?>');">
							<div class="inner">
								<div class="container">
						            <p class="slider-title"><?php the_title(); ?></p>
						            <p class="slider-text"><?php echo get_the_content(); ?></p>
						            <a href="<?php the_field('url'); ?>" class="slider-btn"><?php _e( 'Read more', 'pr-slider' ); ?></a>
						        </div>
					        </div>
						</div>
					</div>
				<?php 
					endwhile;
					wp_reset_postdata(); 
				?>
			</div>
			<div class="slider-home__nav-bottom">
				<div class="container">
					<div class="slider slider-nav-bottom">
						<?php while ( $query->have_posts() ) : $query->the_post(); ?>
							<?php if( get_field('navigation_label') && get_field('small_caption') ): ?>
								<div><span class="slider-nav-caption"><?php the_field('small_caption'); ?></span><h3><?php the_field('navigation_label'); ?></h3></div>
							<?php endif; ?>
						<?php 
							endwhile;
							wp_reset_postdata(); 
						?>
					</div>
				</div>
			</div>
		</div>

		<?php endif;
	}

}

new prSlider();