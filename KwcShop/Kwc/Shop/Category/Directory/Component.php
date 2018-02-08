<?php
class KwcShop_Kwc_Shop_Category_Directory_Component extends Kwc_Directories_Category_Directory_Component
{
    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        $ret['categoryToItemModelName'] = 'KwcShop_Kwc_Shop_Category_Directory_ProductsToCategoriesModel';
        $ret['generators']['detail']['component'] = 'KwcShop_Kwc_Shop_Category_Detail_Component';
        return $ret;
    }
}
