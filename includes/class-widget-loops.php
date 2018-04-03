<?php
/**
 * Widget custom loops.
 *
 * @package moarebasicp
 * @since 1.0.0
 *
 */

if( ! defined( 'ABSPATH' ) ) exit;

/**
 * Extends class WP_Widget.
 *
 * @since  1.0.0
 * @return void
 */
class moare_loops_widget extends WP_Widget{

	function __construct() {

	 	$widget_ops = array(
	 		'classname' => 'mb-loops',
	 		'description' => esc_html__( 'A Simple loops', 'moarebasicp' )
	 	);

	 	parent::__construct(
			'moarebasicp_loops',
			esc_html__( 'Loop featured posts', 'moarebasicp' ),
			$widget_ops
		);

	}

	/**
	 * Front-end display of widget.
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		echo $args['before_widget'];

		$argsloop = array(
			'post_type' => 'post',
			'cat' => array( 2, 19, 7 ),
			'posts_per_page' => 10,
		);

		echo '<ul>';

		$query_secondary = new WP_Query( $argsloop );

		if( $query_secondary->have_posts() ):

		    while( $query_secondary->have_posts() ): $query_secondary->the_post();
				?>

				<li>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</li>

				<?php
		    endwhile;

		endif;

		echo '</ul>';

		$query_secondary = null;
		wp_reset_postdata();

		echo $args['after_widget'];

	}

} // class loops widget
