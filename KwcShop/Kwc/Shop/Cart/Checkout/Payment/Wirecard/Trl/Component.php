<?php
class KwcShop_Kwc_Shop_Cart_Checkout_Payment_Wirecard_Trl_Component extends KwcShop_Kwc_Shop_Cart_Checkout_Payment_Abstract_Trl_Component
{
    public function processIpn(KwcShop_Kwc_Shop_Cart_Checkout_Payment_Wirecard_LogRow $row, $param)
    {
        $this->getData()->chained->getComponent()->processIpn($row, $param);
    }
}

