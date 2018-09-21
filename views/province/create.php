<?php

/* @var $this yii\web\View */
/* @var $model core\models\Province */

$this->title = 'Create ' . Yii::t('app', 'Province');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Area'), 'url' => ['province/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Province'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="province-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>