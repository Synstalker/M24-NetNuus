<?php


if ( ! class_exists( 'Kirki_Field_GravityForms_Select' ) && class_exists('Kirki_Field_Select') ) {
	
		/**
		 * Class Kirki_Field_GravityForms_Select
		 *
		 * Registers a new Kirki Control Type namely 'gravityforms_select'
		 * Extends the current 'select' field type, so you can pretty much use it the same way
		 *
		 * Will return a list of gravity forms referenced by it's form ID in the event gravity forms is activated
		 *
		 * If gravity forms is not activated, it will still output a dropdown, but with a placeholder text
		 */
		class Kirki_Field_GravityForms_Select extends Kirki_Field_Select {

			public $type = 'gravityforms_select';
			public $placeholder = 'Select a Form';

			var $default_args = array(
				'description' => '<i>If the form is not listed here, it may be disabled or deleted...</i><br/><a href="/wp-admin/admin.php?page=gf_edit_forms">view all gravity forms here</a>'
			);

			public function __construct( $config_id, array $args ) {

				/**
				 * Check for an active installation of gravityforms
				 */
				if ( class_exists( 'RGFormsModel' ) ) {
					
					$forms = RGFormsModel::get_forms( true, 'title' );
					
					if( count( $forms ) < 1 ){
						$args['placeholder'] = __( 'No active forms found.' );
					}else{
						foreach( $forms as $key => $form ){
							$args['choices'][$form->id] = $form->id.': ' . $form->title;
						}
					}
					
				} else {
					$args['placeholder'] = __( 'Please install/enable gravity forms.' );
				}
				
				parent::__construct( $config_id, $args );
			}
		}
}