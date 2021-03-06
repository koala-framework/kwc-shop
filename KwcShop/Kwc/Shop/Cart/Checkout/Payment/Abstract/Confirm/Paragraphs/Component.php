<?php
class KwcShop_Kwc_Shop_Cart_Checkout_Payment_Abstract_Confirm_Paragraphs_Component extends Kwc_Paragraphs_Component
{
    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        $ret['generators']['paragraphs']['component'] = array(
            'textImage' => 'Kwc_TextImage_Component',
            'products' => 'KwcShop_Kwc_Shop_Cart_Checkout_Payment_Abstract_Confirm_Paragraphs_Products_Component'
        );
        return $ret;
    }
}
