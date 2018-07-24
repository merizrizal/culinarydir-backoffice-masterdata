<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Category */

$this->title = 'Create ' . Yii::t('app', 'Business Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Business Category'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>