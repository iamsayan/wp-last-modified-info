/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import ServerSideRender from '@wordpress/server-side-render';
import { FontSizePicker, PanelBody, TextControl, SelectControl } from '@wordpress/components';
import { ColorPaletteControl,InspectorControls, LineHeightControl, useBlockProps } from '@wordpress/block-editor';

/**
 * Register Block
 */
const EditPostModified = ( { attributes, setAttributes } ) => {
    const fontSizes = [
        {
            name: __( 'Tiny', 'wp-last-modified-info' ),
            slug: 'small',
            size: 10,
        },
        {
            name: __( 'Small', 'wp-last-modified-info' ),
            slug: 'small',
            size: 14,
        },
        {
            name: __( 'Normal', 'wp-last-modified-info' ),
            slug: 'normal',
            size: 16,
        },
        {
            name: __( 'Big', 'wp-last-modified-info' ),
            slug: 'big',
            size: 20,
        }
    ];
    
    return (
        <div { ...useBlockProps() }>
            <ServerSideRender
                block='wplmi/post-modified-date'
                attributes={ attributes }
            />
            <InspectorControls key='settings'>
                <PanelBody title={ __( 'Options', 'wp-last-modified-info' ) } initialOpen={ false }>
                    <TextControl
                        label={ __( 'Format', 'wp-last-modified-info' ) }
                        help={ __( 'Date Time format. Leave blank for default.', 'wp-last-modified-info' ) }
                        value={ attributes.format }
                        onChange={ ( value ) => setAttributes( { format: value } ) }
                    />
                    <SelectControl
                        label={ __( 'Display', 'wp-last-modified-info' ) }
                        value={ attributes.display }
                        options={ [
                            { label: 'Block', value: 'block' },
                            { label: 'Inline', value: 'inline' },
                        ] }
                        onChange={ ( value ) => setAttributes( { display: value } ) }
                    />
                    <SelectControl
                        label={ __( 'Text Align', 'wp-last-modified-info' ) }
                        value={ attributes.textAlign }
                        options={ [
                            { label: 'Left', value: 'left' },
                            { label: 'Center', value: 'center' },
                            { label: 'Right', value: 'right' },
                        ] }
                        onChange={ ( value ) => setAttributes( { textAlign: value } ) }
                    />
                </PanelBody>
                <PanelBody title={ __( 'Content', 'wp-last-modified-info' ) } initialOpen={ false }>
                    <TextControl
                        label={ __( 'Text Before', 'wp-last-modified-info' ) }
                        help={ __( 'Text to show before the timestamp', 'wp-last-modified-info' ) }
                        value={ attributes.textBefore }
                        onChange={ ( value ) => setAttributes( { textBefore: value } ) }
                    />
                    <TextControl
                        label={ __( 'Text After', 'wp-last-modified-info' ) }
                        help={ __( 'Text to show after the timestamp', 'wp-last-modified-info' ) }
                        value={ attributes.textAfter }
                        onChange={ ( value ) => setAttributes( { textAfter: value } ) }
                    />
                </PanelBody>
                <PanelBody title={ __( 'Typography', 'wp-last-modified-info' ) }>
                    <FontSizePicker
                        label={ __( 'Font Size', 'wp-last-modified-info' ) }
                        value={ attributes.varFontSize }
                        onChange={ ( value ) => setAttributes( { varFontSize: value } ) }
                        fallBackFontSize={ 16 }
                        fontSizes={ fontSizes }
                    />
                    <LineHeightControl
                        label={ __( 'Line Height', 'wp-last-modified-info' ) }
                        value={ attributes.varLineHeight }
                        onChange={ ( value ) => setAttributes( { varLineHeight: value } ) }
                    />
                </PanelBody>
                <PanelBody title={ __( 'Colors', 'wp-last-modified-info' ) }>
                    <ColorPaletteControl
                        label={ __( 'Background', 'wp-last-modified-info' ) }
                        value={ attributes.varColorBackground }
                        onChange={ ( value ) => setAttributes( { varColorBackground: value } ) }
                    />
                    <ColorPaletteControl
                        label={ __( 'Text', 'wp-last-modified-info' ) }
                        value={ attributes.varColorText }
                        onChange={ ( value ) => setAttributes( { varColorText: value } ) }
                    />
                </PanelBody>
            </InspectorControls>
        </div>
    )
};
 
export default EditPostModified;