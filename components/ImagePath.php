<?php

namespace dongrim\blog\components;

class ImagePath extends \yii\base\Widget
{
    public static function setPathToThumbs($imagePath, $uploadURL)
    {
        $arr = explode($uploadURL,$imagePath);
        return $uploadURL.'/.thumbs'.end($arr);
    }
}