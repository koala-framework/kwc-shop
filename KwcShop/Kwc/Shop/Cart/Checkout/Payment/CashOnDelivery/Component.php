<?php
class KwcShop_Kwc_Shop_Cart_Checkout_Payment_CashOnDelivery_Component extends KwcShop_Kwc_Shop_Cart_Checkout_Payment_Abstract_Component
{
    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        $ret['componentName'] = trlKwfStatic('Cash on Delivery');
        $ret['cashOnDeliveryCharge'] = 6.5;
        $ret['orderData'] = 'KwcShop_Kwc_Shop_Cart_Checkout_Payment_CashOnDelivery_OrderData';
        return $ret;
    }
}
