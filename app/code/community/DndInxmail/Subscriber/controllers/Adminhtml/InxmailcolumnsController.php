<?php

/**
 * @category               Module Controller
 * @package                DndInxmail_Subscriber
 * @dev                    Merlin
 * @last_modified          13/03/2013
 * @copyright              Copyright (c) 2012 Agence Dn'D
 * @author                 Agence Dn'D - Conseil en creation de site e-Commerce Magento : http://www.dnd.fr/
 * @license                http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Adminhtml_InxmailcolumnsController extends Mage_Adminhtml_Controller_Action
{

    /**
     * @return $this
     */
    protected function _initAction()
    {
        $this->loadLayout()->_addBreadcrumb(Mage::helper('adminhtml')->__('Create Inxmail columns'), Mage::helper('adminhtml')->__('Create Inxmail columns'));

        return $this;
    }

    /**
     *
     */
    public function indexAction()
    {
        $this->_forward('new');
    }

    /**
     *
     */
    public function newAction()
    {
        $this->_initAction()->renderLayout();
    }

    /**
     * Create a new column in Inxmail
     *
     * @return boolean
     */
    public function createAction()
    {
        $synchronize = Mage::helper('dndinxmail_subscriber/synchronize');

        if (!$session = $synchronize->openInxmailSession()) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dndinxmail_subscriber')->__('Inxmail session does not exist'));
            $this->_redirect('*/*/new');

            return false;
        }

        $post = $this->getRequest()->getPost();

        if (!$post) {
            $synchronize->closeInxmailSession();
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dndinxmail_subscriber')->__('No post data'));
            $this->_redirect('*/*/new');

            return false;
        }

        $namePostData       = $post['column_name'];
        $textLengthPostData = $post['column_length'];
        $typePostData       = $post['column_type'];

        $name   = ($namePostData != '' && $namePostData != null) ? $namePostData : 'Default';
        $length = ($textLengthPostData != '' && $textLengthPostData != null) ? $textLengthPostData : 80;
        $type   = ($typePostData != '' && $typePostData != null) ? $typePostData : 'col_text';

        switch ($type) {

            case 'col_text':
                $inxmailType = Inx_Api_Recipient_Attribute::DATA_TYPE_STRING;
                break;

            case 'col_date_time':
                $inxmailType = Inx_Api_Recipient_Attribute::DATA_TYPE_DATETIME;
                break;

            case 'col_date':
                $inxmailType = Inx_Api_Recipient_Attribute::DATA_TYPE_DATE;
                break;

            case 'col_time':
                $inxmailType = Inx_Api_Recipient_Attribute::DATA_TYPE_TIME;
                break;

            case 'col_int':
                $inxmailType = Inx_Api_Recipient_Attribute::DATA_TYPE_INTEGER;
                break;

            case 'col_float':
                $inxmailType = Inx_Api_Recipient_Attribute::DATA_TYPE_DOUBLE;
                break;

            case 'col_yesno':
                $inxmailType = Inx_Api_Recipient_Attribute::DATA_TYPE_BOOLEAN;
                break;

            default:
                $inxmailType = Inx_Api_Recipient_Attribute::DATA_TYPE_STRING;
                break;

        }

        try {
            $result = $session->getAttributeManager()->create($name, $inxmailType, (int)$length);

            if ($result <= 0) {
                $message = Mage::helper('dndinxmail_subscriber')->__('Column %s already exist in Inxmail', $name);
                throw new Exception($message);
            }

            $message = Mage::helper('dndinxmail_subscriber')->__('Column %s successfully created in Inxmail', $name);
            Mage::getSingleton('adminhtml/session')->addSuccess($message);
            $synchronize->closeInxmailSession();
            $this->_redirect('*/*/new');

            return true;
        }
        catch (Exception $e) {
            $synchronize->closeInxmailSession();
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            $this->_redirect('*/*/new');

            return false;
        }
    }

}