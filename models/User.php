<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property integer $country_id
 * @property string $name
 * @property string $phone
 *
 * @property Country $country
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_id'], 'integer'],
            [['name'], 'required', 'except' => 'search'],
            [['name'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 32],
            [['phone'], 'match', 'pattern' => '#^\+\d-\(\d{3}\)-\d{3}-\d\d-\d\d$#', 'message' => 'Invalid phone format: +D-(DDD)-DDD-DD-DD expected.'],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],

	        [['id', 'country.id'], 'safe', 'on' => 'search'],
        ];
    }

	public function attributes()
	{
		return array_merge(parent::attributes(), ['country.id']);
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('app', 'ID'),
            'country_id' => Yii::t('app', 'Country ID'),
            'name'       => Yii::t('app', 'Name'),
            'phone'      => Yii::t('app', 'Phone'),

	        'country.id' => Yii::t('app', 'Country'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    public function search($params)
    {
        $query = self::find()
	        ->alias('u')
	        ->with('country')
	        ->joinWith('country');

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
	        'sort' => [
		        'attributes' => [
			        'id',
			        'name',
			        'phone',
			        'country.id' => [
				        'asc'  => ['countries.name' => SORT_ASC],
				        'desc' => ['countries.name' => SORT_DESC],
			        ]
		        ],
		        'defaultOrder' => ['name' => SORT_ASC],
	        ],
	        'pagination' => [
		        'pageSize' => 20,
	        ],
        ]);

        // load the search form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query
	        ->andFilterWhere([
		        'u.id' => $this->id,
		        'country_id' => $this->getAttribute('country.id'),
	        ])
	        ->andFilterWhere(['like', 'u.name',  $this->name])
            ->andFilterWhere(['like', 'u.phone', $this->phone]);

        return $dataProvider;
    }

}
