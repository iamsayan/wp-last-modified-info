<?php

/**
 * Runs on Admin Dashboard
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

add_action( 'add_meta_boxes', 'lmt_add_meta_box_to_gutenburg' );

// insert data upon post save
add_filter( 'wp_insert_post_data', 'lmt_disable_update_date_gutenburg', 99, 2 );

function lmt_add_meta_box_to_gutenburg( $post ) {
    // If user can't publish posts, then get out
    if ( ! current_user_can( 'publish_posts' ) ) return;
	
	$current_screen = get_current_screen();
	if ( method_exists( $current_screen, 'is_block_editor' ) && $current_screen->is_block_editor() ) { 
        add_meta_box( 'lmt_meta_box_gutenburg', __( 'Last Updated', 'wp-last-modified-info' ), 'lmt_show_on_gutenburg_edit_screen', '', 'side', 'high', array(
            '__back_compat_meta_box' => false,
	    ) );
	}
}

function lmt_show_on_gutenburg_edit_screen( $post ) {

    global $wp_locale;

	if( $post->post_status == 'auto-draft' ) {
		return;
    }

    $datemodified = $post->post_modified;
    
	$jj = mysql2date('d', $datemodified, false);
	$mm = mysql2date('m', $datemodified, false);
	$aa = mysql2date('Y', $datemodified, false);
	$hh = mysql2date('H', $datemodified, false);
    $mn = mysql2date('i', $datemodified, false);
    $ss = mysql2date('s', $datemodified, false);

    $stop_update = get_post_meta( $post->ID, '_lmt_disableupdate', true );
	$post_types = get_post_type_object( get_post_type( $post ) );
	
	// get plugin settings
	$options = get_option('lmt_plugin_global_settings');
    
	// get modified time with a particular format
    $lmt_updated_time = get_the_modified_time('M j, Y @ H:i');
    $orig_time = get_the_time('U');
    $mod_time = get_the_modified_time('U'); ?>
    
    <div class="misc-pub-section-gutenburg curtime misc-pub-last-updated" style="padding-top:5px;">

	<span id="lmt-timestamp-text"><?php _e( 'Updated on', 'wp-last-modified-info' ) ?></span>

    <a href="#edit_timestampmodified" class="edit-timestampmodified hide-if-no-js" role="button">
		<span aria-hidden="true">
		    <span class="dashicons dashicons-edit" style="font-size: 15px;padding-top: 2px;"></span>
		</span>
		<span class="screen-reader-text">
		    <?php _e('Edit modified date and time', 'wp-last-modified-info'); ?>
		</span>
	</a>

	<span id="lmt-timestamp-gutenburg" style="float: right;"><strong><?php echo $lmt_updated_time ?></strong></span>

        <fieldset id="timestampmodifieddiv" class="hide-if-js">
			<legend class="screen-reader-text"><?php _e('Last modified date and time', 'wp-last-modified-info'); ?></legend>
			<div class="timestamp-wrap tsw-be">
				<label>
					<span class="screen-reader-text"><?php _e('Month', 'wp-last-modified-info'); ?></span>
					<select id="mmm" name="mmm" class="be-mmm">
						<?php
						for ($i = 1; $i < 13; $i++) {
							$monthnum = zeroise($i, 2);
							$monthtext = $wp_locale->get_month_abbrev($wp_locale->get_month($i));
							echo '<option value="'.$monthnum.'" data-text="'.$monthtext.'" '.selected($monthnum, $mm, false).'>'.sprintf(__( '%1$s-%2$s' ), $monthnum, $monthtext).'</option>';
						}
						?>
					</select>
				</label>
				<label>
					<span class="screen-reader-text"><?php _e('Day', 'wp-last-modified-info'); ?></span>
					<input type="text" id="jjm" class="be-jjm" name="jjm" value="<?php echo $jj; ?>" size="2" maxlength="2" autocomplete="off" />
				</label>, <label>
					<span class="screen-reader-text"><?php _e('Year', 'wp-last-modified-info'); ?></span>
					<input type="text" id="aam" class="be-aam" name="aam" value="<?php echo $aa; ?>" size="4" maxlength="4" autocomplete="off" />
				</label> <?php _e('@', 'wp-last-modified-info'); ?><label>
					<span class="screen-reader-text"><?php _e('Hour', 'wp-last-modified-info'); ?></span>
					<input type="text" id="hhm" class="be-hhm" name="hhm" value="<?php echo $hh; ?>" size="2" maxlength="2" autocomplete="off" />
				</label><?php _e(':', 'wp-last-modified-info'); ?><label>
					<span class="screen-reader-text"><?php _e('Minute', 'wp-last-modified-info'); ?></span>
					<input type="text" id="mnm" class="be-mnm" name="mnm" value="<?php echo $mn; ?>" size="2" maxlength="2" autocomplete="off" />
				</label>
			</div>
			<?php
			$currentlocal = current_time('timestamp');
			$mm_current = gmdate('m', $currentlocal);
			$jj_current = gmdate('d', $currentlocal);
			$aa_current = gmdate('Y', $currentlocal);
			$hh_current = gmdate('H', $currentlocal);
			$mn_current = gmdate('i', $currentlocal);

			$vals = array(
				'mmm' => array($mm, $mm_current),
				'jjm' => array($jj, $jj_current),
				'aam' => array($aa, $aa_current),
				'hhm' => array($hh, $hh_current),
				'mnm' => array($mn, $mn_current),
			);

			foreach($vals as $key => $val) {
				echo '<input type="hidden" id="hidden_'.$key.'" name="hidden_'.$key.'" value="'.$val[0].'">';
				echo '<input type="hidden" id="cur_'.$key.'" name="cur_'.$key.'" value="'.$val[1].'">';
			} ?>

			<input type="hidden" id="ssm" name="ssm" value="<?php echo $ss; ?>">
            <input type="hidden" id="change-modified" name="changemodifiedgutenburg" value="no">
            <input type="hidden" id="lmt-disable-hidden" name="disableupdategutenburghidden" value="no">
			<input type="hidden" id="lmt-last-modified" name="lastmodifiedhidden" value="<?php echo get_the_modified_time( 'Y-m-d H:i:s' ); ?>">
				
			<p id="lmt-meta" class="meta-options">
			    <a href="#edit_timestampmodified" class="save-timestamp hide-if-no-js button"><?php _e('OK', 'wp-last-modified-info'); ?></a> <a href="#edit_timestampmodified" class="cancel-timestamp hide-if-no-js button-cancel"><?php _e('Cancel', 'wp-last-modified-info'); ?></a>&nbsp;&nbsp;
                <label for="lmt_disable" class="selectit" title="Keep this checked, if you do not want to change modified date and time on this <?php echo $post_types->capability_type ?>">
		            <input type="checkbox" id="lmt_disable" name="disableupdategutenburg" <?php if( $stop_update == 'yes' ) { echo 'checked'; } ?>><?php _e( 'Disable update', 'wp-last-modified-info' ); ?>
				</label>
			</p>
			
		</fieldset>

        <script type="text/javascript">
		    jQuery(document).ready(function($) {
		    	$tsmdiv = $('#timestampmodifieddiv');
    
		    	function updateTextModified() {
    
		    		var dateFormat = '%1$s %2$s, %3$s @ %4$s:%5$s';
		    		var aam = $('#aam').val(), mmm = $('#mmm').val(), jjm = $('#jjm').val(), hhm = $('#hhm').val(), mnm = $('#mnm').val();
		    		var textModifiedOn = "<?php _e('Updated on:', 'wp-last-modified-info'); ?>";
		    		$('#lmt-timestamp-gutenburg').html(
		    			'\n ' + ' <strong>' +
		    			dateFormat
		    				.replace( '%1$s', $( 'option[value="' + mmm + '"]', '#mmm' ).attr( 'data-text' ) )
		    				.replace( '%2$s', parseInt( jjm, 10 ) )
		    				.replace( '%3$s', aam )
		    				.replace( '%4$s', ( '00' + hhm ).slice( -2 ) )
		    				.replace( '%5$s', ( '00' + mnm ).slice( -2 ) ) +
		    				'</strong> '
		    		);
		    		return true;
		    	}
    
		    	/*
		    	 * Partially borrowed from wp-admin/js/post.js
		    	 */
		    	$tsmdiv.siblings('a.edit-timestampmodified').click( function( event ) {
		    		if ( $tsmdiv.is( ':hidden' ) ) {
		    			$tsmdiv.slideDown( 'fast', function() {
		    				$( 'input, select', $tsmdiv.find( '.timestamp-wrap' ) ).first().focus();
		    			} );
		    			$(this).hide();
		    		}
		    		event.preventDefault();
		    	});
    
		    	$tsmdiv.find('.cancel-timestamp').click( function( event ) {
		    		$tsmdiv.slideUp('fast').siblings('a.edit-timestampmodified').show().focus();
		    		$('#mmm').val($('#hidden_mmm').val());
		    		$('#jjm').val($('#hidden_jjm').val());
		    		$('#aam').val($('#hidden_aam').val());
		    		$('#hhm').val($('#hidden_hhm').val());
		    		$('#mnm').val($('#hidden_mnm').val());
		    		updateTextModified();
		    		$('#change-modified').val('no');
		    		event.preventDefault();
		    	});
    
		    	$tsmdiv.find('.save-timestamp').click( function( event ) {
		    		if ( updateTextModified() ) {
		    			$tsmdiv.slideUp('fast');
		    			$tsmdiv.siblings('a.edit-timestampmodified').show().focus();
		    		}
		    		$('#change-modified').val('yes');
		    		event.preventDefault();
		    	});
    
		    	$('#lmt_disable').change(function() {
                    if ($('#lmt_disable').is(':checked')) {
                        $('#lmt-disable-hidden').val('yes');
                    }
                    if (!$('#lmt_disable').is(':checked')) {
                        $('#lmt-disable-hidden').val('no');
                    }
		    	});
		    	$('#lmt_disable').trigger('change');
		    });
	    </script>
    </div><?php
}

