<?php
class KwcShop_Kwc_Shop_Cart_Checkout_Update_20150309Legacy30277 extends Kwf_Update
{
    protected function _init()
    {
        parent::_init();

        $this->_actions[] = new Kwf_Update_Action_Db_AddField(array(
            'table' => 'KwcShop_Kwc_Shop_orders',
            'field' => 'firstname',
            'type' => 'VARCHAR(200)',
            'null' => false,
            'default' => ''
        ));
        $this->_actions[] = new Kwf_Update_Action_Db_AddField(array(
            'table' => 'KwcShop_Kwc_Shop_orders',
            'field' => 'lastname',
            'type' => 'VARCHAR(200)',
            'null' => false,
            'default' => ''
        ));
        $this->_actions[] = new Kwf_Update_Action_Db_AddField(array(
            'table' => 'KwcShop_Kwc_Shop_orders',
            'field' => 'city',
            'type' => 'VARCHAR(200)',
            'null' => false,
            'default' => ''
        ));
        $this->_actions[] = new Kwf_Update_Action_Db_AddField(array(
            'table' => 'KwcShop_Kwc_Shop_orders',
            'field' => 'email',
            'type' => 'VARCHAR(200)',
            'null' => false,
            'default' => ''
        ));
        $this->_actions[] = new Kwf_Update_Action_Db_AddField(array(
            'table' => 'KwcShop_Kwc_Shop_orders',
            'field' => 'zip',
            'type' => 'VARCHAR(50)',
            'null' => false,
            'default' => ''
        ));
        $this->_actions[] = new Kwf_Update_Action_Db_AddField(array(
            'table' => 'KwcShop_Kwc_Shop_orders',
            'field' => 'payment',
            'type' => 'VARCHAR(100)',
            'null' => false,
            'default' => ''
        ));

        $this->_actions[] = new Kwf_Update_Action_Db_ConvertFieldModel(array(
            'table' => 'KwcShop_Kwc_Shop_orders',
            'fields' => array('firstname', 'lastname', 'payment', 'zip', 'email', 'city'),
        ));
    }
    public function update()
    {
        parent::update();
        Kwf_Registry::get('db')->query("UPDATE `KwcShop_Kwc_Shop_orders` SET payment='prePayment' WHERE payment='prepayment'");
    }
}
