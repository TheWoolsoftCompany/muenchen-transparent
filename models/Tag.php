<?php

namespace app\models;

use app\models\Antrag;
use app\models\BenutzerIn;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "texte".
 *
 * The followings are the available columns in table 'texte':
 * @property int $id
 * @property string $name
 * @property int $angelegt_benutzerIn_id
 * @property string $angelegt_datum
 * @property int $reviewed
 *
 * The followings are the available model relations:
 * @property BenutzerIn $angelegt_benutzerIn
 * @property Antrag[] $antraege
 */
class Tag extends ActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Text the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['name', 'required'],
            ['id, angelegt_benutzerIn_id, reviewed', 'numerical', 'integerOnly' => true],
            ['name', 'length', 'max' => 100],
            ['angelegt_datum', 'length', 'max' => 20],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAngelegt_benutzerIn()
    {
        return $this->hasOne(BenutzerIn::className(), ['id' => 'angelegt_benutzerIn_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAntraege()
    {
        return $this->hasMany(Antrag::className(), ['id' => 'antraege_tags'])->viaTable('tag_id', ['antrag_id' => 'id']);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id'                     => 'ID',
            'name'                   => 'Name',
            'reviewed'               => 'Geprüft',
            'angelegt_datum'         => 'Angelegt: Datum',
            'angelegt_benutzerIn_id' => 'Anegelegt: BenutzerIn-ID',
            'angelegt_benutzerIn'    => 'Anegelegt: BenutzerIn',
            'antraege'               => 'Anträge',
        ];
    }

    /**
     * @return string
     */
    public function getNameLink()
    {
        $link_name = $this->name;
        return Html::a($this->name, Url::to("themen/tag", ["tag_id" => $this->id, "tag_name" => $link_name]));
    }

    /**
     * @param int $num
     * @return Tag[]
     */
    public static function getTopTags($num)
    {
        // @TODO

        /** @var Tag[] $tags */
        $tags     = Tag::find()->all();
        $tags_out = [];
        foreach ($tags as $tag) if (count($tag->antraege) > 0) $tags_out[] = $tag;
        return $tags_out;
    }

}