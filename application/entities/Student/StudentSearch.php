<?php

namespace application\entities\Student;

use application\forms\student\SearchForm;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class StudentSearch extends Student
{
	public $email;
	public $query;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname', 'gender', 'birthdate',
                'residence', 'group_number','query'], 'string'],
            ['rates','integer'],
            ['email','email']

        ];
    }

    /**
     * @inheritdoc
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
    public function search($params, SearchForm $form)
    {
        $query = Student::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder'=> ['rates'=>SORT_DESC]],
            'pagination' => [
                'pagesize' => 50,
            ],
        ]);



        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

       if($form->query && $form->validate()){
            $q = $form->query;
           $query->andFilterWhere(['like', 'firstname', $q])
                 ->orFilterWhere(['like', 'lastname', $q])
                 ->orFilterWhere(['like', 'group_number', $q]);
           if(is_numeric($q) && $q > 0 ) {
               $query->orFilterWhere(['=', 'rates', (int)$q]);
           }

            return $dataProvider;
       }

        $query->andFilterWhere([
            'id' => $this->id,
            'rates' => $this->rates,
            'birthdate'=>$this->birthdate ? strtotime($this->birthdate) : ""

        ]);

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
                ->andFilterWhere(['like', 'lastname', $this->lastname])
                ->andFilterWhere(['like', 'gender', $this->gender])
                ->andFilterWhere(['like', 'residence', $this->residence])
                ->andFilterWhere(['like', 'group_number', $this->group_number])

                ->andFilterWhere(['like', 'email', $this->email]);


        return $dataProvider;
    }/**/

    protected function fullSearch($params,$query){

    }
}
