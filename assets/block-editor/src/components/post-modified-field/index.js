/**
 * External dependencies
 */
import { parseISO, endOfMonth, startOfMonth } from 'date-fns';

/**
 * WordPress dependencies
 */
import { __, _x, isRTL } from "@wordpress/i18n";
import { useSelect, useDispatch } from "@wordpress/data";
import { useState, useMemo } from '@wordpress/element';
import { PluginPostStatusInfo } from '@wordpress/editor';
import { dateI18n, getDate, getSettings } from "@wordpress/date";
import { DateTimePicker, Dropdown, Button, __experimentalHStack as HStack, CheckboxControl } from '@wordpress/components';
import { __experimentalInspectorPopoverHeader as InspectorPopoverHeader } from '@wordpress/block-editor';
import { store as coreStore } from '@wordpress/core-data';
import { Icon, lockOutline, unseen } from '@wordpress/icons';

import './style.css';

const PostModifiedField = () => {
    const [ popoverAnchor, setPopoverAnchor ] = useState( null );
    const { timezone, formats } = getSettings();

    const is12HourTime = /a(?!\\)/i.test(
		formats.time
			.toLowerCase() // Test only the lower case a.
			.replace( /\\\\/g, '' ) // Replace "//" with empty strings.
			.split( '' )
			.reverse()
			.join( '' ) // Reverse the string and test for "a" not followed by a slash.
	);

    const { date, modifiedDate, postStatus, postType, postMeta } = useSelect( ( select ) => ({
        date: select( 'core/editor' ).getEditedPostAttribute( 'date' ),
        modifiedDate: select( 'core/editor' ).getEditedPostAttribute( 'modified' ),
        postStatus: select( 'core/editor' ).getEditedPostAttribute( 'status' ),
        postType: select( 'core/editor' ).getCurrentPostType(),
        postMeta: select( 'core/editor' ).getEditedPostAttribute( 'meta' ),
    }));

    const isTimezoneSameAsSiteTimezone = ( date ) => {
        const siteOffset = Number( timezone.offset );
        const dateOffset = -1 * ( date.getTimezoneOffset() / 60 );
        return siteOffset === dateOffset;
    }

    const getTimezoneAbbreviation = () => {
        if ( timezone.abbr && isNaN( Number( timezone.abbr ) ) ) {
            return timezone.abbr;
        }
    
        const symbol = timezone.offset < 0 ? '' : '+';
        return `UTC${ symbol }${ timezone.offsetFormatted }`;
    }

    const isSameDay = ( left, right ) => {
        return (
            left.getDate() === right.getDate() &&
            left.getMonth() === right.getMonth() &&
            left.getFullYear() === right.getFullYear()
        );
    }

    const getFullPostScheduleLabel = () => {
        const date = getDate( modifiedDate );

        const timezoneAbbreviation = getTimezoneAbbreviation();
        const formattedDate = dateI18n(
            // translators: Use a non-breaking space between 'g:i' and 'a' if appropriate.
            _x( 'F j, Y g:i\xa0a', 'post modified full date format', 'wp-last-modified-info' ),
            date
        );
        return isRTL()
            ? `${ timezoneAbbreviation } ${ formattedDate }`
            : `${ formattedDate } ${ timezoneAbbreviation }`;
    }

    const getPostScheduleLabel = () => {
        const now = new Date();

        if ( ! isTimezoneSameAsSiteTimezone( now ) ) {
            return getFullPostScheduleLabel();
        }

        const date = getDate( modifiedDate );
        
        if ( isSameDay( date, now ) ) {
            return sprintf(
                // translators: %s: Time of day the post is modified.
                __( 'Today at %s' ),
                // translators: If using a space between 'g:i' and 'a', use a non-breaking space.
                dateI18n( _x( 'g:i\xa0a', 'post modified time format', 'wp-last-modified-info' ), date )
            );
        }       

        if ( date.getFullYear() === now.getFullYear() ) {
            return dateI18n(
                // translators: If using a space between 'g:i' and 'a', use a non-breaking space.
                _x( 'F j g:i\xa0a', 'post modified date format without year', 'wp-last-modified-info' ),
                date
            );
        }

        return dateI18n(
            // translators: Use a non-breaking space between 'g:i' and 'a' if appropriate.
            _x( 'F j, Y g:i\xa0a', 'post modified full date format', 'wp-last-modified-info' ),
            date
        );
    }

    const { editPost } = useDispatch( 'core/editor' );

    const [ previewedMonth, setPreviewedMonth ] = useState(
		startOfMonth( new Date( modifiedDate ) )
	);

    const popoverProps = useMemo(
		() => ( {
			anchor: popoverAnchor,
			'aria-label': __( 'Change modified date' ),
			placement: 'left-middle',
			offset: 36,
			shift: true,
		} ),
		[ popoverAnchor ]
	);

    // Pick up published site posts.
	const eventsByPostType = useSelect(
		( select ) =>
			select( coreStore ).getEntityRecords( 'postType', postType, {
				status: 'publish',
				after: startOfMonth( previewedMonth ).toISOString(),
				before: endOfMonth( previewedMonth ).toISOString(),
				exclude: [ select( 'core/editor' ).getCurrentPostId() ],
				per_page: 100,
				_fields: 'id,modified',
			} ),
		[ previewedMonth, postType ]
	);

	const events = useMemo(
		() =>
			( eventsByPostType || [] ).map( ( { modified: eventDate } ) => ( {
				date: new Date( eventDate ),
			} ) ),
		[ eventsByPostType ]
    );

    if ( [ 'auto-draft', 'future' ].includes( postStatus ) ) {
        return null;
    }

    const frontHidden = postMeta?._lmt_disable === 'yes';
    const updateDisabled = postMeta?._lmt_disableupdate === 'yes';
    const showHideFrontend = wplmiBlockEditor.postTypes.includes( postType ) && wplmiBlockEditor.isEnabled;

    const label = getPostScheduleLabel();
    const fullLabel = getFullPostScheduleLabel();

    return (
        <PluginPostStatusInfo className="wplmi-modified-edit">
            <HStack
                className="editor-post-panel__row"
                ref={ setPopoverAnchor }
            >
                <div className="editor-post-panel__row-label">
                    { __( 'Modified', 'wp-last-modified-info' ) } 
                    { updateDisabled && <Icon icon={ lockOutline } size={ 18 } /> }
                    { showHideFrontend && frontHidden && <Icon icon={ unseen } size={ 18 } /> }
                </div>
                <div className="editor-post-panel__row-control">
                    <Dropdown
                        popoverProps={ popoverProps }
                        focusOnMount
                        className="editor-post-schedule__panel-dropdown"
                        contentClassName="editor-post-schedule__dialog"
                        renderToggle={ ( { onToggle, isOpen } ) => (
                            <Button
                                size="compact"
                                className="editor-post-schedule__dialog-toggle"
                                variant="tertiary"
                                tooltipPosition="middle left"
                                onClick={ onToggle }
                                aria-label={ sprintf(
                                    // translators: %s: Current post modified date.
                                    __( 'Change modified date: %s', 'wp-last-modified-info' ),
                                    label
                                ) }
                                label={ fullLabel }
                                showTooltip={ label !== fullLabel }
                                aria-expanded={ isOpen }
                            >
                                { label }
                            </Button>
                        ) }
                        renderContent={ ( { onClose } ) => (
                            <>
                                <InspectorPopoverHeader
                                    title={ __( 'Modified', 'wp-last-modified-info' ) }
                                    onClose={ onClose }
                                />
                                { showHideFrontend &&
                                    <CheckboxControl
                                        label={ __( 'Hide on Frontend', 'wp-last-modified-info' ) }
                                        checked={ frontHidden }
                                        onChange={ () => editPost( { meta: { _lmt_disable: frontHidden ? 'no' : 'yes' } } ) }
                                        help={ __( 'Hide post modified data from frontend.', 'wp-last-modified-info' ) }
                                    />
                                }
                                <CheckboxControl
                                    label={ __( 'Lock Modified Date', 'wp-last-modified-info' ) }
                                    checked={ updateDisabled }
                                    onChange={ () => editPost( { meta: { _lmt_disableupdate: updateDisabled ? 'no' : 'yes' } } ) }
                                    help={ __( 'Prevents post modified date changes.', 'wp-last-modified-info' ) }
                                    __nextHasNoMarginBottom={ updateDisabled }
                                />
                                { ! updateDisabled && 
                                    <DateTimePicker
                                        currentDate={ modifiedDate }
                                        onChange={ ( modified ) => { editPost( { modified } ) } }
                                        is12Hour={ is12HourTime }
                                        events={ events }
                                        isInvalidDate={ ( currentDate ) => {
                                            const today = new Date();
                                            const current = new Date(currentDate);
                                            const publish = new Date(date);
                                            
                                            // Reset time components to midnight
                                            today.setHours(0, 0, 0, 0);
                                            current.setHours(0, 0, 0, 0);
                                            publish.setHours(0, 0, 0, 0);
                                            
                                            return current < publish || current > today;
                                        }}
                                        dateOrder={
                                            /* translators: Order of day, month, and year. Available formats are 'dmy', 'mdy', and 'ymd'. */
                                            _x( 'dmy', 'modified date order', 'wp-last-modified-info' )
                                        }
                                        onMonthPreviewed={ ( date ) => setPreviewedMonth( parseISO( date ) ) }
                                    />
                                }
                            </>
                        ) }
                    />
                </div>
            </HStack>
        </PluginPostStatusInfo>
    );
};

export default PostModifiedField;