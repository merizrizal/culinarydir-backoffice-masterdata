<?php

namespace backoffice\modules\masterdata;

use Yii;

/**
 * master data module definition class
 */
class MasterDataModule extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backoffice\modules\masterdata\controllers';
    public $defaultRoute = 'membership-type/index';
    public $name = 'Master Data';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        Yii::configure($this, require __DIR__ . '/config/navigation.php');
    }
}
