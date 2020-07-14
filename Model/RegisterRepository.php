<?php

namespace Neptune\FirstModule\Model;

use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\AuthenticationException;
use Magento\Customer\Api\AccountManagementInterface;
use Neptune\FirstModule\Api\LoginRepositoryInterface;

class RegisterRepository implements RegisterRepositoryInterface{
    /**
     * @var RequestFactory
     */
    protected $requestFactory;

    /**
     * @var CustomerExtractor
     */
    protected $customerExtractor;

    /**
	 * @var AccountManagementInterface
	 */
    protected $customerAccountManagement;
    
    /**
	 * RegisterRepository constructor.
     * @param RequestFactory $requestFactory
     * @param CustomerExtractor $customerExtractor
	 * @param AccountManagementInterface $customerAccountManagement
	 */

    public function __construct(AccountManagementInterface $customerAccountManagement,
                                    RequestFactory $requestFactory,
                                    CustomerExtractor $customerExtractor,
    ){
        
        $this->customerAccountManagement = $customerAccountManagement;
        $this->requestFactory = $requestFactory;
        $this->customerExtractor = $customerExtractor;
    } 

    /**
	 * Register a user
	 * @param string $email
     * @param string $password
     * @param string $firstname
     * @param string $lastname
	 * @throws AlreadyExistsException
     * @throws AuthenticationException
	 */

    public function register($email, $password, $firstname, $lastname){
        $register = array();
        if($email)
            $register['username'] = $email;
        if($password)
            $register['password'] = $password;
        if($firstname)
            $register['firstname'] = $firstname;
        if($lastname)
            $register['lastname'] = $lastname;
               
        $request = $this->requestFactory->create();
        $request->setParams($register);
        
        if(!empty($register['username']) && 
            !empty($register['password']) &&
            !empty($register['firstname']) &&
            !empty($register['lastname'])){
            try{
                $customer = $this->customerExtractor->extract('customer_account_create', $request);
                $customer = $this->customerAccountManagement
                                ->createAccount($customer, $register['password']);
                $code = 1;
                $data = array('id'=>$customer->getId(),
                            'username'=>$customer->getEmail(),
                            'firstname'=> $customer->getFirstName(),
                            'lastname'=>$customer->getLastName()
            );
            }
            catch(AlreadyExistsException $e){
                $data = __('Invalid login or password.');
                $code = 0;
            }
            catch(AuthenticationException $e){
                $data = __('Invalid login or password.');
                $code = 0;
            }
        }else{
            $data = __('Invalid details.');
            $code = 0;
        }
        $result = array(array('data'=>$data, 'status'=>$code));
        return $result;
    }
}