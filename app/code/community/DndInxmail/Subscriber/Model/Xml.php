<?php

/**
 * @category                Module Model
 * @package                 DndInxmail_Subscriber
 * @dev                     Barracuda
 * @last_modified           13/03/2012
 * @copyright               Copyright (c) 2012 Agence Dn'D
 * @author                  Agence Dn'D - Conseil en creation de site e-Commerce Magento : http://www.dnd.fr/
 * @license                 http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Model_Xml extends Mage_Core_Model_Abstract
{

    /**
     * Get XML product for one product
     *
     * @param object $product
     * @param string $type
     *
     * @return string $xml
     */
    public function getProductXml($product, $type)
    {
        $xml = $this->getStructureProductXml();
        $iw  = Mage::getStoreConfig("dndinxmail_subscriber_datasource/feed_$type/img_width");
        $ih  = Mage::getStoreConfig("dndinxmail_subscriber_datasource/feed_$type/img_height");

        $categoryIds = $product->getCategoryIds();
        $categoryId = null;
        if (isset($categoryIds[0])) {
            $categoryId = $categoryIds[0];
        }
        $category    = Mage::getModel("catalog/category")->load($categoryId);

        $imagePath = $this->_getProductImagePath($product, $iw, $ih);

        $xml = str_replace('{{product_category}}', htmlspecialchars($category->getName()), $xml);
        $xml = str_replace('{{product_id}}', htmlspecialchars($product->getId()), $xml);
        $xml = str_replace('{{product_name}}', htmlspecialchars($product->getName()), $xml);
        $xml = str_replace('{{product_brand}}', htmlspecialchars($product->getManufacturer()), $xml);
        $xml = str_replace('{{product_description}}', htmlspecialchars($product->getShortDescription()), $xml);
        $xml = str_replace('{{product_url}}', htmlspecialchars($product->getProductUrl()), $xml);
        $xml = str_replace('{{product_sku}}', htmlspecialchars($product->getSku()), $xml);
        $xml = str_replace('{{product_image}}', htmlspecialchars($imagePath), $xml);
        $xml = str_replace('{{product_price}}', htmlspecialchars(Mage::helper('tax')->getPrice($product, $product->getFinalPrice(), true)), $xml);
        $xml = str_replace('{{product_currency}}', htmlspecialchars(Mage::getStoreConfig('currency/options/default')), $xml);

        $attributes = array_filter(explode(",", Mage::getStoreConfig("dndinxmail_subscriber_datasource/feed_$type/attributes")));

        $xmlAttr = "";

        if (count($attributes) != 0) {
            foreach ($attributes as $attributeCode) {
                $attribute = $product->getResource()->getAttribute($attributeCode);
                if (!$attribute) {
                    continue;
                }
                $xmlAttr .= "<" . ucfirst($attributeCode) . ">" . htmlspecialchars($product->getAttributeText($attributeCode)) . "</" . ucfirst($attributeCode) . ">";
            }
        }

        $xml = str_replace('{{specificAttribute}}', $xmlAttr, $xml);

        return $xml;
    }

    /**
     * @param $product
     * @param $width
     * @param $height
     *
     * @return string
     */
    protected function _getProductImagePath($product, $width, $height)
    {
        $imagePath = Mage::helper('catalog/image')->init($product, 'image')->resize($width, $height)->__toString();
        $inxmailImagesFolder = trim(Mage::helper('dndinxmail_subscriber/config')->getInxmailImagesFolder(), ' /');

        $mediaConfigHelper = Mage::getSingleton('catalog/product_media_config');
        $unrequiredPath    = $mediaConfigHelper->getBaseMediaUrl() . '/cache';
        $cleanUri          = ltrim(str_ireplace($unrequiredPath, '', $imagePath), '/');

        $inxmailUri      = $inxmailImagesFolder . '/' . $this->_transformToUrl($cleanUri);
        $inxmailUrl      = Mage::getBaseUrl('media') . $inxmailUri;
        $inxmailUriPath  = $inxmailImagesFolder . DS . $this->_transformToPath($cleanUri);
        $inxmailFilePath = Mage::getBaseDir('media') . DS . $inxmailUriPath;
        if (file_exists($inxmailFilePath)) {
            return $inxmailUrl;
        }

        $magentoFilePath = $mediaConfigHelper->getBaseMediaPath() . DS . 'cache' . DS . $cleanUri;

        try {
            if (file_exists($magentoFilePath)) {
                $info = pathinfo($inxmailFilePath);
                $dir = $info['dirname'];
                if(!is_writable($dir) ) {
                    $io = new Varien_Io_File();
                    $io->mkdir($dir);
                }
                copy($magentoFilePath, $inxmailFilePath);
                Mage::helper('core/file_storage_database')->saveFile($inxmailUri);
                return $inxmailUrl;
            }
        } catch (Exception $e) {
            Mage::helper('dndinxmail_subscriber/log')->logExceptionData($e);
            Mage::logException($e);
        }

        return $imagePath;
    }

    /**
     * @param $url
     *
     * @return mixed
     */
    protected function _transformToPath($url)
    {
        return str_replace('/', DS, $url);
    }

    /**
     * @param $path
     *
     * @return mixed
     */
    protected function _transformToUrl($path)
    {
        return str_replace(DS, '/', $path);
    }

    /**
     * Get XML product for a list of products
     *
     * @param object $products
     *
     * @return string $xml
     */
    public function getListProductsXml($products, $type)
    {
        $xml = '<Offers>';

        foreach ($products as $product) {
            $product = Mage::getModel("catalog/product")->load($product->getId());
            $xml .= $this->getProductXml($product, $type);
        }

        $xml .= '</Offers>';

        return $xml;
    }


    /**
     * Get the XML structure
     *
     * @return string $xml
     */
    public function getStructureProductXml()
    {
        $xml = '<Offer>
					<MerchantCategory>{{product_category}}</MerchantCategory>
					<OfferID>{{product_id}}</OfferID>
					<Name>{{product_name}}</Name>
					<Brand>{{product_brand}}</Brand>
					<Description>{{product_description}}</Description>
					<DeepLink>{{product_url}}</DeepLink>
					<ProductID>{{product_sku}}</ProductID>
					<ImageUrl>{{product_image}}</ImageUrl>
					<Prices>{{product_price}}</Prices>
					<Currency>{{product_currency}}</Currency>
					{{specificAttribute}}
				</Offer>';

        return $xml;
    }

}