<?php
interface KwcShop_Kwc_Shop_Cart_Plugins_Interface
{
    public function getAdditionalSumRows($order, $total);
    public function orderConfirmed(KwcShop_Kwc_Shop_Cart_Order $order);
    public function alterBackendOrderForm(Kwf_Form $form);

    /**
     * Placeholders für Mails, Confirm Seite etc
     */
    public function getPlaceholders(KwcShop_Kwc_Shop_Cart_Order $order);
}
