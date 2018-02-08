<?php
class Shop_Kwc_Shop_AddToCartAbstract_Trl_Component extends Kwc_Chained_Trl_Component
{
    public static function getSettings($masterComponentClass = null)
    {
        $ret = parent::getSettings($masterComponentClass);
        $ret['generators']['form'] = array(
            'class' => 'Kwf_Component_Generator_Static',
            'component' => 'Shop_Kwc_Shop_AddToCartAbstract_Trl_Form_Component'
        );
        return $ret;
    }

    public function getTemplateVars(Kwf_Component_Renderer_Abstract $renderer)
    {
        $ret = Kwc_Chained_Trl_Component::getTemplateVars($renderer);
        $ret['form'] = $this->getData()->getChildComponent('-form');
        return $ret;
    }

    public function getForm()
    {
        return $this->getData()->getChildComponent('-form')->getComponent()->getForm();
    }

    public final function getAdditionalOrderData(Shop_Kwc_Shop_Cart_OrderProduct $orderProduct)
    {
        return Shop_Kwc_Shop_AddToCartAbstract_OrderProductData::getInstance($this->getData()->componentClass)
            ->getAdditionalOrderData($orderProduct);
    }

    public function getPrice(Shop_Kwc_Shop_Cart_OrderProduct $orderProduct)
    {
        return Shop_Kwc_Shop_AddToCartAbstract_OrderProductData::getInstance($this->getData()->componentClass)
            ->getPrice($orderProduct);
    }

    public final function getAmount(Shop_Kwc_Shop_Cart_OrderProduct $orderProduct)
    {
        return Shop_Kwc_Shop_AddToCartAbstract_OrderProductData::getInstance($this->getData()->componentClass)
            ->getAmount($orderProduct);
    }

    public final function orderConfirmed(Shop_Kwc_Shop_Cart_OrderProduct $orderProduct)
    {
        Shop_Kwc_Shop_AddToCartAbstract_OrderProductData::getInstance($this->getData()->componentClass)
            ->orderConfirmed($orderProduct);
    }

    public function getProductText(Shop_Kwc_Shop_Cart_OrderProduct $orderProduct)
    {
        return $this->getData()->getParentByClass('Shop_Kwc_Shop_Products_Detail_Trl_Component')->row->title;
    }

    public function getProduct()
    {
        return $this->getData()->parent;
    }
}
