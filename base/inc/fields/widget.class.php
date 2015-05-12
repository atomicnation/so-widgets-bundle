<?php

/**
 * Class SiteOrigin_Widget_Field_Widget
 */
class SiteOrigin_Widget_Field_Widget extends SiteOrigin_Widget_Field_Container_Base {
	/**
	 * The class name of the widget to be included.
	 *
	 * @access protected
	 * @var string
	 */
	protected $class_name;

	public function __construct( $base_name, $element_id, $element_name, $field_options, SiteOrigin_Widget $for_widget, $parent_container = array() ) {
		parent::__construct( $base_name, $element_id, $element_name, $field_options, $for_widget, $parent_container );

		if( isset( $field_options['class'] ) ) {
			$this->class_name = $field_options['class'];

			if( class_exists( $this->class_name ) ) {
				/* @var $sub_widget SiteOrigin_Widget */
				$sub_widget = new $this->class_name;
				if( is_a( $sub_widget, 'SiteOrigin_Widget' ) ) {
					$this->sub_field_options = $sub_widget->form_options( $this->for_widget );
				}
			}
		}
	}


	protected function render_field( $value, $instance ) {
		// Create the extra form entries
		?><div class="siteorigin-widget-section <?php if( !empty($this->hide ) ) echo 'siteorigin-widget-section-hide'; ?>"><?php

		if( ! class_exists( $this->class_name ) ) {
			printf( __( '%s does not exist', 'siteorigin-widgets' ), $this->class_name );
			echo '</div>';
			return;
		}

		/* @var $sub_widget SiteOrigin_Widget */
		$sub_widget = new $this->class_name;
		if( ! is_a( $sub_widget, 'SiteOrigin_Widget' ) ) {
			printf( __( '%s is not a SiteOrigin Widget', 'siteorigin-widgets' ), $this->class_name );
			echo '</div>';
			return;
		}
		$this->create_and_render_sub_fields( $value, array( 'name' => $this->base_name, 'type' => 'widget' ) );
		?></div><?php
	}

}