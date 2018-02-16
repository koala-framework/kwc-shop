<?php
class KwcShop_Kwc_Shop_Products_Directory_Update_20150309Shop00004 extends Kwf_Update
{
    public function update()
    {
        $rows = Kwf_Model_Abstract::getInstance('KwcShop_Kwc_Shop_Cart_OrderProducts')->getRows();
        echo "updading ".count($rows)." rows...\n";
        foreach ($rows as $row) {
            $row->size = (int)$row->size_backup;
            $row->amount = (int)$row->amount_backup;
            $row->save();
        }
    }
}