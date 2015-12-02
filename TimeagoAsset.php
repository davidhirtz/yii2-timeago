<?php
/**
 * TimeagoAsset.php
 * @author David Hirtz
 * @link https://www.davidhirtz.com
 */
namespace davidhirtz\yii2\timeago;
use Yii;

/**
 * Class TimeagoAsset.
 * @package davidhirtz\yii2\timeago
 */
class TimeagoAsset extends \yii\web\AssetBundle
{
	const LOCALE_DIR='/locales';
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
		'except'=>[
			'contrib',
		],
	];

	/**
	 * @inherit
	 */
	public $js = [
		'jquery.timeago.js',
	];

	/**
	 * @var bool whether the locale should be loaded
	 */
	public $locale=true;

	/**
	 * @var bool whether the short locale version should be loaded. If
	 * no short version was found, it falls back to the default locale.
	 */
	public $short=false;

	/**
	 * Adds timeago locale depending on app language if {locale} is true.
	 * If the app language is set to English this step is skipped.
	 */
	public function init()
	{
		if($this->locale || $this->short)
		{
			/**
			 * Sanitize language.
			 */
			$language=str_replace('_', '-', strtolower(Yii::$app->language));

			if(($this->short || strpos($language, 'en')!==0) && !$this->setLocaleScript($language))
			{
				/**
				 * Try short version.
				 */
				if($language=substr($language, 0, strpos($language, '-')))
				{
					$this->setLocaleScript($language);
				}
			}
		}

		parent::init();
	}

	/**
	 * @param string $language
	 * @param bool $isShort
	 * @return bool
	 */
	private function setLocaleScript($language, $isShort=false)
	{
		if($this->short && !$isShort && $this->setLocaleScript($language.'-short', true))
		{
			return true;
		}

		if(file_exists(Yii::getAlias($this->sourcePath).$this->getLocaleFilename($language)))
		{
			$this->js[]=trim($this->getLocaleFilename($language), DIRECTORY_SEPARATOR);
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
		return strtr(self::LOCALE_DIR.DIRECTORY_SEPARATOR.self::LOCALE_FILENAME, ['{locale}'=>$language]);
	}
}