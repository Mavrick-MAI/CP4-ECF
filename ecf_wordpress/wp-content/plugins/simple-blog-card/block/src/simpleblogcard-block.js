const { registerBlockType } = wp.blocks;
const { Fragment } = wp.element;
const { InspectorControls } = wp.blockEditor;
const { TextControl, RadioControl, RangeControl, ToggleControl, ColorPalette } = wp.components;
const { serverSideRender: ServerSideRender } = wp;

const colors = [
	{ name: simpleblogcard_text.white,  color: '#ffffff' },
	{ name: simpleblogcard_text.black,  color: '#000000' },
	{ name: simpleblogcard_text.red,    color: '#ff0000' },
	{ name: simpleblogcard_text.yellow, color: '#ffff00' },
	{ name: simpleblogcard_text.blue,   color: '#0000ff' },
];

registerBlockType(
	'simple-blog-card/simpleblogcard-block',
	{
		title: 'Simple Blog Card',
		icon: 'share-alt2',
		category: 'widgets',

		edit ( props ) {
			return [
			<Fragment>
				<ServerSideRender
					block = 'simple-blog-card/simpleblogcard-block'
					attributes = { props.attributes }
				/>
				<TextControl
					label = { 'URL' }
					value = { props.attributes.url }
					onChange = { ( value ) => props.setAttributes( { url: value } ) }
				/>

				<InspectorControls>
				{}
					<TextControl
						label = { 'URL' }
						value = { props.attributes.url }
						onChange = { ( value ) => props.setAttributes( { url: value } ) }
					/>
					<RangeControl
						label = { simpleblogcard_text.dessize }
						max = { 300 }
						min = { 0 }
						value = { props.attributes.dessize }
						onChange = { ( value ) => props.setAttributes( { dessize: value } ) }
					/>
					<RangeControl
						label = { simpleblogcard_text.imgsize }
						max = { 200 }
						min = { 0 }
						value = { props.attributes.imgsize }
						onChange = { ( value ) => props.setAttributes( { imgsize: value } ) }
					/>
					{ simpleblogcard_text.color }
					<ColorPalette
						colors={ colors }
						value = { props.attributes.color }
						onChange = { ( value ) => props.setAttributes( { color: value } ) }
					/>
					<RangeControl
						label = { simpleblogcard_text.color_width }
						max = { 15 }
						min = { 1 }
						value = { props.attributes.color_width }
						onChange = { ( value ) => props.setAttributes( { color_width: value } ) }
					/>
					<TextControl
						label = { simpleblogcard_text.title }
						value = { props.attributes.title }
						onChange = { ( value ) => props.setAttributes( { title: value } ) }
					/>
					<RangeControl
						label = { simpleblogcard_text.t_line_height }
						max = { 300 }
						min = { 10 }
						value = { props.attributes.t_line_height }
						onChange = { ( value ) => props.setAttributes( { t_line_height: value } ) }
					/>
					<TextControl
						label = { simpleblogcard_text.description }
						value = { props.attributes.description }
						onChange = { ( value ) => props.setAttributes( { description: value } ) }
					/>
					<RangeControl
						label = { simpleblogcard_text.d_line_height }
						max = { 300 }
						min = { 10 }
						value = { props.attributes.d_line_height }
						onChange = { ( value ) => props.setAttributes( { d_line_height: value } ) }
					/>
					<ToggleControl
						label = { simpleblogcard_text.target_blank }
						checked = { props.attributes.target_blank }
						onChange = { ( value ) => props.setAttributes( { target_blank: value } ) }
					/>
				</InspectorControls>
			</Fragment>
			];
		},

		save () {
			return null;
		},

	}
);
