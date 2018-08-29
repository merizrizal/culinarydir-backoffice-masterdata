<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use sycomponent\AjaxRequest;
use sycomponent\ModalDialog;
use sycomponent\NotificationDialog;

/* @var $this yii\web\View */
/* @var $searchModel core\models\search\StatusApprovalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$ajaxRequest = new AjaxRequest([
    'modelClass' => 'StatusApproval',
]);

$ajaxRequest->index();

$status = Yii::$app->session->getFlash('status');
$message1 = Yii::$app->session->getFlash('message1');
$message2 = Yii::$app->session->getFlash('message2');

if ($status !== null) :
    $notif = new NotificationDialog([
        'status' => $status,
        'message1' => $message1,
        'message2' => $message2,
    ]);

    $notif->theScript();
    echo $notif->renderDialog();

endif;

$this->title = Yii::t('app', 'Status Approval');
$this->params['breadcrumbs'][] = $this->title; ?>

<?= $ajaxRequest->component(true) ?>

<div class="status-approval-index">

    <?php
    $modalDialog = new ModalDialog([
        'clickedComponent' => 'a#delete',
        'modelAttributeId' => 'model-id',
        'modelAttributeName' => 'model-name',
    ]); ?>

    <?= GridView::widget([
        'id' => 'grid-view-status-approval',
        'dataProvider' => $dataProvider,
        'pjax' => false,
        'bordered' => false,
        'panelHeadingTemplate' => '
            <div class="kv-panel-pager pull-right" style="text-align:right">
                {pager}{summary}
            </div>
            <div class="clearfix"></div>'
        ,
        'panelFooterTemplate' => '
            <div class="kv-panel-pager pull-right" style="text-align:right">
                {summary}{pager}
            </div>
            {footer}
            <div class="clearfix"></div>'
        ,
        'panel' => [
            'heading' => '',
        ],
        'toolbar' => [
            [
                'content' => Html::a('<i class="fa fa-sync-alt"></i>', ['index'], [
                            'id' => 'refresh',
                            'class' => 'btn btn-success',
                            'data-placement' => 'top',
                            'data-toggle' => 'tooltip',
                            'title' => 'Refresh'
                ])
            ],
        ],
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'condition',
            'branch',
            'group',
            'order',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '
                    <div class="btn-container hide">
                        <div class="visible-lg visible-md">
                            <div class="btn-group btn-group-md" role="group" style="width: 200px">
                                {view}{update}{delete}{up}{down}
                            </div>
                        </div>
                        <div class="visible-sm visible-xs">
                            <div class="btn-group btn-group-lg" role="group" style="width: 260px">
                                {view}{update}{delete}{up}{down}
                            </div>
                        </div>
                    </div>',
                'buttons' => [
                    'view' =>  function($url, $model, $key) {
                        return Html::a('<i class="fa fa-search-plus"></i>', $url, [
                            'id' => 'view',
                            'class' => 'btn btn-primary',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'title' => 'View',
                        ]);
                    },
                    'update' =>  function($url, $model, $key) {
                        return Html::a('<i class="fa fa-pencil-alt"></i>', $url, [
                            'id' => 'update',
                            'class' => 'btn btn-success',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'title' => 'Edit',
                        ]);
                    },
                    'delete' =>  function($url, $model, $key) {
                        return Html::a('<i class="fa fa-trash-alt"></i>', $url, [
                            'id' => 'delete',
                            'class' => 'btn btn-danger',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'data-not-ajax' => 1,
                            'title' => 'Delete',
                            'model-id' => $model->id,
                            'model-name' => $model->name,
                        ]);
                    },
                    'up' =>  function($url, $model, $key) {
                        return Html::a('<i class="fa fa-arrow-up"></i>', ['up', 'id' => $model->id], [
                            'id' => 'view',
                            'class' => 'btn btn-default',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'title' => 'Up',
                        ]);
                    },
                    'down' =>  function($url, $model, $key) {
                        return Html::a('<i class="fa fa-arrow-down"></i>', ['down', 'id' => $model->id], [
                            'id' => 'update',
                            'class' => 'btn btn-default',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'title' => 'Down',
                        ]);
                    },
                ]
            ],
        ],
        'tableOptions' => [
            'class' => 'table table-striped table-hover'
        ],
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['id' => $model['id'], 'class' => 'row-grid-view-status-approval', 'style' => 'cursor: pointer;'];
        },
        'pager' => [
            'firstPageLabel' => '<i class="fa fa-angle-double-left"></i>',
            'prevPageLabel' => '<i class="fa fa-angle-left"></i>',
            'lastPageLabel' => '<i class="fa fa-angle-double-right"></i>',
            'nextPageLabel' => '<i class="fa fa-angle-right"></i>',
        ],
    ]); ?>

</div>

<?= $modalDialog->renderDialog() ?>

<?php
$jscript = ''
    . $modalDialog->getScript() . '

    $("div.container.body").off("click");
    $("div.container.body").on("click", function(event) {

        if ($(event.target).parent(".row-grid-view-status-approval").length > 0) {

            $("td").not(event.target).popover("destroy");
        } else {
            $(".popover.in").popover("destroy");
        }
    });

    $(".row-grid-view-status-approval").popover({
        trigger: "click",
        placement: "top",
        container: ".row-grid-view-status-approval",
        html: true,
        selector: "td",
        content: function () {
            var content = $(this).parent().find(".btn-container").html();

            return $(content);
        }
    });

    $(".row-grid-view-status-approval").on("shown.bs.popover", function(event) {

        $(\'[data-toggle="tooltip"]\').tooltip();

        var popoverId = $(event.target).attr("aria-describedby");

        $(document).on("click", "#" + popoverId + " a", function(event) {

            if ($(this).attr("data-not-ajax") == undefined) {
                ajaxRequest($(this));
            }

            return false;
        });
    });
';

$this->registerJs($jscript); ?>
