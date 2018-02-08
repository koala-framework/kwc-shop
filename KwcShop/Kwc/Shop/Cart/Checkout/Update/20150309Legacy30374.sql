ALTER TABLE `KwcShop_Kwc_Shop_orders` ADD `cart_component_class` VARCHAR( 200 ) NOT NULL AFTER `checkout_component_id` ;
UPDATE KwcShop_Kwc_Shop_orders SET cart_component_class='Kwc_Babytuch_Shop_Cart_Component';
