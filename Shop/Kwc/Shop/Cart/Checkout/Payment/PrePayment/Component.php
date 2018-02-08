<?php
class Shop_Kwc_Shop_Cart_Checkout_Payment_PrePayment_Component extends Shop_Kwc_Shop_Cart_Checkout_Payment_Abstract_Component
{
    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        $ret['componentName'] = trlKwfStatic('Pre Payment');
        return $ret;
    }
}
