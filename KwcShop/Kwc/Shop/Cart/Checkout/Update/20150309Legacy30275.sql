ALTER TABLE `KwcShop_Kwc_Shop_orders` ADD `canceled` TINYINT NOT NULL ;
ALTER TABLE `KwcShop_Kwc_Shop_orders` ADD `invoice_date` DATE NULL ;
ALTER TABLE `KwcShop_Kwc_Shop_orders` ADD number INT NOT NULL ;
UPDATE `KwcShop_Kwc_Shop_orders` SET number=id;
ALTER TABLE `KwcShop_Kwc_Shop_orders` CHANGE `package_sent` `shipped` DATE NULL DEFAULT NULL;
ALTER TABLE `KwcShop_Kwc_Shop_orders` ADD origin ENUM ('internet', 'phone') NOT NULL DEFAULT 'internet';
