ALTER TABLE `KwcShop_Kwc_Shop_product_prices` DROP FOREIGN KEY `KwcShop_Kwc_Shop_product_prices_ibfk_1` ;
ALTER TABLE `KwcShop_Kwc_Shop_product_prices` ADD FOREIGN KEY ( `shop_product_id` )
    REFERENCES `KwcShop_Kwc_Shop_products` (
        `id`
    ) ON DELETE CASCADE ON UPDATE CASCADE ;
