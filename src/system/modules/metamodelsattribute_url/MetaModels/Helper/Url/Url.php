<?php

/**
 * The MetaModels extension allows the creation of multiple collections of custom items,
 * each with its own unique set of selectable attributes, with attribute extendability.
 * The Front-End modules allow you to build powerful listing and filtering of the
 * data in each collection.
 *
 * PHP version 5
 * @package    MetaModels
 * @subpackage AttributeUrl
 * @author     Stefan Heimes <stefan_heimes@hotmail.com>
 * @author     Andreas Isaak <info@andreas-isaak.de>
 * @copyright  The MetaModels team.
 * @license    LGPL.
 * @filesource
 */

namespace MetaModels\Helper\Url;

use DcGeneral\DataDefinition\ContainerInterface;
use MetaModels\Helper\ContaoController;

/**
 * This is the MetaModelAttribute class for handling urls.
 *
 * @package    MetaModels
 * @subpackage AttributeUrl
 * @author     Stefan Heimes <stefan_heimes@hotmail.com>
 * @author     Andreas Isaak <info@andreas-isaak.de>
 */
class Url
{
	protected static $objInstance = null;

	protected function __construct()
	{
	}

	public static function getInstance()
	{
		if (!is_object(self::$objInstance))
		{
			self::$objInstance = new self();
		}

		return self::$objInstance;
	}

	/**
	 * Return the page picker wizard
	 *
	 * ToDo: We should add the right interface here.
	 * @param \DcGeneral\DataDefinition\ContainerInterface $dc
	 *
	 * @return string
	 */
	public function singlePagePicker($dc)
	{
		if(version_compare(VERSION,'3.1', '>=')){
			$currentField = $dc->getEnvironment()->getCurrentModel()->getItem()->get($dc->field);
			return ' <a href="contao/page.php?do='.\Input::get('do').'&amp;table='.$dc->table.'&amp;field='.$dc->field . '_' . ($dc->id ? $dc->id:'b' ) .'&amp;value='.str_replace(array('{{link_url::', '}}'), '', $currentField[1]).'" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['pagepicker']).'" onclick="Backend.getScrollOffset();Backend.openModalSelector({\'width\':765,\'title\':\''.specialchars(str_replace("'", "\\'", $GLOBALS['TL_LANG']['MOD']['page'][0])).'\',\'url\':this.href,\'id\':\'' . $dc->field . '_' . ($dc->id ? $dc->id:'b' ) .'\',\'tag\':\'ctrl_' . $dc->field . '_' . ($dc->id ? $dc->id:'b' ) . '\',\'self\':this});return false">' . \Image::getHtml('pickpage.gif', $GLOBALS['TL_LANG']['MSC']['pagepicker'], 'style="vertical-align:top;cursor:pointer"') . '</a>';
		}
		$strField = 'ctrl_' . $dc->inputName;
		return ' ' . ContaoController::getInstance()->generateImage('pickpage.gif', $GLOBALS['TL_LANG']['MSC']['pagepicker'], 'style="vertical-align:top;cursor:pointer" onclick="Backend.pickPage(\'' . $strField . '\')"');
	}

	/**
	 * Return the page picker wizard
	 *
	 * ToDo: We should add the right interface here.
	 * @param \DcGeneral\DataDefinition\ContainerInterface $dc
	 *
	 * @return string
	 */
	public function multiPagePicker($dc)
	{
		$GLOBALS['TL_CSS']['metamodelsattribute_url'] = 'system/modules/metamodelsattribute_url/html/style.css';
		if(version_compare(VERSION,'3.1', '>=')){
			$currentField = $dc->getEnvironment()->getCurrentModel()->getItem()->get($dc->field);
			return ' <a href="contao/page.php?do='.\Input::get('do').'&amp;table='.$dc->table.'&amp;field='.$dc->field . '_' . ($dc->id ? $dc->id:'b' ) .'_1&amp;value='.str_replace(array('{{link_url::', '}}'), '', $currentField[1]).'" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['pagepicker']).'" onclick="Backend.getScrollOffset();Backend.openModalSelector({\'width\':765,\'title\':\''.specialchars(str_replace("'", "\\'", $GLOBALS['TL_LANG']['MOD']['page'][0])).'\',\'url\':this.href,\'id\':\'' . $dc->field . '_' . ($dc->id ? $dc->id:'b' ) .'_1\',\'tag\':\'ctrl_' . $dc->field . '_' . ($dc->id ? $dc->id:'b' ) . '_1\',\'self\':this});return false">' . \Image::getHtml('pickpage.gif', $GLOBALS['TL_LANG']['MSC']['pagepicker'], 'style="vertical-align:top;cursor:pointer"') . '</a>';
		}
		$strField = 'ctrl_' . $dc->inputName . '_1';
		return ' ' . ContaoController::getInstance()->generateImage('pickpage.gif', $GLOBALS['TL_LANG']['MSC']['pagepicker'], 'style="vertical-align:top;cursor:pointer" onclick="Backend.pickPage(\'' . $strField . '\')"');
	}

}
