Yii2 jQuery Timeago Plugin
==========================
Yii2 extension for [jQuery](https://jquery.com) plugin [timeago](http://timeago.yarp.com) which makes it easy to support automatically updating fuzzy timestamps (e.g. "4 minutes ago" or "about 1 day ago") from ISO 8601 formatted dates and times embedded in your HTML (à la microformats).

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist davidhirtz/yii2-timeago "*"
```

or add

```
"davidhirtz/yii2-timeago": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your view like this:

```php
<?php \davidhirtz\yii2\timeago\AssetBundle::register($this); ?>```

You can disable the default locale behavior by configuring your asset manager like this:

```php
'assetManager'=>[
	'bundles'=>[
		'davidhirtz\yii2\timeago\TimeagoAsset'=>[
			'locale'=>false,
		],
	],
],```