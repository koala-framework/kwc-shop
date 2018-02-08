<?php
class KwcShop_Kwc_Shop_Cart_Checkout_Payment_Abstract_Mail_Paragraphs_Component
    extends Kwc_Paragraphs_Component
{
    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        $ret['generators']['paragraphs']['component'] = array(
            'textImage' => 'Kwc_TextImage_Component',
            'space' => 'Kwc_Basic_Space_Component',
            'address' => 'KwcShop_Kwc_Shop_Cart_Checkout_Payment_Abstract_Mail_Paragraphs_Address_Component',
            'products' => 'KwcShop_Kwc_Shop_Cart_Checkout_Payment_Abstract_Mail_Paragraphs_Products_Component',
            'message' => 'KwcShop_Kwc_Shop_Cart_Checkout_Payment_Abstract_Mail_Paragraphs_Message_Component'
        );
        return $ret;
    }
}
