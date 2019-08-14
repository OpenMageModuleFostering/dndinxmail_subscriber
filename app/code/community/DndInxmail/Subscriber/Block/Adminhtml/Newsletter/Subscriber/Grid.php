<?php

/**
 * @category               Module Block
 * @package                DndInxmail_Subscriber
 * @dev                    Merlin
 * @last_modified          13/03/2013
 * @copyright              Copyright (c) 2012 Agence Dn'D
 * @author                 Agence Dn'D - Conseil en creation de site e-Commerce Magento : http://www.dnd.fr/
 * @license                http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Block_Adminhtml_Newsletter_Subscriber_Grid extends Mage_Adminhtml_Block_Newsletter_Subscriber_Grid
{

    /**
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn('subscriber_id', array(
            'header' => Mage::helper('newsletter')->__('ID'),
            'index'  => 'subscriber_id'
        ));

        $this->addColumn('email', array(
            'header' => Mage::helper('newsletter')->__('Email'),
            'index'  => 'subscriber_email'
        ));

        $this->addColumn('email_bounced', array(
            'header'         => Mage::helper('newsletter')->__('Email Bounced'),
            'index'          => 'email_bounced',
            'type'           => 'options',
            'options'        => array(
                0 => Mage::helper('dndinxmail_subscriber')->__('No'),
                1 => Mage::helper('dndinxmail_subscriber')->__('Yes')
            ),
            'frame_callback' => array(
                $this,
                'decorateEmailBounced'
            )
        ));

        $this->addColumn('type', array(
            'header'  => Mage::helper('newsletter')->__('Type'),
            'index'   => 'type',
            'type'    => 'options',
            'options' => array(
                1 => Mage::helper('newsletter')->__('Guest'),
                2 => Mage::helper('newsletter')->__('Customer')
            )
        ));

        $this->addColumn('firstname', array(
            'header'  => Mage::helper('newsletter')->__('Customer First Name'),
            'index'   => 'customer_firstname',
            'default' => '----'
        ));

        $this->addColumn('lastname', array(
            'header'  => Mage::helper('newsletter')->__('Customer Last Name'),
            'index'   => 'customer_lastname',
            'default' => '----'
        ));

        $this->addColumn('status', array(
            'header'  => Mage::helper('newsletter')->__('Status'),
            'index'   => 'subscriber_status',
            'type'    => 'options',
            'options' => array(
                Mage_Newsletter_Model_Subscriber::STATUS_NOT_ACTIVE   => Mage::helper('newsletter')->__('Not Activated'),
                Mage_Newsletter_Model_Subscriber::STATUS_SUBSCRIBED   => Mage::helper('newsletter')->__('Subscribed'),
                Mage_Newsletter_Model_Subscriber::STATUS_UNSUBSCRIBED => Mage::helper('newsletter')->__('Unsubscribed'),
                Mage_Newsletter_Model_Subscriber::STATUS_UNCONFIRMED  => Mage::helper('newsletter')->__('Unconfirmed'),
            )
        ));

        $this->addColumn('website', array(
            'header'  => Mage::helper('newsletter')->__('Website'),
            'index'   => 'website_id',
            'type'    => 'options',
            'options' => $this->_getWebsiteOptions()
        ));

        $this->addColumn('group', array(
            'header'  => Mage::helper('newsletter')->__('Store'),
            'index'   => 'group_id',
            'type'    => 'options',
            'options' => $this->_getStoreGroupOptions()
        ));

        $this->addColumn('store', array(
            'header'  => Mage::helper('newsletter')->__('Store View'),
            'index'   => 'store_id',
            'type'    => 'options',
            'options' => $this->_getStoreOptions()
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('customer')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('customer')->__('Excel XML'));

        return Mage_Adminhtml_Block_Widget_Grid::_prepareColumns();
    }

    /**
     * @param $value
     * @param $row
     * @param $column
     * @param $isExport
     *
     * @return string
     */
    public function decorateEmailBounced($value, $row, $column, $isExport)
    {
        if ($row->getEmailBounced()) {
            $cell = '<span class="grid-severity-notice"><span>' . Mage::helper('dndinxmail_subscriber')->__('Yes') . '</span></span>';
        }
        else {
            $cell = '<span class="grid-severity-minor"><span>' . Mage::helper('dndinxmail_subscriber')->__('No') . '</span></span>';
        }

        return $cell;
    }

}
