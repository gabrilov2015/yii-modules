<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\helpers;

/**
 * Html provides a set of static methods for generating commonly used HTML tags.
 *
 * Nearly all of the methods in this class allow setting additional html attributes for the html
 * tags they generate. You can specify for example. 'class', 'style'  or 'id' for an html element
 * using the `$options` parameter. See the documentation of the [[tag()]] method for more details.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Html extends BaseHtml
{
	public static function mDropDownList($name, $labelDropdown = '',$selection = null, $items = [], $options = [])
    {
		if(isset($options['dropdown_type']) && $options['dropdown_type'] == 'normal'){
			return static::DropDownList($name,$selection,$items,$options);
		}
        $selectOptions = static::renderMSelectOptions($name, $selection, $items);
		if(isset($options['class']) && strpos($options['class'], 'multiple-dropdown') === FALSE){
			$options['class'] .= ' multiple-dropdown ';
		}elseif(!isset($options['class'])){
			$options['class'] = ' multiple-dropdown ';
		}
		if(!empty($labelDropdown)){
			$labelDropdown = static::tag('label', $labelDropdown);
		}
        return static::tag('div', $labelDropdown . ' ' . static::tag('ul', "\n" . $selectOptions . "\n"), $options);
    }
	
	public static function renderMSelectOptions($name, $selection, $items)
    {
        $lines = [];

        foreach ($items as $key => $value) {
			if(in_array($key,$selection)){
				$options['checked'] = true;
			} else { 
				$options['checked'] = false;
			}
			$lines[$key] = static::tag('li', static::input('checkbox', $name, $value, $options) . ' ' . $value);
        }

        return implode("\n", $lines);
    }
	
	public static function eDropDownList($name, $labelDropdown = '', $selection = null, $items = [], $options = [])
    {
        $selectOptions = static::renderESelectOptions($items);
		if(isset($options['class']) && strpos($options['class'], 'editable-dropdown') === FALSE){
			$options['class'] .= ' editable-dropdown ';
		}elseif(!isset($options['class'])){
			$options['class'] = ' editable-dropdown ';
		}
		if(!empty($labelDropdown)){
			$labelDropdown = static::tag('label', $labelDropdown);
		}
        return static::tag('div', $labelDropdown . ' ' . static::tag('div', '<span class="select-arrow"></span> ' . static::input('text', $name, $selection) . ' ' . static::tag('ul', "\n" . $selectOptions . "\n", ['style'=>'display:none;']),['class'=>'selection-list']), $options);
    }
	
	public static function renderESelectOptions($items)
    {
        $lines = [];

        foreach ($items as $key => $value) {
			$lines[$key] = static::tag('li', $value);
        }

        return implode("\n", $lines);
    }
	
	public static function autoCompleteInput($name, $ajaxUrl, $labelInput = '', $items = [], $options = []){
		if(!empty($labelInput)){
			$labelInput = static::tag('label', $labelInput);
		}
		if(isset($options['class']) && strpos($options['class'], 'editable-dropdown') === FALSE){
			$options['class'] .= ' autocomplete-box ';
		}elseif(!isset($options['class'])){
			$options['class'] = ' autocomplete-box ';
		}
		//$options['data-url'] = $ajaxUrl;
		$renderInputs = static::renderInputs($name, $items);
		$json = file_get_contents($ajaxUrl);
		$data_items = json_decode($json);
		$autoCompleteOptions = static::renderAutoCompleteOptions($data_items);
		return static::tag('div', $labelInput . ' ' . static::tag('div', $renderInputs . ' ' . static::input('text', $name.'[]','',['class'=>'at-input']) . ' ' . static::tag('ul', "\n" . $autoCompleteOptions . "\n", ['style'=>'display:none;','data-name'=>$name.'[]'])), $options);
	}
	
	public static function renderInputs($name, $items)
    {
        $lines = [];

        foreach ($items as $key => $item) {
			$lines[$key] = static::tag('div', static::input('text', $name.'['.$item['id'].']', $item['value'],['readonly'=>'readonly']) . '<span>&times;</span>', ['class'=>'tag','style'=>'background-color:#'.$item['color']]);
        }

        return implode("\n", $lines);
    }
	
	public static function renderAutoCompleteOptions($items)
    {
        $lines = [];

        foreach ($items as $key => $item) {
			$lines[$key] = static::tag('li', $item->value, ['id'=> 'tag-'.$item->id,'data-color'=>$item->color]);
        }

        return implode("\n", $lines);
    }
}
