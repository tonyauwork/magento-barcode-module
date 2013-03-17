<?php
class ND_Barcodeform_Block_Sales_Order_View extends Mage_Adminhtml_Block_Sales_Order_View
{

    public function __construct()
    {
        parent::__construct();		
		$this->addButton('printbt', array(
			'label'     => Mage::helper('sales')->__('Print Barcode'),
			'onclick'   => 'window.open(\'' . $this->getUrl('barcodeform/index/form') . '\')',
			'class' => 'go',
		));

		
    }

}