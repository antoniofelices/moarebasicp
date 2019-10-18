<?php
/**
 * Widget Facebook timeline.
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
class Moare_Widget_Facebook extends WP_Widget{

	function __construct() {

		$widget_ops = array(
			'classname'			=> 'mb-facebook',
			'description'		=> esc_html__( 'A Simple timeline de Facebook', 'moarebasicp' )
		);

		parent::__construct(
			'moarebasicp_facebook',
			esc_html__( 'Moare - Timeline Facebook', 'moarebasicp' ),
			$widget_ops
		);

	}

	/**
	 * Back-end inputs content.
	 *
	 * @param array $instance Saved values from database.
	 */
	public function form( $instance ) {

		$pagefacebook = ! empty( $instance['pagefacebook'] ) ? $instance['pagefacebook'] : esc_html__( 'facebook-page', 'moarebasicp' );

		?>

		<label for="<?php echo esc_attr( $this->get_field_id('pagefacebook') ); ?>"><?php esc_attr_e('Page Facebook. Without slash.'); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id('pagefacebook') ); ?>" name="<?php echo esc_attr( $this->get_field_name('pagefacebook') ); ?>" type="text" value="<?php echo esc_attr( $pagefacebook ); ?>" />

		<?php

	}

	/**
	 * Front-end display of widget.
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		echo $args['before_widget'];

		$pagefacebook    = $instance['pagefacebook'];

		?>

		<div class="fb-page" data-href="https://www.facebook.com/ <?php echo esc_attr( $pagefacebook ); ?>" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false">
			<blockquote cite="https://www.facebook.com/ <?php echo esc_attr( $pagefacebook ); ?>" class="fb-xfbml-parse-ignore"><?php echo esc_html( $pagefacebook ); ?></blockquote>
		</div>

		<?php

		echo $args['after_widget'];

	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['pagefacebook'] = ( ! empty( $new_instance['pagefacebook'] ) ) ? strip_tags( $new_instance['pagefacebook'] ) : '';

		return $instance;
	}

} // class Facebook widget
