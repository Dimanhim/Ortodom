<?php

namespace app\modules\directory\models;

use app\models\BasePage;
use app\models\Image;
use app\models\Page;
use app\models\Product;
use himiklab\thumbnail\EasyThumbnailImage;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * This is the model class for table "shoes_brands".
 *
 * @property integer $id
 * @property string $name
 * @property integer $created_at
 * @property integer $updated_at
 */
class ShoesBrand extends ShoesBase
{
    public $color_ids = [];
    public $images_field = [];
    public $brand_color_images = [];

    const DEFAULT_IMAGE_ID = 91;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shoes_brands';
    }

    /**
     * @return array
     */
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
            [['shoes_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['short_description', 'description', 'meta_description', 'meta_keywords'], 'string'],
            [['color_ids', 'full_color_ids', 'images_field', 'brand_color_images', 'age_group_id', 'lining_id', 'sole_id', 'material_id'], 'safe'],
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
            'shoes_id' => 'Вид обуви',
            'age_group_id' => 'Возрастная группа',
            'material_id' => 'Материал верха',
            'lining_id' => 'Материал подкладки',
            'sole_id' => 'Материал подошвы',
            'color_ids' => 'Цвета',
            'full_color_ids' => 'Цвета',
            'images_field' => 'Изображения',
            'short_description' => 'Короткое описание',
            'description' => 'Описание',
            'meta_description' => 'Мета-тег description',
            'meta_keywords' => 'Мета-тег keywords',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function afterFind()
    {
        if($colors = BrandColor::find()->select(['color_id', 'material_id'])->where(['brand_id' => $this->id])->asArray()->all()) {
            $color_ids = [];
            $full_color_ids = [];
            foreach($colors as $color) {
                if(
                    ShoesMaterial::find()->where(['id' => $color['material_id']])->exists()
                    &&
                    ShoesColor::find()->where(['id' => $color['color_id']])->exists()
                ) {
                    $color_ids[$color['material_id']][] = $color['color_id'];
                }

            }
            $this->color_ids = $color_ids;
            // получить из $this->>color_ids
            /*$this->full_color_ids = array_map(function($a) {
                return $a['color_id'];
            }, $color_ids);*/
            if($color_ids) {
                foreach($color_ids as $material_id => $color_values) {
                    if($color_values) {
                        foreach($color_values as $color_id) {
                            $this->full_color_ids[] = $color_id;
                        }
                    }
                }
            }
        }
        if($this->age_group_id) {
            $this->age_group_id = explode(',', $this->age_group_id);
        }
        if($this->lining_id) {
            $this->lining_id = explode(',', $this->lining_id);
        }
        if($this->sole_id) {
            $this->sole_id = explode(',', $this->sole_id);
        }
        if($this->material_id) {
            $this->material_id = explode(',', $this->material_id);
        }
        return parent::afterFind();
    }

    public function beforeSave($insert)
    {
        if($this->color_ids) {
            foreach($this->color_ids as $material_id => $color_ids) {
                BrandColor::deleteAll(['brand_id' => $this->id, 'material_id' => $material_id]);
                //foreach($this->color_ids as $color_id) {
                if($color_ids) {
                    foreach($color_ids as $color_id) {
                        $brandColor = new BrandColor();
                        $brandColor->brand_id = $this->id;
                        $brandColor->color_id = $color_id;
                        $brandColor->material_id = $material_id;
                        $brandColor->save();
                    }
                }
            }

        }
        if($this->age_group_id) {
            $this->age_group_id = implode(',', $this->age_group_id);
        }
        if($this->lining_id) {
            $this->lining_id = implode(',', $this->lining_id);
        }
        if($this->sole_id) {
            $this->sole_id = implode(',', $this->sole_id);
        }
        if($this->material_id) {
            $this->material_id = implode(',', $this->material_id);
        }
        return parent::beforeSave($insert);
    }
    public function afterSave($insert, $changedAttributes)
    {
        $this->setPage();
        return parent::afterSave($insert, $changedAttributes);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['brand_id' => 'id']);
    }

    public function getShoes()
    {
        return $this->hasOne(Shoes::className(), ['id' => 'shoes_id']);
    }
    public function getAgeGroup()
    {
        return $this->hasOne(AgeGroup::className(), ['id' => 'age_group_id']);
    }
    public function getAgeGroups()
    {
        return $this->age_group_id ? AgeGroup::find()->where(['in', 'id', $this->age_group_id])->all() : false;
    }
    public function getAgeGroupNames()
    {
        if($ageGroups = $this->ageGroups) {
            foreach($ageGroups as $ageGroup) {
                $names[] = $ageGroup->name;
            }
            return implode(', ', $names);
        }
        return false;
    }
    public function getMaterial()
    {
        return $this->hasOne(ShoesMaterial::className(), ['id' => 'material_id']);
    }
    public function getMaterials()
    {
        return $this->material_id ? ShoesMaterial::find()->where(['in', 'id', $this->material_id])->all() : false;
    }
    public function getMaterialNames()
    {
        if($materials = $this->materials) {
            foreach($materials as $material) {
                $names[] = $material->name;
            }
            return implode(', ', $names);
        }
        return false;
    }
    public function getLining()
    {
        return $this->hasOne(ShoesLining::className(), ['id' => 'lining_id']);
    }
    public function getLinings()
    {
        return $this->lining_id ? ShoesLining::find()->where(['in', 'id', $this->lining_id])->all() : false;
    }
    public function getLiningNames()
    {
        if($linings = $this->linings) {
            foreach($linings as $lining) {
                $names[] = $lining->name;
            }
            return implode(', ', $names);
        }
        return false;
    }
    public function getSole()
    {
        return $this->hasOne(ShoesSole::className(), ['id' => 'sole_id']);
    }
    public function getSoles()
    {
        return $this->sole_id ? ShoesLining::find()->where(['in', 'id', $this->sole_id])->all() : false;
    }
    public function getSoleNames()
    {
        if($soles = $this->soles) {
            foreach($soles as $sole) {
                $names[] = $sole->name;
            }
            return implode(', ', $names);
        }
        return false;
    }
    public function getBrandColors()
    {
        return $this->hasMany(BrandColor::className(), ['brand_id' => 'id']);
    }
    public function getBrandColorImages()
    {
        return $this->hasMany(BrandColorImage::className(), ['brand_id' => 'id']);
    }
    public function getBrandMaterialColors($materialId)
    {
        return BrandColor::findAll(['brand_id' => $this->id, 'material_id' => $materialId]);
    }

    public static function getList()
    {
        return ArrayHelper::map(self::find()->asArray()->all(), 'id', 'name');
    }

    public function getColorImages($color_id)
    {
        if($brandColorImages = BrandColorImage::find()->select(['image_id'])->where(['brand_id' => $this->id, 'color_id' => $color_id])->orderBy(['position' => SORT_ASC])->asArray()->all()) {
            $imageIds = [];
            foreach($brandColorImages as $brandColorImage) {
                $imageIds[] = $brandColorImage['image_id'];
            }
            return Image::find()->where(['in', 'id', $imageIds])->orderBy(['position' => SORT_ASC])->all();
        }
        return false;
    }

    public function brandMaterialsCount($materialId)
    {
        $count = 0;
        if($brandColors = BrandColor::find()->where(['brand_id' => $this->id, 'material_id' => $materialId])->all()) {
            foreach($brandColors as $brandColor) {
                if($brandColorImages = BrandColorImage::findAll(['brand_id' => $this->id, 'color_id' => $brandColor->color_id])) {
                    foreach($brandColorImages as $brandColorImage) {
                        if($brandColorImage->image) {
                            $count++;
                        }
                    }
                }
            }
        }
        return $count;
    }

    public function uploadImages()
    {
        if($this->images_field) {
            foreach($this->images_field as $colorId => $imageFile) {
                if($images = UploadedFile::getInstances($this, 'images_field['.$colorId.']')) {
                    foreach ($images as $image) {
                        $fileName = md5(time().$image->name);
                        $filePath = "/upload/model-images/{$fileName}.{$image->extension}";

                        if ($image->saveAs(Yii::getAlias('@webroot').$filePath)) {
                            $modelImage = new Image();
                            $modelImage->path = $filePath;
                            if($modelImage->save()) {
                                $color_image = new BrandColorImage();
                                $color_image->brand_id = $this->id;
                                $color_image->color_id = $colorId;
                                $color_image->image_id = $modelImage->id;
                                $color_image->save();
                            }
                        }
                    }
                }
            }
        }
        return true;
    }
    public function similarModels()
    {
        $query = self::find()
            ->joinWith(['brandColors']);

            if($this->color_ids) {
                foreach($this->color_ids as $colorId) {
                    $query->orOnCondition(['brand_colors.color_id' => $colorId]);
                }
            }

            $query->orOnCondition(['age_group_id' => $this->age_group_id]);
            $query->orOnCondition(['shoes_id' => $this->shoes_id]);

            $query->andWhere('shoes_brands.id <> '.$this->id);
            $query->orderBy(['brand_colors.color_id' => SORT_DESC]);
        return $query->all();
    }
    public function getSiteLink()
    {
        //return false;
        if($this->product && ($page = $this->product->page)) {
            return Html::a($page->name, Url::to('http://'.BasePage::URL_FRONT.$page->getFullUri()), ['target' => '_blanc']);
        }
        return false;
    }

    public function setPage()
    {
        if(!$product = Product::findOne(['brand_id' => $this->id])) {
            $product = new Product();
            $product->name = $this->name;
            $product->brand_id = $this->id;
        }
        else {
            $product->name = $this->name;
        }
        if($product->save()) {
            return $product->setPage($this);
        }
        return false;
    }
    public function setAgeGroup()
    {
        switch ($this->age_group_id) {
            case 1 : return Page::CHILD_SHOES_ID;
            case 2 : return Page::TEENAGER_SHOES_ID;
            case 3 : return Page::MAN_SHOES_ID;
            case 4 : return Page::WOMAN_SHOES_ID;
        }
        return null;
    }

    public function getMaterialList()
    {
        return $this->materials;
    }

    public function getBeginColorId()
    {
        if($colorMaterialIds = $this->color_ids) {
            foreach($colorMaterialIds as $materialId => $colorIds) {
                if($colorIds) {
                    foreach ($colorIds as $colorId) {
                        if($this->getColorImages($colorId)) {
                            return $colorId;
                        }
                    }
                }
            }
        }
        return 1;
    }

    public function getBeginMaterialColorId($material_id)
    {
        if($colorMaterialIds = $this->color_ids) {
            foreach($colorMaterialIds as $materialId => $colorIds) {
                if($materialId == $material_id && $colorIds) {
                    foreach ($colorIds as $colorId) {
                        if($this->getColorImages($colorId)) {
                            return $colorId;
                        }
                    }
                }
            }
        }
        return 1;
    }

    public static function defaultImagePath()
    {
        if($image = Image::findOne(self::DEFAULT_IMAGE_ID)) {
            return $image->path;
        }
    }
    public function getImg()
    {
        if($brandColors = $this->brandColorImages) {
            $brandColor = $brandColors[0];
            if($brandColor->image && $brandColor->image->path) {
                if(EasyThumbnailImage::thumbnailFile(Yii::getAlias('@webroot').$brandColor->image->path, 320, 210, EasyThumbnailImage::THUMBNAIL_OUTBOUND)) {
                    return EasyThumbnailImage::thumbnailImg(Yii::getAlias('@webroot').$brandColor->image->path, 320, 210, EasyThumbnailImage::THUMBNAIL_OUTBOUND);
                }
            }
            if($defaultImagePath = ShoesBrand::defaultImagePath()) {
                return EasyThumbnailImage::thumbnailImg(Yii::getAlias('@webroot').$defaultImagePath, 320, 210, EasyThumbnailImage::THUMBNAIL_OUTBOUND);
            }
        }

        return false;
    }
}
