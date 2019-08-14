<?php
class LR_CallPrice_Block_Adminhtml_Request_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        if (Mage::registry('request_data')) {
            $data = Mage::registry('request_data')->getData();
        } else {
            $data = array();
        }

        $form = new Varien_Data_Form(array(
                "id" => "edit_form",
                "action" => $this->getUrl("*/*/save", array("id" => $this->getRequest()->getParam("id"))),
                "method" => "post",
                "enctype" => "multipart/form-data",
            )
        );
        $form->setUseContainer(true);
        $this->setForm($form);

        $fieldset = $form->addFieldset('request_data', array(
            'legend' => Mage::helper('lr_callprice')->__('Call For Price Request Information')
        ));

        $fieldset->addField('customer_name', 'text', array(
            'label' => Mage::helper('lr_callprice')->__('Customer Name'),
            'class' => '',
            'required' => false,
            'name' => 'customer_name',
            'note' => Mage::helper('lr_callprice')->__('Customer name.'),
        ));

        $fieldset->addField('customer_email', 'text', array(
            'label' => Mage::helper('lr_callprice')->__('Customer Email'),
            'class' => '',
            'required' => false,
            'name' => 'customer_email',
        ));

        $fieldset->addField('customer_telephone', 'text', array(
            'label' => Mage::helper('lr_callprice')->__('Telephone'),
            'class' => '',
            'required' => false,
            'name' => 'customer_telephone',
        ));

        $fieldset->addField('product_name', 'textarea', array(
            'label' => Mage::helper('lr_callprice')->__('Request Details'),
            'class' => '',
            'required' => false,
            'name' => 'product_name',
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('lr_callprice')->__('Status'),
            'name' => 'status',
            'values' => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('lr_callprice')->__('New'),
                ),
                array(
                    'value' => 2,
                    'label' => Mage::helper('lr_callprice')->__('Complete'),
                ),
            ),
        ));

        $form->setValues($data);

        return parent::_prepareForm();
    }
}
