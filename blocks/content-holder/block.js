( function( wp ) {
	/**
	 * Registers a new block provided a unique name and an object defining its behavior.
	 * @see https://github.com/WordPress/gutenberg/tree/master/blocks#api
	 */
	var registerBlockType = wp.blocks.registerBlockType;
	
	var RawHTML = wp.element.RawHTML;
	var Fragment = wp.element.Fragment;
	var Component = wp.element.Component;
	var compose = wp.element.compose;
	

	var Toolbar = wp.components.Toolbar;
	var Button = wp.components.Button;
	var Tooltip = wp.components.Tooltip;
	var PanelBody = wp.components.PanelBody;
	var PanelRow = wp.components.PanelRow;
	var FormToggle = wp.components.FormToggle;
	var TextControl = wp.components.TextControl;
	var ColorPicker = wp.components.ColorPicker;
	
	var SelectControl = wp.components.SelectControl;
	var Dashicon = wp.components.Dashicon;
	var Component = wp.components.Component;
	//var withState = wp.compose.withState;
	var ServerSideRender = wp.components.ServerSideRender;
	var BlockPreview = wp.BlockPreview;
	
	var PlainText = wp.editor.PlainText;
	var RichText = wp.editor.RichText;
	var MediaUpload = wp.editor.MediaUpload;
	var InspectorControls = wp.editor.InspectorControls;
	var InnerBlocks = wp.editor.InnerBlocks;
	var PanelColor = wp.editor.PanelColor;
	var PanelColorSettings = wp.editor.PanelColorSettings;
	var AlignmentToolbar = wp.editor.AlignmentToolbar;
	var BlockControls = wp.editor.BlockControls;
	var BlockAlignmentToolbar = wp.editor.BlockAlignmentToolbar;
	var ColorPalette = wp.editor.ColorPalette;
	var getColorClass = wp.editor.getColorClass;

	var withSelect = wp.data.withSelect;
	var withDispatch = wp.data.withDispatch;

	/**
	 * Returns a new element of given type. Element is an abstraction layer atop React.
	 * @see https://github.com/WordPress/gutenberg/tree/master/element#element
	 */
	var el = wp.element.createElement;

	/**
	 * Retrieves the translation of text.
	 * @see https://github.com/WordPress/gutenberg/tree/master/i18n#api
	 */
	var __ = wp.i18n.__;


	
	var applyWithSelect = withSelect( function( select ) {
		var getEntityRecords = select( 'core' ).getEntityRecords;

		return {
			posts: getEntityRecords( 'postType', 'post' )
		};
	} );
	
	/**
	 * Every block starts by registering a new block type definition.
	 * @see https://wordpress.org/gutenberg/handbook/block-api/
	 */
	registerBlockType( 'content-holder/block', {
		/**
		 * This is the display title for your block, which can be translated with `i18n` functions.
		 * The block inserter will show this name.
		 */
		title: __( 'Content Holder' ),

		/**
		 * 
		 * The block inserter will show this name.
		 */
		icon: 'migrate',

		/**
		 * Blocks are grouped into categories to help users browse and discover them.
		 * The categories provided by core are `common`, `embed`, `formatting`, `layout` and `widgets`.
		 */
		category: 'widgets',

		/**
		 * Optional block extended support features.
		 */
		supports: {
			// support for an HTML mode.
			html: false,
			// support for an anchor link.
			anchor: false,
			// allow block to be converted into a reusable block.
			reusable: false,
			// support for the generated className.
			className: false,
			// support for the custom className.
			customClassName: true

		},

	
		transforms: {
			
			to: [
				{
					type: 'shortcode',
					blocks: [ 'content-holder/block' ],
					isMatch: function( attributes ) {
						return attributes.id;
					},
					transform: function( attributes ) {

						return createBlock( 'content-holder/block', {
							id: attributes.id,
						} );
					},
				},
			],
			
			from: [
				{
					type: 'shortcode',
					// Shortcode tag can also be an array of shortcode aliases
					tag: '[a-z][a-z0-9_-]*',
					
					attributes: {
						// An attribute can be source from the shortcode attributes
						id: {
							type: 'number',
							shortcode: function( attributes ) {
								var id = attributes.named.id ? attributes.named.id : 'idnone';
								return id.replace( 'id', '' );
							},
						},
						// An attribute can be source from the shortcode attributes
						slug: {
							type: 'string',
							shortcode: function( attributes ) {
								var slug = attributes.named.slug ? attributes.named.slug : 'slugnone';
								return slug.replace( 'slug', '' );
							},
						},

						text: {
							type: 'string',
							shortcode: function shortcode(attrs, _ref) {
								var content = _ref.content;
		
								return content;
							}
						}
					},
				},
			]
		},
		

		/**
		 * The edit function describes the structure of your block in the context of the editor.
		 * This represents what the editor will render when the block is used.
		 * @see https://wordpress.org/gutenberg/handbook/block-edit-save/#edit
		 *
		 * @param {Object} [props] Properties passed from the editor.
		 * @return {Element}       Element to render.
		 */
		

		edit: function (props){ 
			console.log(props);
			
			var attributes =  props.attributes;
			var setAttributes =  props.setAttributes;
			var isSelected = props.isSelected;

			//Function to update id attribute
			function changeId(id){
			setAttributes({id});
			}

			//Function to update post name
			function changeSlug(slug){
			setAttributes({slug});
			}

			var select = {
				value: attributes.slug,
				label: __( 'Select a content holder below' ),
				onChange: changeSlug,
				options: attributes.options
				/* options: [
					{value:'', label: 'Select a Content Holder '},
					{value: 'address', label: 'Address'},
					{value: 'demo', label: 'Demo'},
					{value: 'grid', label: 'Grid'},
				]	*/
				
			}

			if( isSelected ){

			}

			return el('div', {className:''}, [
				el(InspectorControls, {}, 
				[
					el(PanelBody,{},
					[
						el(SelectControl, select)
					])
				]),
				el(ServerSideRender,{
					block: 'content-holder/block',
					attributes: {
						slug:attributes.slug,
						id:attributes.id
					}
				})
			] );
		},

	
		/**
		 * The save function defines the way in which the different attributes should be combined
		 * into the final markup, which is then serialized by Gutenberg into `post_content`.
		 * @see https://wordpress.org/gutenberg/handbook/block-edit-save/#save
		 *
		 * @return {Element}       Element to render.
		 */
		save: function save(props) {
			var attributes = props.attributes;
	
			return wp.element.createElement(
				RawHTML,
				null,
				attributes.text
			);
		}
	} );
} )(
	window.wp
);