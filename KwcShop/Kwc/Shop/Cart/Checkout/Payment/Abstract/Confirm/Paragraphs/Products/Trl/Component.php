<?php
class KwcShop_Kwc_Shop_Cart_Checkout_Payment_Abstract_Confirm_Paragraphs_Products_Trl_Component extends Kwc_Chained_Trl_Component
{
    public function getTemplateVars(Kwf_Component_Renderer_Abstract $renderer)
    {
        $ret = parent::getTemplateVars($renderer);
        if ($ret['order']) {
            $order = $renderer->getRecipient();
            $ret['items'] = $order->getProductsDataWithProduct($this->getData());
        }
        return $ret;
    }

}

