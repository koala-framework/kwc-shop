<?php
class KwcShop_Kwc_Shop_Products_Detail_RelatedProducts_Product_Component extends Kwc_Abstract_Composite_Component
{
    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        $ret['componentName'] = trlKwfStatic('Related Products');
        $ret['ownModel'] = 'Kwf_Component_FieldModel';
        return $ret;
    }

    public function getTemplateVars(Kwf_Component_Renderer_Abstract $renderer)
    {
        $ret = parent::getTemplateVars($renderer);
        $ret['product'] = Kwf_Component_Data_Root::getInstance()->getComponentByClass(
            'KwcShop_Kwc_Shop_Products_Detail_Component',
            array('id' => $this->getRow()->product_id)
        );
        return $ret;
    }
}
