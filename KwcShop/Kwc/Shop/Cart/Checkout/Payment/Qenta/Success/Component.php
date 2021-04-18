<?php
class KwcShop_Kwc_Shop_Cart_Checkout_Payment_Qenta_Success_Component extends Kwc_Editable_Component
{
    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        $ret['flags']['processInput'] = true;
        $ret['plugins']['placeholders'] = 'Kwf_Component_Plugin_Placeholders';
        $ret['viewCache'] = false;
        $ret['generators']['content']['component'] = 'KwcShop_Kwc_Shop_Cart_Checkout_Payment_Abstract_Confirm_Paragraphs_Component';
        return $ret;
    }

    public function getNameForEdit()
    {
        $ret = trlKwf('Shop Confirmation Text');
        $subroot = $this->getData()->getSubroot();
        if ($subroot && isset($subroot->id)) $ret .= ' (' .$this->getData()->getSubroot()->id . ')';
        $ret .= ' ' . Kwf_Trl::getInstance()->trlStaticExecute(Kwc_Abstract::getSetting($this->getData()->parent->componentClass, 'componentName'));
        return $ret;
    }

    protected function _getOrder()
    {
        $ret = Kwf_Model_Abstract::getInstance(Kwc_Abstract::getSetting($this->getData()->getParentByClass('KwcShop_Kwc_Shop_Cart_Component')->componentClass, 'childModel'))
            ->getReferencedModel('Order')->getCartOrder();
        if (!$ret || !$ret->data) {
            return null;
        }
        return $ret;
    }

    public function processInput($data)
    {
        Kwf_Exception_Abstract::$logErrors = true; //activate log always, because request comes from qenta
        ignore_user_abort(true);

        if (!isset($data['orderNumber'])) {
            $home = $this->getData()->getSubroot()->getAbsoluteUrl();
            header("Location: $home");
            exit;
        }

        if (!$this->_isValidResponse($data)) {
            throw new Kwf_Exception_Client(trlKwf('An invalid response was sent.'));
        }
        $this->getData()->parent->getComponent()->processQentaResponse($data);
    }

    private function _isValidResponse($response)
    {
        $secret = Kwf_Config::getValue('qenta.secret');
        $string = '';
        foreach ($response as $key => $value) {
            if ($key == 'responseFingerprint') continue;
            if ($key == 'responseFingerprintOrder') {
                $string .= $secret;
            }
            $string .= "{$value}";
        }
        return $response['responseFingerprint'] == hash_hmac('sha512', $string, $secret);
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
