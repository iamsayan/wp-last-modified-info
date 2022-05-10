/**
 * WordPress dependencies
 */
import { registerPlugin } from '@wordpress/plugins';

/**
 * Internal dependencies
 */
import PostModifiedDateChange from './components/post-modified-field';
import PostModifiedDateToggle from './components/post-modified-toggle';
import PostModifiedFrontControl from './components/post-modified-front-control';

const WPLastModifiedInfo = () => {
    return (
        <>
            <PostModifiedDateChange />
            <PostModifiedDateToggle />
            <PostModifiedFrontControl />
        </>
    );
};

registerPlugin( 'wp-last-modified-info', {
    render: WPLastModifiedInfo,
    icon: null,
} );
