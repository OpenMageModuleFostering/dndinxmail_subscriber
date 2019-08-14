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
        $category    = Mage::getModel("catalog/category")->load($categoryIds[0]);

        $xml = str_replace('{{product_category}}', htmlspecialchars($category->getName()), $xml);
        $xml = str_replace('{{product_id}}', htmlspecialchars($product->getId()), $xml);
        $xml = str_replace('{{product_name}}', htmlspecialchars($product->getName()), $xml);
        $xml = str_replace('{{product_brand}}', htmlspecialchars($product->getManufacturer()), $xml);
        $xml = str_replace('{{product_description}}', htmlspecialchars($product->getShortDescription()), $xml);
        $xml = str_replace('{{product_url}}', htmlspecialchars($product->getProductUrl()), $xml);
        $xml = str_replace('{{product_sku}}', htmlspecialchars($product->getSku()), $xml);
        $xml = str_replace('{{product_image}}', htmlspecialchars(Mage::helper('catalog/image')->init($product, 'image')->resize($iw, $ih)->__toString()), $xml);
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