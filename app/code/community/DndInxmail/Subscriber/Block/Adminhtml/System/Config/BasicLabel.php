<?php

/**
 * @category               Module Block
 * @package                DndInxmail_Subscriber
 * @dev                    Alexander Velykzhanin
 * @last_modified          13/10/2015
 * @copyright              Copyright (c) 2015 Flagbit GmbH & Co. KG
 * @author                 Flagbit GmbH & Co. KG : https://www.flagbit.de/
 * @license                http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Block_Adminhtml_System_Config_BasicLabel
    extends Mage_Adminhtml_Block_System_Config_Form_Field
    implements Varien_Data_Form_Element_Renderer_Interface
{
    /**
     * Render About html
     *
     * @param Varien_Data_Form_Element_Abstract $element
     *
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $html = '<td class="label">' . $element->getLabel() . '</td>';
        $html .= '<td class="value">' . $this->_getElementHtml($element) . '</td>';

        return $this->_decorateRowHtml($element, $html);
    }
}