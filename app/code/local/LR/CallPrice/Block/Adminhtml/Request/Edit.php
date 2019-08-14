<?php
	
class LR_CallPrice_Block_Adminhtml_Request_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "id";
				$this->_blockGroup = "lr_callprice";
				$this->_controller = "adminhtml_request";
				$this->_updateButton("save", "label", Mage::helper("lr_callprice")->__("Save Item"));
				$this->_removeButton("delete", "label", Mage::helper("lr_callprice")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("lr_callprice")->__("Save And Continue Edit"),
					"onclick"   => "saveAndContinueEdit()",
					"class"     => "save",
				), -100);



				$this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
		}

		public function getHeaderText()
		{
				if( Mage::registry("request_data") && Mage::registry("request_data")->getId() ){

				    return Mage::helper("lr_callprice")->__("Edit Request '%s'", $this->htmlEscape(Mage::registry("request_data")->getId()));

				} 
				else{

				     return Mage::helper("lr_callprice")->__("Add Request");

				}
		}
}