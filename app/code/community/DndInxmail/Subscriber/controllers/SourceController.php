<?php

/**
 * @category                Module Controller
 * @package                 DndInxmail_Subscriber
 * @dev                     Barracuda
 * @last_modified           13/03/2012
 * @copyright               Copyright (c) 2012 Agence Dn'D
 * @author                  Agence Dn'D - Conseil en creation de site e-Commerce Magento : http://www.dnd.fr/
 * @license                 http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_SourceController extends Mage_Core_Controller_Front_Action
{

    /**
     * Get XML for one product with the ID in the URL
     *
     * @return boolean
     */
    public function productAction()
    {
        $productId  = $this->getRequest()->getParam("id");
        $productSku = $this->getRequest()->getParam("sku");

        if ($productId || $productSku) {
            $product = ($productId) ? Mage::getModel("catalog/product")->load($productId) : Mage::getModel("catalog/product")->loadByAttribute('sku', $productSku);
        }
        else {
            echo $this->__('Product ID or SKU not found in the URL');

            return false;
        }

        if (!$product || !$product->getId()) {
            echo $this->__('No Product found');

            return false;
        }

        $width  = Mage::getStoreConfig("dndinxmail_subscriber_datasource/feed_oneproduct/img_width");
        $height = Mage::getStoreConfig("dndinxmail_subscriber_datasource/feed_oneproduct/img_height");

        if (!is_numeric($height) || !is_numeric($width)) {
            echo $this->__('Image width and height must be integers');

            return false;
        }

        $this->loadLayout(false);
        Mage::app()->getResponse()->setHeader('Content-Type', 'text/xml', true);
        $result = Mage::getModel('dndinxmail_subscriber/xml')->getProductXml($product, 'oneproduct');
        Mage::app()->getResponse()->setBody($result);
        $this->renderLayout();

        return true;
    }

    /**
     * Get XML for a list of 3 products. Product was filtered by a type choosen in the URL.
     *
     * @return boolean
     */
    public function listAction()
    {
        $type          = $this->getRequest()->getParam("type");
        $nbParam       = $this->getRequest()->getParam("nb");
        $storeId       = Mage::app()->getStore()->getId();
        $typeAvailable = array(
            'random',
            'new',
            'bestsell',
            'attribute',
            'category'
        );
        $nb            = ($nbParam) ? $nbParam : Mage::getStoreConfig("dndinxmail_subscriber_datasource/feed_$type/nb");

        if (!$type) {
            echo $this->__('Type was not found in the URL');

            return false;
        }

        if (!in_array($type, $typeAvailable)) {
            echo $this->__('Type is not valid');

            return false;
        }

        if (!is_numeric($nb)) {
            echo $this->__('Number parameter must be an integer');

            return false;
        }

        $products = Mage::getResourceModel('catalog/product_collection')->addStoreFilter($storeId)->addAttributeToFilter('status', 1)->addAttributeToFilter('visibility', array('in' => Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH));

        switch ($type) {

            case 'random':
                $products = $products->setPageSize($nb);
                $products->getSelect()->order(new Zend_Db_Expr('RAND()'));
                break;

            case 'new':
                $products->addAttributeToSort('created_at', 'desc')->setPageSize($nb);
                break;

            case 'bestsell':
                $products = Mage::getResourceModel('reports/product_collection')->addAttributeToSelect('*')->addOrderedQty()->setStoreId($storeId)->addStoreFilter($storeId)->addAttributeToSort('ordered_qty', 'desc')->setPageSize($nb);
                $products->load();
                break;

            case 'attribute':
                $attribute = $this->getRequest()->getParam("code");
                $value     = $this->getRequest()->getParam("value");
                $products->addAttributeToFilter("$attribute", "$value")->setPageSize($nb);
                break;

            case 'category':
                $categoryID = $this->getRequest()->getParam("id");
                $category   = Mage::getModel("catalog/category")->load($categoryID);
                $products->addCategoryFilter($category)->setPageSize($nb);
                break;

        }

        if (count($products) < $nb) {
            echo $this->__('Not enough products');

            return false;
        }

        $this->loadLayout(false);
        Mage::app()->getResponse()->setHeader('Content-Type', 'text/xml', true);
        $result = Mage::getModel('dndinxmail_subscriber/xml')->getListProductsXml($products, $type);
        Mage::app()->getResponse()->setBody($result);
        $this->renderLayout();

        return true;
    }

    /**
     * Get last bought products for specific customer
     *
     * @author Merlin
     *
     * @return boolean
     */
    public function lastBoughtProductsAction()
    {
        $type       = 'lastbought';
        $customerId = $this->getRequest()->getParam("id");
        $nb         = Mage::getStoreConfig("dndinxmail_subscriber_datasource/feed_$type/nb");

        if (!$customerId) {
            echo $this->__('Customer ID not found in the URL');

            return false;
        }

        $customer = Mage::getModel('customer/customer')->load($customerId);

        if (!$customer instanceof Varien_Object || !$customer->getId()) {
            echo $this->__('The customer with ID %s does not exist.', $customerId);

            return false;
        }

        $order = Mage::getResourceModel('sales/order_collection')->addFieldToFilter('customer_id', $customerId)->addAttributeToSort('created_at', 'DESC')->setPageSize($nb);

        if (!$order->getId()) {
            echo $this->__('Customer with ID %s does not have order yet', $customerId);

            return false;
        }

        $items = $order->getAllItems();

        if (count($items) <= 0) {
            echo $this->__('Order with ID %s does not have item', $order->getId());

            return false;
        }

        $products = array();
        foreach ($items as $item) {
            $productId = $item->getProductId();
            $product   = Mage::getModel('catalog/product')->load($productId);
            if (!$product instanceof Varien_Object || !$product->getId()) continue;
            $products[] = $product;
        }

        $this->loadLayout(false);
        Mage::app()->getResponse()->setHeader('Content-Type', 'text/xml', true);
        $result = Mage::getModel('dndinxmail_subscriber/xml')->getListProductsXml($products, $type);
        Mage::app()->getResponse()->setBody($result);
        $this->renderLayout();

        return true;
    }

    /**
     * Get related products
     *
     * @return boolean
     */
    public function relatedAction()
    {
        $productId  = $this->getRequest()->getParam("id");
        $productSku = $this->getRequest()->getParam("sku");
        $type       = 'related';

        if (!$productId && !$productSku) {
            echo $this->__('Product ID or SKU not found in the URL');

            return false;
        }

        $product = ($productId) ? Mage::getModel("catalog/product")->load($productId) : Mage::getModel("catalog/product")->loadByAttribute('sku', $productSku);

        if (!$product instanceof Varien_Object || !$product->getId()) {
            echo $this->__('The product with ID %s does not exist.', $productId);

            return false;
        }

        $collection = $product->getRelatedProductCollection()->addAttributeToSelect('required_options')->setPositionOrder()->addStoreFilter();

        if (Mage::helper('catalog')->isModuleEnabled('Mage_Checkout')) {
            $collection->addMinimalPrice()->addFinalPrice()->addTaxPercents()->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())->addUrlRewrite();
        }

        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);

        $collection->load();

        $products = array();
        foreach ($collection as $product) {
            $product->setDoNotUseCategoryId(true);
            $products[] = $product;
        }

        $this->loadLayout(false);
        Mage::app()->getResponse()->setHeader('Content-Type', 'text/xml', true);
        $result = Mage::getModel('dndinxmail_subscriber/xml')->getListProductsXml($products, $type);
        Mage::app()->getResponse()->setBody($result);
        $this->renderLayout();

        return true;
    }

}