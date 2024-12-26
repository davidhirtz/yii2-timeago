<?php

declare(strict_types=1);

namespace davidhirtz\yii2\timeago;

use DateTimeInterface;
use Yii;
use yii\helpers\Html;

/**
 * Timeago is a helper class, which initializes {@see TimeagoAsset} once and renders the timeago HTML tag via
 * {@see Timeago::tag()}.
 */
final class Timeago
{
    public static function tag(DateTimeInterface|int|string|null $time, array $options = []): string
    {
        if ($time !== null) {
            TimeagoAsset::register(Yii::$app->getView());

            $options['data-date'] ??= Yii::$app->getFormatter()->asDatetime($time, "php:c");
            return Html::tag('x-timeago', Yii::$app->getFormatter()->asDatetime($time), $options);
        }

        return '';
    }
}