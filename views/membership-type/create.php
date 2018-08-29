<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model core\models\MembershipType */

$this->title = 'Create ' . Yii::t('app', 'Membership Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Membership'), 'url' => ['product-service/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Membership Type'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="membership-type-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modelMembershipTypeProductService' => $modelMembershipTypeProductService,
    ]) ?>

</div>