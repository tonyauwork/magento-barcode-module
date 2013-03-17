<?php

class ND_Barcodeform_Block_Adminhtml_Form extends Mage_Adminhtml_Block_Template
{

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('nd/barcodeform/form.phtml');
    }
	
	protected function getOrder()
	{
		 return Mage::registry('sales_order');
	}
		
	
}


?>