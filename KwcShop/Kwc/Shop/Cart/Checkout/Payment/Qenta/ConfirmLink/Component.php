<?php
class KwcShop_Kwc_Shop_Cart_Checkout_Payment_Qenta_ConfirmLink_Component extends Kwc_Abstract
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
        $ret['options'] = array(
            'confirmOrderUrl' => "$controllerBaseUrl/json-confirm-order",
            'params' => array(
                'paymentComponentId' => $this->getData()->parent->componentId
            )
        );
        return $ret;
    }

    //used in trl
    public static function buildWirecardButtonHtml($params, $payment, $order, $paymentUrl)
    {
        $postData = array(
            'customerId' => Kwf_Config::getValue('qenta.customerId'),
            'consumerBillingFirstname' => $order->firstname,
            'consumerBillingLastname' => $order->lastname,
            'consumerEmail' => $order->email,
            'consumerBillingAddress1' => $order->street,
            'consumerBillingCity' => $order->city,
            'consumerBillingCountry' => $order->country,
            'consumerBillingZipCode' => $order->zip,
            'consumerChallengeIndicator' => '04',
            'merchantTokenizationFlag' => 'true',
            'orderDescription' => $order->firstname . ' ' . $order->lastname . ' (' . $order->zip . ') '.$payment->trlKwf('Order: {0}', $order->order_number),
            'customerStatement' => $payment->trlKwf('Order: {0}', $order->order_number), // bank statement
            'duplicateRequestCheck' => 'no',
            'successUrl' => $payment->getChildComponent('_success')->getAbsoluteUrl(),
            'cancelUrl' => $payment->getChildComponent('_cancel')->getAbsoluteUrl(),
            'serviceUrl' => $payment->getChildComponent('_cancel')->getAbsoluteUrl(),
            'failureUrl' => $payment->getChildComponent('_failure')->getAbsoluteUrl(),
            'language' => $payment->getLanguage(),
            'amount' => $params['amount'],
            'currency' => $params['currency'],
            'paymentType' => $params['paymentType'],
            'orderReference' => $params['orderId'],
            'babytuch_orderId' => $order->id
        );
        $postData['requestFingerprintOrder'] = self::_getRequestFingerprintOrder($postData);
        $postData['requestFingerprint'] = self::_getRequestFingerprint($postData, Kwf_Config::getValue('qenta.secret'));

        $ret = "<form action=\"$paymentUrl\" method=\"post\" name=\"form\">\n";
        foreach ($postData as $k=>$i) {
            if ($k == 'secret') continue;
            $ret .= "<input type=\"hidden\" name=\"$k\" value=\"".Kwf_Util_HtmlSpecialChars::filter($i)."\">\n";
        }
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

        $payment = $this->getData()->getParentByClass('KwcShop_Kwc_Shop_Cart_Checkout_Payment_Qenta_Component');

        $params = array(
            'amount' => round($total, 2),
            'currency' => 'EUR',
            'paymentType' => Kwc_Abstract::getSetting($payment->componentClass, 'paymentType'),
            'orderId' => $order->id
        );
        $paymentUrl = Kwf_Config::getValue('qenta.url');

        return self::buildWirecardButtonHtml($params, $payment, $order, $paymentUrl);
    }

    protected static function _getRequestFingerprintOrder($postData)
    {
        $ret = '';
        foreach ($postData as $key => $value) {
            $ret .= "{$key},";
        }
        $ret .= 'requestFingerprintOrder,secret';

        return $ret;
    }

    protected static function _getRequestFingerprint($postData, $secret)
    {
        $ret = '';
        foreach ($postData as $key => $value) {
            $ret .= "{$value}";
        }
        $ret .= "{$secret}";

        return hash_hmac('sha512', $ret, $secret);
    }
}
