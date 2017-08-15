yii2-plupload
=============
Plupload Widget for Yii2
uses [moxiecode/plupload](https://github.com/moxiecode/plupload)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist alexgivi/yii2-plupload-widget "*"
```

or add

```
"alexgivi/yii2-plupload-widget": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \alexgivi\plupload\Plupload::widget(); ?>```