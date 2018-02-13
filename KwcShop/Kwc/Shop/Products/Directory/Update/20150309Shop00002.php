<?php
class KwcShop_Kwc_Shop_Products_Directory_Update_20150309Shop00002 extends Kwf_Update
{
    public function update()
    {
        $db = Kwf_Registry::get('db');
        $executed = $db->fetchOne("SHOW columns FROM `kwc_shop_order_products` LIKE 'add_component_class'");
        if ($executed) return;

        $db->query("ALTER TABLE `kwc_shop_order_products` ADD `add_component_class` VARCHAR( 200 ) NOT NULL");
        $db->query("UPDATE kwc_shop_order_products SET add_component_class='Kwc_Babytuch_Shop_AddToCart_Component'");
    }
}
