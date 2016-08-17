<?php

namespace dongrim\blog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
//use app\modules\blog\models\Category;
/**
 * CategorySearch represents the model behind the search form about `amilna\blog\models\Category`.
 */
class CategorySearch extends Category
{
    const STATUS_ACTIVE = 1;
    const STATUS_BLOCKED = 0;

    public static function getStatusArray()
    {
        return [

            self::STATUS_ACTIVE => Yii::t('app', 'Active'),
            self::STATUS_BLOCKED => Yii::t('app', 'Inactive'),
        ];
    }

    public static function findAllStatus()
    {
        return self::getStatusArray();
    }

    /*public $blogcatposId;*/
    /*public $categoriesId;*/
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'isdel'], 'integer'],
            [['title', 'description', 'image'/*, blogcatposId, parentId, categoriesId*/], 'safe'],
            [['status'], 'boolean'],
        ];
    }

    public static function find()
    {
        return parent::find()->where([Category::tableName().'.isdel' => 0]);
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    private function queryString($fields)
    {
        $params = [];
        foreach ($fields as $afield)
        {
            $field = $afield[0];
            $tab = isset($afield[1])?$afield[1]:false;
            if (!empty($this->$field))
            {
                if (substr($this->$field,0,2) == "< " || substr($this->$field,0,2) == "> " || substr($this->$field,0,2) == "<=" || substr($this->$field,0,2) == ">=" || substr($this->$field,0,2) == "<>")
                {
                    array_push($params,[str_replace(" ","",substr($this->$field,0,2)), "lower(".($tab?$tab.".":"").$field.")", strtolower(trim(substr($this->$field,2)))]);
                }
                else
                {
                    array_push($params,["like", "lower(".($tab?$tab.".":"").$field.")", strtolower($this->$field)]);
                }
            }
        }
        return $params;
    }

    private function queryNumber($fields)
    {
        $params = [];
        foreach ($fields as $afield)
        {
            $field = $afield[0];
            $tab = isset($afield[1])?$afield[1]:false;
            if (!empty($this->$field))
            {
                $number = explode(" ",trim($this->$field));
                if (count($number) == 2)
                {
                    if (in_array($number[0],['>','>=','<','<=','<>']) && is_numeric($number[1]))
                    {
                        array_push($params,[$number[0], ($tab?$tab.".":"").$field, $number[1]]);
                    }
                }
                elseif (count($number) == 3)
                {
                    if (is_numeric($number[0]) && is_numeric($number[2]))
                    {
                        array_push($params,['>=', ($tab?$tab.".":"").$field, $number[0]]);
                        array_push($params,['<=', ($tab?$tab.".":"").$field, $number[2]]);
                    }
                }
                elseif (count($number) == 1)
                {
                    if (is_numeric($number[0]))
                    {
                        array_push($params,['=', ($tab?$tab.".":"").$field, str_replace(["<",">","="],"",$number[0])]);
                    }
                }
            }
        }
        return $params;
    }

    private function queryTime($fields)
    {
        $params = [];
        foreach ($fields as $afield)
        {
            $field = $afield[0];
            $tab = isset($afield[1])?$afield[1]:false;
            if (!empty($this->$field))
            {
                $time = explode(" - ",$this->$field);
                if (count($time) > 1)
                {
                    array_push($params,[">=", "concat('',".($tab?$tab.".":"").$field.")", $time[0]]);
                    array_push($params,["<=", "concat('',".($tab?$tab.".":"").$field.")", $time[1]." 24:00:00"]);
                }
                else
                {
                    if (substr($time[0],0,2) == "< " || substr($time[0],0,2) == "> " || substr($time[0],0,2) == "<=" || substr($time[0],0,2) == ">=" || substr($time[0],0,2) == "<>")
                    {
                        array_push($params,[str_replace(" ","",substr($time[0],0,2)), "concat('',".($tab?$tab.".":"").$field.")", trim(substr($time[0],2))]);
                    }
                    else
                    {
                        array_push($params,["like", "concat('',".($tab?$tab.".":"").$field.")", $time[0]]);
                    }
                }
            }
        }
        return $params;
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
        $query = $this->find();

        $query->joinWith([/*,blogcatpos,categories*/]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        /* uncomment to sort by relations table on respective column
        $dataProvider->sort->attributes['blogcatposId'] = [
            'asc' => ['{{%blogcatpos}}.id' => SORT_ASC],
            'desc' => ['{{%blogcatpos}}.id' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['categoriesId'] = [
            'asc' => ['{{%categories}}.id' => SORT_ASC],
            'desc' => ['{{%categories}}.id' => SORT_DESC],
        ];*/

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $params = self::queryNumber([['id',$this->tableName()],['parent_id'],['status'],['isdel']/*['id','{{%blogcatpos}}'],['id','{{%parent}}'],['id','{{%categories}}']*/]);
        foreach ($params as $p)
        {
            $query->andFilterWhere($p);
        }
        $query->andFilterWhere(['like', 'status', $this->status]);
        $params = self::queryString([['title'],['description'],['image']/*['id','{{%blogcatpos}}'],['id','{{%parent}}'],['id','{{%categories}}']*/]);
        foreach ($params as $p)
        {
            $query->andFilterWhere($p);
        }

        return $dataProvider;
    }


    public function getStructure()
    {
        //запрос к базе данных в $result попадают все записи из таблицы в виде массива
        $result = Category::find()
            ->where('status = :status AND isdel = :isdel',[':status' => self::STATUS_ACTIVE, ':isdel'=>0])
            ->asArray()
            ->all();

        if (!$result) {
            return array();
        }
        // $arr_cat будет создаваться массив категорий, где индексы, это parent_id
        $arr_cat = array();

        //В цикле формируем массив

        for ($i = 0; $i < count($result);$i++) {

            $row = $result[$i];

            if ($row['parent_id'] == NULL)
                $row['parent_id'] = 0;

            //Формируем массив, где ключами являются id родительской категории
            if (empty($arr_cat[$row['parent_id']])) {
                $arr_cat[$row['parent_id']] = array();
            }
            $arr_cat[$row['parent_id']][] = $row;
        }

        // $view_cat - лямда функция для создания массива категорий, который будет передан в отображение

        $view_cat = function ($data, $parent_id = 0) use ( & $view_cat)
        {
            $result = NULL;
            if (empty($data[$parent_id])) {
                return;
            }
            $result = array();
            //перебираем в цикле массив и выводим на экран
            for ($i = 0; $i < count($data[$parent_id]);$i++) {

                $result[] = ['label' => $data[$parent_id][$i]['title'],
                    'url' => '/blog/default?category='.$data[$parent_id][$i]['title'],
                    //можно пометить какой либо пункт как активный
                    'active' => $data[$parent_id][$i]['id'] == 8,
                    'options' => ['class' => 'dropdown' ],
                    'items' => $view_cat($data,$data[$parent_id][$i]['id'])];
                 //рекурсия - проверяем нет ли дочерних категорий
            }
            return $result;
        };

        $result = $view_cat($arr_cat);

        return $result;

    }


}
