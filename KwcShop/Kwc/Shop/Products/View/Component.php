<?php
class KwcShop_Kwc_Shop_Products_View_Component extends KwcShop_Kwc_Shop_Products_ViewWithoutAddToCart_Component
{
    public function getPartialVars($partial, $nr, $info)
    {
        $ret = parent::getPartialVars($partial, $nr, $info);
        $ret['item']->addToCart = null;
        $ret['item']->addToCart = $this->getData()->parent->getComponent()
            ->getItemDirectory()->getChildComponent('-'.$ret['item']->id);
        return $ret;
    }
}
