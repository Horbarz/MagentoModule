<?php

namespace Neptune\FirstModule\Api;


use Magento\Framework\Exception\AuthenticationException;
use Magento\Framework\Exception\AlreadyExistsException;
/**
 * Neptune Api to get login customer
 */

interface RegisterRepositoryInterface{
	/**
	 *Login a customer
	 *
     *@param string $email
	 *@param string $password
	 *@param string $firstname
	 *@param string $lastname
	 *@return array $data
	 *@throws AlreadyExistsException
	 *@throws AuthenticationException
	 */

	public function register($email, $password, $firstname, $lastname);
}