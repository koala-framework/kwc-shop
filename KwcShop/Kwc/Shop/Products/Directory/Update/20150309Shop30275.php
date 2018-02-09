
<?php
class KwcShop_Kwc_Shop_Products_Directory_Update_20150309Shop30275 extends Kwf_Update
{
    public function update()
    {
        $db = Kwf_Registry::get('db');
        $executed = $db->fetchOne("SHOW columns FROM `kwc_shop_orders` LIKE 'canceled'");
        if ($executed) return;

        $db->query("
            ALTER TABLE `kwc_shop_orders` ADD `canceled` TINYINT NOT NULL ;
            ALTER TABLE `kwc_shop_orders` ADD `invoice_date` DATE NULL ;
            ALTER TABLE `kwc_shop_orders` ADD number INT NOT NULL ;
            UPDATE `kwc_shop_orders` SET number=id;
            ALTER TABLE `kwc_shop_orders` CHANGE `package_sent` `shipped` DATE NULL DEFAULT NULL;
            ALTER TABLE `kwc_shop_orders` ADD origin ENUM ('internet', 'phone') NOT NULL DEFAULT 'internet';
        ");
    }
}
