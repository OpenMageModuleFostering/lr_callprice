<?php
class LR_CallPrice_Block_Adminhtml_Request_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("request_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("lr_callprice")->__("Request Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("lr_callprice")->__("Request Information"),
				"title" => Mage::helper("lr_callprice")->__("Request Information"),
				"content" => $this->getLayout()->createBlock("lr_callprice/adminhtml_request_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
