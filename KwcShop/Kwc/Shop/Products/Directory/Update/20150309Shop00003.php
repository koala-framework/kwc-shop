<?php
class KwcShop_Kwc_Shop_Products_Directory_Update_20150309Shop00003 extends Kwf_Update
{
    public function update()
    {
        $db = Kwf_Registry::get('db');
        $executed = $db->fetchOne("SHOW columns FROM `kwc_shop_order_products` LIKE 'data'");
        if ($executed) return;

        $db->query("ALTER TABLE `kwc_shop_order_products` ADD `data` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL");
        $db->query("ALTER TABLE `kwc_shop_order_products` CHANGE `size` `size_backup` TINYINT(4) NOT NULL");
        $db->query("ALTER TABLE `kwc_shop_order_products` CHANGE `amount` `amount_backup` SMALLINT NOT NULL");
    }
}
