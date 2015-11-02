<?php

/**
 * PS EAN Widget Class
 * Used for creating a front-end widget with different input forms
 * which will gather input from the user
 */
class PS_EAN_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		parent::__construct(
			'ps_ean_api_widget', // Base ID
			__( 'EAN Widget', 'ps_ean_api' ), // Name
			array( 'description' => __( 'Expedia Affiliate Network Widget', 'ps_ean_api' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		// outputs the content of the widget
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		$base_url = get_option('psean_base_url');
		?>
	<form method="get" action="<?php echo $base_url; ?>/hotel/list">
		<label for='ean_country'>Country:</label>
		<input type='text' id='ean_country' name='ean_country' />
		
		<label for='ean_prov'>Province:</label>
		<input type='text' id='ean_prov' name='ean_prov' />
		<label for='ean_city'>City:</label>
		<input type='text' id='ean_city' name='ean_city' /><br>
		<input type="submit" value="Search" />
		</form>

		<?php
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'ps_ean_api' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}
}