<?php

include 'ImgEditor.php';
include 'Binding.php';
include 'Hook.php';

/* 
 * the first extend
 * build for gray scale filter
 */
class Extend {
    var $file_save_path = 'newImages';
    
    function __construct() {
        $Hook = Hook::getInstance();
        $Hook->bind('grayscale', $this, 'grayscale');
    }

    public function grayscale($imgs, $scale) {
        $date = date('j_F_Y_h_i');
        
        foreach ($imgs as $image) {
            $extension = $this->get_image_extension($image);
            $new_image = $date . '_grayscale_' . $image;
            if ($extension == '.jpg' || $extension == '.jpeg') {
                $image_orig = ImageCreateFromJPEG($image);
            } elseif ($extension == '.png') {
                $image_orig = imagecreatefrompng($image);
            } elseif ($extension == '.gif') {
                $image_orig = imagecreatefromgif($image);
            }
            
            for ($i = 0; $i < $scale; $i++) {
                    imagefilter($image_orig, IMG_FILTER_GRAYSCALE);
            }
            
            if ($extension== '.jpg' || $extension== '.jpeg') {
                ImageJPEG($image_orig, $this->file_save_path . '/' . $new_image);
            } elseif ($extension == '.png') {
                imagepng($image_orig, $this->file_save_path . '/' . $new_image);
            } elseif ($extension == '.gif') {
                imagegif($image_orig, $this->file_save_path . '/' . $new_image);
            }
            ImageDestroy($image_orig);
        }
    }

    public function get_image_extension($image){
        $imageData = getimagesize($image);
        return image_type_to_extension($imageData[2]);
    }
}


$Base = new ImgEditor();
$Extend = new Extend();

$imgs['1'] = 'cat.jpg';
$arr[1] = $imgs;
$arr[2] = 2;
$Base->applyEffect('grayscale', $arr)
?>
