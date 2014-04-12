<?php
class Checkbook_Checkbook_Block_Form extends Mage_Payment_Block_Form
{
	protected function _construct()
	{
		parent::_construct();
		$this->setTemplate('checkbook/form.phtml');
	}
	
	public function getFinalValue()
    {
        $quote = Mage::getModel('checkout/session')->getQuote();
        $totals = $quote->getTotals();
        return round($totals['grand_total']->_data['value'],2);
    }
	
	public function getCustomerFirstName()
    {
        $quote = Mage::getModel('checkout/session')->getQuote();
        $shippingAddress = $quote->getShippingAddress();
		return $shippingAddress->getfirstname();
    }
	
	public function getCustomerLastName()
    {
        $quote = Mage::getModel('checkout/session')->getQuote();
        $shippingAddress = $quote->getShippingAddress();
		return $shippingAddress->getlastname();
    }
	
	public function getStreetLine1()
	{
		$quote = Mage::getModel('checkout/session')->getQuote();
        $shippingAddress = $quote->getShippingAddress();
		$street = $shippingAddress->getstreet();
		if($street['0']!='') {
			return $street['0'];
		} else {
			return 'Street Line 1';
		}
	}
	
	public function getStreetLine2()
	{
		$quote = Mage::getModel('checkout/session')->getQuote();
        $shippingAddress = $quote->getShippingAddress();
		if($street['1']!='') {
			return $street['1'];
		} else {
			return 'Street Line 2';
		}
	}
	
	public function getCity()
	{
		$quote = Mage::getModel('checkout/session')->getQuote();
        $shippingAddress = $quote->getShippingAddress();
		return $shippingAddress->getcity();
	}
	
	public function getRegion()
	{
		$quote = Mage::getModel('checkout/session')->getQuote();
        $shippingAddress = $quote->getShippingAddress();
		return $shippingAddress->getregion();
	}
	
	public function getPostcode()
	{
		$quote = Mage::getModel('checkout/session')->getQuote();
        $shippingAddress = $quote->getShippingAddress();
		return $shippingAddress->getpostcode();
	}
	
	public function getCustomerEmail()
	{
		$quote = Mage::getModel('checkout/session')->getQuote();
        $shippingAddress = $quote->getShippingAddress();
		return $shippingAddress->getemail();
	}
	
	public function getCountryName()
	{
		$quote = Mage::getModel('checkout/session')->getQuote();
        $shippingAddress = $quote->getShippingAddress();
		$country_id = $shippingAddress->getcountry_id();
		$countryName = Mage::getModel('directory/country')->load($country_id)->getName();
		return $countryName;
	}
	
	public function getItemDescription()
	{
		$quote = Mage::getModel('checkout/session')->getQuote();
        return count($quote->getAllItems()).' Items';
	}
	
	public function getCurrencyCode()
	{
		$quote = Mage::getModel('checkout/session')->getQuote();
        return $quote->getquote_currency_code();
	}
}