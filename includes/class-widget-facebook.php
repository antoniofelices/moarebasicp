<?php
/**
 * Widget and functions to Facebook timeline
 *
 * @package moarebasicp
 * @since 0.1.0
 *
 */


/**
 * Extends class WP_Widget.
 *
 * @since  0.1.0
 * @return void
 */
class moare_facebook_widget extends WP_Widget
{

	function __construct()
	{

	 	$widget_ops = array(
	 		'classname' => 'mb-facebook',
	 		'description' => esc_html__( 'A Simple timeline de Facebook', 'moarebasicp' )
	 	);

	 	parent::__construct(
			'moarebasicp_facebook',
			esc_html__( 'Timeline Facebook', 'moarebasicp' ),
			$widget_ops
		);

	}

	/**
	 * Back-end inputs content.
	 *
	 * @param array $instance Saved values from database.
	 */
	public function form( $instance )
	{

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
	public function widget( $args, $instance )
    {

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
	public function update( $new_instance, $old_instance )
    {
		$instance = array();

		$instance['pagefacebook'] = ( ! empty( $new_instance['pagefacebook'] ) ) ? strip_tags( $new_instance['pagefacebook'] ) : '';

		return $instance;
	}


} // class Facebook widget


/**
 * Adding some Javascript code to head
 *
 * @since  0.1.0
 * @return void
 */
function moarebasicp_js_facebook(){
	?>

	<div id="fb-root"></div>

	<script>

	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.10";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));

	</script>

	<?php
}

/**
 * Initialize class moare_facebook_widget
 *
 * @since  0.1.0
 * @return ¿?
 */
function moarebasicp_fb_timeline(){

	register_widget('moare_facebook_widget');

}

/**
 * Load functions to wp_head and widget_init
 *
 * @since  0.1.0
 * @return void
 */
function moarebasicp_fb_setup(){

   add_action( 'widgets_init', 'moarebasicp_fb_timeline', 10 );
   add_action( 'wp_head', 'moarebasicp_js_facebook', 10 );

}

moarebasicp_fb_setup();
