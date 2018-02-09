<?php
class KwcShop_Kwc_Shop_Products_Directory_Update_20150309Shop00005 extends Kwf_Update
{
    public function update()
    {
        $db = Kwf_Registry::get('db');
        $executed = $db->fetchOne("SHOW columns FROM `kwc_shop_products` LIKE 'component'");
        if ($executed) return;

        $db->query("ALTER TABLE `kwc_shop_products` ADD `component` VARCHAR( 255 ) NOT NULL AFTER `id`");
    }
}
