<?php
class Shop_Kwc_Shop_Cart_Plugins_Voucher_Vouchers extends Kwf_Model_Db
{
    protected $_table = 'Shop_Kwc_Shop_vouchers';
    protected $_dependentModels = array(
        'history' => 'Shop_Kwc_Shop_Cart_Plugins_Voucher_VoucherHistory'
    );

    protected function _init()
    {
        parent::_init();
        $this->_exprs['used_amount'] = new Kwf_Model_Select_Expr_Child_Sum('history', 'amount');

        $this->_filters['code'] = new Kwf_Filter_Row_Random(8);
    }
}
