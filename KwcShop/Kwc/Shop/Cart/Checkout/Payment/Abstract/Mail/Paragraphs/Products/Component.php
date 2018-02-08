<?php
//TODO: könnte von KwcShop_Kwc_Shop_Cart_Checkout_Payment_Abstract_Confirm_Paragraphs_Products_Component erben
class KwcShop_Kwc_Shop_Cart_Checkout_Payment_Abstract_Mail_Paragraphs_Products_Component extends Kwc_Abstract
{
    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        $ret['viewCache'] = false;
        $ret['componentName'] = trlKwfStatic('Order Products');
        return $ret;
    }

    public function getTemplateVars(Kwf_Component_Renderer_Abstract $renderer)
    {
        $ret = parent::getTemplateVars($renderer);
        if ($renderer && $renderer instanceof Kwf_Component_Renderer_Mail) {
            $order = $renderer->getRecipient();
            $ret['items'] = $order->getProductsData();

            $c = $this->getData()->getParentByClass('KwcShop_Kwc_Shop_Cart_Checkout_Component');
            $ret['sumRows'] = $c->getComponent()->getSumRows($order);
        }
        return $ret;
    }
}
