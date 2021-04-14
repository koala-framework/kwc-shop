<?php
class KwcShop_Kwc_Shop_Cart_Checkout_Payment_Wirecard_ConfirmLink_Component extends Kwc_Abstract
{
    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        $ret['viewCache'] = false;
        return $ret;
    }

    public function getTemplateVars(Kwf_Component_Renderer_Abstract $renderer)
    {
        $ret = parent::getTemplateVars($renderer);
        $controllerBaseUrl = Kwc_Admin::getInstance($this->getData()->componentClass)->getControllerUrl();
        $ret['wirecardButton'] = $this->_getWirecardButton();
        $ret['options'] = array(
            'confirmOrderUrl' => "$controllerBaseUrl/json-confirm-order",
            'initiatePaymentUrl' => "$controllerBaseUrl/json-initiate-payment",
            'params' => array(
                'paymentComponentId' => $this->getData()->parent->componentId
            )
        );
        return $ret;
    }

    //used in trl
    public static function buildWirecardButtonHtml($params, $payment, $order, $initUrl)
    {
        $params = array(
            'amount' => $params['amount'],
            'currency' => $params['currency'],
            'language' => $payment->getLanguage(),
            'orderDescription' => $order->firstname . ' ' . $order->lastname . ' (' . $order->zip . '), '.$payment->trlKwf('Order: {0}', $order->number),
            'firstname' => $order->firstname,
            'lastname' => $order->lastname,
            'email' => $order->email,
            'city' => $order->city,
            'country' => $order->country,
            'street1' => $order->street,
            'postal-code' => $order->zip,
            'displayText' => $payment->trlKwf('Thank you very much for your order.'),
            'successRedirectUrl' => $payment->getChildComponent('_success')->getAbsoluteUrl(),
            'failRedirectUrl' => $payment->getChildComponent('_failure')->getAbsoluteUrl(),
            'cancelRedirectUrl' => $payment->getChildComponent('_cancel')->getAbsoluteUrl(),
            'paymentType' => $params['paymentType'],
            'orderId' => $params['orderId'],
        );
        $ret = "<form action=\"$initUrl\" method=\"post\" name=\"form\">\n";
        foreach ($params as $k=>$i) {
        if ($k == 'secret') continue;
            $ret .= "<input type=\"hidden\" name=\"$k\" value=\"".Kwf_Util_HtmlSpecialChars::filter($i)."\">\n";
        }

        $ret .= "<input type=\"button\" value=\"{$payment->trlKwf('Buy now')}\" class=\"submit\">\n";
        $ret .= "</form>\n";
        return $ret;

    }

    protected function _getWirecardButton()
    {
        $order = Kwf_Model_Abstract::getInstance(Kwc_Abstract::getSetting(
            $this->getData()->getParentByClass('KwcShop_Kwc_Shop_Cart_Component')->componentClass, 'childModel'
        ))->getReferencedModel('Order')->getCartOrder();
        $total = $this->getData()->getParentByClass('KwcShop_Kwc_Shop_Cart_Checkout_Component')
            ->getComponent()->getTotal($order);

        $payment = $this->getData()->getParentByClass('KwcShop_Kwc_Shop_Cart_Checkout_Payment_Wirecard_Component');

        $params = array(
            'amount' => round($total, 2),
            'currency' => 'EUR',
            'paymentType' => Kwc_Abstract::getSetting($payment->componentClass, 'paymentType'),
            'orderId' => $order->id
        );
        $initUrl =  Kwc_Admin::getInstance($this->getData()->componentClass)
                ->getControllerUrl() . '/json-initiate-payment';

        return self::buildWirecardButtonHtml($params, $payment, $order, $initUrl);
    }
}
