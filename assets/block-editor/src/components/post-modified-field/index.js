/**
 * WordPress dependencies
 */
import { __ } from "@wordpress/i18n";
import { useSelect, useDispatch } from "@wordpress/data";
import { PluginPostStatusInfo } from '@wordpress/edit-post';
import { dateI18n, __experimentalGetSettings } from "@wordpress/date";
import { DateTimePicker, Dropdown, Button } from "@wordpress/components";

const PostModifiedField = () => {
    const settings = __experimentalGetSettings();
    const dateTimeFormat = settings.formats.date + ' ' + settings.formats.time;
    const is12HourFormat = ( format ) => {
        return /(?:^|[^\\])[aAgh]/.test( format );
    }

    const { editedModified, currentModified, postStatus, postMeta } = useSelect( ( select ) => {
        return {
            editedModified: select( 'core/editor' ).getEditedPostAttribute( 'modified' ),
            currentModified: select( 'core/editor' ).getCurrentPostAttribute( 'modified' ),
            postStatus: select( 'core/editor' ).getEditedPostAttribute( 'status' ),
            postMeta: select( 'core/editor' ).getEditedPostAttribute( 'meta' ),
        };
    } );

    const { editPost } = useDispatch( 'core/editor' );

    if ( [ 'auto-draft', 'future' ].includes( postStatus ) ) {
        return null;
    }

    return (
        <PluginPostStatusInfo>
            { postMeta?._lmt_disableupdate == 'yes' ? (
                <>
                    <span>{ __( 'Last Modified', 'wp-last-modified-info' ) }</span>
                    <b>{ dateI18n( dateTimeFormat, editedModified ) }</b>
                </>
            ) : (
                <>
                    <span>{ __( 'Modified', 'wp-last-modified-info' ) }</span>
                    <Dropdown
                        position="bottom left"
                        contentClassName="edit-post-post-schedule__dialog"
                        renderToggle={ ( { onToggle, isOpen } ) => (
                            <Button
                                className="edit-post-post-schedule__toggle"
                                onClick={ onToggle }
                                aria-expanded={ isOpen }
                                isTertiary
                            >
                                { dateI18n( dateTimeFormat, editedModified ) }
                            </Button>
                        ) }
                        renderContent={ () => (
                            <DateTimePicker
                                currentDate={ editedModified }
                                onChange={ ( modified ) => { editPost( { modified } ) } }
                                is12Hour={ is12HourFormat( settings.formats.time ) }
                            />
                        ) }
                    />
                </>
            ) }
        </PluginPostStatusInfo>
    );
};

export default PostModifiedField;