<?php
/**@package    mage2 ... */
namespace Neptune\FirstModule\Helper;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Pricing\Helper\Data;

class ProductHelper{
    /**
     * @varr Data
     */

    private $priceHelper;

    /**
     * ProductHelper constructor.
     * @param Data $priceHelper
     */

    public function __construct(
        Data $priceHelper
    ){
        $this->priceHelper = $priceHelper;
    }

    public function formatPrice($price){
        return $this->priceHelper->currency($price, true, false);
    }

    public function getProductImagesArray($product){
        /**
         * @var \Magento\Catalog\Model\Product $product
         */
        $images = $product->getMediaGalleryImages();
        $imageArray = array();
        foreach($images as $image){
            /**@var $i \Magento\Catlog\Model\Product\Image */
            $imageArray[] = $image->getUrl();
        }
        return $imageArray;
    }
}