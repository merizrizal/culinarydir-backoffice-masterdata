<?php

/* @var $this yii\web\View */
/* @var $model core\models\RatingComponent */

$this->title = 'Update ' . Yii::t('app', 'Rating Component') . ' : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rating Component'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rating-component-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
