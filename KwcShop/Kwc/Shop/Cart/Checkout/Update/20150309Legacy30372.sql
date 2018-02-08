ALTER TABLE `KwcShop_Kwc_Shop_orders` ADD `invoice_number` INT NULL ;
UPDATE `KwcShop_Kwc_Shop_orders` SET shipped = NOW();


