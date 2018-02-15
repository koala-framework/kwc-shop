<?php
class KwcShop_Kwc_Shop_Cart_Plugins_Voucher_Component extends Kwf_Component_Plugin_Abstract
    implements KwcShop_Kwc_Shop_Cart_Plugins_Interface
{
    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        $ret['componentName'] = trlKwfStatic('Vouchers');
        $ret['assetsAdmin']['files'][] = 'kwcShop/KwcShop/Kwc/Shop/Cart/Plugins/Voucher/Panel.js';
        $ret['extConfig'] = 'KwcShop_Kwc_Shop_Cart_Plugins_Voucher_ExtConfig';
        $ret['menuConfig'] = 'KwcShop_Kwc_Shop_Cart_Plugins_Voucher_MenuConfig';
        return $ret;
    }

    public function getAdditionalSumRows($order, $total)
    {
        if (!$order instanceof KwcShop_Kwc_Shop_Cart_Order) return array();
        if (!$order->voucher_code) return array();

        $text = trlKwfStatic('Voucher');
        if ($order->voucher_amount) {
            $amount = -(float)$order->voucher_amount;
        } else {

            $s = new Kwf_Model_Select();
            $s->whereEquals('code', $order->voucher_code);
            $row = Kwf_Model_Abstract::getInstance('KwcShop_Kwc_Shop_Cart_Plugins_Voucher_Vouchers')->getRow($s);

            if (!$row || $row->amount - $row->used_amount <= 0) return array();

            $amount = -min($total, $row->amount - $row->used_amount);
            $remainingAmount = $row->amount - $row->used_amount + $amount;
            if ($remainingAmount > 0) {
                $helper = new Kwf_View_Helper_Money();
                $text .= ' ('.trlKwfStatic('Remaining Amount {0}', $helper->money($remainingAmount)).')';
            }
        }

        return array(array(
            'amount' => $amount,
            'text' => $text.':',
            'type' => 'voucher',
            'class' => 'voucher'
        ));
    }

    public function orderConfirmed(KwcShop_Kwc_Shop_Cart_Order $order)
    {
        if (!$order->voucher_code) return;

        $c = Kwf_Component_Data_Root::getInstance()->getComponentByDbId($order->checkout_component_id);
        foreach ($c->getComponent()->getSumRows($order) as $sumRow) {
            if (isset($sumRow['type']) && $sumRow['type'] == 'voucher') {
                $s = new Kwf_Model_Select();
                $s->whereEquals('code', $order->voucher_code);
                $row = Kwf_Model_Abstract::getInstance('KwcShop_Kwc_Shop_Cart_Plugins_Voucher_Vouchers')->getRow($s);
                $remainingAmount = $row->amount - $row->used_amount + $sumRow['amount'];
                $h = $row->createChildRow('history');
                $h->amount = -$sumRow['amount'];
                $h->order_id = $order->id;
                $h->date = $order->date;
                $h->comment = trlKwf('Order').' '.$order->order_number;
                $h->save();

                //verbrauchten betrag auch noch bei der order speichern
                $order->voucher_amount = (float)$h->amount;
                $order->voucher_remaining_amount = (float)$remainingAmount;
                $order->save();
                break;
            }
        }
    }

    public function alterBackendOrderForm(Kwf_Form $form)
    {
        $fs = $form->add(new Kwf_Form_Container_FieldSet(trlKwfStatic('Voucher')));
        $fs->add(new Kwf_Form_Field_TextField('voucher_code', trlKwfStatic('Code')));
        $fs->add(new Kwf_Form_Field_NumberField('voucher_amount', trlKwfStatic('Amount of Money', 'Amount')))
            ->setComment('€')
            ->setWidth(50);
    }

    public function getPlaceholders(KwcShop_Kwc_Shop_Cart_Order $order)
    {
        $helper = new Kwf_View_Helper_Money();

        $remainingAmount = (float)$order->voucher_remaining_amount;
        return array(
            'voucherRemainingAmount' => $helper->money($remainingAmount)
        );
    }
}
