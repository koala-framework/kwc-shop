<?php
class KwcShop_Kwc_Shop_Cart_Checkout_Payment_Wirecard_Success_Component extends Kwc_Editable_Component
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
        Kwf_Exception_Abstract::$logErrors = true; //activate log always, because request comes from wirecard
        ignore_user_abort(true);

        if (!isset($_POST['response-base64']))
            throw new Kwf_Exception_Client('Invalid request');
        if (!$this->_isValidSignature($_POST['response-base64'], $_POST['response-signature-base64']))
            throw new Kwf_Exception_Client('Response verification failed');

        $paymentResponse = json_decode(base64_decode($_POST['response-base64']), true);
        $this->getData()->parent->getComponent()->processWirecardResponse($paymentResponse);
    }

    private function _isValidSignature($responseBase64, $signatureBase64)
    {
        $secret = Kwf_Config::getValue('wirecard.secret');
        $signature = hash_hmac('sha256', $responseBase64, $secret, true);
        return hash_equals($signature, base64_decode($signatureBase64));
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
