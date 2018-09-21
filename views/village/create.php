<?php

/* @var $this yii\web\View */
/* @var $model core\models\Village */

$this->title = 'Create ' . Yii::t('app', 'Village');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Area'), 'url' => ['province/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Village'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="village-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>