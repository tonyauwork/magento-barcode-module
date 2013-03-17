<?php

class ND_Barcodeform_IndexController extends Mage_Adminhtml_Controller_Action
{

	protected function _initOrder()
    {
        $id = $this->getRequest()->getParam('order_id');
        $order = Mage::getModel('sales/order')->load($id);

        if (!$order->getId()) {
            $this->_getSession()->addError($this->__('The order desn\'t exist.'));
            $this->_redirect('*/*/');
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            return false;
        }
        Mage::register('sales_order', $order);
        Mage::register('current_order', $order);
        return $order;
    }
	
	protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('dashboard');
    }	

	public function formAction(){
		if ($order = $this->_initOrder()) {
			echo $this->getLayout()->createBlock('barcodeform/adminhtml_form')->toHtml();	
		}
	}
}