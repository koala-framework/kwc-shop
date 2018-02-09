<?php
class KwcShop_Kwc_Shop_Products_Directory_Update_20150309Shop30372 extends Kwf_Update
{
    public function update()
    {
        $db = Kwf_Registry::get('db');
        $executed = $db->fetchOne("SHOW columns FROM `kwc_shop_orders` LIKE 'invoice_number'");
        if ($executed) return;

        $db->query("
            ALTER TABLE `kwc_shop_orders` ADD `invoice_number` INT NULL ;
            UPDATE `kwc_shop_orders` SET shipped = NOW();
        ");
    }
}
