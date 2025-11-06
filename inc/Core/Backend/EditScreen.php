<?php
/**
 * Post edit screen.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core\Backend
 * @author     Sayan Datta <iamsayan@protonmail.com>
 */

namespace Wplmi\Core\Backend;

use Wplmi\Helpers\Ajax;
use Wplmi\Helpers\Hooker;
use Wplmi\Helpers\SettingsData;

defined( 'ABSPATH' ) || exit;

/**
 * Post Edit Screen class.
 */
class EditScreen
{
	use Ajax;
    use Hooker;
    use SettingsData;

	/**
	 * Register functions.
	 */
	public function register() {
		$this->action( 'post_submitbox_misc_actions', 'submitbox_edit', 5 );
		$this->action( 'quick_edit_custom_box', 'quick_edit', 10, 2 );
		$this->action( 'bulk_edit_custom_box', 'bulk_edit', 10, 2 );
		$this->ajax( 'process_bulk_edit', 'bulk_save' );
		$this->filter( 'wp_insert_post_data', 'update_data', 9999, 2 );
	}

	/**
	 * Post Submit Box HTML output.
	 *
	 * @param WP_Post $post WP Post
	 */
	public function submitbox_edit( $post ) {
		global $wp_locale;

		if ( in_array( $post->post_status, [ 'auto-draft', 'future' ] ) ) {
			return;
		}

		$datemodified = $post->post_modified;

		$jj = mysql2date( 'd', $datemodified, false );
		$mm = mysql2date( 'm', $datemodified, false );
		$aa = mysql2date( 'Y', $datemodified, false );
		$hh = mysql2date( 'H', $datemodified, false );
		$mn = mysql2date( 'i', $datemodified, false );
		$ss = mysql2date( 's', $datemodified, false );

		$stop_update = $this->get_meta( $post->ID, '_lmt_disableupdate' );
		$post_types = get_post_type_object( $post->post_type );

		// get modified time with a particular format
		$orig_time = get_post_time( 'U', false, $post );
		$mod_time = get_post_modified_time( 'U', false, $post ); ?>

		<div class="misc-pub-section curtime misc-pub-last-updated">
			<span id="wplmi-timestamp"> <?php esc_html_e( 'Updated on:', 'wp-last-modified-info' ) ?> <strong><?= esc_html( get_the_modified_time( 'M j, Y \a\t H:i' ) ); ?></strong></span>
			<a href="#edit_timestampmodified" class="edit-timestampmodified hide-if-no-js" role="button"><span aria-hidden="true"><?php esc_html_e( 'Edit', 'wp-last-modified-info' ); ?></span> <span class="screen-reader-text"><?php esc_html_e( 'Edit modified date and time', 'wp-last-modified-info' ); ?></span></a>
			<fieldset id="timestampmodifieddiv" class="hide-if-js" data-prefix="<?php esc_attr_e( 'Updated on:', 'wp-last-modified-info' ); ?>" data-separator="<?php esc_attr_e( 'at', 'wp-last-modified-info' ); ?>" style="padding-top: 5px;line-height: 1.76923076;">
				<legend class="screen-reader-text"><?php esc_html_e( 'Last modified date and time', 'wp-last-modified-info' ); ?></legend>
				<div class="timestamp-wrap">
					<label>
						<span class="screen-reader-text"><?php esc_html_e( 'Month', 'wp-last-modified-info' ); ?></span>
						<select id="mmm" name="mmm" class="time-modified">
							<?php
							for ( $i = 1; $i < 13; $i++ ) {
								$monthnum = zeroise( $i, 2 );
								$monthtext = $wp_locale->get_month_abbrev( $wp_locale->get_month( $i ) );
								echo '<option value="' . esc_attr( $monthnum ) . '" data-text="' . esc_attr( $monthtext ) . '" ' . selected( $monthnum, $mm, false ).'>' . sprintf( '%1$s-%2$s', esc_html( $monthnum ), esc_html( $monthtext ) ) . '</option>';
							}
							?>
						</select>
					</label>
					<label>
						<span class="screen-reader-text"><?php esc_html_e( 'Day', 'wp-last-modified-info' ); ?></span>
						<input type="text" id="jjm" class="time-modified jjm-edit" name="jjm" value="<?= esc_attr( $jj ); ?>" size="2" maxlength="2" autocomplete="off" />
					</label>, <label>
						<span class="screen-reader-text"><?php esc_html_e( 'Year', 'wp-last-modified-info' ); ?></span>
						<input type="text" id="aam" class="time-modified aam-edit" name="aam" value="<?= esc_attr( $aa ); ?>" size="4" maxlength="4" autocomplete="off" />
					</label> <?php esc_html_e( 'at', 'wp-last-modified-info' ); ?><label>
						<span class="screen-reader-text"><?php esc_html_e( 'Hour', 'wp-last-modified-info'); ?></span>
						<input type="text" id="hhm" class="time-modified hhm-edit" name="hhm" value="<?= esc_attr( $hh ); ?>" size="2" maxlength="2" autocomplete="off"/>
					</label><?php esc_html_e(':', 'wp-last-modified-info'); ?><label>
						<span class="screen-reader-text"><?php esc_html_e( 'Minute', 'wp-last-modified-info' ); ?></span>
						<input type="text" id="mnm" class="time-modified mnm-edit" name="mnm" value="<?= esc_attr( $mn ); ?>" size="2" maxlength="2" autocomplete="off" />
					</label>
				</div>
				<label for="wplmi_disable" class="wplmi-disable-update" style="display:block;margin: 5px 0;" title="<?php esc_attr_e( 'Keep this checked, if you do not want to change modified date and time on this post.', 'wp-last-modified-info' ); ?>">
					<input type="checkbox" id="wplmi_disable" name="disableupdate" <?php if ( $stop_update == 'yes' ) { echo 'checked'; } ?>><span><?php esc_html_e( 'Lock Modified Date', 'wp-last-modified-info' ); ?></span>
				</label>
				<?php

				$currentlocal = current_time( 'timestamp', 0 );
				$mm_current = gmdate( 'm', $currentlocal );
				$jj_current = gmdate( 'd', $currentlocal );
				$aa_current = gmdate( 'Y', $currentlocal );
				$hh_current = gmdate( 'H', $currentlocal );
				$mn_current = gmdate( 'i', $currentlocal );

				$vals = [
					'mmm' => [ $mm, $mm_current ],
					'jjm' => [ $jj, $jj_current ],
					'aam' => [ $aa, $aa_current ],
					'hhm' => [ $hh, $hh_current ],
					'mnm' => [ $mn, $mn_current ],
				];

				foreach ( $vals as $key => $val ) {
					echo '<input type="hidden" id="hidden_' . esc_attr( $key ). '" name="hidden_' . esc_attr( $key ) . '" value="' . esc_attr( $val[0] ). '">';
					echo '<input type="hidden" id="cur_' . esc_attr( $key ) . '" name="cur_' . esc_attr( $key ) . '" value="' . esc_attr( $val[1] ) . '">';
				} ?>

				<input type="hidden" id="ssm" name="ssm" value="<?= esc_attr( $ss ); ?>">
				<input type="hidden" id="wplmi-change-modified" name="wplmi_change" value="no">
				<input type="hidden" id="wplmi-disable-hidden" name="wplmi_disable" value="<?= ( $stop_update ) ? esc_attr( $stop_update ) : 'no'; ?>">
				<input type="hidden" id="wplmi-post-modified" name="wplmi_modified" value="<?= esc_attr( $datemodified ); ?>">

				<p id="wplmi-meta" class="wplmi-meta-options">
					<a href="#edit_timestampmodified" class="save-timestamp hide-if-no-js button"><?php esc_html_e( 'OK', 'wp-last-modified-info' ); ?></a>
					<a href="#edit_timestampmodified" class="cancel-timestamp hide-if-no-js button-cancel"><?php esc_html_e( 'Cancel', 'wp-last-modified-info' ); ?></a>&nbsp;&nbsp;&nbsp;
				</p>
			</fieldset>
		</div><?php
	}

