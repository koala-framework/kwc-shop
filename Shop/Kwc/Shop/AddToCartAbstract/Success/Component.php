<?php
class Shop_Kwc_Shop_AddToCartAbstract_Success_Component extends Kwc_Form_Success_Component
{
    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        return $ret;
    }

    public function getTemplateVars(Kwf_Component_Renderer_Abstract $renderer)
    {
        $ret = parent::getTemplateVars($renderer);
        $ret['cart'] = Kwf_Component_Data_Root::getInstance()
            ->getComponentByClass(array('Shop_Kwc_Shop_Cart_Component', 'Shop_Kwc_Shop_Cart_Trl_Component'), array('ignoreVisible' => true, 'subroot'=>$this->getData()));
        return $ret;
    }
}
