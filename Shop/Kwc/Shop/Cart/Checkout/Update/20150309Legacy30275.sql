ALTER TABLE `Shop_Kwc_Shop_orders` ADD `canceled` TINYINT NOT NULL ;
ALTER TABLE `Shop_Kwc_Shop_orders` ADD `invoice_date` DATE NULL ;
ALTER TABLE `Shop_Kwc_Shop_orders` ADD number INT NOT NULL ;
UPDATE `Shop_Kwc_Shop_orders` SET number=id;
ALTER TABLE `Shop_Kwc_Shop_orders` CHANGE `package_sent` `shipped` DATE NULL DEFAULT NULL;
ALTER TABLE `Shop_Kwc_Shop_orders` ADD origin ENUM ('internet', 'phone') NOT NULL DEFAULT 'internet';
