<?php
/**
 * set preLoginIgnore for wirecard confirm url in config: preLoginIgnore.wirecardConfirm = url
 **/
class KwcShop_Kwc_Shop_Cart_Checkout_Payment_Wirecard_Component extends KwcShop_Kwc_Shop_Cart_Checkout_Payment_Abstract_Component
{
    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        $ret['componentName'] = trlKwfStatic('Wirecard');
        // Delete confirm because of wirecard dispatch confirm url
        unset($ret['generators']['confirm']);
        $ret['generators']['child']['component']['confirmLink'] = 'KwcShop_Kwc_Shop_Cart_Checkout_Payment_Wirecard_ConfirmLink_Component';
        $ret['generators']['cancel'] = array(
            'class' => 'Kwf_Component_Generator_Page_Static',
            'component' => 'KwcShop_Kwc_Shop_Cart_Checkout_Payment_Wirecard_Cancel_Component',
            'name' => trlKwfStatic('Cancel')
        );

        $ret['generators']['failure'] = array(
            'class' => 'Kwf_Component_Generator_Page_Static',
            'component' => 'KwcShop_Kwc_Shop_Cart_Checkout_Payment_Wirecard_Failure_Component',
            'name' => trlKwfStatic('Failure')
        );

        $ret['generators']['success'] = array(
            'class' => 'Kwf_Component_Generator_Page_Static',
            'component' => 'KwcShop_Kwc_Shop_Cart_Checkout_Payment_Wirecard_Success_Component',
            'name' => trlKwfStatic('Success')
        );

        /**
         * Possible types are:
         * creditcard, alipay-xborder, bancontact, eps, ideal, paybox, paydirekt, paylib, paypal, paysafecard,
         * p24, sepadirectdebit, sofortbanking
         **/
        $ret['paymentType'] = '';
        return $ret;
    }

    public function processWirecardResponse($wirecardResponse)
    {
        $paymentState = isset($wirecardResponse['payment']['transaction-state']) ? $wirecardResponse['payment']['transaction-state'] : null;
        if ($paymentState == 'failed') {
            $message = trl('Transaktion ist fehlgeschlagen.');
            $message .= ' ' . $paymentResponse['statuses']['status'][0]['description']; // take latest error message
            $e = new Kwf_Exception('Wirecard Transaction Failed: '.$message);
            $e->log();
        } else if ($paymentState == 'success') {
            $orderId = $wirecardResponse['payment']['request-id'];
            $orderRow = Kwf_Model_Abstract::getInstance(Kwc_Abstract::getSetting($this->getData()->parent->parent->componentClass, 'childModel'))
                ->getReferencedModel('Order')->getRow($orderId);

            if (!$orderRow) {
                throw new Kwf_Exception("Order not found");
            }

            $orderRow->payment_component_id = $this->getData()->componentId;
            $orderRow->checkout_component_id = $this->getData()->parent->componentId;
            $orderRow->cart_component_class = $this->getData()->parent->parent->componentClass;
            $orderRow->status = 'payed';
            $orderRow->payed = date('Y-m-d H:i:s');

            if (!$orderRow->confirm_mail_sent) {
                foreach ($this->getData()->parent->parent->getComponent()->getShopCartPlugins() as $p) {
                    $p->orderConfirmed($orderRow);
                }
                foreach ($orderRow->getChildRows('Products') as $p) {
                    $addComponent = KwcShop_Kwc_Shop_AddToCartAbstract_OrderProductData::getAddComponentByDbId(
                        $p->add_component_id, $this->getData()
                    );
                    if ($addComponent) $addComponent->getComponent()->orderConfirmed($p);
                }
                $this->sendConfirmMail($orderRow);

                $orderRow->date = date('Y-m-d H:i:s');
                $orderRow->confirm_mail_sent = date('Y-m-d H:i:s');
            }
            $orderRow->save();
            KwcShop_Kwc_Shop_Cart_Orders::setOverriddenCartOrderId($orderId);
            if (KwcShop_Kwc_Shop_Cart_Orders::getCartOrderId() == $orderId) {
                KwcShop_Kwc_Shop_Cart_Orders::resetCartOrderId();
            }
            return true;
        } else {
            throw new Kwf_Exception('Error while processing the order');
        }
        return false;
    }
}
