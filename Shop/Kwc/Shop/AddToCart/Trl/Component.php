<?php
class Shop_Kwc_Shop_AddToCart_Trl_Component extends Shop_Kwc_Shop_AddToCartAbstract_Trl_Component
{
    public static function getSettings($masterComponentClass = null)
    {
        $ret = parent::getSettings($masterComponentClass);
        $ret['generators']['form']['component'] = 'Shop_Kwc_Shop_AddToCart_Trl_Form_Component';
        $ret['orderProductData'] = 'Shop_Kwc_Shop_AddToCart_Trl_OrderProductData';
        return $ret;
    }

    public function getProductRow()
    {
        return $this->getData()->chained->parent->row;
    }
}
