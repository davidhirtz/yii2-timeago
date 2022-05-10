<?php
/**
 * @author David Hirtz
 * @link https://www.davidhirtz.com
 */

namespace davidhirtz\yii2\timeago;

use yii\grid\DataColumn;
use yii\helpers\Html;

/**
 * TimeagoColumn can be used to display simple {@see Timeago::tag()} grid columns.
 */
class TimeagoColumn extends DataColumn
{
    /**
     * @var string|null adds Bootstrap CSS classes to header and content options, to show this column only at given
     * breakpoint. Defaults to `null` which adds no extra classes.
     */
    public $displayAtBreakpoint;

    /**
     * @return void
     */
    public function init()
    {
        if ($this->displayAtBreakpoint) {
            $cssClass = ["d-none d-{$this->displayAtBreakpoint}-table-cell"];
            Html::addCssClass($this->headerOptions, $cssClass);
            Html::addCssClass($this->contentOptions, $cssClass);
        }

        parent::init();
    }

    /**
     * @inheritDoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return Timeago::tag($this->getDataCellValue($model, $key, $index));
    }
}