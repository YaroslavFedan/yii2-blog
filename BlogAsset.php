<?php

namespace dongrim\blog;

use yii\web\AssetBundle;

class BlogAsset extends AssetBundle
{
    public $sourcePath = '@dongrim/blog/assets';

    public $css = [
        'css/blog.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

}