<?php
class KwcShop_Kwc_Shop_Cart_Checkout_Payment_Qenta_Failure_Component extends Kwc_Editable_Component
{
    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        $ret['flags']['processInput'] = true;
        return $ret;
    }

    public function getNameForEdit()
    {
        $ret = trlKwf('Shop Error Text');
        $subroot = $this->getData()->getSubroot();
        if ($subroot && isset($subroot->id)) $ret .= ' (' .$this->getData()->getSubroot()->id . ')';
        $ret .= ' ' . Kwf_Trl::getInstance()->trlStaticExecute(Kwc_Abstract::getSetting($this->getData()->parent->componentClass, 'componentName'));
        return $ret;
    }
}
