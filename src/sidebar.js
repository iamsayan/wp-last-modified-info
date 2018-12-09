/**
 * Internal block libraries
 */

const { __ } = wp.i18n;

const {
	PluginSidebar,
	PluginSidebarMoreMenuItem
} = wp.editPost;

const {
	PanelBody,
	TextControl,
	CheckboxControl,
	DateTimePicker,
} = wp.components;

const {
	Component,
	Fragment
} = wp.element;

const { withSelect } = wp.data;

const { compose } = wp.compose;

const { registerPlugin } = wp.plugins;

class WP_Last_Modified_Info extends Component {
	constructor() {
		super( ...arguments );

		this.state = {
            key: '_lmt_disable',
			value: '',
			isChecked: false,
        }

		this.handleChecked = this.handleChecked.bind(this);

		wp.apiFetch( { path: `/wp/v2/posts/${this.props.postId}`, method: 'GET' } ).then(
			( data ) => {
				this.setState( {
					value: data.meta._lmt_disable,
				} );
				if ( this.state.value == 'yes' ) {
					this.setState( {
						isChecked: !this.state.isChecked,
					} );
				}
				return data;
			},
			( err ) => {
				return err;
			}
		);
    }

    handleChecked() {
        this.setState({
            isChecked: !this.state.isChecked,
            value: this.state.isChecked == false ? 'yes' : '',
        } );
    }
    
	static getDerivedStateFromProps( nextProps, state ) {
		if ( ( nextProps.isPublishing || nextProps.isSaving ) && !nextProps.isAutoSaving ) {
			wp.apiRequest( { path: `/wp-last-modified-info/v1/update-meta?id=${nextProps.postId}`, method: 'POST', data: state } ).then(
				( data ) => {
					return data;
				},
				( err ) => {
					return err;
				}
			);
		}
    }

	render() {
		return (
			<Fragment>
				<PluginSidebarMoreMenuItem
					target="wp-last-modified-info-sidebar"
				>
					{ __( 'WP Last Modified Info' ) }
				</PluginSidebarMoreMenuItem>
				<PluginSidebar
					name="wp-last-modified-info-sidebar"
					title={ __( 'WP Last Modified Info' ) }
				>
					<PanelBody>
                        <CheckboxControl
							label={ __( 'Disable auto insert on frontend' ) }
							value={ this.state.value }
							checked={ this.state.isChecked }
		                    onChange={ this.handleChecked }
	                    />
					</PanelBody>
				</PluginSidebar>
			</Fragment>
		)
	}
}

const WPLMI = withSelect( ( select, { forceIsSaving } ) => {
	const {
		getCurrentPostId,
		isSavingPost,
		isPublishingPost,
		isAutosavingPost,
    } = select( 'core/editor' );
    
	return {
		postId: getCurrentPostId(),
		isSaving: forceIsSaving || isSavingPost(),
		isAutoSaving: isAutosavingPost(),
		isPublishing: isPublishingPost(),
    };
    
} )( WP_Last_Modified_Info );

registerPlugin( 'wp-last-modified-info', {
	icon: 'clock',
	render: WPLMI,
} );