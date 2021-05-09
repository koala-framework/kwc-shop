<?php
class KwcShop_Kwc_Shop_Cart_Checkout_Payment_Qenta_Cancel_ContentSender extends Kwf_Component_Abstract_ContentSender_Default
{
    public function sendContent($includeMaster)
    {
        $session = new Kwf_Session_Namespace('kwcShopCart');
        if ($session->qentaCartId) {
            $orderId = $session->qentaCartId;
        } else if (isset($_POST['babytuch_orderId'])) {
            $orderId = $_POST['babytuch_orderId'];
        }

        if (isset($orderId)) {
            KwcShop_Kwc_Shop_Cart_Orders::setCartOrderId($orderId);
            $order = Kwf_Model_Abstract::getInstance(Kwc_Abstract::getSetting($this->_data->parent->parent->parent->componentClass, 'childModel'))
                ->getReferencedModel('Order')->getCartOrder();
            $order->status = 'cart';
            $order->save();
            unset($session->qentaCartId);
        }
        Kwf_Util_Redirect::redirect($this->_data->parent->parent->parent->getUrl());
    }
}
