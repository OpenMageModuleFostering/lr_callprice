<?php
class LR_CallPrice_Block_Form extends Mage_Core_Block_Template
{
    public function getFormAction()
    {
    return Mage::getUrl('callprice/form/submit');
    }

    public function customerLoggedIn()
    {
     return Mage::getSingleton('customer/session')->isLoggedIn();
    }
    public function buttonLabel()
    {
        $label = Mage::getStoreConfig('catalog/call_for_price/call_for_price_button_text');

        return $label;
    }
    public function getProductId()
    {
       return $product_id = $this->getRequest()->getPost('product');
    }
    public function option_details()
    {

        $product_id = $this->getRequest()->getPost('product');
        $product_model = Mage::getModel('catalog/product')->load($product_id);
        $product_type = $product_model->getTypeId();
        $option_details = $this->__('Product Name')." = ";
        $option_details.=$product_model->getName();
        $option_details.="\n";
        switch ($product_type) {
            case "configurable":
                $super_attribute = $this->getRequest()->getPost('super_attribute');
                if($super_attribute!="")
                {
                    foreach($super_attribute as $att=>$option_id)
                    {
                        // Load attribute code
                        $attribute_data = Mage::getModel('catalog/resource_eav_attribute')->load($att); // $att is the ID of the attribute.
                        $option_details.= $attribute_data->getData('frontend_label');
                        $option_details.=" = ";
                        $option_col = Mage::getResourceModel( 'eav/entity_attribute_option_collection')
                            ->setAttributeFilter($att)
                            ->setStoreFilter()
                            ->setPositionOrder( 'DESC' );

                        foreach	($option_col AS $option ) {
                            if($option->getOptionId()==$option_id)
                            {
                                $option_details.= $option->getValue();
                            }
                        }
                        $option_details.="\n";
                    }
                }
                break;
            case "bundle":
                $bundle_options = $this->getRequest()->getPost('bundle_option');
                // Following code is to simplify array
                foreach($bundle_options as $key=>$bundle_option)
                {
                    if(is_array($bundle_option))
                    {
                        foreach($bundle_option as $k => $v)
                        {
                            if(strpos($v,',')>-1)
                            {
                                $mdata = explode(",",$v);
                                $bundle_options[$key] = $mdata;
                            }

                        }
                    }
                }
                // Ends
                $bundled_product = $product_model;
                $selectionCollection = $bundled_product->getTypeInstance(true)->getSelectionsCollection(
                    $bundled_product->getTypeInstance(true)->getOptionsIds($bundled_product), $bundled_product
                );
                $bundled_items = array();
                foreach($selectionCollection as $option)
                {
                    $simple_product = Mage::getModel('catalog/product')->load($option->product_id);
                    //$option->getSelectionId() = value of selected items
                    $bundled_items[$option->getSelectionId()] = $simple_product->getName();
                }
                $optionsCollection = $bundled_product->getTypeInstance(true)->getOptionsCollection($bundled_product);
                $optionCollection =array();
                foreach($optionsCollection as $oc)
                {
                    $optionCollection[$oc->getOptionId()]=$oc->getDefaultTitle();
                }
                // Code to get Data array in format : case => Apick
                $data =array();
                $m_bundle_option = array();
                foreach($bundle_options as $key=>$bundle_option)
                {
                    if(is_array($bundle_option))
                    {
                          foreach($bundle_option as $k => $v)
                          {
                            $sdata[$k] = $bundled_items[$v];
                          }
                          $data[$optionCollection[$key]]= implode(" , ",$sdata);
                    }
                    else
                    {
                        $data[$optionCollection[$key]] = $bundled_items[$bundle_option];
                    }
                }
                foreach($data as $k =>$v)
                {
                    $option_details.=$k;
                    $option_details.=" = ";
                    $option_details.=$v;
                    $option_details.="\n";
                }

                break;

        }

    return $option_details;
    }


}
