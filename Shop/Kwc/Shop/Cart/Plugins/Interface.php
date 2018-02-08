<?php
interface Shop_Kwc_Shop_Cart_Plugins_Interface
{
    public function getAdditionalSumRows($order, $total);
    public function orderConfirmed(Shop_Kwc_Shop_Cart_Order $order);
    public function alterBackendOrderForm(Kwf_Form $form);

    /**
     * Placeholders für Mails, Confirm Seite etc
     */
    public function getPlaceholders(Shop_Kwc_Shop_Cart_Order $order);
}
