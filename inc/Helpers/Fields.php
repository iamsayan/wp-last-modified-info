<?php
/**
 * Fields functions.
 *
 * @since      1.8.0
 * @package    Wplmi
 * @subpackage Wplmi\Helpers
 * @author     Sayan Datta <iamsayan@protonmail.com>
 */

namespace Wplmi\Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * Ajax class.
 */
trait Fields {

	private $option_name = 'lmt_plugin_global_settings';

	/**
	 * Send AJAX response.
	 *
	 * @param array $data    Data to send using ajax.
	 * @param boolean $success Optional. If this is an error. Defaults: true.
	 */
	protected function do_field( array $data ) {
		if ( empty( $data['type'] ) ) {
			$data['type'] = 'text';
		}

		$class = [ 'wplmi-form-control', 'wplmi-form-el' ];
		if ( ! empty( $data['class'] ) ) {
			if ( is_array( $data['class'] ) ) {
				$class = array_merge( $class, $data['class'] );
			} else {
				$class[] = $data['class'];
			}
		}

		$name = $data['id'];
		if ( isset( $data['name'] ) ) {
			$name = $data['name'];
		}

		$attr = [];
		if ( isset( $data['required'] ) && true === $data['required'] ) {
			$attr[] = 'required';
			$attr[] = 'data-required="yes"';
		} else {
			$attr[] = 'data-required="no"';
		}

		if ( isset( $data['checked'] ) && true === $data['checked'] ) {
			$attr[] = 'checked';
		}

		if ( isset( $data['disabled'] ) && true === $data['disabled'] ) {
			$attr[] = 'disabled';
		}

		if ( isset( $data['readonly'] ) && true === $data['readonly'] ) {
			$attr[] = 'readonly';
		}

		if ( ! empty( $data['attributes'] ) && is_array( $data['attributes'] ) ) {
			foreach ( $data['attributes'] as $key => $value ) {
				$attr[] = $key . '="' . $value . '"';
			}
		}

		if ( ! empty( $data['condition'] ) && is_array( $data['condition'] ) ) {
			$cattr = 'data-condition="' . htmlspecialchars( wp_json_encode( $data['condition'] ), ENT_QUOTES, 'UTF-8' ) . '"';
			$attr[] = $cattr;
		}

		if ( ! empty( $data['show_if'] ) ) {
			$cattr = 'data-show-if="' . $data['show_if'] . '"';
			$attr[] = $cattr;
		}

		$value = $data['value'] ?? '';

		if ( $data['type'] == 'hidden' ) {
			echo '<input type="hidden" name="' . esc_attr( $this->option_name ) . '[' . esc_attr( $name ) . ']" id="' . esc_attr( $data['id'] ) . '" autocomplete="off" value="' . esc_attr( $value ) . '" />';
			return;
		}

		$tooltip = '';
		if ( ! empty( $data['description'] ) ) {
			if ( isset( $data['tooltip'] ) && $data['tooltip'] ) {
				$tooltip = '<span class="tooltip" title="' . esc_attr( $data['description'] ) . '"><span title="" class="dashicons dashicons-editor-help"></span></span>';
			} else {
				$tooltip = '<div class="description">' . wp_kses_post( $data['description'] ) . '</div>';
			}
		}

		if ( $data['type'] === 'checkbox' ) {
			$value = ! empty( $value ) ? $value : '1';
			echo '<label class="switch">';
				echo '<input type="checkbox" name="' . esc_attr( $this->option_name ) . '[' . esc_attr( $name ) . ']" id="' . esc_attr( $data['id'] ) . '" class="wplmi-form-el" value="' . esc_attr( $value ) . '" ' . wp_kses_post( implode( ' ', array_unique( $attr ) ) ) . ' />
				<span class="slider">
					<svg width="3" height="8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2 6" class="toggle-on" role="img" aria-hidden="true" focusable="false"><path d="M0 0h2v6H0z"></path></svg>
					<svg width="8" height="8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 6 6" class="toggle-off" role="img" aria-hidden="true" focusable="false"><path d="M3 1.5c.8 0 1.5.7 1.5 1.5S3.8 4.5 3 4.5 1.5 3.8 1.5 3 2.2 1.5 3 1.5M3 0C1.3 0 0 1.3 0 3s1.3 3 3 3 3-1.3 3-3-1.3-3-3-3z"></path></svg>
				</span>';
			echo '</label>' . wp_kses_post( $tooltip );
			return;
		}

		if ( isset( $data['type'] ) ) {
			if ( in_array( $data['type'], [ 'text', 'email', 'password', 'date', 'number' ], true ) ) {
				echo '<input type="' . esc_attr( $data['type'] ) . '" name="' . esc_attr( $this->option_name ) . '[' . esc_attr( $name ) . ']" id="' . esc_attr( $data['id'] ) . '" class="' . esc_attr( implode( ' ', array_unique( $class ) ) ) . '" autocomplete="off" value="' . esc_attr( $value ) . '" ' . wp_kses_post( implode( ' ', array_unique( $attr ) ) ) . ' />';
			} elseif ( $data['type'] === 'textarea' ) {
				echo '<textarea class="' . esc_attr( implode( ' ', array_unique( $class ) ) ) . '" id="' . esc_attr( $data['id'] ) . '" name="' . esc_attr( $this->option_name ) . '[' . esc_attr( $name ) . ']" ' . wp_kses_post( implode( ' ', array_unique( $attr ) ) ) . ' autocomplete="off">' . wp_kses_post( $value ) . '</textarea>';
			} elseif ( $data['type'] === 'select' ) {
				if ( isset( $data['options'] ) && is_array( $data['options'] ) ) {
					echo '<select id="' . esc_attr( $data['id'] ) . '" class="' . esc_attr( implode( ' ', array_unique( $class ) ) ) . '" name="' . esc_attr( $this->option_name ) . '[' . esc_attr( $name ) . ']" ' . wp_kses_post( implode( ' ', array_unique( $attr ) ) ) . ' autocomplete="off">';
					if ( ! empty( $data['options'] ) ) {
						foreach ( $data['options'] as $key => $option ) {
							$disabled = '';
							if ( isset( $data['filter'] ) && $data['filter'] ) {
								$disabled = ( strpos( $key, 'premium' ) !== false ) ? ' disabled' : '';
							}
							echo '<option value="' . esc_attr( $key ) . '" ' . selected( $key, $value, false ) . esc_attr( $disabled ) . '>' . esc_html( $option ) . '</option>';
						}
					}
					echo '</select>';
				}
			} elseif ( $data['type'] === 'multiple' ) {
				if ( isset( $data['options'] ) && is_array( $data['options'] ) ) {
					echo '<select id="' . esc_attr( $data['id'] ) . '" class="' . esc_attr( implode( ' ', array_unique( $class ) ) ) . '" name="' . esc_attr( $this->option_name ) . '[' . esc_attr( $name ) . '][]" multiple="multiple" ' . wp_kses_post( implode( ' ', array_unique( $attr ) ) ) . ' style="width: 90%">';
					if ( ! empty( $data['options'] ) ) {
						foreach ( $data['options'] as $key => $option ) {
							echo '<option value="' . esc_attr( $key ) . '" ' . selected( in_array( $key, $value ), true, false ) . '>' . esc_html( $option ) . '</option>';
						}
					}
					echo '</select>';
				}
			} elseif ( $data['type'] === 'multiple_tax' ) {
				if ( isset( $data['options'] ) && is_array( $data['options'] ) ) {
					echo '<select id="' . esc_attr( $data['id'] ) . '" class="' . esc_attr( implode( ' ', array_unique( $class ) ) ) . '" name="' . esc_attr( $this->option_name ) . '[' . esc_attr( $name ) . '][]" multiple="multiple" ' . wp_kses_post( implode( ' ', array_unique( $attr ) ) ) . ' style="width: 90%">';
					if ( ! empty( $data['options'] ) ) {
						foreach ( $data['options'] as $key => $option ) {
							echo '<optgroup label="' . esc_attr( $option['label'] ) . '">';
							if ( isset( $option['categories'] ) && ! empty( $option['categories'] ) && is_array( $option['categories'] ) ) {
								foreach ( $option['categories'] as $cat_slug => $cat_name ) {
									echo '<option value="' . esc_attr( $cat_slug ) . '" ' . selected( in_array( $cat_slug, $value ), true, false ) . '>' . esc_html( $cat_name ) . '</option>';
								}
							}
							echo '</optgroup>';
						}
					}
					echo '</select>';
				}
			} elseif ( $data['type'] === 'wp_editor' ) {
				echo '<div class="wplmi-form-control wplmi-form-el wplmi-editor" ' . wp_kses_post( implode( ' ', array_unique( $attr ) ) )  . '>';
				wp_editor( html_entity_decode( $value, ENT_COMPAT, "UTF-8" ), $data['id'], [
					'textarea_name' => esc_attr( $this->option_name ) . '[' . esc_attr( $name ) . ']',
					'textarea_rows' => '8',
					'teeny'         => true,
					'tinymce'       => false,
					'media_buttons' => false,
				] );
				echo '</div>';
			}
			echo wp_kses_post( $tooltip );
			return;
		}
	}
}
