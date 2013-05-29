<?php

class Binding {

    var $oObj;
    var $sMethod;

    function __construct(&$oObj, $sMethod) {
        $this->oObj = $oObj;
        $this->sMethod = $sMethod;
    }
    
    function trigger($aArgs = array()) {
        call_user_func_array(array($this->oObj, $this->sMethod), $aArgs);
    }
}
?>
