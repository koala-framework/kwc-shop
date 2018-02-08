<?php
class KwcShop_Kwc_Shop_Cart_Component extends Kwc_Directories_Item_Directory_Component
{
    private $_chartPlugins;

    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        $ret['generators']['child']['component']['form'] = 'KwcShop_Kwc_Shop_Cart_Form_Component';
        $ret['generators']['child']['component']['view'] = 'KwcShop_Kwc_Shop_Cart_View_Component';
        $ret['generators']['detail']['class'] = 'KwcShop_Kwc_Shop_Cart_Generator';
        $ret['generators']['detail']['component'] = 'KwcShop_Kwc_Shop_Cart_Detail_Component';
        $ret['childModel'] = 'KwcShop_Kwc_Shop_Cart_OrderProducts';
        $ret['generators']['checkout'] = array(
            'class' => 'Kwf_Component_Generator_Page_Static',
            'component' => 'KwcShop_Kwc_Shop_Cart_Checkout_Component',
            'name' => trlKwfStatic('Checkout')
        );
        $ret['viewCache'] = false;
        $ret['rootElementClass'] = 'kwfUp-webStandard kwfUp-webForm';
        $ret['componentName'] = trlKwfStatic('Shop.Cart');
        $ret['componentNameShort'] = trlKwfStatic('Cart');
        $ret['componentCategory'] = 'admin';
        $ret['placeholder']['backToShop'] = trlKwfStatic('Back to shop');
        $ret['placeholder']['checkout'] = trlKwfStatic('To checkout');
        $ret['placeholder']['headline'] = trlKwfStatic('Your cart contains');

        $ret['extConfig'] = 'Kwf_Component_Abstract_ExtConfig_None';
        $ret['contentSender'] = 'KwcShop_Kwc_Shop_Cart_ContentSender';

        $ret['flags']['processInput'] = true;

        $ret['vatRate'] = 0.2;
        $ret['vatRateShipping'] = 0.2;
        return $ret;
    }

    public function getOrderProductsModel()
    {
        return $this->getChildModel();
    }

    public function preProcessInput()
    {
        // to remove deleted products from the cart
        Kwf_Model_Abstract::getInstance($this->_getSetting('childModel'))
            ->getReferencedModel('Order')
            ->getCartOrder()
            ->getProductsDataWithProduct($this->getData());
    }

    public function getTemplateVars(Kwf_Component_Renderer_Abstract $renderer)
    {
        $ret = parent::getTemplateVars($renderer);
        $ret['countProducts'] = $this->getData()->countChildComponents(array('generator'=>'detail'));
        $ret['checkout'] = $this->getData()->getChildComponent('_checkout');
        $ret['shop'] = $this->getData()->getParentPage();

        $ret['order'] = Kwf_Model_Abstract::getInstance($this->_getSetting('childModel'))
        ->getReferencedModel('Order')
        ->getCartOrder();
        $ret['subTotal'] = $ret['order']->getSubTotal();
        $ret['total'] = $ret['order']->getTotal();

        $ret['sumRows'] = $ret['order']->getSumRows();
        return $ret;
    }

    public final function getShopCartPlugins()
    {
        return Kwf_Model_Abstract::getInstance($this->_getSetting('childModel'))
            ->getReferencedModel('Order')
            ->getShopCartPlugins();
    }

    public function getFormComponents()
    {
        $ret = array();
        foreach ($this->getData()->getChildComponents(array('generator'=>'detail')) as $c) {
            $ret[] = $c->getChildComponent('-form')
                ->getComponent();
        }
        return $ret;
    }
}
