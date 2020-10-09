<?php
class Settings{
    public $modal_width;
    public $modal_height;

    public function set_hw($h, $w){
        $this->modal_width = $w;
        $this->modal_height = $h;
    }
}
?>