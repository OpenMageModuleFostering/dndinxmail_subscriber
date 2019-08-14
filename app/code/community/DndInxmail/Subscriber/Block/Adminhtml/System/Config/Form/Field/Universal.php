<?php

/**
 * @category               Module Block
 * @package                DndInxmail_Subscriber
 * @dev                    Alexander Velykzhanin
 * @last_modified          29/07/2015
 * @copyright              Copyright (c) 2015 Flagbit GmbH & Co. KG
 * @author                 Flagbit GmbH & Co. KG : https://www.flagbit.de/
 * @license                http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Block_Adminhtml_System_Config_Form_Field_Universal
    extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{


    protected $_fields = array();


    /**
     * load column config
     *
     * @return Varien_Simplexml_Element
     */
    protected function _loadColumnConfig()
    {
        return new Varien_Simplexml_Element(
            $this->getElement()->getOriginalData('columns')
        );
    }


    /**
     * get Text field renderer
     *
     * @param $field
     * @return null
     */
    protected function _getFieldText($field)
    {
        return null;
    }


    /**
     * get Select field renderer
     *
     * @param $field
     * @return null
     */
    protected function _getFieldSelect($field)
    {
        $sourceModelName =(string) $field->source_model;
        if(empty($sourceModelName)){
            return null;
        }
        $sourceModel = Mage::getModel($sourceModelName);

        $select = $this->getLayout()->createBlock(
            'dndinxmail_subscriber/adminhtml_system_config_form_field_universal_select', '',
            array('is_render_to_js_template' => true)
        );
        $select->setOptions($sourceModel->toOptionArray());
        $select->setClass($field->getName().'_select');

        if(!empty($field->style)){
            $select->setExtraParams('style="'.$field->style.'"');
        }

        return $select;
    }


    /**
     * Prepare to render
     */
    protected function _prepareToRender()
    {

        /* @var $field Varien_Simplexml_Element */
        foreach($this->_loadColumnConfig() as $field){

            $this->addColumn($field->getName(), array(
                    'label'     => Mage::helper('dndinxmail_subscriber')->__((string) $field->label),
                    'style'     => (string) $field->style,
                    'renderer'  => $this->_getFieldRenderer($field)
                ));
        }

        $this->_addAfter = false;
        $_label = $this->getElement()->getOriginalData('button_label');
        if(empty($_label)){
            $_label = 'Add';
        }
        $this->_addButtonLabel = Mage::helper('dndinxmail_subscriber')->__($_label);
    }


    /**
     * get Field renderer
     *
     * @param $field
     * @return null
     */
    protected function _getFieldRenderer($field)
    {
        if(!isset($this->_fields[$field->getName()])){

            $_type = (string) $field->type;
            if(!$_type){
                $_type = 'text';
            }

            $_fieldRenderMethod = '_getField'.ucfirst($_type);
            if(!is_callable(array($this, $_fieldRenderMethod))){
                return null;
            }
            $this->_fields[$field->getName()] = call_user_func(array($this, $_fieldRenderMethod), $field);
        }
        return $this->_fields[$field->getName()];
    }


    /**
     * Prepare existing row data object
     *
     * @param Varien_Object
     */
    protected function _prepareArrayRow(Varien_Object $row)
    {
        /* @var $field Varien_Simplexml_Element */
        foreach($this->_loadColumnConfig() as $field){

            $_type = (string) $field->type;
            if(!$_type || $_type != 'select'){
                continue;
            }

            $row->setData(
                'option_extra_attr_' . $this->_getFieldRenderer($field)->calcOptionHash($row->getData($field->getName())),
                'selected="selected"'
            );
        }
    }
}