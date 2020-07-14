<?php

namespace Neptune\FirstModule\Api;


use Magento\Framework\Exception\NotFoundException;
/**
 * Neptune Api to get current login customer
 */

interface CurrentUserRepositoryInterface{
	/**
	 *Login a customer
	 *
     *@return array $data
	 *@throws NotFoundException
	 */

	public function getCurrentUser();
}