	/**
	 * Quick edit HTML output.
	 *
	 * @param string  $column_name  Current column name
	 * @param string  $post_type    Post type
	 */
	public function quick_edit( $column_name, $post_type ) {
		global $wp_locale;

		if ( 'lastmodified' !== $column_name ) {
			return;
		} ?>

		<fieldset id="inline-edit-col-modified-date" class="inline-edit-date">
			<legend><span class="title"><?php esc_html_e( 'Modified', 'wp-last-modified-info' ); ?></span></legend>
				<div class="timestamp-wrap">
					<label class="inline-edit-group">
						<span class="screen-reader-text"><?php esc_html_e( 'Month', 'wp-last-modified-info' ); ?></span>
						<select id="mmm" class="time-modified" name="mmm">
							<?php
							for ( $i = 1; $i < 13; $i++ ) {
								$monthnum = zeroise( $i, 2 );
								$monthtext = $wp_locale->get_month_abbrev( $wp_locale->get_month( $i ) );
								echo '<option value="' . esc_attr( $monthnum ) . '" data-text="' . esc_attr( $monthtext ) . '">' . sprintf( '%1$s-%2$s', esc_html( $monthnum ), esc_html( $monthtext ) ) . '</option>';
							}
							?>
						</select>
					</label>
					<label class="inline-edit-group">
						<span class="screen-reader-text"><?php esc_html_e( 'Day', 'wp-last-modified-info' ); ?></span>
						<input type="text" id="jjm" class="time-modified tm-jjm" name="jjm" value="" size="2" maxlength="2" autocomplete="off" />
					</label>, <label>
						<span class="screen-reader-text"><?php esc_html_e( 'Year', 'wp-last-modified-info' ); ?></span>
						<input type="text" id="aam" class="time-modified tm-aam" name="aam" value="" size="4" maxlength="4" autocomplete="off" />
					</label> <?php esc_html_e( 'at', 'wp-last-modified-info' ); ?> <label>
						<span class="screen-reader-text"><?php esc_html_e( 'Hour', 'wp-last-modified-info' ); ?></span>
						<input type="text" id="hhm" class="time-modified tm-hhm" name="hhm" value="" size="2" maxlength="2" autocomplete="off" />
					</label>:<label>
						<span class="screen-reader-text"><?php esc_html_e( 'Minute', 'wp-last-modified-info' ); ?></span>
						<input type="text" id="mnm" class="time-modified tm-mnm" name="mnm" value="" size="2" maxlength="2" autocomplete="off" />
					</label>&nbsp;&nbsp;<label for="wplmi_disable">
						<input type="checkbox" id="wplmi_disable" name="disableupdate" />
						<span class="checkbox-title"><?php esc_html_e( 'Lock Modified Date', 'wp-last-modified-info' ); ?></span>
					</label>
				</div>
				<input type="hidden" id="ssm" name="ssm" value="">
				<input type="hidden" id="wplmi-change-modified" name="wplmi_change" value="no">
				<input type="hidden" id="wplmi-disable-hidden" name="wplmi_disable" value="">
				<input type="hidden" id="wplmi-post-modified" name="wplmi_modified" value="">
			</fieldset>
		<?php
	}

