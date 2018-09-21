<?php

/* @var $this yii\web\View */
/* @var $model core\models\Village */

$this->title = 'Update ' . Yii::t('app', 'Village') . ' : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Area'), 'url' => ['province/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Village'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="village-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
