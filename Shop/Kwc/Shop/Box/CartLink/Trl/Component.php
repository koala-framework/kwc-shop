<?php
class Shop_Kwc_Shop_Box_CartLink_Trl_Component extends Kwc_Chained_Trl_Component
{
    public function getTemplateVars(Kwf_Component_Renderer_Abstract $renderer)
    {
        $ret = parent::getTemplateVars($renderer);
        foreach ($ret['links'] as $k=>$i) {
            $chained = Kwc_Chained_Trl_Component::getChainedByMaster($i['component'], $this->getData());
            if ($chained) {
                $ret['links'][$k]['component'] = $chained;
            } else {
                unset($ret['links'][$k]);
            }
        }
        return $ret;
    }
}
