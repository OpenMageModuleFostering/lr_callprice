<?php
class LR_CallPrice_Block_Adminhtml_Request_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);

				if (Mage::getSingleton("adminhtml/session")->getRequestData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getRequestData());
					Mage::getSingleton("adminhtml/session")->setRequestData(null);
				} 
				elseif(Mage::registry("request_data")) {
				    $form->setValues(Mage::registry("request_data")->getData());
				}
				return parent::_prepareForm();
		}
}
