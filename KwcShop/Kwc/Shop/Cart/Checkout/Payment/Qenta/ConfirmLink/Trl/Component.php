<?php
class KwcShop_Kwc_Shop_Cart_Checkout_Payment_Qenta_ConfirmLink_Trl_Component extends Kwc_Chained_Trl_Component
{
    public function getTemplateVars(Kwf_Component_Renderer_Abstract $renderer)
    {
        $ret = parent::getTemplateVars($renderer);
        $ret['wirecardButton'] = $this->_getWirecardButton();
        $ret['options'] = array(
            'controllerUrl' =>
                Kwc_Admin::getInstance($this->getData()->componentClass)->getControllerUrl() .
                '/json-confirm-order',
            'params' => array(
                'paymentComponentId' => $this->getData()->parent->componentId
            )
        );
        return $ret;
    }

    protected function _getWirecardButton()
    {
        $order = Kwf_Model_Abstract::getInstance(Kwc_Abstract::getSetting(
            $this->getData()->chained->getParentByClass('KwcShop_Kwc_Shop_Cart_Component')->componentClass, 'childModel'
        ))->getReferencedModel('Order')->getCartOrder();
        $total = $this->getData()->chained->getParentByClass('KwcShop_Kwc_Shop_Cart_Checkout_Component')
            ->getComponent()->getTotal($order);

        $payment = $this->getData()->getParentByClass('KwcShop_Kwc_Shop_Cart_Checkout_Payment_Qenta_Trl_Component');

        $params = array(
            'amount' => round($total, 2),
            'currency' => 'EUR',
            'paymentType' => Kwc_Abstract::getSetting($payment->chained->componentClass, 'paymentType'),
            'orderId' => $order->id
        );

        $paymentUrl = Kwf_Config::getValue('qenta.url');

        return KwcShop_Kwc_Shop_Cart_Checkout_Payment_Qenta_ConfirmLink_Component::buildWirecardButtonHtml($params, $payment, $order, $initUrl);
    }
}

