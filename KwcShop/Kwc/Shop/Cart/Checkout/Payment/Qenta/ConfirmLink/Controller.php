<?php
class KwcShop_Kwc_Shop_Cart_Checkout_Payment_Qenta_ConfirmLink_Controller extends Zend_Controller_Action
{
    // is called by js, so it might be that this code isn't called at all
    public function jsonConfirmOrderAction()
    {
        $component = Kwf_Component_Data_Root::getInstance()
            ->getComponentById($this->_getParam('paymentComponentId'));
        $order = Kwf_Model_Abstract::getInstance(Kwc_Abstract::getSetting($component->getParentByClass('KwcShop_Kwc_Shop_Cart_Component')->componentClass, 'childModel'))
            ->getReferencedModel('Order')->getCartOrder();
        if ($order && $component &&
            is_instance_of($component->componentClass, 'KwcShop_Kwc_Shop_Cart_Checkout_Payment_Qenta_Component')
        ) {
            if (!$order->countChildRows('Products')) {
                $this->view->success = false;
                $this->view->message = trlKwf("Can't submit order because the cart is empty.");
                return;
            }

            $order->payment_component_id = $component->componentId;
            $order->checkout_component_id = $component->parent->componentId;
            $order->cart_component_class = $component->parent->parent->componentClass;
            $order->status = 'processing';
            $order->date = date('Y-m-d H:i:s');
            $order->save();

            $session = new Kwf_Session_Namespace('kwcShopCart');
            $session->qentaCartId = $order->id;

            $confirmLinkCmp = $component->getChildComponent('-confirmLink');
            $total = $component->parent->getComponent()->getTotal($order);
            $params = array(
                'amount' => round($total, 2),
                'currency' => 'EUR',
                'paymentType' => Kwc_Abstract::getSetting($component->componentClass, 'paymentType'),
                'orderId' => $order->id
            );
            $this->view->formHtml = call_user_func(array($confirmLinkCmp->componentClass, 'buildWirecardButtonHtml'),
                $params,
                $component,
                $order,
                Kwf_Config::getValue('qenta.url')
            );
        }
    }

}
