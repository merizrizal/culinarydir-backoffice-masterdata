<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model core\models\District */

$this->title = 'Create ' . Yii::t('app', 'District');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Area'), 'url' => ['province/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'District'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="district-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>