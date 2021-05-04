<?php

namespace app\assets;

use yii\web\AssetBundle;

class DualListBoxAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/dualListBox.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
