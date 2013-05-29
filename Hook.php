<?php

class Hook {

    /**
     * Stores the static instance of this object - singleton design pattern
     * @param object
     */
    private static $instance;

    private $aHooks = array();

    private function __construct() {
        
    }

    /**
     * get instance of this object
     */
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Hook();
        }

        return self::$instance;
    }
    /*
    *bind event to method 
    */
    function bind($sEvent, &$oObj, $sMethod) {
        $this->aHooks[$sEvent][] = new Binding($oObj, $sMethod);
    }

    /**
     * Trigger a bound event
     */
    function trigger($sEvent, $aArgs = array()) {
        if (array_key_exists($sEvent, $this->aHooks)) {
            foreach ($this->aHooks[$sEvent] as $key => $Binding) {
                $Binding->trigger($aArgs);
            }
        }
    }

}
?>
