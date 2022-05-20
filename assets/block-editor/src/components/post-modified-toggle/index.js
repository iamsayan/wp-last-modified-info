/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { FormToggle } from '@wordpress/components';
import { useSelect, useDispatch } from '@wordpress/data';
import { PluginPostStatusInfo } from '@wordpress/edit-post';

const PostModifiedDateToggle = () => {
    const { postStatus, postMeta } = useSelect( ( select ) => {		
		return {
            postStatus: select( 'core/editor' ).getEditedPostAttribute( 'status' ),
			postMeta: select( 'core/editor' ).getEditedPostAttribute( 'meta' ),
		};
	} );

    const { editPost } = useDispatch( 'core/editor', [ postMeta._lmt_disableupdate ] );

    if ( [ 'auto-draft', 'future' ].includes( postStatus ) ) {
        return null;
    }

    return (
        <PluginPostStatusInfo>
            <span>{ __( 'Lock Modified Date', 'wp-last-modified-info' ) }</span>
            <FormToggle
                checked={ postMeta._lmt_disableupdate == 'yes' ? true : false }
                onChange={ () => editPost( { meta: { _lmt_disableupdate: postMeta._lmt_disableupdate == 'yes' ? 'no' : 'yes' } } ) }
            />
        </PluginPostStatusInfo>
    );
};

export default PostModifiedDateToggle;