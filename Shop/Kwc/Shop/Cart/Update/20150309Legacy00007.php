<?php
class Shop_Kwc_Shop_Cart_Update_20150309Legacy00007 extends Kwf_Update
{
    
    public function update()
    {
        Kwf_Registry::get('db')->query("ALTER TABLE  `Shop_Kwc_Shop_products` ADD  `component_id` VARCHAR( 255 ) NOT NULL AFTER  `id`");
        Kwf_Registry::get('db')->query("ALTER TABLE  `Shop_Kwc_Shop_products` ADD INDEX (  `component_id` );");
    }

    public function postUpdate()
    {
        $c = Kwf_Component_Data_Root::getInstance()
            ->getComponentByClass('Shop_Kwc_Shop_Products_Directory_Component', array('limit'=>1, 'ignoreVisible'=>true));
p($c);
        if ($c) {
            Kwf_Registry::get('db')->query("UPDATE Shop_Kwc_Shop_products SET component_id='$c->dbId'");
        }
    }
}
