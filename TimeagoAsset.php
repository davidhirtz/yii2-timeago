<?php
/**
 * @author David Hirtz
 * @link https://www.davidhirtz.com
 */

namespace davidhirtz\yii2\timeago;

use Yii;
use yii\helpers\Json;
use yii\web\AssetBundle;
use yii\web\View;

/**
 * TimeagoAsset registers javascript assets related to the jQuery plugin Timeago.
 * @link https://github.com/rmm5t/jquery-timeago
 */
class TimeagoAsset extends AssetBundle
{
    public const LOCALE_DIR = '/locales';
    public const LOCALE_FILENAME = 'jquery.timeago.{locale}.js';

    /**
     * @var bool whether the locale should be loaded
     */
    public $locale = true;

    /**
     * @var bool whether the short locale version should be loaded. If no short version was found, it falls back to the
     * default locale. Defaults to `false`.
     */
    public $short = false;

    /**
     * @link http://timeago.yarp.com/
     * @var array additional plugin settings.
     */
    public $settings = [];

    /**
     * @inherit
     */
    public $sourcePath = '@bower/jquery-timeago';

    /**
     * @var array
     */
    public $publishOptions = [
        'only' => [
            'jquery.timeago.js',
            'locales/*',
        ],
        'except' => [
            'contrib',
        ],
    ];

    /**
     * @var array
     */
    public $js = [
        'jquery.timeago.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset'
    ];

    /**
     * Adds timeago locale depending on app language if {locale} is true. If the app language is set to English this
     * step is skipped.
     */
    public function init()
    {
        // If strings are set in plugin settings, disable locale loading
        if (isset($this->settings['strings'])) {
            $this->locale = false;
            $this->short = false;
        }

        // Add locale js to stack
        if ($this->locale || $this->short) {
            // Sanitize language
            $language = str_replace('_', '-', strtolower(Yii::$app->language));

            // Try short version
            if (($this->short || strpos($language, 'en') !== 0) && !$this->setLocaleScript($language)) {
                if ($language = substr($language, 0, strpos($language, '-'))) {
                    $this->setLocaleScript($language);
                }
            }
        }

        parent::init();
    }

    /**
     * @param View $view
     * @return TimeagoAsset
     */
    public static function register($view)
    {
        $bundle = parent::register($view);
        $bundle->registerJs($view);

        return $bundle;
    }

    /**
     * Registers timeago javascript.
     *
     * @param View $view
     * @param array $settings
     */
    public function registerJs($view, $settings = [])
    {
        if ($this->settings || $settings) {
            $settings = Json::htmlEncode(array_merge($this->settings, $settings));
            $view->registerJs("jQuery.extend(jQuery.timeago.settings, $settings);", $view::POS_READY, 'timeagoOptions');
        }

        $view->registerJs("jQuery('time.timeago').timeago();", $view::POS_READY, 'timeago');
    }

    /**
     * @param string $language
     * @param bool $isShort
     * @return bool
     */
    private function setLocaleScript($language, $isShort = false)
    {
        if ($this->short && !$isShort && $this->setLocaleScript($language . '-short', true)) {
            return true;
        }

        if (file_exists(Yii::getAlias($this->sourcePath) . $this->getLocaleFilename($language))) {
            $this->js[] = trim($this->getLocaleFilename($language), '/');
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
        return strtr(self::LOCALE_DIR . '/' . self::LOCALE_FILENAME, ['{locale}' => $language]);
    }
}