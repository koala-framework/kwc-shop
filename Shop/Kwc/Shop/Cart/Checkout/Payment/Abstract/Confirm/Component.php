<?php
class Shop_Kwc_Shop_Cart_Checkout_Payment_Abstract_Confirm_Component extends Kwc_Editable_Component
{
    private $_order;
    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        $ret['generators']['content']['component'] = 'Shop_Kwc_Shop_Cart_Checkout_Payment_Abstract_Confirm_Paragraphs_Component';
        $ret['flags']['processInput'] = true;
        $ret['rootElementClass'] = 'kwfUp-webStandard';
        $ret['plugins']['placeholders'] = 'Kwf_Component_Plugin_Placeholders';
        $ret['viewCache'] = false;
        return $ret;
    }

    public function getNameForEdit()
    {
        return trlKwf('Shop Confirmation Text') . ' '
            . Kwf_Trl::getInstance()->trlStaticExecute(Kwc_Abstract::getSetting($this->getData()->parent->componentClass, 'componentName'));
    }

    protected function _getOrder()
    {
        $ret = Kwf_Model_Abstract::getInstance(Kwc_Abstract::getSetting($this->getData()->getParentByClass('Shop_Kwc_Shop_Cart_Component')->componentClass, 'childModel'))
            ->getReferencedModel('Order')->getCartOrder();
        if (!$ret || !$ret->data) {
            return null;
        }
        return $ret;
    }

    public function processInput($data)
    {
        $o = $this->_getOrder();
        if (!$o) {
            //this order was already confirmed
            header("Location: ".$this->getData()->parent->parent->parent->parent->url);
            exit;
        } else if (!$o->payment) {
            //this order has no customer data
            header("Location: ".$this->getData()->getParentByClass('Shop_Kwc_Shop_Cart_Checkout_Component')->url);
            exit;
        }
        $this->getData()->parent->getComponent()->confirmOrder($o);
    }

    public function getPlaceholders()
    {
        $o = $this->_getOrder();
        if (!$o) return array();
        return $o->getPlaceholders();
    }

    public final function getCurrentOrder()
    {
        return $this->_getOrder();
    }
}
