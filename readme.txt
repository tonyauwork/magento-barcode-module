Main features:

1. Module name: ND_Barcodeform
2. Provide the Barcode generator(Code39 & QR) in helper
	you can use it like these:
	
	$imgurl = Mage::helper("barcodeform")->Qr("your text");
	$imgurl = Mage::helper("barcodeform")->Code39("your text");
	
	the barcode image file stores in the ./media/barcode folder
	
	and barcode image file's name depends the input, use md5() to generate it.
	
3. add a column to the Mage_Adminhtml_Block_Sales_Order_Grid, the action is to show the form

4. add a print button to the Mage_Adminhtml_Block_Sales_Order_View, the action is to show the form

5. add a attribute to the catalog/product, name is "myattribcode" for the product barcode.

6. can configure the form's parameter via the system Configuration.
	
	system->Configuration->ND EXTENSIONS->Barcode Form

	







