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
	 		'description' => esc_html__( 'A Simple cpt queries, similar featured post genesis', 'moarebasicp' )
	 	);

	 	parent::__construct(
			'moarebasicp_loops',
			esc_html__( 'Moare - Featured cpts', 'moarebasicp' ),
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
		$posts_num = $instance['posts_num'];
		$orderby = $instance['orderby'];
		$order = $instance['order'];
		$taxname = $instance['taxname'];
		$taxid = $instance['taxid'];

		$show_title = $instance['show_title'];
		$show_excerpt = $instance['show_excerpt'];
		$show_image = $instance['show_image'];
		$postid = get_the_ID();

		if ( $cptname && $taxname && $taxid ) {
			$argsloop = array(
				'post_type' => $cptname,
				'posts_per_page' => $posts_num,
				'orderby'  => $orderby,
				'order' => $order,
				'post__not_in' => array( $postid ),
				'tax_query' => array(
					array(
						'taxonomy' => $taxname,
						'terms' => $taxid,
						'field' => 'term_id'
					)
				)
			);
		} else if( $cptname && !$taxname && !$taxid ) {
			$argsloop = array(
				'post_type' => $cptname,
				'posts_per_page' => $posts_num,
				'orderby'  => $orderby,
				'order' => $order,
				'post__not_in' => array( $postid )
			);
		} else {
			return;
		}

		$query_secondary = new WP_Query( $argsloop );

		if( $query_secondary->have_posts() ):

		    while( $query_secondary->have_posts() ): $query_secondary->the_post();

				?>

				<article <?php post_class(); ?>>

				<?php

				if ( $show_image ) {

					?>

					<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_post_thumbnail( 'medium' ); ?></a>

					<?php

				}
				if ( $show_title ) {

					?>

					<header class="entry-header">
						<?php the_title( '<h4 class="entry-title" itemprop="headline"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' ); ?>
					</header>

					<?php

				}
				if ( $show_excerpt ) {

					?>

				  <div class="entry-content">
				    <?php the_excerpt(); ?>
				  </div>

					<?php

				}

				?>

				</article>

				<?php

				endwhile;

		endif;

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

		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$cptname = ! empty( $instance['cptname'] ) ? $instance['cptname'] : '';
		$orderby = ! empty( $instance['orderby'] ) ? $instance['orderby'] : esc_html__( 'Default', 'moarebasicp' );
		$order = ! empty( $instance['order'] ) ? $instance['order'] : esc_html__( 'ASC', 'moarebasicp' );
		$posts_num = ! empty( $instance['posts_num'] ) ? $instance['posts_num'] : 1;
		$taxname = ! empty( $instance['taxname'] ) ? $instance['taxname'] : '';
		$taxid = ! empty( $instance['taxid'] ) ? $instance['taxid'] : '';

		$show_image = ! empty( $instance['show_image'] ) ? $instance['show_image'] : 0;
		$show_title = ! empty( $instance['show_title'] ) ? $instance['show_title'] : 0;
		$show_excerpt = ! empty( $instance['show_excerpt'] ) ? $instance['show_excerpt'] : 0;

		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title', 'moarebasicp' ); ?>:</label>
			<br>
			<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'cptname' ) ); ?>"><?php esc_attr_e( 'CPT name', 'moarebasicp' ); ?>:</label>
			<br>
			<input id="<?php echo esc_attr( $this->get_field_id( 'cptname' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cptname' ) ); ?>" type="text" value="<?php echo esc_attr( $cptname ); ?>">
		</p>

		<p>
		  <label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php esc_html_e( 'Order By', 'moarebasicp' ); ?>:</label>
		  <select id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>">
		    <option value="date" <?php selected( 'date', $orderby ); ?>><?php esc_html_e( 'Date Published', 'moarebasicp' ); ?></option>
		    <option value="modified" <?php selected( 'modified', $orderby ); ?>><?php esc_html_e( 'Date Modified', 'moarebasicp' ); ?></option>
		    <option value="title" <?php selected( 'title', $orderby ); ?>><?php esc_html_e( 'Title', 'moarebasicp' ); ?></option>
		    <option value="parent" <?php selected( 'parent', $orderby ); ?>><?php esc_html_e( 'Parent', 'moarebasicp' ); ?></option>
		    <option value="ID" <?php selected( 'ID', $orderby ); ?>><?php esc_html_e( 'ID', 'moarebasicp' ); ?></option>
		    <option value="rand" <?php selected( 'rand', $orderby ); ?>><?php esc_html_e( 'Random', 'moarebasicp' ); ?></option>
		  </select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php esc_html_e( 'Sort Order', 'moarebasicp' ); ?>:</label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>">
				<option value="DESC" <?php selected( 'DESC', $order ); ?>><?php esc_html_e( 'Descending (3, 2, 1)', 'moarebasicp' ); ?></option>
				<option value="ASC" <?php selected( 'ASC', $order ); ?>><?php esc_html_e( 'Ascending (1, 2, 3)', 'moarebasicp' ); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'posts_num' ) ); ?>"><?php esc_html_e( 'Number of Posts to Show', 'moarebasicp' ); ?>:</label>
			<br>
			<input type="number" id="<?php echo esc_attr( $this->get_field_id( 'posts_num' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_num' ) ); ?>" value="<?php echo esc_attr( $posts_num ); ?>" size="2" placeholder="1" />
		</p>

		<div>
			<strong><?php esc_html_e( 'Tax name and Tax id have to be together', 'moarebasicp' ) ?></strong><br>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'taxname' ) ); ?>"><?php esc_attr_e('Tax name', 'moarebasicp'); ?>:</label>
				<br>
				<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'taxname' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'taxname' ) ); ?>"  value="<?php echo esc_attr( $taxname ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'taxid' ) ); ?>"><?php esc_attr_e('Tax ID', 'moarebasicp'); ?>:</label>
				<br>
				<input type="number" id="<?php echo esc_attr( $this->get_field_id( 'taxid' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'taxid' ) ); ?>" value="<?php echo esc_attr( $taxid ); ?>" />
			</p>
		</div>

		<p>
			<input id="<?php echo esc_attr( $this->get_field_id( 'show_image' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'show_image' ) ); ?>" value="1" <?php checked( $show_image ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_image' ) ); ?>"><?php esc_html_e( 'Show Featured Image', 'moarebasicp' ); ?></label>
		</p>

		<p>
			<input id="<?php echo esc_attr( $this->get_field_id( 'show_title' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'show_title' ) ); ?>" value="1" <?php checked( $show_title ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_title' ) ); ?>"><?php esc_html_e( 'Show Post Title', 'moarebasicp' ); ?></label>
		</p>

		<p>
			<input id="<?php echo esc_attr( $this->get_field_id( 'show_excerpt' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'show_excerpt' ) ); ?>" value="1" <?php checked( $show_excerpt ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_excerpt' ) ); ?>"><?php esc_html_e( 'Show Excerpt', 'moarebasicp' ); ?></label>
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
		$instance['posts_num'] = ( ! empty( $new_instance['posts_num'] ) ) ? strip_tags( $new_instance['posts_num'] ) : '';
		$instance['orderby'] = ( ! empty( $new_instance['orderby'] ) ) ? strip_tags( $new_instance['orderby'] ) : '';
		$instance['order'] = ( ! empty( $new_instance['order'] ) ) ? strip_tags( $new_instance['order'] ) : '';
		$instance['taxname'] = ( ! empty( $new_instance['taxname'] ) ) ? strip_tags( $new_instance['taxname'] ) : '';
		$instance['taxid'] = ( ! empty( $new_instance['taxid'] ) ) ? strip_tags( $new_instance['taxid'] ) : '';
		$instance['show_image'] = ( ! empty( $new_instance['show_image'] ) ) ? strip_tags( $new_instance['show_image'] ) : '';
		$instance['show_title'] = ( ! empty( $new_instance['show_title'] ) ) ? strip_tags( $new_instance['show_title'] ) : '';
		$instance['show_excerpt'] = ( ! empty( $new_instance['show_excerpt'] ) ) ? strip_tags( $new_instance['show_excerpt'] ) : '';

		return $instance;

	}

} // class loops widget
