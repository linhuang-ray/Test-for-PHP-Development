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

/*
 * the second plugin 
 * build for resize effect
 */
class Extend2 {
    var $file_save_path = 'newImages';
    
    function __construct() {
        $Hook = Hook::getInstance();
        $Hook->bind('resize', $this, 'resize');
    }

     public function resize($imgs, $width, $height = null) {
        $date = date('j_F_Y_h_i');
        
        foreach ($imgs as $image) {
            $extension = $this->get_image_extension($image);
            $new_image = $date . '_resize_' . $image;
            if ($extension == '.jpg' || $extension == '.jpeg') {
                $image_orig = ImageCreateFromJPEG($image);
            } elseif ($extension == '.png') {
                $image_orig = imagecreatefrompng($image);
            } elseif ($extension == '.gif') {
                $image_orig = imagecreatefromgif($image);
            }
            if ($height == null){
                $height = $width;
            }
            $photoX = ImagesX($image_orig);
            $photoY = ImagesY($image_orig);
            $image_fin = ImageCreateTrueColor($width, $height);
            ImageCopyResampled($image_fin, $image_orig, 0, 0, 0, 0, $width + 1, $height + 1, $photoX, $photoY);
            if ($extension == '.jpg' || $extension == '.jpeg') {
                ImageJPEG($image_fin, $this->file_save_path . '/' . $new_image);
            } elseif ($extension== '.png') {
                imagepng($image_fin, $this->file_save_path . '/' . $new_image);
            } elseif ($extension == '.gif') {
                imagegif($image_fin, $this->file_save_path . '/' . $new_image);
            }
            
            ImageDestroy($image_orig);
            ImageDestroy($image_fin);
        }
    }

     public function get_image_extension($image){
        $imageData = getimagesize($image);
        return image_type_to_extension($imageData[2]);
    }
}


class Extend3 {
    var $file_save_path = 'newImages';
    
    function __construct() {
        $Hook = Hook::getInstance();
        $Hook->bind('blur', $this, 'blur');
    }
    public function get_image_extension($image){
        $imageData = getimagesize($image);
        return image_type_to_extension($imageData[2]);
    }
    
     public function blur($imgs, $type, $scale) {
        $date = date('j_F_Y_h_i');
        
        foreach ($imgs as $image) {
            $extension = $this->get_image_extension($image);
            $new_image = $date . '_blur_' . $image;
            if ($extension == '.jpg' || $extension == '.jpeg') {
                $image_orig = ImageCreateFromJPEG($image);
            } elseif ($extension == '.png') {
                $image_orig = imagecreatefrompng($image);
            } elseif ($extension == '.gif') {
                $image_orig = imagecreatefromgif($image);
            }
            
            for ($i = 0; $i < $scale; $i++) {
                if ($type == 'GAUSSIAN') {
                    imagefilter($image_orig, IMG_FILTER_GAUSSIAN_BLUR);
                } else {
                    imagefilter($image_orig, IMG_FILTER_SELECTIVE_BLUR);
                }
            }
            
            if ($extension == '.jpg' || $extension == '.jpeg') {
                ImageJPEG($image_orig, $this->file_save_path . '/' . $new_image);
            } elseif ($extension == '.png') {
                imagepng($image_orig, $this->file_save_path . '/' . $new_image);
            } elseif ($extension == '.gif') {
                imagegif($image_orig, $this->file_save_path . '/' . $new_image);
            }
            ImageDestroy($image_orig);
        }
    }   
 }


$Base = new ImgEditor();
$Extend = new Extend();
$Plugin2 = new Extend2();
$Plugin3 = new Extend3();

$imgs['1'] = 'cat.jpg';
$arr[1] = $imgs;
$arr[2] = 2;
//$Base->applyEffect('grayscale', $arr);

 $imgs['1'] = 'dog.jpg';
$arr[1] = $imgs;
$arr[2] = 150;
$Base->applyEffect('resize', $arr);

$arr[2] = 'GAUSSIAN';
$arr[3] = 10;
$Base->applyEffect('blur', $arr);
?>
