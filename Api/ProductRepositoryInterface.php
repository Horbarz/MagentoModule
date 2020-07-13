<?php

namespace Neptune\FirstModule\Api;

use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Neptune Api to get Product by ID
 */

interface ProductRepositoryInterface{
	/**
	 *Get Product by its ID
	 *
	 *@param int $id
	 *@return \Neptune\FirstModule\Api\Data\ProductInterface
	 *@throws NoSuchEntityException
	 */

	public function getProductById($id);
}