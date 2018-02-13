<?php
class KwcShop_Kwc_Shop_Products_Directory_Update_20150309Shop00007 extends Kwf_Update
{
    
    public function update()
    {
        $db = Kwf_Registry::get('db');
        $executed = $db->fetchOne("SHOW columns FROM `kwc_shop_products` LIKE 'component_id'");
        if ($executed) return;

        $db->query("ALTER TABLE `kwc_shop_products` ADD `component_id` VARCHAR( 255 ) NOT NULL AFTER `id`");
        $db->query("ALTER TABLE `kwc_shop_products` ADD INDEX ( `component_id` )");
    }

    public function postUpdate()
    {
        $c = Kwf_Component_Data_Root::getInstance()
            ->getComponentByClass('KwcShop_Kwc_Shop_Products_Directory_Component', array('limit'=>1, 'ignoreVisible'=>true));
        p($c);
        if ($c) {
            Kwf_Registry::get('db')->query("UPDATE kwc_shop_products SET component_id='$c->dbId'");
        }
    }
}
