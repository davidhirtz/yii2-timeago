Yii 2 Timeago
==========================
Used to display auto-updating, translated relative dates (e.g. "3 minutes ago") HTML tags using a custom web component.
For the previous version build on jQuery, use the version `v1.2.0` constraint in your `composer.json`.

Installation
------------

```
composer require davidhirtz/yii2-timeago "^2.1"
```

Usage
-----

Once the extension is installed, simply use it in your view like this:

```php
<?= \davidhirtz\yii2\timeago\Timeago::tag(time()); ?>
```

Or use the column helper class in your `\yii\grid\GridView`:

```php
[
    'attribute' => 'created_at',
    'class' => \davidhirtz\yii2\timeago\TimeAgoColumn::class,
],
```