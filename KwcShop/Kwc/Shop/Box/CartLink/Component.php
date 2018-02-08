<?php
class KwcShop_Kwc_Shop_Box_CartLink_Component extends Kwc_Abstract
{
    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        $ret['viewCache'] = false;
        $ret['rootElementClass'] = 'kwfUp-webStandard kwcShopBoxCartLink';
        $ret['assets']['dep'][] = 'ExtConnection';
        $ret['placeholder']['toCart'] = trlKwfStatic('To cart');
        $ret['ordersModel'] = 'KwcShop_Kwc_Shop_Cart_Orders';
        return $ret;
    }


    public function getTemplateVars(Kwf_Component_Renderer_Abstract $renderer)
    {
        $ret = parent::getTemplateVars($renderer);

        $ret['links'] = $this->_getLinks();

        $ret['hasContent'] = $this->hasContent();
        
        $ret['totalAmount'] = Kwf_Model_Abstract::getInstance($this->_getSetting('ordersModel'))
            ->getCartOrder()->getTotalAmount();
        
        return $ret;
    }

    protected function _getLinks()
    {
        $ret = array();
        $placeholder = $this->_getSetting('placeholder');
        $ret['cart'] = array(
            'component' => $this->_getCart(),
            'text' => $placeholder['toCart']
        );
        return $ret;
    }

    private function _getCart()
    {
        return Kwf_Component_Data_Root::getInstance()->getComponentByClass(
            'KwcShop_Kwc_Shop_Cart_Component',
            array('subroot' => $this->getData())
        );
    }

    public function hasContent()
    {
        if (!$this->_getCart()) return false;
        return (bool)$this->_getCart()->countChildComponents(array('generator'=>'detail'));
    }
}
