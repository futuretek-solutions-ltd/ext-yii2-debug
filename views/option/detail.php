<?php

use futuretek\debug\OptionPanel;
use yii\helpers\Html;

$options = OptionPanel::getOptions();
?>

<h1>Options</h1>

<?php if (0 === count($options)) { ?>
    <p>Empty.</p>
<?php } else { ?>
    <div class="table-responsive">
        <table class="table table-condensed table-bordered table-striped table-hover" style="table-layout: fixed;">
            <thead>
            <tr>
                <th style="nowrap">Key</th>
                <th>Value</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($options as $item) { ?>
                <tr>
                    <th style="white-space: normal"><?= Html::encode($item['name']) ?></th>
                    <td style="overflow:auto"><?= Html::encode($item['value']) ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>
