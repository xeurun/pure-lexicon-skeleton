<?php

namespace common\api\frontend\controllers\v1\word;

class IndexAction extends \yii\rest\IndexAction
{
    /** @inheritdoc */
    protected function prepareDataProvider()
    {
        /* @var $modelClass \yii\db\BaseActiveRecord */
        $modelClass = $this->modelClass;

        return new \yii\data\ActiveDataProvider([
            'query' => $modelClass::find()->filterWhere(['bad_word' => 1])
        ]);
    }
}