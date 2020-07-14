<?php

namespace Neptune\FirstModule\Model;

use Magento\Framework\Exception\EmailNotConfirmedException;
use Magento\Framework\Exception\AuthenticationException;
use Magento\Customer\Api\AccountManagementInterface;
use Neptune\FirstModule\Api\LoginRepositoryInterface;

class LoginRepository implements LoginRepositoryInterface{

    /**
	 * @var AccountManagementInterface
	 */
    protected $customerAccountManagement;
    
    /**
	 * LoginRepository constructor.
	 * @param AccountManagementInterface $customerAccountManagement
	 */

    public function __construct(AccountManagementInterface $customerAccountManagement){
        $this->customerAccountManagement = $customerAccountManagement;
    } 

    /**
	 * Get Product by its ID
	 * @param string $email
     * @param string $password
	 * @throws EmailNotConfirmedException
     * @throws AuthenticationException
	 */

    public function login($email, $password){
        $login = array();
        if($email)
            $login['username'] = $email;
        if($password)
            $login['password'] = $password;
        
        if(!empty($login['username']) && !empty($login['password'])){
            try{
                $customer = $this->customerAccountManagement
                                ->authenticate($login['username'], $login['password']);
                $error = false;
                $data = array('id'=>$customer->getId(),
                            'username'=>$customer->getEmail(),
                            'name'=>ucwords($customer->getFirstName().' '. $customer->getLastName())
            );
            }catch(EmailNotConfirmedException $e){
                $value = $this->customerUrl->getEmailConfirmationUrl($login['username']);
                $data = __(
                    'This account is not confirmed.'.'<a href="%1">Click here</a> to resend confirmation mail.'. $value
                );
                $error = array('status'=>0,'data'=>$data);
            }catch(AuthenticationException $e){
                $data = __('Invalid login or password.');
                $error = true;
            }
        }else{
            $data = __('Invalid login or password.');
            $error = true;
        }
        $result = array(array('data'=>$data, 'error'=>$error));
        return $result;
    }
}