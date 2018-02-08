<?php
class Shop_Kwc_Shop_Products_Detail_RelatedProducts_Component extends Kwc_Abstract_List_Component
{
    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        $ret['componentName'] = trlKwfStatic('Related Products');
        $ret['generators']['child']['component'] = 'Shop_Kwc_Shop_Products_Detail_RelatedProducts_Product_Component';
        return $ret;
    }
}
