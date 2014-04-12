<?php
/**
 * Checkbook Payment Module
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Checkbook
 * @package    Checkbook_Checkbook
 * @author     Abhishek Srivastava <abhisheksrivastava@cedcoss.com>
 */

/**
 * 
 * Checkbook Payonline Controller
 *
 */
class Checkbook_Checkbook_PayonlineController extends Mage_Core_Controller_Front_Action
{
	/**
     * Return Checkout Object
     *
     * @return Mage_Checkout_Model_Session
     */
    public function getCheckout()
    {
        return Mage::getSingleton('checkout/session');
    }
	
    public function indexAction() {
		$secret_key = Mage::getStoreConfig('payment/checkbook/secret_key');
		$charge_endpoint_url = Mage::getStoreConfig('payment/checkbook/endpoint');
		
		$this->loadLayout();
        $session = $this->getCheckout();
        $lastOrderId = $session->getLastOrderId();

		//Code To Call API.
		$token = $session->getCheckbookToken();
		$amount = $session->getAmount(); //Amount to be charged
		$currency = $session->getCurrency();
		$description = $session->getDescription();

		$session->unsCheckbookToken();
		$session->unsAmount();
		$session->unsCurrency();
		$session->unsDescription();

		$options = array(
		  'http'=>array(
			'method'=>"POST",
			'header'=>
			  "Accept-language: en\r\n".
			  "Content-type: application/x-www-form-urlencoded\r\n",
			'content'=>http_build_query(
				array(            
					'key'=> $secret_key,
					'token'=> $token,
					'amount' => $amount,
					'currency' => $currency,
					'description' => $description

				),'','&'
			)
		));
		$context = stream_context_create($options);
		$refno = file_get_contents($charge_endpoint_url,false,$context);
		$pos = strpos($refno, "SUCCESS");
		$response = json_decode($refno);
		if($response->status == 'SUCCESS') {
			$session->addSuccess(Mage::helper('checkbook')->__($response->error));
		} else {
			$session->addError(Mage::helper('checkbook')->__($response->error));
		}
		//End Of Code.
        Mage::dispatchEvent('checkout_onepage_controller_success_action', array('order_ids' => array($lastOrderId)));
        $this->renderLayout();
        return $this->_redirect('checkout/onepage/success', array('_secure'=>true));
    }
}