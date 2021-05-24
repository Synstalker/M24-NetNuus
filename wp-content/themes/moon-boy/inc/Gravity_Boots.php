<?php
/**
 * Various html and css class enhancements based on the structure given here:
 * Specifically for the frontend of the theme
 *
 * @see https://getbootstrap.com/docs/4.0/components/forms/
 * @see https://getbootstrap.com/docs/4.0/components/alerts/
 * @todo use this filter gform_get_form_filter  wp-content/plugins/gravityforms/form_display.php:1105
 * @todo, hide empty labels on gravity forms
 */
namespace MoonBoy\Gravity_Boots;

use MoonBoy;

if( !is_admin() && class_exists('\DOMDocument' ) ){
	
	/**
	 * Checks if a gravity form has been submitted
	 * @return bool
	 */
	function form_submitted(){
		return isset( $_POST['gform_submit'] ) && '1' === $_POST['gform_submit'];
	}
	
	/**
	 * @see     https://stackoverflow.com/a/2087136/1654250
	 *
	 * @param   \DOMNode $node
	 *
	 * @param String     $query
	 *
	 * @return string
	 */
	function innerHTML( \DOMNode $node, String $query = '' ){
		$innerHTML = "";
		$children  = $node->childNodes;
		
		foreach ($children as $child)
		{
			$innerHTML .= $node->ownerDocument->saveHTML($child);
		}
		
		return $innerHTML;
	}
	
	/**
	 * @param String       $query
	 * @param \DOMDocument $document
	 *
	 * @return \DOMNodeList
	 */
	function querySelectorAllInDOM( String $query, \DOMDocument $document ){
		$xpath = new \DOMXpath($document);
		$nodes = $xpath->query($query);
		$nodes = 0 !== $nodes->length ? $nodes : new \DOMNodeList();
		return $nodes;
	}
	
	function querySelectorAllInString( String $query, String $html_string ){
		$dom = new \DOMDocument();
		$result = $dom->loadHTML($html_string);
		if( !$result ){
			return $html_string;
		}
		$dom->preserveWhiteSpace = false;
		return querySelectorAllInDOM( $query, $dom );
	}
	
	/**
	 * @param String       $query
	 * @param String       $cssClass
	 * @param \DOMDocument $dom
	 * @param bool         $replace_class
	 *
	 * @return \DOMDocument
	 */
	function setClassInDOM( String $cssClass, \DOMDocument &$dom, String $query, bool $replace_class = false ){
		
		$nodes = querySelectorAllInDOM( $query, $dom);
		
		if( !$nodes ){
			return $dom;
		}
		
		for($i=0; $i<$nodes->length; $i++){
			$node = $nodes->item($i);
			$cssClass = $replace_class ? $cssClass : $node->getAttribute('class'). ' '.$cssClass;
			$node->setAttribute('class',$cssClass);
		}
		
		$dom->saveHTML();
		
		return $dom;
	}
	
	function setAttributeInString( String $attribute , String $attribute_value, $html_string, $xpath_query = '//*' ){
		
		$has_body_tag = strpos($html_string, '</body>') ? true : false;
		$dom = new \DOMDocument();
		$dom->loadHTML($html_string);
		
		$nodes = querySelectorAllInDOM( $xpath_query, $dom);
		
		if( !$nodes ){
			return $html_string;
		}

		for($i=0; $i<$nodes->length; $i++){
			$node = $nodes->item($i);
			$node->setAttribute($attribute,$attribute_value);
		}
		
		$dom->saveHTML();
		
		/**
		 * In most scenarios, you'd wanna just grab the contents of the body tag....
		 * ... unless it had a body tag to begin with
		 */
		if( !$has_body_tag ){
			$body = $dom->getElementsByTagName('body');
			$html_string = '';
			foreach ($body as $table)
			{
				$html_string .= innerHTML($table);
			}
		}else{
			$html_string = $dom->saveHTML();
		}
		
		return $html_string;
	}
	
	function setClassInString( String $query, String $newCssClass, String $html_string, bool $replace_class = false ){
		//@todo check if the query is in the jquery format
		$has_body_tag = strpos($html_string, '</body>') ? true : false;
		$dom = new \DOMDocument();
		$dom->loadHTML($html_string);
		setClassInDOM($newCssClass,$dom, $query, $replace_class );
		
		/**
		 * In most scenarios, you'd wanna just grab the contents of the body tag....
		 * ... unless it had a body tag to begin with
		 */
		if( !$has_body_tag ){
			$body = $dom->getElementsByTagName('body');
			$html_string = '';
			foreach ($body as $table)
			{
				$html_string .= innerHTML($table);
			}
		}else{
			$html_string = $dom->saveHTML();
		}
		
		return $html_string;
	}
	
	/**
	 * @description Changes the field container tag from an li to a div
	 *
	 * @author  Jay Hoffmann (modified by Ryan Edwards)
	 *
	 * @source  https://jayhoffmann.com/using-gravity-forms-bootstrap-styles/
	 * @see     https://gist.github.com/rynokins/8089d4d5641edd11fe09cbc50765df7c
	 * @see     wp-content/plugins/gravityforms/form_display.php:2948
	 */
	add_filter( 'gform_field_container', function( $field_container, $field, $form, $css_class, $style, $field_content ) {

		$field_container = str_replace('<li','<div',$field_container);
		$field_container = str_replace('</li>','</div>',$field_container);
		return $field_container;

	}, 10, 6 );
	
	/**
	 * @description adds 'form-group' as a css class to the existing field classes
	 * @see wp-content/plugins/gravityforms/form_display.php:2933
	 */
	add_filter( 'gform_field_css_class', function( $css_class , $field, $form ){

		$css_class = $css_class. ' form-group';
		if( 'medium' !== $field->size ){
			$css_class = 'large' === $field->size ? $css_class. ' form-group-lg' : $css_class;
			$css_class = 'small' === $field->size ? $css_class. ' form-group-sm' : $css_class;
		}
		return $css_class;

	}, MoonBoy\DEFAULT_FILTER_PRIORITY, 3 );
	
	/**
	 * @description Replaces the css class for the validation message with 'alert alert-danger'
	 *
	 * @see wp-content/plugins/gravityforms/form_display.php:954
	 *
	 * @see https://getbootstrap.com/docs/4.0/components/alerts/
	 */
	add_filter( 'gform_validation_message', function( $validation_message, $form  ){
		
		if( !form_submitted() ){
			return $validation_message;
		}

		$validation_message = setClassInString('//div[@class="validation_error"]', 'alert alert-danger', $validation_message );
		return $validation_message;

	}, MoonBoy\DEFAULT_FILTER_PRIORITY, 2 );
	
	/**
	 * @see wp-content/plugins/gravityforms/form_display.php:1105
	 * @todo remove the yellow class
	 */
	add_filter( 'gform_get_form_filter', function($form_string, $form) {

		$form_string = setClassInString('//input[@type="submit"]','btn btn-lg yellow btn-primary',$form_string );
		if( form_submitted() ){
			$form_string = setClassInString( '//div[contains(@class,"gfield")][contains(@class,"gfield_error")]','has-error',$form_string);
		}

		$form_string = str_replace( '<ul', '<div', $form_string);
		$form_string = str_replace( '</ul>', '</div>', $form_string);
		return $form_string;

	}, MoonBoy\DEFAULT_FILTER_PRIORITY, 2 );
	
	
	/**
	 * @see wp-content/plugins/gravityforms/form_display.php:3005
	 */
	add_filter( 'gform_field_content', function( $field_content, $field, $value, $var, $form_id  ){
		
		$label_css_class = 'control-label';
		
		//if innerText of label is empty then set it to empty
		$labels = querySelectorAllInString( '//label[contains(@class,"gfield_label")]',$field_content);
		for( $i=0; $i<$labels->length; $i++ ){
			$label = $labels->item($i);
			if( '*' === $label->textContent || '' === $label->textContent ){
				$label_css_class .= ' empty';
			}
		}
		
		
		$field_content = setClassInString('//label[contains(@class, "gfield_label")]',$label_css_class, $field_content);
		if( form_submitted() ){
			$field_content = setClassInString('//div[contains(@class, "validation_message")]','help-block',$field_content );
		}
		
		$input_css_class = 'form-control';
		
		if( 'small' === $field->size ){
			$input_css_class.= ' input-sm';
		}else if( 'large' === $field->size ){
			$input_css_class.= ' input-lg';
		}
		
		if( 'captcha' !== $field->get_input_type() ){
			$field_content = setClassInString('//*[self::input or self::textarea]', $input_css_class, $field_content );
			$field_content = setAttributeInString('required','required', $field_content, '//*[self::input or self::textarea][@aria-required="true"]' );
		}
		
		return $field_content;
	}, MoonBoy\DEFAULT_FILTER_PRIORITY, 5 );
	
	/**
	 * @description Updates the css class on gravity form confirmation messages
	 * @see wp-content/plugins/gravityforms/form_display.php:1567
	 */
	add_filter( 'gform_confirmation', function ( $confirmation, $form, $lead, $ajax ) {
		
		$confirmation = setClassInString( '//div[contains(@class,"gform_confirmation_message")]','alert alert-success',$confirmation);
		return $confirmation;
		
	}, MoonBoy\DEFAULT_FILTER_PRIORITY, 4 );
}