<?php

namespace app\models;

use app\modules\directory\models\ShoesBrand;
use himiklab\thumbnail\EasyThumbnailImage;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Inflector;

/**
 * This is the model class for table "services".
 *
 * @property integer $id
 * @property string $name
 * @property string $content
 * @property integer $image_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class Product extends BasePage
{
    const PRODUCT_CATALOG_ID = 2;

    public $image_field;
    public $image_fields = ['image_field' => 'image_id'];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
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
            [['name'], 'required'],
            [['content', 'short_description'], 'string'],
            [['image_id', 'config_id', 'brand_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['image_field'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'content' => 'Контент',
            'short_description' => 'Короткое описание',
            'image_id' => 'Изображение',
            'image_field' => 'Изображение',
            'config_id' => 'Конфигуратор',
            'brand_id' => 'Модель',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::class, ['id' => 'image_id']);
    }

    public function getPage()
    {
        return Page::find()->where(['relation_id' => $this->id, 'type' => Page::TYPE_PRODUCT])->one();
        return $this->hasOne(Page::className(), ['relation_id' => 'id'], ['type' => Page::TYPE_PRODUCT]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfig()
    {
        return $this->hasOne(Config::className(), ['id' => 'config_id']);
    }
    public function getBrand()
    {
        return $this->hasOne(ShoesBrand::className(), ['id' => 'brand_id']);
    }
    public function getRelationName($relationName)
    {
        if($this->config && $this->config->$relationName) {
            return $this->config->$relationName->name;
        }
        return false;
    }
    public function getAgeGroupName()
    {
        $teenName = 'подростковая';
        $adultName = 'взрослая';
        if($this->page && $this->page->parent_id == 32) return $teenName;
        return $adultName;
    }
    public function setPage($brand)
    {
        if(!$page = Page::findOne(['type' => Page::TYPE_PRODUCT, 'relation_id' => $this->id])) {
            $page = new Page();
            $page->alias = Inflector::slug($brand->name);
        }
        $page->name = $brand->name;
        $page->h1 = $brand->name;
        $page->title = $brand->name;
        $page->meta_description = $brand->meta_description;
        $page->type = Page::TYPE_PRODUCT;
        $page->relation_id = $this->id;
        $page->is_active = 1;
        $page->parent_id = $brand->setAgeGroup();
        if(!$page->save()) {
            Yii::info($page->errors);
        }
    }
    public function getImagePath()
    {
        return $this->image ? $this->image->path : '';
    }

    public function getImg()
    {
        if($this->brand && $this->brand->img) {
            return $this->brand->img;
        }
        return false;
        if($this->image && $this->image->path) {
            if(EasyThumbnailImage::thumbnailFile(Yii::getAlias('@webroot').$this->image->path, 320, 210, EasyThumbnailImage::THUMBNAIL_OUTBOUND)) {
                return EasyThumbnailImage::thumbnailImg(Yii::getAlias('@webroot').$this->image->path, 320, 210, EasyThumbnailImage::THUMBNAIL_OUTBOUND);
            }
        }
        if($defaultImagePath = ShoesBrand::defaultImagePath()) {
            return EasyThumbnailImage::thumbnailImg(Yii::getAlias('@webroot').$defaultImagePath, 320, 210, EasyThumbnailImage::THUMBNAIL_OUTBOUND);
        }
        return false;
    }
}
