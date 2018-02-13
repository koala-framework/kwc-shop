<?php
class KwcShop_Kwc_Shop_Cart_Detail_Component extends Kwc_Abstract_Composite_Component
{
    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        $ret['generators']['child']['component']['form'] = 'KwcShop_Kwc_Shop_Cart_Detail_Form_Component';
        $ret['viewCache'] = false;
        $ret['flags']['processInput'] = true;
        $ret['placeholder']['product'] = trlKwfStatic('Product').': ';
        $ret['placeholder']['unitPrice'] = '';
        return $ret;
    }

    public function preProcessInput($data)
    {
        if (isset($data[$this->getData()->componentId.'-delete'])) {
            $this->getData()->row->delete();
        }
        // HACK: Should be delegated to AddToCartAbstract_Component which show the form
        if (isset($data[$this->getData()->parent->componentId.'-form-update'])) {
            $amount = $data['order'.$this->getData()->row->id.'_amount'];
            $this->getData()->row->amount = $amount;
        }
    }

    public function getTemplateVars(Kwf_Component_Renderer_Abstract $renderer)
    {
        $ret = parent::getTemplateVars($renderer);
        $addCmp = KwcShop_Kwc_Shop_AddToCartAbstract_OrderProductData::getAddComponentByDbId(
            $this->getData()->row->add_component_id, $this->getData()
        );
        if ($addCmp) {
            $ret['product'] = $addCmp->getComponent()->getProduct();
            $ret['row'] = $this->getData()->row;
            $ret['price'] = $addCmp->getComponent()->getPrice($ret['row']);
            $ret['text'] = $addCmp->getComponent()->getProductText($ret['row']);
        }
        return $ret;
    }

    public function getAddToCartForm()
    {
        return KwcShop_Kwc_Shop_AddToCartAbstract_OrderProductData::getAddComponentByDbId(
            $this->getData()->row->add_component_id, $this->getData()
        );

    }

    public function getOrderProductRow()
    {
        return $this->getData()->row;
    }
}
