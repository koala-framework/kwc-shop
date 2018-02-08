<?php
class Shop_Kwc_Shop_ProductList_Component extends Kwc_Directories_List_Component
{
    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        $ret['generators']['child']['component']['view'] = 'Shop_Kwc_Shop_Products_View_Component';
        $ret['ownModel'] = 'Kwf_Component_FieldModel';
        $ret['componentName'] = trlKwfStatic('Shop.ProductList');
        $ret['componentIcon'] = 'basket';
        return $ret;
    }

    public static function getItemDirectoryClasses($directoryClass)
    {
        return self::_getParentItemDirectoryClasses($directoryClass, 4);
    }

    protected function _getItemDirectory()
    {
        return Kwf_Component_Data_Root::getInstance()
            ->getComponentByClass('Shop_Kwc_Shop_Products_Directory_Component');
    }

    public function getSelect($overrideValues = array())
    {
        $ret = parent::getSelect($overrideValues);
        if ($this->getRow()->component) {
            $ret->whereEquals('component', $this->getRow()->component);
        }
        return $ret;
    }
}
