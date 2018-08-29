<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model core\models\RatingComponent */

$this->title = 'Create ' . Yii::t('app', 'Rating Component');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rating Component'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rating-component-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>