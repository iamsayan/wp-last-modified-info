/**
 * External dependencies
 */
import { parseISO, endOfMonth, startOfMonth } from 'date-fns';

/**
 * WordPress dependencies
 */
import { __, _x, isRTL, sprintf } from '@wordpress/i18n';
import { useSelect, useDispatch } from '@wordpress/data';
import { useState, useMemo } from '@wordpress/element';
import { PluginPostStatusInfo } from '@wordpress/editor';
import { dateI18n, getDate, getSettings } from '@wordpress/date';
import {
	DateTimePicker,
	Dropdown,
	Button,
	__experimentalHStack as HStack,
	CheckboxControl,
} from '@wordpress/components';
import { __experimentalInspectorPopoverHeader as InspectorPopoverHeader } from '@wordpress/block-editor';
import { store as coreStore } from '@wordpress/core-data';
import { Icon, lockOutline, unseen } from '@wordpress/icons';

import './style.css';

const PostModifiedField = () => {
	const [ popoverAnchor, setPopoverAnchor ] = useState( null );

	// ------------------------------------------------------------------
	// Settings & helpers
	// ------------------------------------------------------------------
	const { timezone = {}, formats = {} } = getSettings() ?? {};

	// Simpler 12-hour test: look for an unescaped 'a' in the time format.
	const is12HourTime = useMemo( () => /(^|[^\\])a/i.test( formats.time ?? '' ), [ formats.time ] );

	// ------------------------------------------------------------------
	// Data
	// ------------------------------------------------------------------
	const { date, modifiedDate, postStatus, postType, postMeta, postId } = useSelect(
		( select ) => ( {
			date: select( 'core/editor' ).getEditedPostAttribute( 'date' ),
			modifiedDate: select( 'core/editor' ).getEditedPostAttribute( 'modified' ),
			postStatus: select( 'core/editor' ).getEditedPostAttribute( 'status' ),
			postType: select( 'core/editor' ).getCurrentPostType(),
			postMeta: select( 'core/editor' ).getEditedPostAttribute( 'meta' ),
			postId: select( 'core/editor' ).getCurrentPostId(),
		} ),
		[]
	);

	const { editPost } = useDispatch( 'core/editor' );

	// ------------------------------------------------------------------
	// Early return
	// ------------------------------------------------------------------
	if ( [ 'auto-draft', 'future' ].includes( postStatus ) ) {
		return null;
	}

	// ------------------------------------------------------------------
	// Date helpers
	// ------------------------------------------------------------------
	const isTimezoneSameAsSiteTimezone = ( d ) => {
		if ( ! ( d instanceof Date ) || isNaN( d ) ) return false;
		const siteOffset = Number( timezone.offset ) || 0;
		const dateOffset = -1 * ( d.getTimezoneOffset() / 60 );
		return siteOffset === dateOffset;
	};

	const getTimezoneAbbreviation = () => {
		if ( timezone.abbr && isNaN( Number( timezone.abbr ) ) ) return timezone.abbr;
		const symbol = Number( timezone.offset ) < 0 ? '' : '+';
		return `UTC${ symbol }${ timezone.offsetFormatted ?? timezone.offset }`;
	};

	const isSameDay = ( left, right ) =>
		left instanceof Date &&
		right instanceof Date &&
		left.getDate() === right.getDate() &&
		left.getMonth() === right.getMonth() &&
		left.getFullYear() === right.getFullYear();

	// ------------------------------------------------------------------
	// Labels
	// ------------------------------------------------------------------
	const fullLabel = useMemo( () => {
		const d = getDate( modifiedDate );
		if ( ! ( d instanceof Date ) || isNaN( d ) ) return '';
		const tz = getTimezoneAbbreviation();
		const formatted = dateI18n(
			_x( 'F j, Y g:i\xa0a', 'post modified full date format', 'wp-last-modified-info' ),
			d
		);
		return isRTL() ? `${ tz } ${ formatted }` : `${ formatted } ${ tz }`;
	}, [ date, modifiedDate ] );

	const shortLabel = useMemo( () => {
		const d = getDate( modifiedDate );
		if ( ! ( d instanceof Date ) || isNaN( d ) ) return fullLabel;

		const now = new Date();
		if ( ! isTimezoneSameAsSiteTimezone( now ) ) return fullLabel;

		if ( isSameDay( d, now ) ) {
			return sprintf(
				__( 'Today at %s', 'wp-last-modified-info' ),
				dateI18n( _x( 'g:i\xa0a', 'post modified time format', 'wp-last-modified-info' ), d )
			);
		}

		if ( d.getFullYear() === now.getFullYear() ) {
			return dateI18n(
				_x( 'F j g:i\xa0a', 'post modified date format without year', 'wp-last-modified-info' ),
				d
			);
		}

		return dateI18n(
            // translators: Use a non-breaking space between 'g:i' and 'a' if appropriate.
            _x( 'F j, Y g:i\xa0a', 'post modified full date format', 'wp-last-modified-info' ),
            date
        );
	}, [ date, modifiedDate, fullLabel ] );

	// ------------------------------------------------------------------
	// Month-preview logic
	// ------------------------------------------------------------------
	const [ previewedMonth, setPreviewedMonth ] = useState( () => {
		const d = getDate( modifiedDate );
		return d instanceof Date && ! isNaN( d ) ? startOfMonth( d ) : startOfMonth( new Date() );
	} );

	const popoverProps = useMemo(
		() => ( {
			anchor: popoverAnchor,
			'aria-label': __( 'Change modified date', 'wp-last-modified-info' ),
			placement: 'left-middle',
			offset: 36,
			shift: true,
		} ),
		[ popoverAnchor ]
	);

	// ------------------------------------------------------------------
	// Events for calendar dots
	// ------------------------------------------------------------------
	const eventsByPostType = useSelect(
		( select ) =>
			select( coreStore ).getEntityRecords( 'postType', postType, {
				status: 'publish',
				after: startOfMonth( previewedMonth ).toISOString(),
				before: endOfMonth( previewedMonth ).toISOString(),
				exclude: [ postId ],
				per_page: 100,
				_fields: 'id,modified',
			} ),
		[ previewedMonth, postType, postId ]
	);

	const events = useMemo(
		() =>
			( eventsByPostType || [] ).map( ( { modified } ) => ( {
				date: new Date( modified ),
			} ) ),
		[ eventsByPostType ]
	);

	// ------------------------------------------------------------------
	// UI flags
	// ------------------------------------------------------------------
	const frontHidden = postMeta?._lmt_disable === 'yes';
	const updateDisabled = postMeta?._lmt_disableupdate === 'yes';
	const showHideFrontend =
		typeof wplmiBlockEditor !== 'undefined' &&
		Array.isArray( wplmiBlockEditor.postTypes ) &&
		wplmiBlockEditor.postTypes.includes( postType ) &&
		wplmiBlockEditor.isEnabled;

	// ------------------------------------------------------------------
	// Render
	// ------------------------------------------------------------------
	return (
		<PluginPostStatusInfo className="wplmi-modified-edit">
			<HStack className="editor-post-panel__row" ref={ setPopoverAnchor }>
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
									__( 'Change modified date: %s', 'wp-last-modified-info' ),
									shortLabel
								) }
								label={ fullLabel }
								showTooltip={ shortLabel !== fullLabel }
								aria-expanded={ isOpen }
							>
								{ shortLabel }
							</Button>
						) }
						renderContent={ ( { onClose } ) => (
							<>
								<InspectorPopoverHeader
									title={ __( 'Modified', 'wp-last-modified-info' ) }
									onClose={ onClose }
								/>

								{ showHideFrontend && (
									<CheckboxControl
										label={ __( 'Hide on Frontend', 'wp-last-modified-info' ) }
										checked={ frontHidden }
										onChange={ () =>
											editPost( { meta: { _lmt_disable: frontHidden ? 'no' : 'yes' } } )
										}
										help={ __( 'Hide post modified data from frontend.', 'wp-last-modified-info' ) }
									/>
								) }

								<CheckboxControl
									label={ __( 'Lock Modified Date', 'wp-last-modified-info' ) }
									checked={ updateDisabled }
									onChange={ () =>
										editPost( { meta: { _lmt_disableupdate: updateDisabled ? 'no' : 'yes' } } )
									}
									help={ __( 'Prevents post modified date changes.', 'wp-last-modified-info' ) }
									__nextHasNoMarginBottom
								/>

								{ ! updateDisabled && (
									<DateTimePicker
										currentDate={ modifiedDate }
										onChange={ ( modified ) => editPost( { modified } ) }
										is12Hour={ is12HourTime }
										events={ events }
										isInvalidDate={ ( currentDate ) => {
											const current = new Date( currentDate );
											const publish = new Date( date );
											// Reset to midnight for clean comparison
											[ current, publish ].forEach( ( d ) => d.setHours( 0, 0, 0, 0 ) );
											return current < publish;
										} }
										dateOrder={ _x( 'dmy', 'modified date order', 'wp-last-modified-info' ) }
										onMonthPreviewed={ ( d ) => setPreviewedMonth( parseISO( d ) ) }
									/>
								) }
							</>
						) }
					/>
				</div>
			</HStack>
		</PluginPostStatusInfo>
	);
};

export default PostModifiedField;