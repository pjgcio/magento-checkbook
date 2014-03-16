<?php
class Checkbook_Block_Form_Checkbook extends Mage_Payment_Block_Form
{
	protected function _construct()
	{
		parent::_construct();
		$this->setTemplate('checkbook/form/checkbook.phtml');
	}
}