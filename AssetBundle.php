<?php
/**
 * AssetBundle.php
 * @author David Hirtz
 * @link https://www.davidhirtz.com
 */
namespace davidhirtz\yii2\timeago;
use Yii;

/**
 * Class AssetBundle
 * @package davidhirtz\yii2\timeago
 */
class AssetBundle extends \yii\web\AssetBundle
{
	const LOCALE_DIR='/locale';
	const LOCALE_FILENAME='jquery.timeago.{locale}.js';

	/**
	 * @inherit
	 */
	public $sourcePath = '@bower/jquery-timeago';

	/**
	 * @inherit
	 */
	public $publishOptions=[
		'only'=>[
			'jquery.timeago.js',
			'locales/*',
		],
	];

	/**
	 * @inherit
	 */
	public $js = [
		'jquery.timeago.js',
	];

	/**
	 * @var bool whether the locale should be included too
	 */
	public $locale=true;

	/**
	 * Adds timeago locale depending on app language if {locale} is true.
	 * If the app language is set to English this step is skipped.
	 */
	public function init()
	{
		if($this->locale)
		{
			if(strpos(Yii::$app->language, 'en')!==0 && !$this->setLocale(Yii::$app->language))
			{
				$language=str_replace('_', '-', strtolower(Yii::$app->language));
				$language=substr($language, 0, strpos($language, '-'));

				if($language)
				{
					$this->setLocale($language);
				}
			}
		}

		parent::init();
	}

	/**
	 * @param string $language
	 * @return bool
	 */
	private function setLocale($language)
	{
		if(file_exists(Yii::getAlias($this->sourcePath.self::LOCALE_DIR).'/'.$this->getLocaleFilename($language)))
		{
			$this->js[]=$this->getLocaleFilename($language);
			return true;
		}

		return false;
	}

	/**
	 * @param string $language
	 * @return string
	 */
	private function getLocaleFilename($language)
	{
		return strtr(self::LOCALE_FILENAME, ['{locale}'=>$language]);
	}
}