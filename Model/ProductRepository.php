<?php

namespace Neptune\FirstModule\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Neptune\FirstModule\Api\ProductRepositoryInterface;
use Neptune\FirstModule\Helper\ProductHelper;
use Neptune\FirstModule\Api\Data\ProductInterfaceFactory;


class ProductRepository implements ProductRepositoryInterface{

	/**
	 * @var ProductInterfaceFactory
	 */
	private $productInterfaceFactory;

	/**
	 * @var ProductHelper
	 */
	private $productHelper;

	/**
	 * @var \Magento\Catalog\Api\ProductRepositoryInterface
	 */
	private $productRepository;

	/**
	 * ProductRepository constructor.
	 * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
	 * @param ProductInterfaceFactory $productFactory
	 * @param ProductHelper $productHelper
	 */
	public function __construct(
		\Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
		ProductInterfaceFactory $productInterfaceFactory,
		ProductHelper $productHelper
	){
		$this->productInterfaceFactory = $productInterfaceFactory;
		$this->productHelper = $productHelper;
		$this->productRepository = $productRepository;
	}

	/**
	 * Get Product by its ID
	 * @param int $id
	 * @return \Neptune\FirstModule\Api\Data\ProductInterface
	 * @throws NoSuchEntityException
	 */

	public function getProductById($id){
		/** @var \Neptune\FirstModule\Api\Data\ProductInterface $productInterface */
		$productInterface = $this->productInterfaceFactory->create();
		try {
			/** @var \Magento\Catalog\Api\ProductInterface $product */
			$product = $this->productRepository->getById($id);
			$productInterface->setId($product->getId());
			$productInterface->setSku($product->getSku());
			$productInterface->setName($product->getName());
			$productInterface->setDescription($product->getDescription() ? $product->getDescription() : "");
			$productInterface->setPrice($this->productHelper->formatPrice($product->getPrice()));
			$productInterface->setImages($this->productHelper->getProductImagesArray($product));
			return $productInterface;
		}catch(NoSuchEntityException $e){
			throw NoSuchEntityException::singleField("id",$id);
		}
	}


}