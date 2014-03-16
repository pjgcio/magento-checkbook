<?php
class Checkbook_Model_Checkbook extends Mage_Payment_Model_Method_Abstract
{
	protected $_code = 'checkbook';
	protected $_formBlockType = 'checkbook/form_checkbook';
	protected $_infoBlockType = 'pcheckbookay/info_checkbook';

	public function assignData($data)
	{
		if (!($data instanceof Varien_Object)) {
			$data = new Varien_Object($data);
		}
		$info = $this->getInfoInstance();
		$info->setCheckNo($data->getCheckNo())
		->setCheckDate($data->getCheckDate());
		return $this;
	}


	public function validate()
	{
		parent::validate();

		$info = $this->getInfoInstance();

		$no = $info->getCheckNo();
		$date = $info->getCheckDate();
		if(empty($no) || empty($date)){
			$errorCode = 'invalid_data';
			$errorMsg = $this->_getHelper()->__('Check No and Date are required fields');
		}

		if($errorMsg){
			Mage::throwException($errorMsg);
		}


		return $this;
	}
}
?>
