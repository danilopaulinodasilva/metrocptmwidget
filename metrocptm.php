<?php
/*
Plugin Name: Status CPTM/Metrô
Plugin URI: https://github.com/danilopaulinodasilva/metrocptmwidget
Description: Esse plug-in é um widget personalizado que consome a API Status CPTM/Metrô para mostrar o status das linhas do Metrô e CPTM de São Paulo.
Version: 1.0
Author: Danilo P. da Silva
Author URI: https://github.com/danilopaulinodasilva/metrocptmwidget
License: GPL2
*/

// The widget class
class Status_Cptm_Metro extends WP_Widget {

	// Main constructor
	public function __construct() {
		parent::__construct(
			'status_cptm_metro',
			__( 'Status CPTM/Metrô', 'text_domain' ),
			array(
				'customize_selective_refresh' => true,
			)
		);
	}

	// The widget form (for the backend )
	public function form( $instance ) {

		// Set widget defaults
		$defaults = array(
			'title'    => '',
			'cptm' => '',
			'metro' => ''
		);
		
		// Parse current settings with defaults
		extract( wp_parse_args( ( array ) $instance, $defaults ) ); ?>

		<?php // Widget Title ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Widget Title', 'text_domain' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<?php // Checkboxes ?>
		<p>
			<input id="<?php echo esc_attr( $this->get_field_id( 'cptm' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cptm' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $cptm ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'cptm' ) ); ?>"><?php _e( 'CPTM', 'text_domain' ); ?></label>
		</p>

		<p>
			<input id="<?php echo esc_attr( $this->get_field_id( 'metro' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'metro' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $metro ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'metro' ) ); ?>"><?php _e( 'Metrô', 'text_domain' ); ?></label>
		</p>

	<?php }

	// Update widget settings
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title']    = isset( $new_instance['title'] ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		$instance['cptm'] = isset( $new_instance['cptm'] ) ? 1 : false;
		$instance['metro'] = isset( $new_instance['metro'] ) ? 1 : false;
		return $instance;
	}

	// Display the widget
	public function widget( $args, $instance ) {

		extract( $args );

		// Check the widget options
		$title    = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
		$cptm = ! empty( $instance['cptm'] ) ? $instance['cptm'] : false;
		$metro = ! empty( $instance['metro'] ) ? $instance['metro'] : false;

		// WordPress core before_widget hook (always include )
		echo $before_widget;

		// Display the widget
		echo '<div class="widget-text wp_widget_plugin_box">';

			// Display widget title if defined
			if ( $title ) {
				echo $before_title . $title . $after_title;
			}

			// Mostra linhas da CPTM
			if ( $cptm ) {
				echo '<p>Mostra status das linhas da CPTM</p>';
			}

			// Mostra linhas do Metrô

			if ( $metro ) {
				echo '<p>Mostra status das linhas do Metrô</p>';
			}

		echo '</div>';

		// WordPress core after_widget hook (always include )
		echo $after_widget;

	}

}

// Register the widget
function register_status_cptm_metro() {
	register_widget( 'Status_Cptm_Metro' );
}
add_action( 'widgets_init', 'register_status_cptm_metro' );