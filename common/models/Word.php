<?php

namespace common\models;

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
    public function rules()
    {
        return [
            ['title', 'required'],
            ['altcount', 'integer', 'min' => 0],
            ['bad_word', 'in', 'range' => [0, 1]],
            ['rating', 'integer'],
            ['title', 'string', 'max' => 128],
            ['description', 'string'],
            [['rating', 'altcount'], 'default', 'value' => 0],
            [['bad_word'], 'default', 'value' => 1],
            [['created_at', 'updated_at'], 'safe']
        ];
    }
    public function getAlternatives()
    {
        return $this->hasMany(Word::className(), ['id' => 'good_word_id'])
            ->viaTable('words_alternatives', ['bad_word_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'title'         => 'Title',
            'description'   => 'Description',
            'rating'        => 'Rating',
            'altcount'      => 'Alternative count',
            'bad_word'      => 'Bad word',
            'created_at'    => 'Create date',
            'updated_at'    => 'Update date',
            'alternatives'  => 'Alternatives',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'title',
            'description',
            'rating',
            'altcount',
            'bad_word',
            'created_at',
            'updated_at',
        ];
    }

    public function extraFields()
    {
        return [
            'alternatives'
        ];
    }
}