	/**
	 * Quick ecit HTML output.
	 *
	 * @param string  $column_name  Current column name
	 * @param string  $post_type    Post type
	 */
	public function bulk_edit( $column_name, $post_type ) {
		global $wp_locale;

		if ( 'lastmodified' !== $column_name ) {
			return;
		} ?>

        <div class="inline-edit-col wplmi-bulkedit">
		    <fieldset class="inline-edit-date">
		    	<legend><span class="title"><?php esc_html_e( 'Modified', 'wp-last-modified-info' ); ?></span></legend>
		    	<div class="timestamp-wrap">
		    		<label class="inline-edit-group">
		    			<span class="screen-reader-text"><?php esc_html_e( 'Month', 'wp-last-modified-info' ); ?></span>
		    			<select id="mmm" class="time-modified" name="mmm">
		    			<option value="none">— <?php esc_html_e( 'No Change', 'wp-last-modified-info' ); ?> —</option>
		    				<?php
		    				for ( $i = 1; $i < 13; $i++ ) {
		    					$monthnum = zeroise( $i, 2 );
		    					$monthtext = $wp_locale->get_month_abbrev( $wp_locale->get_month( $i ) );
		    					echo '<option value="' . esc_attr( $monthnum ) . '" data-text="' . esc_attr( $monthtext ) . '">' . sprintf( '%1$s-%2$s', esc_html( $monthnum ), esc_html( $monthtext ) ) . '</option>';
		    				}
		    				?>
		    			</select>
		    		</label>
		    		<label class="inline-edit-group">
		    			<span class="screen-reader-text"><?php esc_html_e( 'Day', 'wp-last-modified-info' ); ?></span>
		    			<input type="text" id="jjm" class="time-modified tm-jjm" name="jjm" value="" size="2" maxlength="2" placeholder="<?php esc_attr_e( 'Day', 'wp-last-modified-info' ); ?>" autocomplete="off" />
		    		</label>, <label>
		    			<span class="screen-reader-text"><?php esc_html_e( 'Year', 'wp-last-modified-info' ); ?></span>
		    			<input type="text" id="aam" class="time-modified tm-aam" name="aam" value="" size="4" maxlength="4" placeholder="<?php esc_attr_e( 'Year', 'wp-last-modified-info' ); ?>" autocomplete="off" />
		    		</label> <?php esc_html_e( 'at', 'wp-last-modified-info' ); ?> <label>
		    			<span class="screen-reader-text"><?php esc_html_e( 'Hour', 'wp-last-modified-info' ); ?></span>
		    			<input type="text" id="hhm" class="time-modified tm-hhm" name="hhm" value="" size="2" maxlength="2" placeholder="<?php esc_attr_e( 'Hour', 'wp-last-modified-info' ); ?>" autocomplete="off" />
		    		</label>:<label>
		    			<span class="screen-reader-text"><?php esc_html_e( 'Minute', 'wp-last-modified-info' ); ?></span>
		    			<input type="text" id="mnm" class="time-modified tm-mnm" name="mnm" value="" size="2" maxlength="2" placeholder="<?php esc_attr_e( 'Min', 'wp-last-modified-info' ); ?>" autocomplete="off" />
		    		</label>&nbsp;&nbsp;<label for="wplmi_disable">
						<span class="select-title"><?php esc_html_e( 'Update Status', 'wp-last-modified-info' ); ?></span>
						<select id="wplmi-disable-update" class="disable-update" name="disable_update">
		    			    <option value="none">— <?php esc_html_e( 'No Change', 'wp-last-modified-info' ); ?> —</option>
						    <option value="yes"><?php esc_html_e( 'Lock Modified Date', 'wp-last-modified-info' ); ?></option>
							<option value="no"><?php esc_html_e( 'Un-Lock Modified Date', 'wp-last-modified-info' ); ?></option>
						</select>
		    		</label>
		    	</div>
		    </fieldset>
	    </div>
		<?php
	}

