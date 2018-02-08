ALTER TABLE `KwcShop_Kwc_Shop_orders` ADD `payment_component_id` VARCHAR( 200 ) NOT NULL AFTER `date` ;
ALTER TABLE `KwcShop_Kwc_Shop_orders` ADD `checkout_component_id` VARCHAR( 200 ) NOT NULL AFTER `payment_component_id` ;
ALTER TABLE `KwcShop_Kwc_Shop_orders` ADD `package_sent` DATE NULL ,
 ADD `payed` DATE NULL ;

UPDATE KwcShop_Kwc_Shop_orders SET checkout_component_id='17_checkout';

CREATE TABLE `KwcShop_Kwc_Shop_product_prices` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
 `shop_product_id` INT UNSIGNED NOT NULL ,
 `price` DECIMAL( 10, 2 ) NOT NULL ,
 `valid_from` DATETIME NOT NULL ,
 INDEX ( `shop_product_id` ) 
) ENGINE = INNODB;

ALTER TABLE `KwcShop_Kwc_Shop_product_prices` ADD FOREIGN KEY ( `shop_product_id` ) REFERENCES `KwcShop_Kwc_Shop_products` (
`id` 
);

INSERT INTO KwcShop_Kwc_Shop_product_prices (shop_product_id, price, valid_from)
SELECT id, price, NOW() FROM KwcShop_Kwc_Shop_products;

ALTER TABLE `KwcShop_Kwc_Shop_products` DROP `price`;

ALTER TABLE `KwcShop_Kwc_Shop_order_products` ADD `shop_product_price_id` INT UNSIGNED NOT NULL AFTER `shop_product_id` ;

ALTER TABLE `KwcShop_Kwc_Shop_order_products` ADD INDEX ( `shop_product_price_id` ) ;

UPDATE `KwcShop_Kwc_Shop_order_products` SET shop_product_price_id = (SELECT id FROM KwcShop_Kwc_Shop_product_prices WHERE KwcShop_Kwc_Shop_product_prices.shop_product_id=KwcShop_Kwc_Shop_order_products.shop_product_id LIMIT 1);


-- #da gibts vielleicht ein problem:
ALTER TABLE `KwcShop_Kwc_Shop_order_products` DROP FOREIGN KEY `KwcShop_Kwc_Shop_order_products_ibfk_1` ;
ALTER TABLE `KwcShop_Kwc_Shop_order_products` DROP FOREIGN KEY `KwcShop_Kwc_Shop_order_products_ibfk_2` ;

ALTER TABLE `KwcShop_Kwc_Shop_order_products` DROP `shop_product_id`;

ALTER TABLE `KwcShop_Kwc_Shop_order_products` ADD FOREIGN KEY ( `shop_order_id` ) REFERENCES `KwcShop_Kwc_Shop_orders` (`id`);
ALTER TABLE `KwcShop_Kwc_Shop_order_products` ADD FOREIGN KEY ( `shop_product_price_id` ) REFERENCES `KwcShop_Kwc_Shop_product_prices` (`id`);
