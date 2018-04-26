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

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		$cptname = $instance['cptname'];
		$taxid = $instance['taxid'];

		$argsloop = array(
			'post_type' => $cptname,
			'posts_per_page' => 10
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

	/**
	 * Back-end widget form.
	 *
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Title', 'moarebasicp' );
		$cptname = ! empty( $instance['cptname'] ) ? $instance['cptname'] : esc_html__( 'CPT name', 'moarebasicp' );
		$taxid = ! empty( $instance['taxid'] ) ? $instance['taxid'] : esc_html__( 'Tax id', 'moarebasicp' );

		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'moarebasicp' ); ?></label>
			<br>
			<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'cptname' ) ); ?>"><?php esc_attr_e( 'CPT name', 'moarebasicp' ); ?></label>
			<br>
			<input id="<?php echo esc_attr( $this->get_field_id( 'cptname' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cptname' ) ); ?>" type="text" value="<?php echo esc_attr( $cptname ); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'taxid' ) ); ?>"><?php esc_attr_e('Tax ID', 'moarebasicp'); ?></label>
			<br>
			<input id="<?php echo esc_attr( $this->get_field_id( 'taxid' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'taxid' ) ); ?>" type="text" value="<?php echo esc_attr( $taxid ); ?>" />
		</p>

		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['cptname'] = ( ! empty( $new_instance['cptname'] ) ) ? strip_tags( $new_instance['cptname'] ) : '';
		$instance['taxid'] = ( ! empty( $new_instance['taxid'] ) ) ? strip_tags( $new_instance['taxid'] ) : '';

		return $instance;

	}

} // class loops widget
