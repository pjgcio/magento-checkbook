<?php
/*
 * Standard Model File
 *
 * @category   Checkbook
 * @package    Checkbook_Checkbook
 * @author     Abhishek Srivastava <abhisheksrivastava@cedcoss.com>
 */
class Checkbook_Checkbook_Model_Standard extends Mage_Payment_Model_Method_Abstract
{
	protected $_code = 'checkbook';
	protected $_formBlockType = 'checkbook/form';
	//protected $_infoBlockType = 'checkbook/info';
	protected $_isInitializeNeeded      = true;
	protected $_canUseInternal          = false;
	protected $_canUseForMultishipping  = false;
	
	protected $_amount;
	protected $_currency;
	protected $_description;
	protected $_token;
	
	public function getCheckout() {
        return Mage::getSingleton('checkout/session');
    }
	
	public function assignData($data)
	{
		if (!($data instanceof Varien_Object)) {
			$data = new Varien_Object($data);
		}
		//Set Data In Checkout Sessions
		$checkout = $this->getCheckout();
		$checkout->setCheckbookToken($data->gettoken());
		$checkout->setAmount($data->getamount());
		$checkout->setCurrency($data->getcurrency());
		$checkout->setDescription($data->getdescription());
		
		return $this;
	}


	public function validate()
	{
		parent::validate();
		
		$amount = $this->getAmount();
		$currency = $this->getCurrency();
		$description = $this->getDescription();
		$token = $this->getToken();
		if($token == ''){
			$errorCode = 'invalid_data';
			//$errorMsg = $this->_getHelper()->__('Please varify your account.');
		}

		if($errorMsg){
			Mage::throwException($errorMsg);
		}
		return $this;
	}
	
	public function getOrderPlaceRedirectUrl($orderId = 0)
	{
		
        $params['_secure'] = true;
	   	if ($orderId != 0 && is_numeric($orderId)) {
	       $params['order_id'] = $orderId;
	    }
        return Mage::getUrl('checkbook/payonline/index', $params);
	}
}
?>
