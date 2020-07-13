<?php

namespace Neptune\FirstModule\Model\Data;

use Neptune\FirstModule\Api\Data\LoginInterface;
use Magento\Framework\DataObject;

class Login extends DataObject implements LoginInterface
{
	/**
	 *@return int
	 */
	public function getId(){
		return $this->getData('id');
	}

	/**
	 *@param int $id
	 *@return $this
	 */
	public function setId($id){
		return $this->setData('id',$id);
	}

	/**
	 *@return string
	 */
	public function getUsername(){
		return $this->getData('username');
	}

	/**
	 *@param string $sku
	 *@return $this
	 */
	public function setUsername($username){
		return $this->setData('username',$username);
	}

}