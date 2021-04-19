<?php
class KwcShop_Kwc_Shop_Cart_Checkout_Payment_Qenta_Cancel_Component extends Kwc_Abstract
{
    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        $ret['contentSender'] = 'KwcShop_Kwc_Shop_Cart_Checkout_Payment_Qenta_Cancel_ContentSender';
        return $ret;
    }
}
