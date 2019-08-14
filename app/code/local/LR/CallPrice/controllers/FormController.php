<?php
class LR_CallPrice_FormController extends Mage_Core_Controller_Front_Action
{
    public function loadformAction()
    {
        /*$this->loadLayout();
        $this->renderLayout();*/
        $success = true;
        $request_form = $this->getLayout()->createBlock('lr_callprice/form','callforprice.form')->setTemplate('lr/callprice/callforprice_form.phtml')->toHtml();
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(array('success' => $success,'request_form' => $request_form)));
    }
    protected function _sendEmailTo()
    {
        return Mage::getStoreConfig('catalog/call_for_price/send_email_to');
    }
    protected function _emailSender()
    {
        return Mage::getStoreConfig('catalog/call_for_price/email_sender');
    }
    protected function _sendEmailTemplate()
    {
        return Mage::getStoreConfig('catalog/call_for_price/email_template');
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

                /* Send email to Admin */
                $templateId = $this->_sendEmailTemplate();
                $emailTemplate  = Mage::getModel('core/email_template')
                    ->load($templateId);

                 //Create an array of variables to assign to template
                $data = array();
                $data['name'] = $name;
                $data['email'] = $email;
                $data['telephone'] = $telephone;
                $data['details']= $details;
				$data['status']= "New"; 
                // $processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);
                $emailTemplate->send($this->_sendEmailTo(),$this->_emailSender(), $data);

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