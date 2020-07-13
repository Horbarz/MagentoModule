<?php

namespace Neptune\FirstModule\Api\Data;

interface LoginInterface{
    /**
	 *@return int
	 */
	public function getId();

	/**
	 *@param int $id
	 *@return $this
	 */
	public function setId($id);

	/**
	 *@return string
	 */
	public function getUsername();

	/**
	 *@param string $username
	 *@return $this
	 */
	public function setUsername($username);
}