<?php

namespace alexgivi\plupload;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class Plupload extends Widget
{
    /**
     * Url to action performing uploaded file processing
     * @var string
     */
    public $url;

    /**
     * Language, used in plupload widget. If not set, use language of application.
     * @var string
     */
    public $language;

    /**
     * Maximum file size
     * @var string
     */
    public $maxFileSize = '16mb';

    /**
     * Maximum file count
     * @var int
     */
    public $maxFileCount = 20;

    public $notSupportMessage = 'Browser not supports technologies used by plupload.';

    public function run()
    {
        $this->_setLanguage();
        PluploadAsset::register($this->view);
        Yii::$app->assetManager->publish($this->_getLanguageFilePath());

        $swfPath = $this->_pluploadBasePath() . '/Moxie.swf';
        $xapPath = $this->_pluploadBasePath() . '/Moxie.xap';
        Yii::$app->assetManager->publish($swfPath);
        Yii::$app->assetManager->publish($xapPath);

        $content = Html::beginForm($this->url, 'post');
        $content .= Html::beginTag('div', [
            'class' => 'plupload',
            'data-moxie-swf' => Yii::$app->assetManager->getPublishedUrl($swfPath),
            'data-moxie-xap' => Yii::$app->assetManager->getPublishedUrl($xapPath),
            'data-max-file-size' => $this->maxFileSize,
            'data-max-file-count' => $this->maxFileCount,
        ]);
        $content .= Html::tag('p', $this->notSupportMessage);
        $content .= Html::endTag('div');
        $content .= Html::endForm();

        $this->view->registerJsFile(Yii::$app->assetManager->getPublishedUrl(
            $this->_getLanguageFilePath()), [
            'depends' => PluploadAsset::className(),
        ]);

        $pluploadJs = dirname(__FILE__) . '/plupload.js';
        Yii::$app->assetManager->publish($pluploadJs);
        $this->view->registerJsFile(Yii::$app->assetManager->getPublishedUrl($pluploadJs), [
            'depends' => PluploadAsset::className(),
        ]);
        $this->view->registerJs('Plupload.init();');

        return $content;
    }

    private function _pluploadBasePath()
    {
        return '@vendor/moxiecode/plupload/js';
    }

    private function _getLanguageFilePath()
    {
        return $this->_pluploadBasePath() . "/i18n/{$this->language}.js";
    }

    private function _setLanguage()
    {
        if (empty($this->language)) {
            $this->language = Yii::$app->language;
        }

        if (file_exists(Yii::getAlias($this->_getLanguageFilePath()))) {
            return;
        }

        // no language file. try to find another file.
        $pos = strpos($this->language, '-');
        if ($pos !== false) {
            $this->language = substr($this->language, 0, $pos);

            if (file_exists(Yii::getAlias($this->_getLanguageFilePath()))) {
                return;
            }
        }

        // if no language file at all, use English
        $this->language = 'en';
    }
}