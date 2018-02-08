<?php
class KwcShop_Kwc_Shop_Cart_Checkout_Payment_CashOnDelivery_OrderData extends KwcShop_Kwc_Shop_Cart_Checkout_Payment_Abstract_OrderData
{
    public function getAdditionalSumRows(KwcShop_Kwc_Shop_Cart_Order $order)
    {
        $ret = parent::getAdditionalSumRows($order);
        $ret[] = array(
            'class' => 'cashOnDelivery',
            'text' => trlKwf('Cash on Delivery Charge').':',
            'amount' => $this->_getCashOnDeliveryCharge($order)
        );
        return $ret;
    }

    protected function _getCashOnDeliveryCharge($order)
    {
        return Kwc_Abstract::getSetting($this->_class, 'cashOnDeliveryCharge');
    }
}
