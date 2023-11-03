<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "visit_users".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $visit_date
 * @property integer $created_at
 * @property integer $updated_at
 */
class VisitUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'visit_users';
    }

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
            [['user_id', 'visit_date'], 'required'],
            [['user_id', 'visit_date'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'visit_date' => 'Visit Date',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getUser()
    {
        return $this->user_id ? User::findIdentity($this->user_id) : null;
    }

    /**
     * [disabled => false, my_cell => true]
     * @return bool
     */
    public static function cellValues($date)
    {
        $result = [
            'disabled' => false,
            'class' => null,
        ];
        $user = Yii::$app->user->identity;
        $eachCell = VisitUser::find()->where(['visit_date' => $date])->one();
        if($eachCell) {
            $cellUser = $eachCell->user;
            $result['class'] = $cellUser->cellClass;
            if($cellUser->id != $user->id) {
                $result['disabled'] = true;
            }
        }
        if($user->role == 'superadmin') {
            $result['disabled'] = false;
        }
        return $result;
    }
    public static function userName($date)
    {
        if(!Yii::$app->user->isGuest) {
            $visitUser = VisitUser::find()->where(['visit_date' => $date])->one();
            if($visitUser and ($user = User::findIdentity($visitUser->user_id))) {
                return $user->shortName;
            }
        }
        return '';
    }
    public static function createCell($visit_date, $user_id = 400)
    {
        $model = new self();
        $model->visit_date = $visit_date;
        $model->user_id = $user_id;
        if($model->save()) {
            return $model;
        }
        return false;
    }
    public function changeUserInCell()
    {
        if($this->user_id == 400) {
            $this->user_id = 500;
            return $this->save();
        }
        else {
            return $this->delete();
        }
        /*if($this->user_id == 500) {
            return $this->delete();
        }*/
        return false;
    }
    public function deleteCell()
    {
        return $this->delete();
    }
}
