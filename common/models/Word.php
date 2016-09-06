<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "word".
 *
 * @property integer $id
 * @property string  $content
 * @property integer $created_at
 * @property integer $updated_at
 */
class Word extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'words';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['content'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'content'   => 'Content',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'content',
            'created_at' => function () {
                return date('d-m-y H:i', $this->created_at);
            },
        ];
    }
}
