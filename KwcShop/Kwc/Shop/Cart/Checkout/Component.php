<?php
class KwcShop_Kwc_Shop_Cart_Checkout_Component extends Kwc_Abstract_Composite_Component
{
    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        $ret['componentName'] = trlKwfStatic('Orders');
        $ret['generators']['child']['component']['form'] = 'KwcShop_Kwc_Shop_Cart_Checkout_Form_Component';

        $ret['generators']['payment'] = array(
            'class' => 'Kwf_Component_Generator_PseudoPage_Static',
            'component' => array(
                'prePayment' => 'KwcShop_Kwc_Shop_Cart_Checkout_Payment_PrePayment_Component',
                'cashOnDelivery' => 'KwcShop_Kwc_Shop_Cart_Checkout_Payment_CashOnDelivery_Component',
                'payPal' => 'KwcShop_Kwc_Shop_Cart_Checkout_Payment_PayPal_Component',
                'none' => 'KwcShop_Kwc_Shop_Cart_Checkout_Payment_None_Component'
            )
        );
        $ret['rootElementClass'] = 'kwfUp-webForm kwfUp-webStandard';
        $ret['placeholder']['backToCart'] = trlKwfStatic('Back to cart');

        $ret['shipping'] = 0;

        $ret['generateInvoices'] = true;

        $ret['menuConfig'] = 'KwcShop_Kwc_Shop_Cart_Checkout_MenuConfig';

        $ret['assetsAdmin']['dep'][] = 'ExtFormDateField';
        $ret['assetsAdmin']['files'][] = 'kwcShop/KwcShop/Kwc/Shop/Cart/Checkout/OrdersPanel.js';

        return $ret;
    }

    public final function getTotal($order)
    {
        return $order->getTotal();
    }

    public final function getSumRows($order)
    {
        $ret = $order->getSumRows();
        foreach ($ret as &$r) {
            $r['text'] = $this->getData()->trlStaticExecute($r['text']);
        }
        return $ret;
    }

    public function getPayments()
    {
        return Kwc_Abstract::getChildComponentClasses($this->getData()->componentClass, 'payment');
    }

    public function getPayment($order)
    {
        return $this->getData()->getChildComponent('-'.$order->payment);
    }

    public function getOrderModel()
    {
        return Kwf_Model_Abstract::getInstance(Kwc_Abstract::getSetting($this->getData()->getParentByClass('KwcShop_Kwc_Shop_Cart_Component')->componentClass, 'childModel'))
                ->getReferencedModel('Order');
    }
}
