ALTER TABLE `Shop_Kwc_Shop_orders` CHANGE `status` `status` ENUM( 'cart', 'ordered', 'payed' ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
