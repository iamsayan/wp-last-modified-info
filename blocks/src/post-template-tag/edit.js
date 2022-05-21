/**
 * WordPress dependencies
 */
import { useBlockProps } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';

/**
 * Register Block
 */
const EditPostModifiedTemplate = ( { attributes } ) => {
    return (
        <div { ...useBlockProps() }>
            <ServerSideRender
                block='wplmi/post-template-tag'
                attributes={ attributes }
            />
        </div>
    )
};
 
export default EditPostModifiedTemplate;