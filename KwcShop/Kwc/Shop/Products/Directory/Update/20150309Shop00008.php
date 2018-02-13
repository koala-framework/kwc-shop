<?php
class KwcShop_Kwc_Shop_Products_Directory_Update_20150309Shop00008 extends Kwf_Update
{
    public function update()
    {
        $db = Kwf_Registry::get('db');
        $executed = $db->fetchOne("SHOW columns FROM `kwc_shop_orders` LIKE 'confirm_mail_sent'");
        if ($executed) return;

        $db->query("ALTER TABLE `kwc_shop_orders` ADD `confirm_mail_sent` DATETIME NULL");
    }
}
