<?php

namespace alexgivi\plupload;

use yii\web\AssetBundle;

class PluploadAsset extends AssetBundle
{
    public $baseUrl = '@web';
    public $sourcePath = '@vendor/moxiecode/plupload/js';

    public $css = [
        ['jquery.plupload.queue/css/jquery.plupload.queue.css'],
    ];
    public $js = [
        'plupload.full.min.js',
        'jquery.plupload.queue/jquery.plupload.queue.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
