<?php
namespace app\models\userOverrides;

use app\support\helpers\LoggedInUserFinder;
use dektrium\user\models\UserSearch as BaseUserSearch;
use yii\data\ActiveDataProvider;

class UserSearch extends BaseUserSearch
{
    /** @inheritdoc */
    public function search($params)
    {
        $query = $this->finder->getUserQuery();
        if(!! LoggedInUserFinder::companyNotSet()){
            $query->where(['companies_id' => LoggedInUserFinder::loggedUserCompany()->id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $modelClass = $query->modelClass;
        $table_name = $modelClass::tableName();

        if ($this->created_at !== null) {
            $date = strtotime($this->created_at);
            $query->andFilterWhere(['between', $table_name . '.created_at', $date, $date + 3600 * 24]);
        }

        $query->andFilterWhere(['like', $table_name . '.username', $this->username])
            ->andFilterWhere(['like', $table_name . '.email', $this->email])
            ->andFilterWhere([$table_name . '.id' => $this->id]);

        return $dataProvider;
    }
}