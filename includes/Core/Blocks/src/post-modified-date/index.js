/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import ServerSideRender from '@wordpress/server-side-render';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, ToggleControl } from '@wordpress/components';

/**
 * Register Block
 */
registerBlockType( 'wp-last-modified-info/post-modified-date', {
    apiVersion: 2,
    name: 'wp-last-modified-info/post-modified-date',
    title: __( 'Post Modified Date', 'wp-last-modified-info' ),
    description: __( 'Display simple meta links.', 'wp-last-modified-info' ),
    icon: 'menu-alt',
    // supports: {
    //     customClassName: false,
    // },
    attributes: {
        'title': {
            'type': 'string',
            'default': 'Meta Links'
        },
        'class': {
            'type': 'string',
            'default': ''
        },
        'showSiteAdmin': {
            'type': 'boolean',
            'default': true
        },
        'showProfileEdit': {
            'type': 'boolean',
            'default': true
        },
        'showLogIn': {
            'type': 'boolean',
            'default': true
        }
    },
    edit: ({attributes, setAttributes}) => {
        return (
            <div {...useBlockProps()}>
                <ServerSideRender
                    block='wp-last-modified-info/post-modified-date'
                    attributes={attributes}
                />
                <InspectorControls key='settings'>
                    <PanelBody title={__('Display', 'wp-last-modified-info')}>
                        <TextControl
                            label={__('Title', 'wp-last-modified-info')}
                            value={attributes.title}
                            onChange={(value) => setAttributes({title: value})}
                        />
                    </PanelBody>
                    <PanelBody title={__('Links', 'wp-last-modified-info')}>
                        <ToggleControl
                            label={__('Show Site Admin', 'wp-last-modified-info')}
                            checked={attributes.showSiteAdmin}
                            onChange={(value) => setAttributes({showSiteAdmin: value})}
                        />
                        <ToggleControl
                            label={__('Show Profile Edit', 'wp-last-modified-info')}
                            checked={attributes.showProfileEdit}
                            onChange={(value) => setAttributes({showProfileEdit: value})}
                        />
                        <ToggleControl
                            label={__('Show Log In', 'wp-last-modified-info')}
                            checked={attributes.showLogIn}
                            onChange={(value) => setAttributes({showLogIn: value})}
                        />
                    </PanelBody>
                    <PanelBody title={__('Advanced', 'wp-last-modified-info')}>
                        <TextControl
                            label={__('Additional CSS Class', 'wp-last-modified-info')}
                            value={attributes.class}
                            onChange={(value) => setAttributes({class: value})}
                        />
                    </PanelBody>
                </InspectorControls>
            </div>
        )
    },
    save: () => {
        return null
    }
} );
