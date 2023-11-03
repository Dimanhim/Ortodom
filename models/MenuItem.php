<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "menu_items".
 *
 * @property int $id
 * @property string $name
 * @property int $menu_id
 * @property int $page_id
 * @property string|null $link
 * @property int $parent_id
 * @property int $position
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Menu $menu
 * @property Page $page
 * @property MenuItem $parent
 * @property MenuItem[] $children
 * @property string $actualLink
 */
class MenuItem extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu_items';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (!$this->parent_id) {
            $this->parent_id = 0;
        }
        if (!$this->position) {
            $this->position = 0;
        }
        return parent::beforeSave($insert);
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        foreach ($this->children as $menuItem) {
            $menuItem->parent_id = 0;
            $menuItem->save();
        }
        return parent::beforeDelete();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'menu_id', 'page_id'], 'required'],
            [['menu_id', 'page_id', 'parent_id', 'position'], 'integer'],
            [['name', 'link'], 'string', 'max' => 255],
            [['page_id'], 'safe'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(MenuItem::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(MenuItem::className(), ['parent_id' => 'id'])->orderBy(['position' => SORT_ASC]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'menu_id' => 'Меню',
            'page_id' => 'Страница',
            'link' => 'Произвольная ссылка',
            'parent_id' => 'Родитель',
            'position' => 'Позиция',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * @return string|null
     */
    public function getActualLink() {
        if ($this->page) {
            return $this->page->getFullUri();
        }
        return $this->link;
    }
}
