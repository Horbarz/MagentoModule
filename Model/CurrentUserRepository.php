<?php

namespace Neptune\FirstModule\Model;

use Magento\Framework\Exception\NotFoundException;
use Neptune\FirstModule\Api\CurrentUserRepositoryInterface;
use Magento\Customer\Model\Session;

class CurrentUserRepository extends \Magento\Customer\Controller\AbstractAccount implements CurrentUserRepositoryInterface{

    /**
    * @var \Magento\Customer\Model\Session
    */
    protected $_customerSession;

    /**
    * @var \Magento\Integration\Model\Oauth\TokenFactory
    */
    protected $_tokenModelFactory;
    

    public function __construct(Session $customerSession,
    \Magento\Integration\Model\Oauth\TokenFactory $tokenModelFactory)
    {
        $this->_customerSession = $customerSession;
        $this->_tokenModelFactory = $tokenModelFactory;
    } 

    /**
	 * Get current logged in user
     * @throws NotFoundException
	 */

    public function getCurrentUser(){
        $currentUser = array();
        $customerToken = $this->_tokenModelFactory->create();
        try{
            $customerId = $this->_customerSession->getCustomer()->getId();
            $tokenKey = $customerToken->createCustomerToken($customerId)->getToken();
            $currentUser['id'] = $customerId;
            $currentUser['token'] = $tokenKey;
            $error = false;
        }catch(NotFoundException $e){
            $currentUser = __('User not found.');
            $error = true;
        }
        return array(array('data'=>$currentUser, 'error'=>$error))

        
    }
}