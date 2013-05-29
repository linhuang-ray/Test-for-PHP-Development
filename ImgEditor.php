<?php

class ImgEditor {

    public function __construct() {
    }

    function applyEffect($event, $arr) {
        $Hook = Hook::getInstance();
        $Hook->trigger($event, $arr);
    }
    
}
?>
