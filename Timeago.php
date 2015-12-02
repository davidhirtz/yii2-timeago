<?php
/**
 * Timeago.php
 * @author David Hirtz
 * @link https://www.davidhirtz.com
 */
namespace davidhirtz\yii2\timeago;

use Yii;
use yii\helpers\Html;

/**
 * Class Timeago.
 * @package davidhirtz\yii2\timeago
 */
class Timeago
{
	/**
	 * @var bool
	 */
	private static $isRegistered=false;

	/**
	 * Renders time tag.
	 *
	 * @param int|string|\DateTime $time
	 * @param array $options
	 * @return string
	 */
	public static function tag($time, $options=[])
	{
		if($time)
		{
			if(!self::$isRegistered)
			{
				TimeagoAsset::register(Yii::$app->getView());
				self::$isRegistered=true;
			}

			Html::addCssClass($options, 'timeago');
			$options['datetime']=Yii::$app->formatter->asDatetime($time, "php:c");

			return Html::tag('time', Yii::$app->formatter->asDatetime($time), $options);
		}
	}
}