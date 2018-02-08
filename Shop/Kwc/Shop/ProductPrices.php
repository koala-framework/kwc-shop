<?php
class Shop_Kwc_Shop_ProductPrices extends Kwf_Model_Db
{
    protected $_table = 'Shop_Kwc_Shop_product_prices';
    protected $_referenceMap = array(
        'Product' => array(
            'column'   => 'shop_product_id',
            'refModelClass' => 'Shop_Kwc_Shop_Products',
        )
    );
    protected $_dependentModels = array(
        'OrderProducts' => 'Shop_Kwc_Shop_Cart_OrderProducts',
    );
}
