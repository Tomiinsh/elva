<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form of `app\models\User`.
 */
class UserSearch extends User
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'employee_id'], 'integer'],
            [['password', 'auth_key', 'access_token'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find()->joinWith('employee');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['employee.first_name'] = [
            'asc' => ['employee.first_name' => SORT_ASC],
            'desc' => ['employee.last_name' => SORT_DESC]
        ];

        $dataProvider->sort->attributes['employee.last_name'] = [
            'asc' => ['employee.last_name' => SORT_ASC],
            'desc' => ['employee.last_name' => SORT_DESC]
        ];

        $dataProvider->sort->attributes['employee.date_of_birth'] = [
            'asc' => ['employee.date_of_birth' => SORT_ASC],
            'desc' => ['employee.date_of_birth' => SORT_DESC]
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'employee.first_name', $this->getAttribute('employee.first_name')]);

        return $dataProvider;
    }
}
