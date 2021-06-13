<?php
/**
 * Post edit screen.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core\Backend
 * @author     Sayan Datta <hello@sayandatta.in>
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
	use Ajax, Hooker, SettingsData;

	/**
	 * Register functions.
	 */
	public function register()
	{
		$this->action( 'post_submitbox_misc_actions', 'submitbox_edit', 5 );
		$this->action( 'add_meta_boxes', 'meta_box', 10, 2 );
		$this->action( 'quick_edit_custom_box', 'quick_edit', 10, 2 );
		$this->action( 'bulk_edit_custom_box', 'bulk_edit', 10, 2 );
		$this->action( 'wp_insert_post', 'save_metadata', 99 );
		$this->action( 'woocommerce_update_product', 'woo_save_metadata', 1 );
		$this->ajax( 'process_bulk_edit', 'bulk_save' );
		$this->filter( 'wp_insert_post_data', 'update_data', 99, 2 );
	}
	
	/**
	 * Add Meta box.
	 * 
	 * @param string $post_type Post Type
	 * @param object $post      WP Post
	 */
	public function meta_box( $post_type, $post )
	{
		// If user can't publish posts, then get out
		if ( ! current_user_can( 'publish_posts' ) ) {
		    return;
		}

		if ( in_array( $post->post_status, [ 'auto-draft', 'future' ] ) ) {
			return;
		}
		
		$current_screen = get_current_screen();
		if ( method_exists( $current_screen, 'is_block_editor' ) && $current_screen->is_block_editor() ) {
			add_meta_box( 'wplmi_gutenburg', __( 'Last Updated', 'wp-last-modified-info' ), [ $this, 'metabox' ], [ 'post', 'page' ], 'side', 'high', [ '__back_compat_meta_box' => false ] );
		}
	}

	/**
	 * Post Submit Box HTML output.
	 * 
	 * @param string $post WP Post
	 */
	public function submitbox_edit( $post )
	{
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
		$post_types = get_post_type_object( get_post_type( $post ) );
			
		// get modified time with a particular format
		$orig_time = get_the_time( 'U' );
		$mod_time = get_the_modified_time( 'U' ); ?>
		
		<div class="misc-pub-section curtime misc-pub-last-updated">
			<span id="wplmi-timestamp"> <?php _e( 'Updated on:', 'wp-last-modified-info' ) ?> <strong><?php echo get_the_modified_time( 'M j, Y \a\t H:i' ); ?></strong></span>
			<a href="#edit_timestampmodified" class="edit-timestampmodified hide-if-no-js" role="button"><span aria-hidden="true"><?php _e( 'Edit', 'wp-last-modified-info' ); ?></span> <span class="screen-reader-text"><?php _e( 'Edit modified date and time', 'wp-last-modified-info' ); ?></span></a>
			<fieldset id="timestampmodifieddiv" class="hide-if-js" data-prefix="<?php _e( 'Updated on:', 'wp-last-modified-info' ); ?>" data-separator="<?php _e( 'at', 'wp-last-modified-info' ); ?>" style="padding-top: 5px;line-height: 1.76923076;">
				<legend class="screen-reader-text"><?php _e( 'Last modified date and time', 'wp-last-modified-info' ); ?></legend>
				<div class="timestamp-wrap">
					<label>
						<span class="screen-reader-text"><?php _e( 'Month', 'wp-last-modified-info' ); ?></span>
						<select id="mmm" name="mmm" class="time-modified">
							<?php
							for ( $i = 1; $i < 13; $i++ ) {
								$monthnum = zeroise( $i, 2 );
								$monthtext = $wp_locale->get_month_abbrev( $wp_locale->get_month( $i ) );
								echo '<option value="' . $monthnum . '" data-text="' . $monthtext . '" ' . selected( $monthnum, $mm, false ).'>' . sprintf( __( '%1$s-%2$s' ), $monthnum, $monthtext ) . '</option>';
							}
							?>
						</select>
					</label>
					<label>
						<span class="screen-reader-text"><?php _e( 'Day', 'wp-last-modified-info' ); ?></span>
						<input type="text" id="jjm" class="time-modified jjm-edit" name="jjm" value="<?php echo $jj; ?>" size="2" maxlength="2" autocomplete="off" />
					</label>, <label>
						<span class="screen-reader-text"><?php _e( 'Year', 'wp-last-modified-info' ); ?></span>
						<input type="text" id="aam" class="time-modified aam-edit" name="aam" value="<?php echo $aa; ?>" size="4" maxlength="4" autocomplete="off" />
					</label> <?php _e( 'at', 'wp-last-modified-info' ); ?><label> 
						<span class="screen-reader-text"><?php _e( 'Hour', 'wp-last-modified-info'); ?></span>
						<input type="text" id="hhm" class="time-modified hhm-edit" name="hhm" value="<?php echo $hh; ?>" size="2" maxlength="2" autocomplete="off"/>
					</label><?php _e(':', 'wp-last-modified-info'); ?><label>
						<span class="screen-reader-text"><?php _e( 'Minute', 'wp-last-modified-info' ); ?></span>
						<input type="text" id="mnm" class="time-modified mnm-edit" name="mnm" value="<?php echo $mn; ?>" size="2" maxlength="2" autocomplete="off" />
					</label>
				</div>
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
					echo '<input type="hidden" id="hidden_' . $key . '" name="hidden_' . $key . '" value="' . $val[0] . '">';
					echo '<input type="hidden" id="cur_' . $key . '" name="cur_' . $key . '" value="' . $val[1] . '">';
				} ?>
	
				<input type="hidden" id="ssm" name="ssm" value="<?php echo $ss; ?>">
				<input type="hidden" id="wplmi-change-modified" name="wplmi_change" value="no">
				<input type="hidden" id="wplmi-disable-hidden" name="wplmi_disable" value="<?php echo ( $stop_update ) ? $stop_update : 'no'; ?>">
				<input type="hidden" id="wplmi-post-modified" name="wplmi_modified" value="<?php echo $post->post_modified; ?>">
	
				<p id="wplmi-meta" class="wplmi-meta-options">
					<a href="#edit_timestampmodified" class="save-timestamp hide-if-no-js button"><?php _e( 'OK', 'wp-last-modified-info '); ?></a>
					<a href="#edit_timestampmodified" class="cancel-timestamp hide-if-no-js button-cancel"><?php _e( 'Cancel', 'wp-last-modified-info' ); ?></a>&nbsp;&nbsp;&nbsp;
					<label for="wplmi_disable" class="wplmi-disable-update" title="Keep this checked, if you do not want to change modified date and time on this <?php echo $post_types->name ?>">
						<input type="checkbox" id="wplmi_disable" name="disableupdate" <?php if ( $stop_update == 'yes' ) { echo 'checked'; } ?>><?php _e( 'Disable Update', 'wp-last-modified-info' ); ?>
					</label>
				</p>
			</fieldset>
		</div><?php
	}

	/**
	 * Meta box HTML output.
	 * 
	 * @param string $post WP Post
	 */
	public function metabox( $post )
	{
		global $wp_locale;
	
		$datemodified = $post->post_modified;
		
		$jj = mysql2date( 'd', $datemodified, false );
		$mm = mysql2date( 'm', $datemodified, false );
		$aa = mysql2date( 'Y', $datemodified, false );
		$hh = mysql2date( 'H', $datemodified, false );
		$mn = mysql2date( 'i', $datemodified, false );
		$ss = mysql2date( 's', $datemodified, false );
	
		$stop_update = $this->get_meta( $post->ID, '_lmt_disableupdate' );
		$post_types = get_post_type_object( get_post_type( $post ) );
			
		// get modified time with a particular format
		$orig_time = get_the_time( 'U' );
		$mod_time = get_the_modified_time( 'U' ); ?>
		
		<div class="misc-pub-section-gutenburg curtime misc-pub-last-updated" style="padding-top:5px;">
	        <span id="wplmi-timestamp-text"><?php _e( 'Updated on:', 'wp-last-modified-info' ) ?></span>
            <a href="#edit_timestampmodified" class="edit-timestampmodified hide-if-no-js" role="button">
		        <span aria-hidden="true">
		            <span class="dashicons dashicons-edit" style="font-size: 15px;padding-top: 2px;"></span>
		        </span>
		        <span class="screen-reader-text">
		            <?php _e( 'Edit modified date and time', 'wp-last-modified-info' ); ?>
		        </span>
	        </a>
	        <span id="wplmi-timestamp-be" style="float: right;"><strong><?php echo get_the_modified_time( 'M j, Y \a\t H:i' ); ?></strong></span>
			<fieldset id="timestampmodifieddiv" class="hide-if-js" data-separator="<?php _e( 'at', 'wp-last-modified-info' ); ?>" style="padding-top: 5px;line-height: 1.76923076;">
				<legend class="screen-reader-text"><?php _e( 'Last modified date and time', 'wp-last-modified-info' ); ?></legend>
				<div class="timestamp-wrap tsw-be">
					<label>
						<span class="screen-reader-text"><?php _e( 'Month', 'wp-last-modified-info' ); ?></span>
						<select id="mmm" name="mmm" class="time-modified be-mmm">
							<?php
							for ( $i = 1; $i < 13; $i++ ) {
								$monthnum = zeroise( $i, 2 );
								$monthtext = $wp_locale->get_month_abbrev( $wp_locale->get_month( $i ) );
								echo '<option value="' . $monthnum . '" data-text="' . $monthtext . '" ' . selected( $monthnum, $mm, false ).'>' . sprintf( __( '%1$s-%2$s' ), $monthnum, $monthtext ) . '</option>';
							}
							?>
						</select>
					</label>
					<label>
						<span class="screen-reader-text"><?php _e( 'Day', 'wp-last-modified-info' ); ?></span>
						<input type="text" id="jjm" class="time-modified be-jjm" name="jjm" value="<?php echo $jj; ?>" size="2" maxlength="2" autocomplete="off" />
					</label><span style="vertical-align: sub;">,</span> <label>
						<span class="screen-reader-text"><?php _e( 'Year', 'wp-last-modified-info' ); ?></span>
						<input type="text" id="aam" class="time-modified be-aam" name="aam" value="<?php echo $aa; ?>" size="4" maxlength="4" autocomplete="off" />
					</label> <span style="vertical-align: sub;"><?php _e( 'at', 'wp-last-modified-info' ); ?></span><label> 
						<span class="screen-reader-text"><?php _e( 'Hour', 'wp-last-modified-info'); ?></span>
						<input type="text" id="hhm" class="time-modified be-hhm" name="hhm" value="<?php echo $hh; ?>" size="2" maxlength="2" autocomplete="off"/>
					</label><span style="vertical-align: sub;"><?php _e(':', 'wp-last-modified-info'); ?></span><label>
						<span class="screen-reader-text"><?php _e( 'Minute', 'wp-last-modified-info' ); ?></span>
						<input type="text" id="mnm" class="time-modified be-mnm" name="mnm" value="<?php echo $mn; ?>" size="2" maxlength="2" autocomplete="off" />
					</label>
				</div>
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
					echo '<input type="hidden" id="hidden_' . $key . '" name="hidden_' . $key . '" value="' . $val[0] . '">';
					echo '<input type="hidden" id="cur_' . $key . '" name="cur_' . $key . '" value="' . $val[1] . '">';
				} ?>
	
				<input type="hidden" id="ssm" name="ssm" value="<?php echo $ss; ?>">
				<input type="hidden" id="wplmi-change-modified" name="wplmi_change" value="no">
				<input type="hidden" id="wplmi-disable-hidden" name="wplmi_disable" value="<?php echo ( $stop_update ) ? $stop_update : 'no'; ?>">
				<input type="hidden" id="wplmi-post-modified" name="wplmi_modified" value="<?php echo $post->post_modified; ?>">
	
				<p id="wplmi-meta" class="wplmi-meta-options">
					<a href="#edit_timestampmodified" class="save-timestamp hide-if-no-js button"><?php _e( 'OK', 'wp-last-modified-info '); ?></a>
					<a href="#edit_timestampmodified" class="cancel-timestamp hide-if-no-js button-cancel"><?php _e( 'Cancel', 'wp-last-modified-info' ); ?></a>&nbsp;&nbsp;&nbsp;
					<label for="wplmi_disable" class="wplmi-disable-update" title="Keep this checked, if you do not want to change modified date and time on this <?php echo $post_types->name ?>">
						<input type="checkbox" id="wplmi_disable" name="disableupdate" <?php if ( $stop_update == 'yes' ) { echo 'checked'; } ?>><?php _e( 'Disable Update', 'wp-last-modified-info' ); ?>
					</label>
				</p>
			</fieldset>
		</div><?php
	}

	/**
	 * Quick ecit HTML output.
	 * 
	 * @param string  $column_name  Current column name
	 * @param string  $post_type    Post type
	 */
	public function quick_edit( $column_name, $post_type )
	{
		global $wp_locale;

		if ( 'lastmodified' !== $column_name ) {
			return;
		} ?>

		<div id="inline-edit-col-modified-date">
			<legend><span class="title"><?php _e( 'Modified', 'wp-last-modified-info' ); ?></span></legend>
				<div class="timestamp-wrap">
					<label class="inline-edit-group">
						<span class="screen-reader-text"><?php _e( 'Month', 'wp-last-modified-info' ); ?></span>
						<select id="mmm" class="time-modified" name="mmm">
							<?php
							for ( $i = 1; $i < 13; $i++ ) {
								$monthnum = zeroise( $i, 2 );
								$monthtext = $wp_locale->get_month_abbrev( $wp_locale->get_month( $i ) );
								echo '<option value="' . $monthnum . '" data-text="' . $monthtext . '">' . sprintf( __( '%1$s-%2$s' ), $monthnum, $monthtext ) . '</option>';
							}
							?>
						</select>
					</label>
					<label class="inline-edit-group">
						<span class="screen-reader-text"><?php _e( 'Day', 'wp-last-modified-info' ); ?></span>
						<input type="text" id="jjm" class="time-modified tm-jjm" name="jjm" value="" size="2" maxlength="2" autocomplete="off" />
					</label>, <label>
						<span class="screen-reader-text"><?php _e( 'Year', 'wp-last-modified-info' ); ?></span>
						<input type="text" id="aam" class="time-modified tm-aam" name="aam" value="" size="4" maxlength="4" autocomplete="off" />
					</label> <?php _e( 'at', 'wp-last-modified-info' ); ?> <label>
						<span class="screen-reader-text"><?php _e( 'Hour', 'wp-last-modified-info' ); ?></span>
						<input type="text" id="hhm" class="time-modified tm-hhm" name="hhm" value="" size="2" maxlength="2" autocomplete="off" />
					</label>:<label>
						<span class="screen-reader-text"><?php _e( 'Minute', 'wp-last-modified-info' ); ?></span>
						<input type="text" id="mnm" class="time-modified tm-mnm" name="mnm" value="" size="2" maxlength="2" autocomplete="off" />
					</label>&nbsp;&nbsp;<label for="wplmi_disable">
						<input type="checkbox" id="wplmi_disable" name="disableupdate" />
						<span class="checkbox-title"><?php _e( 'Disable Update', 'wp-last-modified-info' ); ?></span>
					</label>
				</div>
				<input type="hidden" id="ssm" name="ssm" value="">
				<input type="hidden" id="wplmi-change-modified" name="wplmi_change" value="no">
				<input type="hidden" id="wplmi-disable-hidden" name="wplmi_disable" value="">
				<input type="hidden" id="wplmi-post-modified" name="wplmi_modified" value="">
			</div>
		<?php
	}

	/**
	 * Quick ecit HTML output.
	 * 
	 * @param string  $column_name  Current column name
	 * @param string  $post_type    Post type
	 */
	public function bulk_edit( $column_name, $post_type )
	{
		global $wp_locale;

		if ( 'lastmodified' !== $column_name ) {
			return;
		} ?>

        <div class="inline-edit-col wplmi-bulkedit">
		    <fieldset class="inline-edit-date">
		    	<legend><span class="title"><?php _e( 'Modified', 'wp-last-modified-info' ); ?></span></legend>
		    	<div class="timestamp-wrap">
		    		<label class="inline-edit-group">
		    			<span class="screen-reader-text"><?php _e( 'Month', 'wp-last-modified-info' ); ?></span>
		    			<select id="mmm" class="time-modified" name="mmm">
		    			<option value="none">— <?php _e( 'No Change', 'wp-last-modified-info' ); ?> —</option>
		    				<?php
		    				for ( $i = 1; $i < 13; $i++ ) {
		    					$monthnum = zeroise( $i, 2 );
		    					$monthtext = $wp_locale->get_month_abbrev( $wp_locale->get_month( $i ) );
		    					echo '<option value="' . $monthnum . '" data-text="' . $monthtext . '">' . sprintf( __( '%1$s-%2$s' ), $monthnum, $monthtext ) . '</option>';
		    				}
		    				?>
		    			</select>
		    		</label>
		    		<label class="inline-edit-group">
		    			<span class="screen-reader-text"><?php _e( 'Day', 'wp-last-modified-info' ); ?></span>
		    			<input type="text" id="jjm" class="time-modified tm-jjm" name="jjm" value="" size="2" maxlength="2" placeholder="<?php _e( 'Day', 'wp-last-modified-info' ); ?>" autocomplete="off" />
		    		</label>, <label>
		    			<span class="screen-reader-text"><?php _e( 'Year', 'wp-last-modified-info' ); ?></span>
		    			<input type="text" id="aam" class="time-modified tm-aam" name="aam" value="" size="4" maxlength="4" placeholder="<?php _e( 'Year', 'wp-last-modified-info' ); ?>" autocomplete="off" />
		    		</label> <?php _e( 'at', 'wp-last-modified-info' ); ?> <label>
		    			<span class="screen-reader-text"><?php _e( 'Hour', 'wp-last-modified-info' ); ?></span>
		    			<input type="text" id="hhm" class="time-modified tm-hhm" name="hhm" value="" size="2" maxlength="2" placeholder="<?php _e( 'Hour', 'wp-last-modified-info' ); ?>" autocomplete="off" />
		    		</label>:<label>
		    			<span class="screen-reader-text"><?php _e( 'Minute', 'wp-last-modified-info' ); ?></span>
		    			<input type="text" id="mnm" class="time-modified tm-mnm" name="mnm" value="" size="2" maxlength="2" placeholder="<?php _e( 'Min', 'wp-last-modified-info' ); ?>" autocomplete="off" />
		    		</label>&nbsp;&nbsp;<label for="wplmi_disable">
						<span class="select-title"><?php _e( 'Update Status', 'wp-last-modified-info' ); ?></span>
						<select id="wplmi-disable-update" class="disable-update" name="disable_update">
		    			    <option value="none">— <?php _e( 'No Change', 'wp-last-modified-info' ); ?> —</option>
						    <option value="no"><?php _e( 'Enable Update', 'wp-last-modified-info' ); ?></option>
						    <option value="yes"><?php _e( 'Disable Update', 'wp-last-modified-info' ); ?></option>
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
	public function bulk_save()
	{
		// security check
		$this->verify_nonce( 'wplmi_edit_nonce' );

		global $wpdb;

		// we need the post IDs
	    $post_ids = ( isset( $_POST[ 'post_ids' ] ) && ! empty( $_POST[ 'post_ids' ] ) ) ? $_POST[ 'post_ids' ] : NULL;
    
	    // if we have post IDs
	    if ( ! empty( $post_ids ) && is_array( $post_ids ) ) {
    
			$mmm = sanitize_text_field( $_POST['modified_month'] );
		    $jj = sanitize_text_field( $_POST['modified_day'] );
		    $aa = sanitize_text_field( $_POST['modified_year'] );
		    $hh = sanitize_text_field( $_POST['modified_hour'] );
		    $mn = sanitize_text_field( $_POST['modified_minute'] );
			$disable = sanitize_text_field( $_POST['modified_disable'] );
    
		    $mm = ( is_numeric( $mmm ) && $mmm <= 12 ) ? $mmm : '01'; // months
		    $jj = ( is_numeric( $jj ) && $jj <= 31 ) ? $jj : '01'; // days
		    $aa = ( is_numeric( $aa ) && $aa >= 0 ) ? $aa : '1970'; // years
		    $hh = ( is_numeric( $hh ) && $hh <= 24 ) ? $hh : '12'; // hours
		    $mn = ( is_numeric( $mn ) && $mn <= 60 ) ? $mn : '00'; // minutes
		    $ss = '00'; // seconds
	    
			$newdate = sprintf( "%04d-%02d-%02d %02d:%02d:%02d", $aa, $mm, $jj, $hh, $mn, $ss );

			set_transient( 'wplmi_temp_modified_date', $newdate, 15 );

	    	foreach( $post_ids as $post_id ) {
				if ( ! in_array( get_post_status( $post_id ), [ 'auto-draft', 'future' ] ) ) {
				    if ( $mmm != 'none' ) {
						$this->update_meta( $post_id, '_wplmi_last_modified', $newdate );
						$this->update_meta( $post_id, '_wplmi_bulk_update', 'yes' );
				    }
    
				    if ( $disable != 'none' ) {
				    	$this->update_meta( $post_id, '_lmt_disableupdate', $disable );
				    }
				}
			}
	    }
	
		$this->success();
	}

	/**
	 * Save post modified info to db.
	 * 
	 * @param object   $data     Old Data
	 * @param object   $postarr  Current Data
	 * 
	 * @return object  $data
	 */
	public function update_data( $data, $postarr )
	{
		if ( in_array( $postarr['post_status'], [ 'auto-draft', 'future' ] ) ) {
			return $data;
		}

		$modified_temp = get_transient( 'wplmi_temp_modified_date' );
		$proceed = $this->get_meta( $postarr['ID'], '_wplmi_bulk_update' );
		
		if ( $modified_temp && $proceed == 'yes' ) {
			$data['post_modified'] = $modified_temp;
			$data['post_modified_gmt'] = get_gmt_from_date( $modified_temp );

			$this->delete_meta( $postarr['ID'], '_wplmi_bulk_update' );

		    return $data;
		}

		if ( ! isset( $postarr['wplmi_modified'], $postarr['wplmi_change'], $postarr['wplmi_disable'] ) ) {
			return $data;
		}

		$modified = sanitize_text_field( $postarr['wplmi_modified'] );
		$change = sanitize_text_field( $postarr['wplmi_change'] );
		$disabled = sanitize_text_field( $postarr['wplmi_disable'] );

		$this->update_meta( $postarr['ID'], '_lmt_disableupdate', $disabled );

		$published_timestamp = get_the_time( 'U', $postarr['ID'] );
		
		if ( $disabled == 'yes' ) {
		   
			$data['post_modified'] = $modified;
			$data['post_modified_gmt'] = get_gmt_from_date( $modified );

		} else if ( $disabled == 'no' ) {
			
			if ( $change == 'yes' ) {
		        $mm = sanitize_text_field( $postarr['mmm'] );
		        $jj = sanitize_text_field( $postarr['jjm'] );
		        $aa = sanitize_text_field( $postarr['aam'] );
		        $hh = sanitize_text_field( $postarr['hhm'] );
		        $mn = sanitize_text_field( $postarr['mnm'] );
		        $ss = sanitize_text_field( $postarr['ssm'] );
        
		        $mm = ( is_numeric( $mm ) && $mm <= 12 ) ? $mm : '01'; // months
		        $jj = ( is_numeric( $jj ) && $jj <= 31 ) ? $jj : '01'; // days
		        $aa = ( is_numeric( $aa ) && $aa >= 0 ) ? $aa : '1970'; // years
		        $hh = ( is_numeric( $hh ) && $hh <= 24 ) ? $hh : '12'; // hours
		        $mn = ( is_numeric( $mn ) && $mn <= 60 ) ? $mn : '00'; // minutes
		        $ss = ( is_numeric( $ss ) && $ss <= 60 ) ? $ss : '00'; // seconds
	        
				$newdate = sprintf( "%04d-%02d-%02d %02d:%02d:%02d", $aa, $mm, $jj, $hh, $mn, $ss );
				$modified = $newdate;
	
				if ( strtotime( $newdate ) >= $published_timestamp ) {
	                $data['post_modified'] = $newdate;
				    $data['post_modified_gmt'] = get_gmt_from_date( $newdate );
				}
			} else {
				$modified = current_time( 'mysql' );
			}
		}

		$this->update_meta( $postarr['ID'], '_wplmi_last_modified', $modified );

		//error_log( 'WPIPD: ' . $postarr['ID'] );
	
		return $data;
	}

	/**
	 * Store custom field meta box data.
	 *
	 * @param int $post_id The post ID.
	 */
	public function save_metadata( $post_id )
	{
		global $wpdb;

		// return if autosave
	    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
	    	return;
		}
		
	    // Check the user's permissions.
	    if ( ! current_user_can( 'edit_post', $post_id ) ) {
	    	return;
		}
		
		if ( get_transient( 'wplmi_temp_modified_date' ) ) {
			delete_transient( 'wplmi_temp_modified_date' );
		    return;
		}

		if ( isset( $_POST['wplmi_modified'], $_POST['wplmi_change'], $_POST['wplmi_disable'] ) ) {
			return;
		}

		if ( in_array( get_post_status( $post_id ), [ 'auto-draft', 'future' ] ) ) {
			return;
		}

		$disabled = $this->get_meta( $post_id, '_lmt_disableupdate' );
		$modified = $this->get_meta( $post_id, '_wplmi_last_modified' );
		
		if ( $modified && $disabled == 'yes' ) {
	    	$args = [
	            'post_modified'     => $modified,
	            'post_modified_gmt' => get_gmt_from_date( $modified ),
	    	];
    
	    	$wpdb->update( $wpdb->posts, $args, [
	    	    'ID' => $post_id,
			] );
			
			clean_post_cache( $post_id );
		}
		
		if ( $this->do_filter( 'force_update_author_id', false ) ) {
		    $this->update_meta( $post_id, '_edit_last', get_current_user_id() );
		}

		//error_log( 'WPIP: ' . $post_id );
	}

	/**
	 * Update Post Modified date from previously save meta to fix WooCommerce Product Update process.
	 *
	 * @param int $product_id The product ID.
	 */
	public function woo_save_metadata( $product_id )
	{
		global $wpdb;

		if ( in_array( get_post_status( $product_id ), [ 'auto-draft', 'future' ] ) ) {
			return;
		}

		$modified = $this->get_meta( $product_id, '_wplmi_last_modified' );
		$published_timestamp = get_the_time( 'U', $product_id );
		
		if ( $modified && ( strtotime( $modified ) >= $published_timestamp ) ) {
	    	$args = [
	            'post_modified'     => $modified,
	            'post_modified_gmt' => get_gmt_from_date( $modified ),
	    	];
    
	    	$wpdb->update( $wpdb->posts, $args, [
	    	    'ID' => $product_id,
			] );
			
			clean_post_cache( $product_id );
	    }
	}
}