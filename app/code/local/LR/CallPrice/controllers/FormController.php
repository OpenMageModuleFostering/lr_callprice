<?php
class LR_CallPrice_FormController extends Mage_Core_Controller_Front_Action
{
    const XML_PATH_EMAIL_RECIPIENT  = 'catalog/call_for_price/send_email_to';
    const XML_PATH_EMAIL_SENDER     = 'catalog/call_for_price/email_sender';
    const XML_PATH_EMAIL_TEMPLATE   = 'catalog/call_for_price/email_template';
    
    public function loadformAction()
    {
        /*$this->loadLayout();
        $this->renderLayout();*/
        $success = true;
        $request_form = $this->getLayout()->createBlock('lr_callprice/form','callforprice.form')->setTemplate('lr/callprice/callforprice_form.phtml')->toHtml();
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(array('success' => $success,'request_form' => $request_form)));
    }
    
    public function submitAction()
    {
        if ($this->getRequest()->getPost())
        {
            $cp = Mage::getModel('lr_callprice/request');
            $name = $this->getRequest()->getPost('name');
            $email = $this->getRequest()->getPost('email');
            $telephone = $this->getRequest()->getPost('telephone');
            $product_id = $this->getRequest()->getPost('product_id');
            $cp->setCustomerName($name)
                ->setCustomerEmail($email)
                ->setCustomerTelephone($telephone)
				->setStatus(1) // Set Status to New
                ->setProductId($product_id);
			
            $details = $this->getRequest()->getPost('details');
            $cp->setProductName($details);
            try
            {
                $cp->save();
		
				$data = array();
						$data['name'] = $name;
						$data['email'] = $email;
						$data['telephone'] = $telephone;
						$data['details']= $details;
				$data['status']= "New";
				
				$postObject = new Varien_Object();
						$postObject->setData($data);
				
				$translate  = Mage::getSingleton('core/translate');
				$mailTemplate = Mage::getModel('core/email_template');
				
				$mailTemplate->setReplyTo($email)->sendTransactional(
					Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE),
					Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
					Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT),
					null,
					array('data' => $postObject)
				);
				$translate->setTranslateInline(true);  
		
                $success =true;
                $message = $this->__('Your request is accepted.');
            }
            catch (Exception $e)
            {
                $success =false;
                $message = $this->__('Your Request is Not Sent.');
            }

            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(array('success' => $success, 'message' => $message,)));
        }
    }
}
?>