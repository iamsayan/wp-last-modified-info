/**
 * WordPress dependencies
 */
import { registerPlugin } from '@wordpress/plugins';

/**
 * Internal dependencies
 */
import PostModifiedDateChange from './components/post-modified-field';

const WPLastModifiedInfo = () => {
    return (
        <PostModifiedDateChange />
    );
};

registerPlugin( 'wp-last-modified-info', {
    render: WPLastModifiedInfo,
    icon: null,
} );
