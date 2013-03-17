<?php

class ND_Barcodeform_Model_Resource_Eav_Mysql4_Setup extends Mage_Eav_Model_Entity_Setup
{
	/**
     * @return array
     */
    public function getDefaultEntities()
    {
		//add barcode info to product
        return array(
            'catalog_product' => array(				
                'entity_model'      => 'catalog/product',
                'attribute_model'   => 'catalog/resource_eav_attribute',
                'table'             => 'catalog/product',
				'additional_attribute_table' => 'catalog/eav_attribute',
                'entity_attribute_collection' => 'catalog/product_attribute_collection',
                'attributes'        => array(
                    'myattribcode' => array(
                        'group'             => 'General',
                        'label'             => 'Barcode',
                        'type'              => Varien_Db_Ddl_Table::TYPE_VARCHAR,
                        'input'             => 'text',
                        'default'           => '0',
                        'class'             => '',
                        'backend'           => '',
                        'frontend'          => '',
                        'source'            => '',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => false,
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => true,
                        'visible_in_advanced_search' => true,
                        'unique'            => false
                    ),
               )
           ),
      );
	}
}
?>