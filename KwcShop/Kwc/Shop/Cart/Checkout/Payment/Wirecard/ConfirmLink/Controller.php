<?php
class KwcShop_Kwc_Shop_Cart_Checkout_Payment_Wirecard_ConfirmLink_Controller extends Zend_Controller_Action
{
    // is called by js, so it might be that this code isn't called at all
    public function jsonConfirmOrderAction()
    {
        $component = Kwf_Component_Data_Root::getInstance()
            ->getComponentById($this->_getParam('paymentComponentId'));
        $order = Kwf_Model_Abstract::getInstance(Kwc_Abstract::getSetting($component->getParentByClass('KwcShop_Kwc_Shop_Cart_Component')->componentClass, 'childModel'))
            ->getReferencedModel('Order')->getCartOrder();
        if ($order && $component &&
            is_instance_of($component->componentClass, 'KwcShop_Kwc_Shop_Cart_Checkout_Payment_Wirecard_Component')
        ) {
            $order->payment_component_id = $component->componentId;
            $order->checkout_component_id = $component->parent->componentId;
            $order->cart_component_class = $component->parent->parent->componentClass;
            $order->status = 'processing';
            $order->date = date('Y-m-d H:i:s');
            $order->save();
            $session = new Kwf_Session_Namespace('kwcShopCart');
            $session->wirecardCartId = $order->id;
        }
    }

    public function jsonInitiatePaymentAction()
    {
        $wirecardUrl = Kwf_Config::getValue('wirecard.url');
        $wirecardMerchantId = Kwf_Config::getValue('wirecard.merchant.id');
        $wirecardUsername = Kwf_Config::getValue('wirecard.auth.username');
        $wirecardPassword = Kwf_Config::getValue('wirecard.auth.password');

        if (!$wirecardUrl || !$wirecardMerchantId || !$wirecardUsername || !$wirecardPassword) {
            throw new Kwf_Exception_Client('Set wirecard settings in config. (wirecard.url, wirecard.merchant.id, wirecard.auth.username, wirecard.auth.password)');
        }

        $client = new Zend_Http_Client($wirecardUrl);
        $client->setHeaders(array(
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ));
        $client->setAuth($wirecardUsername, $wirecardPassword, \Zend_Http_Client::AUTH_BASIC);
        $postData = array(
            'payment' => array_merge(array(
                'merchant-account-id' => array(
                    'value' => $wirecardMerchantId
                ),
                'account-holder' => array(
                    'first-name' => $this->getParam('firstname'),
                    'last-name' => $this->getParam('lastname'),
                ),
                'locale' => $this->getParam('language'),
                'request-id' => $this->getParam('orderId'),
                'requested-amount' => array(
                    'value' => floatval($this->getParam('amount')),
                    'currency' => $this->getParam('currency')
                ),
                'success-redirect-url' => $this->getParam('successRedirectUrl'),
                'fail-redirect-url' => $this->getParam('failRedirectUrl'),
                'cancel-redirect-url' => $this->getParam('cancelRedirectUrl'),
                'descriptor' => trl("Bestellung Nr. {$this->getParam('orderId')}") // text for bank statement (sofort)
            ),
            $this->_getPaymentTypeData($this->getParam('paymentType')))
        );
        $client->setRawData(json_encode($postData));
        try {
            $response = $client->request('POST');
            if ($response->isSuccessful()) {
                $body = json_decode($response->getBody(), true);
                $this->view->redirectUrl = $body['payment-redirect-url'];
            } else {
                $this->view->errorMessage = trl('Bei der Bezahlung ist ein Fehler aufgetreten. Bitte probieren sie es nach einer Weile erneut.');
                $this->view->success = false;
            }
        } catch (Exception $e) {
            $this->view->errorMessage = trl('Bei der Bezahlung ist ein Fehler aufgetreten. Bitte probieren sie es nach einer Weile erneut.');
            $this->view->success = false;
        }
    }

    private function _getPaymentTypeData($paymentType)
    {
        switch ($paymentType) {
            case 'creditcard':
            case 'paybox':
                $transactionType = 'purchase';
                break;
            case 'alipay-xborder':
            case 'bancontact':
            case 'eps':
            case 'ideal':
            case 'paydirekt':
            case 'paylib':
            case 'paypal':
            case 'paysafecard':
            case 'p24':
            case 'sepadirectdebit':
            case 'sofortbanking':
                $transactionType = 'debit';
                break;
        }
        return array(
            'transaction-type' => $transactionType,
            'payment-methods' => array(
                'payment-method' => array(
                    array(
                        'name' => $paymentType
                    )
                )
            ),
        );
    }
}
