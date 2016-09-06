<?php

namespace common\api\frontend\controllers\v1;

use yii\rest\ActiveController;
use common\models\Word;

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
}
