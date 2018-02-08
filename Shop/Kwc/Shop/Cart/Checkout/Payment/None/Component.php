<?php
class Shop_Kwc_Shop_Cart_Checkout_Payment_None_Component extends Shop_Kwc_Shop_Cart_Checkout_Payment_Abstract_Component
{
    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        $ret['componentName'] = trlKwfStatic('None');
        return $ret;
    }

}