	/**
     * Process bulk post meta data update
     */
	public function bulk_save() {
		// security check
		$this->verify_nonce( 'wplmi_edit_nonce' );

		// phpcs:ignore WordPress.Security.NonceVerification.Missing
		$post_ids = ! empty( $_POST['post_ids'] ) ? wp_parse_id_list( array_map( 'intval', (array) wp_unslash( $_POST['post_ids'] ) ) ) : []; // sanitize & cast IDs

		if ( $post_ids ) { // only proceed if we have posts to bulk-edit
			// phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotValidated
			$mm  = $this->clamp( sanitize_text_field( wp_unslash( $_POST['modified_month'] ?? '' ) ), 1, 12, 1 ); // month 1-12
			// phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotValidated
			$jj  = $this->clamp( sanitize_text_field( wp_unslash( $_POST['modified_day']   ?? '' ) ), 1, 31, 1 ); // day 1-31
			// phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotValidated
			$aa  = $this->clamp( sanitize_text_field( wp_unslash( $_POST['modified_year']  ?? '' ) ), 0, 9999, 1970 ); // year 0-9999
			// phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotValidated
			$hh  = $this->clamp( sanitize_text_field( wp_unslash( $_POST['modified_hour']  ?? '' ) ), 0, 23, 12 ); // hour 0-23
			// phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotValidated
			$mn  = $this->clamp( sanitize_text_field( wp_unslash( $_POST['modified_minute'] ?? '' ) ), 0, 59, 0 ); // minute 0-59
			$ss  = '00'; // seconds hard-coded for bulk

			$newdate   = sprintf( '%04d-%02d-%02d %02d:%02d:%02d', $aa, $mm, $jj, $hh, $mn, $ss ); // build MySQL datetime
			// phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotValidated
			$disable   = sanitize_text_field( wp_unslash( $_POST['modified_disable'] ?? 'none' ) ); // lock status

			// flags to decide which meta to update
			// phpcs:ignore WordPress.Security.NonceVerification.Missing
			$update_date   = 'none' !== ( sanitize_text_field( wp_unslash( $_POST['modified_month'] ?? 'none' ) ) ); // month selector != “No Change”
			$update_status = 'none' !== $disable; // disable selector != “No Change”

			foreach ( $post_ids as $post_id ) {
				if ( in_array( get_post_status( $post_id ), [ 'auto-draft', 'future' ], true ) ) {
					continue; // skip drafts & scheduled posts
				}

				if ( $update_date ) { // save new modified datetime
					$this->update_meta( $post_id, '_wplmi_last_modified', $newdate );
					$this->update_meta( $post_id, 'wplmi_bulk_update_datetime', $newdate ); // flag for update_data()
				}

				if ( $update_status ) { // save lock/unlock preference
					$this->update_meta( $post_id, '_lmt_disableupdate', $disable );
				}
			}
		}

		$this->success();
	}

