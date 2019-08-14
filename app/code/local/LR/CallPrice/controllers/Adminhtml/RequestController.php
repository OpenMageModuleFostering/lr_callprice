<?php

class LR_CallPrice_Adminhtml_RequestController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("lr_callprice/request")->_addBreadcrumb(Mage::helper("adminhtml")->__("Request  Manager"),Mage::helper("adminhtml")->__("Request Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("CallPrice"));
			    $this->_title($this->__("Manager Request"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("CallPrice"));
				$this->_title($this->__("Request"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("lr_callprice/request")->load($id);
				if ($model->getId()) {
					Mage::register("request_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("lr_callprice/request");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Request Manager"), Mage::helper("adminhtml")->__("Request Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Request Description"), Mage::helper("adminhtml")->__("Request Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("lr_callprice/adminhtml_request_edit"))->_addLeft($this->getLayout()->createBlock("lr_callprice/adminhtml_request_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("lr_callprice")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{

		$this->_title($this->__("CallPrice"));
		$this->_title($this->__("Request"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("lr_callprice/request")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("request_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("lr_callprice/request");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Request Manager"), Mage::helper("adminhtml")->__("Request Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Request Description"), Mage::helper("adminhtml")->__("Request Description"));


		$this->_addContent($this->getLayout()->createBlock("lr_callprice/adminhtml_request_edit"))->_addLeft($this->getLayout()->createBlock("lr_callprice/adminhtml_request_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{
			$post_data=$this->getRequest()->getPost();
				if ($post_data) {
					try {
						$model = Mage::getModel("lr_callprice/request")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();
						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Request was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setRequestData(false);
						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setRequestData($this->getRequest()->getPost());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					return;
					}

				}
				$this->_redirect("*/*/");
		}



		public function deleteAction()
		{
				if( $this->getRequest()->getParam("id") > 0 ) {
					try {
						$model = Mage::getModel("lr_callprice/request");
						$model->setId($this->getRequest()->getParam("id"))->delete();
						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
						$this->_redirect("*/*/");
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					}
				}
				$this->_redirect("*/*/");
		}

        public function massStatusUpdateAction()
        {
            $requestIds = $this->getRequest()->getParam('id');      // $this->getMassactionBlock()->setFormFieldName('tax_id'); from Mage_Adminhtml_Block_Tax_Rate_Grid
            if(!is_array($requestIds)) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('lr_callprice')->__('Please select status.'));
            } else {
                try {
                    $model = Mage::getModel("lr_callprice/request");
                    foreach ($requestIds as $requestId) {
                        $model->load($requestId);
                        if ($model->getId()) {
                            $getstatus = $this->getRequest()->getParam("status");
                            $model->setStatus($getstatus);
                            $model->save();
                        }
                    }
                    Mage::getSingleton('adminhtml/session')->addSuccess(
                        Mage::helper('lr_callprice')->__(
                            'Total of %d record(s) were updated.', count($requestIds)
                        )
                    );
                } catch (Exception $e) {
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                }
            }
            $this->_redirect('*/*/');
        }

		
}
