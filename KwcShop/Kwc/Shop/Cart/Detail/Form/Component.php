<?php
class KwcShop_Kwc_Shop_Cart_Detail_Form_Component extends Kwc_Form_NonAjax_Component
{
    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        $ret['generators']['child']['component']['success'] = false;
        $ret['viewCache'] = false;
        return $ret;
    }

    protected function _initForm()
    {
        $addToCart = $this->getData()->parent->getComponent()->getAddToCartForm();
        if ($addToCart) {
            $f = $addToCart->getComponent()->getForm();
            $this->_form = clone $f;
            $productRow = $this->getData()->parent->getComponent()->getOrderProductRow();
            $this->_form->setName('order'.$productRow->id);
            $this->_form->setId($productRow->id);
        }
    }
}
