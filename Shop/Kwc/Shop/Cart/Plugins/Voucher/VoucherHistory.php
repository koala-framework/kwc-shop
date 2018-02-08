<?php
class Shop_Kwc_Shop_Cart_Plugins_Voucher_VoucherHistory extends Kwf_Model_Db
{
    protected $_table = 'Shop_Kwc_Shop_voucher_history';

    protected $_referenceMap = array(
        'voucher' => array(
            'column' => 'voucher_id',
            'refModelClass' => 'Shop_Kwc_Shop_Cart_Plugins_Voucher_Vouchers'
        )
    );
}
