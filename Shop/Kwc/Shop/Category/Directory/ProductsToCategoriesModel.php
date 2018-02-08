<?php
class Shop_Kwc_Shop_Category_Directory_ProductsToCategoriesModel
    extends Kwc_Directories_Category_Directory_ItemsToCategoriesModel
{
    protected $_table = 'Shop_Kwc_Shop_products_to_categories';

    protected function _init()
    {
        $this->_referenceMap['Item'] = array(
            'column'        => 'product_id',
            'refModelClass' => 'Shop_Kwc_Shop_Products',
        );
        parent::_init();
    }
}
