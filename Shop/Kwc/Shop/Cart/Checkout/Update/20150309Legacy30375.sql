ALTER TABLE  `Shop_Kwc_Shop_orders` CHANGE  `status`  `status` ENUM(  'cart',  'processing',  'ordered',  'payed' ) NOT NULL;