function lmt_disable_update_date_gutenburg( $data, $postarr ) {

	if( isset($postarr['disableupdategutenburghidden'] ) && $postarr['disableupdategutenburghidden'] == 'yes' ) {		
		update_post_meta( $postarr['ID'], '_lmt_disableupdate', 'yes' );

		if ( !empty($postarr['lastmodifiedhidden']) ) {
		    $data['post_modified'] = $postarr['lastmodifiedhidden'];
			$data['post_modified_gmt'] = get_gmt_from_date( $postarr['lastmodifiedhidden'] );
		}
	}
	elseif( isset($postarr['disableupdategutenburghidden'] ) && $postarr['disableupdategutenburghidden'] == 'no' ) {
		update_post_meta( $postarr['ID'], '_lmt_disableupdate', 'no' );
		
		if( isset($postarr['changemodifiedgutenburg']) && $postarr['changemodifiedgutenburg'] == 'yes' ) {
			$mm = sanitize_text_field($postarr['mmm']);
			$jj = sanitize_text_field($postarr['jjm']);
			$aa = sanitize_text_field($postarr['aam']);
			$hh = sanitize_text_field($postarr['hhm']);
			$mn = sanitize_text_field($postarr['mnm']);
			$ss = sanitize_text_field($postarr['ssm']);
	
			$mm = (is_numeric($mm) && $mm <= 12) ? $mm : '01'; // months
			$jj = (is_numeric($jj) && $jj <= 31) ? $jj : '01'; // days
			$aa = (is_numeric($aa) && $aa >= 0) ? $aa : '2017'; // years
			$hh = (is_numeric($hh) && $hh <= 24) ? $hh : '12'; // hours
			$mn = (is_numeric($mn) && $mn <= 60) ? $mn : '00'; // minutes
			$ss = (is_numeric($ss) && $ss <= 60) ? $ss : '00'; // seconds
	
			$newdate = sprintf("%04d-%02d-%02d %02d:%02d:%02d", $aa, $mm, $jj, $hh, $mn, $ss);
	
			if ( !empty( $newdate ) ) {
			    $data['post_modified'] = $newdate;
				$data['post_modified_gmt'] = get_gmt_from_date( $newdate );
			}
		}
	}
    return $data;
}

?>