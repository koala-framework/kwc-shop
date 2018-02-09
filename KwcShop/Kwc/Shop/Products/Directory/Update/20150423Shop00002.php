<?php
class KwcShop_Kwc_Shop_Products_Directory_Update_20150423Shop00002 extends Kwf_Update
{
    public function update()
    {
        $db = Kwf_Registry::get('db');
        $db->query('ALTER TABLE `kwc_wirecard_log` ADD `custom` varchar(255) NOT NULL');
        $db->query('ALTER TABLE `kwc_wirecard_log` ADD `callback_success` tinyint(1) NOT NULL');

        $ordersModel = Kwf_Model_Abstract::getInstance('KwcShop_Kwc_Shop_Cart_Orders');
        $logModel = Kwf_Model_Abstract::getInstance('KwcShop_Kwc_Shop_Cart_Checkout_Payment_Wirecard_LogModel');
        foreach ($logModel->getRows() as $row) {
            if (!$row->custom_order_id) continue;

            $order = $ordersModel->getRow($row->custom_order_id);
            $custom = KwcShop_Kwc_Shop_Cart_Checkout_Payment_Wirecard_LogModel::getEncodedCallback(
                $order->payment_component_id, array('orderId' => $order->id)
            );
            $row->custom = $custom;
            $row->callback_success = true;
            $row->save();
        }

        $db->query('ALTER TABLE `kwc_wirecard_log` DROP `custom_order_id`');
    }

}