	/**
	 * Save post modified info to db.
	 *
	 * @param array   $data     Old Data
	 * @param array   $postarr  Current Data
	 *
	 * @return array  $data
	 */
	public function update_data( $data, $postarr ) {
		// Early bail-outs
		if ( empty( $postarr['ID'] ) || in_array( $postarr['post_status'], [ 'auto-draft', 'future' ], true ) ) {
			return $data;
		}

		$post_id = (int) $postarr['ID'];

		// Force-update last editor
		if ( $this->do_filter( 'force_update_author_id', false ) ) {
			$this->update_meta( $post_id, '_edit_last', get_current_user_id() );
		}

		// 1. Bulk-edit always wins (one-shot flag)
		$bulk_datetime = $this->get_meta( $post_id, 'wplmi_bulk_update_datetime' );
		if ( ! empty( $bulk_datetime ) ) {
			$data['post_modified']     = $bulk_datetime;
			$data['post_modified_gmt'] = get_gmt_from_date( $bulk_datetime );
			$this->delete_meta( $post_id, 'wplmi_bulk_update_datetime' );
			$this->update_meta( $post_id, '_wplmi_last_modified', $data['post_modified'] );
			return $data;
		}

		// 2. Determine disabled state (block editor can override)
		$disabled = $this->get_meta( $post_id, '_lmt_disableupdate' );
		if ( isset( $postarr['wplmi_lockmodifiedupdate'] ) ) {
			$disabled = $postarr['wplmi_lockmodifiedupdate'] === 'yes' ? 'yes' : 'no';
		}

		// 3. Classic-editor flow
		if ( isset( $postarr['wplmi_modified'], $postarr['wplmi_change'], $postarr['wplmi_disable'] ) ) {
			$disabled = sanitize_text_field( $postarr['wplmi_disable'] ) ?: $disabled;
			$this->update_meta( $post_id, '_lmt_disableupdate', $disabled );

			if ( $disabled === 'yes' ) {
				$data['post_modified']     = $postarr['post_modified'];
				$data['post_modified_gmt'] = $postarr['post_modified_gmt'];
			} else {
				// Use custom datetime if change flag is set
				if ( ( $postarr['wplmi_change'] ?? 'no' ) === 'yes' ) {
					$newdate = $this->build_datetime( $postarr );
					if ( $newdate && strtotime( $newdate ) >= get_post_time( 'U', false, $post_id ) ) {
						$data['post_modified']     = $newdate;
						$data['post_modified_gmt'] = get_gmt_from_date( $newdate );
					} else {
						$data['post_modified']     = current_time( 'mysql' );
						$data['post_modified_gmt'] = current_time( 'mysql', 1 );
					}
				} else {
					$data['post_modified']     = current_time( 'mysql' );
					$data['post_modified_gmt'] = current_time( 'mysql', 1 );
				}
			}
		} else {
			// 4. Block-editor / REST flow
			if ( $disabled === 'yes' ) {
				$data['post_modified']     = $postarr['post_modified'];
				$data['post_modified_gmt'] = $postarr['post_modified_gmt'];
			} else {
				// REST supplied date?
				if ( ! empty( $postarr['wplmi_modified_rest'] ) ) {
					$modified_timestamp = strtotime( $postarr['wplmi_modified_rest'] );
					$published_timestamp = get_post_time( 'U', false, $post_id );
					if ( $modified_timestamp >= $published_timestamp ) {
						$modified_date = gmdate( 'Y-m-d H:i:s', $modified_timestamp );
						$data['post_modified']     = $modified_date;
						$data['post_modified_gmt'] = get_gmt_from_date( $modified_date );
						$this->update_meta( $post_id, 'wplmi_temp_date', $modified_date );
					} else {
						$data['post_modified']     = current_time( 'mysql' );
						$data['post_modified_gmt'] = current_time( 'mysql', 1 );
					}
				} elseif ( ( $temp_date = $this->get_meta( $post_id, 'wplmi_temp_date' ) ) !== '' ) {
					// Use leftover temp date from previous REST save
					$data['post_modified']     = $temp_date;
					$data['post_modified_gmt'] = get_gmt_from_date( $temp_date );
					$this->delete_meta( $post_id, 'wplmi_temp_date' );
				} else {
					// Default to now
					$data['post_modified']     = current_time( 'mysql' );
					$data['post_modified_gmt'] = current_time( 'mysql', 1 );
				}
			}
		}

		// Persist final modified value
		$this->update_meta( $post_id, '_wplmi_last_modified', $data['post_modified'] );

		// WooCommerce compatibility: mirror the date to WC lookup tables
		if ( function_exists( 'wc_get_order' ) && 'shop_order' === get_post_type( $post_id ) ) {
			// Update the post_modified column in wc_orders (HPOS) if present
			if ( class_exists( '\Automattic\WooCommerce\Internal\DataStores\Orders\OrdersTableDataStore' ) ) {
				global $wpdb;
				$wpdb->update(
					$wpdb->prefix . 'wc_orders',
					[ 'date_updated_gmt' => $data['post_modified_gmt'] ],
					[ 'id' => $post_id ],
					[ '%s' ],
					[ '%d' ]
				);
			}
			// Legacy post meta used by some WC extensions
			update_post_meta( $post_id, '_date_updated', $data['post_modified'] );
		}

		return $data;
	}

