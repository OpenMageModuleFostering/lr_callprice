<?php

class LR_CallPrice_Block_Adminhtml_Request_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct()
    {
        parent::__construct();
        $this->setId("requestGrid");
        $this->setDefaultSort("id");
        $this->setDefaultDir("ASC");
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('id');

        $statuses = array(
            array(
                'value' => 1,
                'label' => $this->__('New'),
            ),
            array(
                'value' => 2,
                'label' => $this->__('Complete'),
            ),
        );
        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem('status', array(
            'label' => $this->__('Change status'),
            'url' => $this->getUrl('*/*/massStatusUpdate', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => $this->__('Status'),
                    'values' => $statuses
                )
            )
        ));
        return $this;
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel("lr_callprice/request")->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn("id", array(
            "header" => $this->__("ID"),
            "align" => "right",
            "width" => "30px",
            "type" => "number",
            "index" => "id",
        ));

        $this->addColumn("customer_name", array(
            "header" => $this->__("Customer Name"),
            "align" => "right",
            "width" => "50px",
            "type" => "varchar",
            "index" => "customer_name",
        ));
        $this->addColumn("customer_email", array(
            "header" => $this->__("Customer Email"),
            "align" => "right",
            "width" => "50px",
            "type" => "varchar",
            "index" => "customer_email",
        ));
        $this->addColumn("customer_telephone", array(
            "header" => $this->__("Customer Telephone"),
            "align" => "right",
            "width" => "50px",
            "type" => "varchar",
            "index" => "customer_telephone",
        ));

        $this->addColumn("product_id", array(
            "header" => $this->__("Product Id"),
            "align" => "right",
            "width" => "50px",
            "type" => "varchar",
            "index" => "product_id",
        ));

        $this->addColumn("product_name", array(
            "header" => $this->__("Request Details"),
            "align" => "right",
            "width" => "50px",
            "type" => "varchar",
            "index" => "product_name",
        ));

        $this->addColumn('status', array(
            'header' => $this->__('Status'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'status',
            'type' => 'options',
            'options' => array(
                1 => 'New',
                2 => 'Complete',
            ),
        ));

        $this->addColumn('view',
            array(
                'header' => $this->__('Action'),
                'width' => '50px',
                'type' => 'action',
                'getter' => 'getId',
                'actions' => array(
                    array(
                        'caption' => $this->__('View'),
                        'url' => array(
                            'base' => 'adminhtml/request/edit',
                            'params' => array('store' => $this->getRequest()->getParam('store'))
                        ),
                        'field' => 'id'
                    )
                ),
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
            ));
        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl("*/*/edit", array("id" => $row->getId()));
    }


}