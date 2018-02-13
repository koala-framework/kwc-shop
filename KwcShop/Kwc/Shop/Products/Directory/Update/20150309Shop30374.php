<?php
class KwcShop_Kwc_Shop_Products_Directory_Update_20150309Shop30374 extends Kwf_Update
{
    public function update()
    {
        $db = Kwf_Registry::get('db');
        $executed = $db->fetchOne("SHOW columns FROM `kwc_shop_orders` LIKE 'cart_component_class'");
        if ($executed) return;

        $db->query("
            ALTER TABLE `kwc_shop_orders` ADD `cart_component_class` VARCHAR( 200 ) NOT NULL AFTER `checkout_component_id` ;
            UPDATE kwc_shop_orders SET cart_component_class='Kwc_Babytuch_Shop_Cart_Component';
        ");
    }
}
