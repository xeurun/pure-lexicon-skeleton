<?php

namespace common\api\frontend\controllers\v1\word;

use Yii;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use common\models\Word;

class CreateAction extends \yii\rest\CreateAction
{
    // TODO: fixit
    /** @inheritdoc */
    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        $params = Yii::$app->getRequest()->getBodyParams();
        if (!isset($params['title']) || !isset($params['alternative'])) {
            throw new \ErrorException('Некорректные данные');
        }

        $params['title'] = trim(strtolower($params['title']));
        $word = Word::findOne(['title' => $params['title']]);
        if (!$word instanceof Word) {
            /* @var $model \yii\db\ActiveRecord */
            $word = new $this->modelClass([
                'scenario' => $this->scenario,
            ]);
        } else if($word->bad_word != 1) {
            throw new \ErrorException('Слово уже используется как альтернативное');
        }

        $params['alternative'] = trim(strtolower($params['alternative']));
        $alternativeWord = Word::findOne(['title' => $params['alternative']]);
        if (!$alternativeWord instanceof Word) {
            /* @var $model \yii\db\ActiveRecord */
            $alternativeWord = new $this->modelClass([
                'scenario' => $this->scenario,
            ]);
            $alternativeWord->setAttributes([
                'title'     => $params['alternative'],
                'bad_word'  => 0
            ]);
            if ($alternativeWord->save()) {
            } elseif (!$word->hasErrors()) {
                throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
            }

        } else if($alternativeWord->bad_word != 0) {
            throw new \ErrorException('Альтернативное слово уже используется как заменяемое');
        }
        unset($params['alternative']);

        $word->setAttribute('altcount', $word->altcount + 1);
        $word->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($word->save()) {
            if (!$word->getAlternatives()->filterWhere(['id' => $alternativeWord->getPrimaryKey()])->exists()) {
                $word->link('alternatives', $alternativeWord);
            }
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($word->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));
        } elseif (!$word->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        return $word;
    }
}