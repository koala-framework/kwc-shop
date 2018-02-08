ALTER TABLE `Shop_Kwc_Shop_product_prices` DROP FOREIGN KEY `Shop_Kwc_Shop_product_prices_ibfk_1` ;
ALTER TABLE `Shop_Kwc_Shop_product_prices` ADD FOREIGN KEY ( `shop_product_id` )
    REFERENCES `Shop_Kwc_Shop_products` (
        `id`
    ) ON DELETE CASCADE ON UPDATE CASCADE ;
