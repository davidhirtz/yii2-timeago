<?php
/**
 * @author David Hirtz
 * @link https://www.davidhirtz.com
 */

namespace davidhirtz\yii2\timeago;

use DateTime;
use Yii;
use yii\helpers\Html;

/**
 * Timeago is a helper class which initializes {@see TimeagoAsset} once and renders the timeago HTML tag via
 * {@see Timeago::tag()}.
 */
class Timeago
{
    /**
     * @var bool
     */
    private static $_isRegistered = false;

    /**
     * Renders time HTML tag.
     *
     * @param int|string|DateTime $time
     * @param array $options
     * @return string
     */
    public static function tag($time, $options = []): string
    {
        if ($time) {
            if (!static::$_isRegistered) {
                TimeagoAsset::register(Yii::$app->getView());
                static::$_isRegistered = true;
            }

            Html::addCssClass($options, 'timeago');
            $options['datetime'] = Yii::$app->getFormatter()->asDatetime($time, "php:c");

            return Html::tag('time', Yii::$app->getFormatter()->asDatetime($time), $options);
        }

        return '';
    }
}