<?php
abstract class Shop_Kwc_Shop_AddToCartAbstract_Component extends Kwc_Form_Component
{
    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        $ret['placeholder']['submitButton'] = trlKwfStatic('add to cart');
        $ret['generators']['child']['component']['success'] = 'Shop_Kwc_Shop_AddToCartAbstract_Success_Component';
        $ret['orderProductData'] = 'Shop_Kwc_Shop_AddToCartAbstract_OrderProductData';
        $ret['productTypeText'] = null;
        return $ret;
    }

    protected function _initForm()
    {
        parent::_initForm();
        $cart = Kwf_Component_Data_Root::getInstance()
            ->getComponentByClass(
                array('Shop_Kwc_Shop_Cart_Component', 'Shop_Kwc_Shop_Cart_Trl_Component'),
                array('subroot'=>$this->getData(), 'ignoreVisible' => true)
            );
        if (!$cart) throw new Kwf_Exception_Client(trlKwf('Need cart for shop but could not find it. Please add in Admin.'));
        $m = $cart->getComponent()->getOrderProductsModel();
        $this->_form->setModel($m);
    }

    public function getTemplateVars(Kwf_Component_Renderer_Abstract $renderer)
    {
        $ret = parent::getTemplateVars($renderer);
        if ($this->_form->getId()) {
            $ret['placeholder']['submitButton'] = $this->data->trlKwf('Update');
        }
        return $ret;
    }

    protected function _beforeInsert(Kwf_Model_Row_Interface $row)
    {
        parent::_beforeInsert($row);
        $orders = Kwf_Model_Abstract::getInstance('Shop_Kwc_Shop_Cart_Orders');
        $row->shop_order_id = $orders->getCartOrderAndSave()->id;
        $row->add_component_id = $this->getData()->dbId;
        $row->add_component_class = $this->getData()->componentClass;
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

    public final function getProductText(Shop_Kwc_Shop_Cart_OrderProduct $orderProduct)
    {
        return Shop_Kwc_Shop_AddToCartAbstract_OrderProductData::getInstance($this->getData()->componentClass)
            ->getProductText($orderProduct);
    }

    public function getProduct()
    {
        return $this->getData()->parent;
    }
}
