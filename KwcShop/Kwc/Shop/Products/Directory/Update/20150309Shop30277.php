<?php
class KwcShop_Kwc_Shop_Products_Directory_Update_20150309Shop30277 extends Kwf_Update
{
    public function update()
    {
        $db = Kwf_Registry::get('db');
        $executed = $db->fetchOne("SHOW columns FROM `kwc_shop_orders` LIKE 'firstname'");
        if ($executed) return;

        $this->_actions[] = new Kwf_Update_Action_Db_AddField(array(
            'table' => 'kwc_shop_orders',
            'field' => 'firstname',
            'type' => 'VARCHAR(200)',
            'null' => false,
            'default' => ''
        ));
        $this->_actions[] = new Kwf_Update_Action_Db_AddField(array(
            'table' => 'kwc_shop_orders',
            'field' => 'lastname',
            'type' => 'VARCHAR(200)',
            'null' => false,
            'default' => ''
        ));
        $this->_actions[] = new Kwf_Update_Action_Db_AddField(array(
            'table' => 'kwc_shop_orders',
            'field' => 'city',
            'type' => 'VARCHAR(200)',
            'null' => false,
            'default' => ''
        ));
        $this->_actions[] = new Kwf_Update_Action_Db_AddField(array(
            'table' => 'kwc_shop_orders',
            'field' => 'email',
            'type' => 'VARCHAR(200)',
            'null' => false,
            'default' => ''
        ));
        $this->_actions[] = new Kwf_Update_Action_Db_AddField(array(
            'table' => 'kwc_shop_orders',
            'field' => 'zip',
            'type' => 'VARCHAR(50)',
            'null' => false,
            'default' => ''
        ));
        $this->_actions[] = new Kwf_Update_Action_Db_AddField(array(
            'table' => 'kwc_shop_orders',
            'field' => 'payment',
            'type' => 'VARCHAR(100)',
            'null' => false,
            'default' => ''
        ));

        $this->_actions[] = new Kwf_Update_Action_Db_ConvertFieldModel(array(
            'table' => 'kwc_shop_orders',
            'fields' => array('firstname', 'lastname', 'payment', 'zip', 'email', 'city'),
        ));
        parent::update();
        Kwf_Registry::get('db')->query("UPDATE `kwc_shop_orders` SET payment='prePayment' WHERE payment='prepayment'");
    }
}
