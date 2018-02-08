<?php
class KwcShop_Kwc_Shop_ProductPrices extends Kwf_Model_Db
{
    protected $_table = 'kwc_shop_product_prices';
    protected $_referenceMap = array(
        'Product' => array(
            'column'   => 'shop_product_id',
            'refModelClass' => 'KwcShop_Kwc_Shop_Products',
        )
    );
    protected $_dependentModels = array(
        'OrderProducts' => 'KwcShop_Kwc_Shop_Cart_OrderProducts',
    );
}
