<?php
class Shop_Kwc_Shop_Cart_Checkout_Payment_PayPal_Cancel_Component extends Kwc_Abstract
{
    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        $ret['contentSender'] = 'Shop_Kwc_Shop_Cart_Checkout_Payment_PayPal_Cancel_ContentSender';
        return $ret;
    }
}
