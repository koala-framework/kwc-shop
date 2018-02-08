ALTER TABLE `Shop_Kwc_Shop_orders` ADD `invoice_number` INT NULL ;
UPDATE `Shop_Kwc_Shop_orders` SET shipped = NOW();


