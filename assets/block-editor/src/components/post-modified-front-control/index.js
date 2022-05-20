/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useSelect, useDispatch } from '@wordpress/data';
import { PluginDocumentSettingPanel} from '@wordpress/edit-post';
import { CheckboxControl, PanelRow } from '@wordpress/components';

const PostModifiedFrontControl = () => {
    const { postStatus, postType, postMeta } = useSelect( ( select ) => {
		return {
            postStatus: select( 'core/editor' ).getEditedPostAttribute( 'status' ),
            postType: select( 'core/editor' ).getCurrentPostType(),
			postMeta: select( 'core/editor' ).getEditedPostAttribute( 'meta' ),
		};
	} );

    const { editPost } = useDispatch( 'core/editor', [ postMeta._lmt_disable ] );

    if ( [ 'auto-draft', 'future' ].includes( postStatus ) ) {
        return null;
    }

    if ( ! wplmiBlockEditor.postTypes.includes( postType ) || ! wplmiBlockEditor.isEnabled ) {
        return null;
    }
    
    return (
        <PluginDocumentSettingPanel name="modified-info" title={ __( 'Modified Info', 'wp-last-modified-info' ) } className="wplmi-panel" icon={null}>
            <PanelRow>
                <CheckboxControl
                    label={ __( 'Hide Modified Info on Frontend', 'wp-last-modified-info' ) }
                    checked={ postMeta._lmt_disable == 'yes' ? true : false }
                    onChange={ () => editPost( { meta: { _lmt_disable: postMeta._lmt_disable == 'yes' ? 'no' : 'yes' } } ) }
                />
            </PanelRow>
        </PluginDocumentSettingPanel>
    );
};

export default PostModifiedFrontControl;