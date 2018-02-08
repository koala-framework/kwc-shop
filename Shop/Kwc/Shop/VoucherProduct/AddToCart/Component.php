<?php
class Shop_Kwc_Shop_VoucherProduct_AddToCart_Component extends Shop_Kwc_Shop_AddToCartAbstract_Component
{
    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        $ret['orderProductData'] = 'Shop_Kwc_Shop_VoucherProduct_AddToCart_OrderProductData';
        $ret['productTypeText'] = trlKwfStatic('Voucher');
        return $ret;
    }
}