	/**
	 * Build Y-m-d H:i:s from classic-editor inputs; returns empty string on failure.
	 *
	 * @param array $postarr
	 * @return string
	 */
	private function build_datetime( array $postarr ): string {
		$mm = $this->clamp( sanitize_text_field( $postarr['mmm'] ?? '' ), 1, 12, 1 );
		$jj = $this->clamp( sanitize_text_field( $postarr['jjm'] ?? '' ), 1, 31, 1 );
		$aa = $this->clamp( sanitize_text_field( $postarr['aam'] ?? '' ), 0, 9999, 1970 );
		$hh = $this->clamp( sanitize_text_field( $postarr['hhm'] ?? '' ), 0, 23, 12 );
		$mn = $this->clamp( sanitize_text_field( $postarr['mnm'] ?? '' ), 0, 59, 0 );
		$ss = $this->clamp( sanitize_text_field( $postarr['ssm'] ?? '' ), 0, 59, 0 );

		return sprintf( '%04d-%02d-%02d %02d:%02d:%02d', $aa, $mm, $jj, $hh, $mn, $ss );
	}

	/**
	 * Clamp a numeric input between min/max with fallback.
	 *
	 * @param mixed $value
	 * @param int   $min
	 * @param int   $max
	 * @param int   $fallback
	 * @return int
	 */
	private function clamp( $value, int $min, int $max, int $fallback ): int {
		return is_numeric( $value ) ? max( $min, min( $max, (int) $value ) ) : $fallback;
	}
}
