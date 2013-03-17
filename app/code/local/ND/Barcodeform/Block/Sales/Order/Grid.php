<?php
class ND_Barcodeform_Block_Sales_Order_Grid extends Mage_Adminhtml_Block_Sales_Order_Grid
{
    protected function _prepareColumns()
    {
	    if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
			$this->addColumn('barcode_form',
                array(
                    'header'    => Mage::helper('sales')->__('Barcode'),
                    'width'     => '50px',
                    'type'      => 'action',
                    'getter'     => 'getId',
                    'actions'   => array(
                        array(
                            'caption' => Mage::helper('sales')->__('Print'),
                            'url'     => array('base'=>'barcodeform/index/form/'),
                            'field'   => 'order_id',
							'target' => 'order_id'
							
                        )
                    ),
                    'filter'    => false,
                    'sortable'  => false,
                    'index'     => 'stores',
                    'is_system' => true,
            ));
			$this->addColumnsOrder('barcode_form', 'action');
		}
        return parent::_prepareColumns();
    }
}