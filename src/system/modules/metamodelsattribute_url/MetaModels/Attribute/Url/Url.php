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

namespace MetaModels\Attribute\Url;

use MetaModels\Attribute\BaseSimple;
use MetaModels\IMetaModel;

/**
 * This is the MetaModelAttribute class for handling urls.
 *
 * @package    MetaModels
 * @subpackage AttributeUrl
 * @author     Stefan Heimes <stefan_heimes@hotmail.com>
 * @author     Andreas Isaak <info@andreas-isaak.de>
 */
class Url extends BaseSimple
{

	public function __construct(IMetaModel $objMetaModel, $arrData = array())
	{
		if (TL_MODE == 'BE')
		{
			$GLOBALS['TL_CSS']['metamodelsattribute_url'] = 'system/modules/metamodelsattribute_url/html/style.css';
		}

		parent::__construct($objMetaModel, $arrData);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSQLDataType()
	{
		return 'blob NULL';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAttributeSettingNames()
	{
		return array_merge(parent::getAttributeSettingNames(), array(
			'no_external_link',
			'mandatory',
			'trim_title'
		));
	}

	/**
	 * {@inheritdoc}
	 */
	public function valueToWidget($varValue)
	{
		if ($this->get('trim_title') && is_array($varValue))
		{
			$varValue = $varValue[1];
		}

		return parent::valueToWidget($varValue);
	}

	/**
	 * {@inheritdoc}
	 */
	public function widgetToValue($varValue, $intId)
	{
		if ($this->get('trim_title') && !is_array($varValue))
		{
			$varValue = array(0 => '', 1 => $varValue);
		}

		return parent::widgetToValue($varValue, $intId);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getFieldDefinition($arrOverrides = array())
	{
		$arrFieldDef = parent::getFieldDefinition($arrOverrides);

		$arrFieldDef['inputType'] = 'text';
		$arrFieldDef['eval']['tl_class'] .= ' wizard inline';
		$arrFieldDef['wizard']['pagePicker'] = array('MetaModels\Helper\Url\Url', 'singlePagePicker');

		if (!$this->get('trim_title'))
		{
			$arrFieldDef['eval']['size'] = 2;
			$arrFieldDef['eval']['multiple'] = true;
			$arrFieldDef['eval']['tl_class'] .= ' metamodelsattribute_url';
			$arrFieldDef['wizard']['pagePicker'] = array('MetaModels\Helper\Url\Url', 'multiPagePicker');
		}

		return $arrFieldDef;
	}
}
