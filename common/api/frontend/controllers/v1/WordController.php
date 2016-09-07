<?php

namespace common\api\frontend\controllers\v1;

use yii\rest\ActiveController;
use common\models\Word;
use common\api\frontend\controllers\v1\word\{
    IndexAction, CreateAction
};

/**
 * Lexicon main controller
 */
class WordController extends ActiveController
{
    public $modelClass = Word::class;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions = parent::actions();

        $actions['index'] = [
            'class'         => IndexAction::className(),
            'modelClass'    => $this->modelClass,
            'checkAccess'   => [$this, 'checkAccess'],
        ];

        $actions['create'] = [
            'class'         => CreateAction::className(),
            'modelClass'    => $this->modelClass,
            'checkAccess'   => [$this, 'checkAccess'],
        ];

        return $actions;
    }
}
