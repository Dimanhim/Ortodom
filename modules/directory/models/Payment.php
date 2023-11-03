<?php

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace app\modules\directory\models;

/**
 * This is the model class for table "payments".
 *
 * @property int $id
 * @property string $name
 */
class Payment extends \yii\db\ActiveRecord
{
    const COMPENSATION = 1;
    const CASH = 3;
    const REDRESS = 4;
    const NR = 6;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
        ];
    }

    public function getNameValue()
    {
        if($this->id == 18 && ($model = self::findOne(11))) {
            return $model->name;
        }
        return $this->name;
    }
}
