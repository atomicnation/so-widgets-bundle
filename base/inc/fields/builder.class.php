<?php

/**
 * A full instance of SiteOrigin Page Builder as a field.
 *
 * Class SiteOrigin_Widget_Field_Builder
 */
class SiteOrigin_Widget_Field_Builder extends SiteOrigin_Widget_Field_Base {

	protected function render_field( $value, $instance ){
		if( defined('SITEORIGIN_PANELS_VERSION') ) {
			if( ! is_string( $value ) ) {
				$value = json_encode( $value );
			}

			// Normal rendering code
			?>
			<div class="siteorigin-page-builder-widget" data-mode="dialog">
				<p>
					<button class="button-secondary siteorigin-panels-display-builder" ><?php _e('Open Builder', 'siteorigin-panels') ?></button>
				</p>
				<input
					type="hidden"
					class="siteorigin-widget-input panels-data"
					value="<?php echo esc_attr( $value ) ?>"
					name="<?php echo esc_attr( $this->element_name ) ?>"
					id="<?php echo esc_attr( $this->element_id ) ?>"
					/>

				<script type="text/javascript">
					( function( panelsData ){
						// Create the panels_data input
						document.getElementById('<?php echo $this->element_id ?>').value = JSON.stringify( panelsData );
					} )( <?php echo $value ?> );
				</script>
			</div>
			<?php
		}
		else {
			// Let the user know that they need Page Builder installed
			?><p><?php _e( 'This field requires SiteOrigin Page Builder.', 'so-widgets-bundle' ) ?></p><?php
		}
	}

	/**
	 * Process the panels_data
	 *
	 * @param mixed $value
	 * @param array $instance
	 *
	 * @return array|mixed|object
	 */
	protected function sanitize_field_input( $value, $instance ){
		$panels_data = json_decode( $value, true );
		if( function_exists('siteorigin_panels_process_raw_widgets') && !empty( $panels_data['widgets'] ) && is_array( $panels_data['widgets'] ) ) {
			$panels_data['widgets'] = siteorigin_panels_process_raw_widgets( $panels_data['widgets'] );
		}

		return $panels_data;
	}

}