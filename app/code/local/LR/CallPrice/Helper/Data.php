<?php
class LR_CallPrice_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function loadformurl()
    {
        $loadformurl = Mage::getUrl('callprice/form/loadform');
        return $loadformurl;
    }

    public function submitformurl()
    {
        $submitformurl = Mage::getUrl('callprice/form/submit');
        return $submitformurl;
    }

    public function getButtonTitle()
    {
        return Mage::getStoreConfig('catalog/call_for_price/call_for_price_button_text');
    }

    //check which customer group for which we will show call for price button
    public function allowedCustomerGroup()
    {

      return Mage::getStoreConfig('catalog/call_for_price/customer_groups');
    }

    public function getCurrentCustomerGroup()
    {
        $login = Mage::getSingleton( 'customer/session' )->isLoggedIn(); //Check if User is Logged In
        if($login)
        {
            $groupId = Mage::getSingleton('customer/session')->getCustomerGroupId(); //Get Customers Group ID
            return $groupId;
        }
    }

    public function getSpecificDateRange()
    {
        return Mage::getStoreConfig('catalog/call_for_price/specific_date_range');
    }
    public function getFromDate()
    {
        return Mage::getStoreConfig('catalog/call_for_price/from_date');
    }
    public function getToDate()
    {
        return Mage::getStoreConfig('catalog/call_for_price/to_date');
    }

   public function getDateToShowButton()
    {
        //Get From To date
        if($this->getSpecificDateRange()==1)
        {
			$fromDate = date('m/d/Y',strtotime($this->getFromDate()));
			$toDate = date('m/d/Y',strtotime($this->getToDate()));
			$todayDate = date('m/d/Y');
			if(strtotime($todayDate)>=strtotime($fromDate) && strtotime($todayDate)<=strtotime($toDate))
			{
			  return 1;
			}
        } 		
    }

    public function showCallForPriceButton($_product)
    {        
		$callpriceflag = 0;
		$callpriceflagparent = 0;
		$callforprice =0;
		
		$allowed_customer_groups =array();
        $customer_groups = $this->allowedCustomerGroup();  // Check customer Group
        if($customer_groups!="")
        {
            $allowed_customer_groups = explode(',',$customer_groups);
        }
        
		$c_group = $this->getCurrentCustomerGroup(); // current customer group id
		
		if(count($allowed_customer_groups)>0)
		{
			if(in_array($c_group,$allowed_customer_groups))
			{
				$showCallForPriceButton =1;
				return $showCallForPriceButton;            
			}
			else
			{
				$showCallForPriceButton =0;
				
			}
		}
		
        $buttonDate = $this->getDateToShowButton(); 
			
        if($buttonDate==1)
		{
		    $showCallForPriceButton =1;
            return $showCallForPriceButton;			
		}
		
        $currentCategory = Mage::registry('current_category'); // check for current category
        if($currentCategory)
        {
            $cat = Mage::getModel('catalog/category')->load($currentCategory->getId());
            $callpriceflag = $cat->getCallForPriceActive();
            			
			if($cat->getParentCategory())
			{
			$callpriceflagparent = $cat->getParentCategory()->getCallForPriceActive();
			}
        }

        $callforprice = $_product->getCallForPriceActive(); // Check for product   
        
		
		
		if($callforprice==1||$callpriceflagparent==1||$callpriceflag==1)
        {
            $showCallForPriceButton =1;            
        }
		return $showCallForPriceButton;
    }


}
	 