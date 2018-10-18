<?php

/* @var $this yii\web\View */
/* @var $model core\models\MembershipType */
/* @var $modelMembershipTypeProductService core\models\MembershipTypeProductService */

$this->title = 'Update ' . Yii::t('app', 'Membership Type') . ' : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Membership'), 'url' => ['product-service/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Membership Type'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="membership-type-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelMembershipTypeProductService' => $modelMembershipTypeProductService,
    ]) ?>

</div>
