<?php

declare(strict_types=1);

namespace davidhirtz\yii2\timeago;

use yii\web\AssetBundle;

final class TimeagoAsset extends AssetBundle
{
    public $js = ['timeago.min.js'];
    public $sourcePath = '@npm/x-timeago/dist';
}