<?php
/**
 * Widget Social Share.
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
class moare_social_share_widget extends WP_Widget{

	function __construct() {

	 	$widget_ops = array(
	 		'classname' => 'mb-social-share',
	 		'description' => esc_html__( 'A Simple Social Share buttons', 'moarebasicp' )
	 	);

	 	parent::__construct(
			'moarebasicp_socialshare',
			esc_html__( 'Moare - Social share buttons', 'moarebasicp' ),
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

		if( is_singular() && !is_front_page() ){

      $mb_url_params = array(
        'url'   => get_the_permalink(),
        'title' => get_the_title()
      );

      $mb_facebook = sprintf('<a href="https://facebook.com/sharer/sharer.php?u=%s">Facebook</a>',
        esc_url( $mb_url_params['url'] )
      );

      $mb_twitter = sprintf('<a href="https://twitter.com/intent/tweet?url=%s">Twitter</a>',
        esc_url( $mb_url_params['url'] )
      );

      // $sn_googleplus = sprintf('<a href="https://plus.google.com/share?url=%s">Google+</a>',
      //   esc_url( $mb_url_params['url'] )
      // );
			//
      // $sn_linkedin = sprintf('<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=%s">Linkedin</a>',
      //   esc_url( $mb_url_params['url'] )
      // );

			?>

			<ul class="social">
				<li><?php print $mb_facebook; ?></li>
				<li><?php print $mb_twitter; ?></li>
			</ul>

			<?php

		}

		echo $args['after_widget'];

	}

} // class social share
