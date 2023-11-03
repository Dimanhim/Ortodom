<?php


namespace app\models;


use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

/**
 * @property Page $page
 * @property PageRelation[] $pageRelations
 * @property Page[] $related
 */
class BasePage extends \yii\db\ActiveRecord
{
    const URL_FRONT = 'ortodom-spb.ru';
    public $dateFields = [];
    public $image_fields = [];
    public $image_preview_fields = [];
    public $relatedField;
    public $ecommerceRelated;

    public static function getFrontUrls()
    {
        return [
            'ortodom-spb.ru',
            'www.ortodom-spb.ru',
        ];
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
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function beforeSave($insert)
    {
        $this->handleDates();
        $this->handleImages();
        return parent::beforeSave($insert);
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        $this->handleRelated();
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     *
     */
    public function afterFind()
    {
        $this->setupDates();
        $this->setupRelated();
        parent::afterFind();
    }

    /**
     *
     */
    private function handleDates() {
        foreach ($this->dateFields as $dateField => $dateFieldName) {
            $this->$dateFieldName = strtotime($this->$dateField);
        }
    }

    /**
     *
     */
    private function handleRelated() {
        if (!$page = $this->page) {
            return;
        }

        PageRelation::deleteAll(['page_id' => $page->id]);
        if (is_array($this->relatedField)) {
            foreach ($this->relatedField as $relatedId) {
                $newPageRelation = new PageRelation();
                $newPageRelation->page_id = $page->id;
                $newPageRelation->related_id = $relatedId;
                $newPageRelation->save();
            }
        }
    }


    /**
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    private function handleImages() {
        if (!$page = $this->page) {
            return;
        }

        $filesDir = Yii::getAlias('@webroot')."/upload/{$page->type}/";
        if (!file_exists($filesDir)) mkdir($filesDir, 0777, true);
        foreach ($this->image_fields as $image_field => $image_fieldName) {
            if ($file = UploadedFile::getInstance($this, $image_field)) {
                $fileName = md5(time().$image_fieldName);
                $filePath = "/upload/{$page->type}/{$fileName}.{$file->extension}";

                if (!$file->saveAs(Yii::getAlias('@webroot').$filePath)) {
                    continue;
                }

                if ($this->$image_fieldName and $existingImage = Image::findOne($this->$image_fieldName)) {
                    $existingImage->delete();
                }

                if ($image = Image::create($filePath)) {
                    $this->$image_fieldName = $image->id;
                }
            }
        }
        foreach ($this->image_preview_fields as $image_field => $image_fieldName) {
            if ($file = UploadedFile::getInstance($this, $image_field)) {
                $fileName = md5(time().$image_fieldName);
                $filePath = "/upload/{$page->type}/{$fileName}.'-preview'.{$file->extension}";

                if (!$file->saveAs(Yii::getAlias('@webroot').$filePath)) {
                    continue;
                }

                if ($this->$image_fieldName and $existingImage = Image::findOne($this->$image_fieldName)) {
                    $existingImage->delete();
                }

                if ($image = Image::create($filePath)) {
                    $this->$image_fieldName = $image->id;
                }
            }
        }
        if($page->type == 'products') {
            foreach ($this->spec_image_fields as $spec_image_field => $spec_image_fieldName) {
                if ($file = UploadedFile::getInstance($this, $spec_image_field)) {
                    $fileName = md5(time().$spec_image_fieldName);
                    $filePath = "/upload/{$page->type}/{$fileName}.{$file->extension}";

                    if (!$file->saveAs(Yii::getAlias('@webroot').$filePath)) {
                        continue;
                    }

                    if ($this->$spec_image_fieldName and $existingImage = Image::findOne($this->$spec_image_fieldName)) {
                        $existingImage->delete();
                    }

                    if ($image = Image::create($filePath)) {
                        $this->$spec_image_fieldName = $image->id;
                    }
                }
            }
        }

    }

    /**
     *
     */
    private function setupRelated() {
        return;
        $relatedPage = $this->page ? PageRelation::find()->select('related_id')->where(['page_id' => $this->page->id]) : null;
        $this->relatedField = $relatedPage ? $relatedPage->column() : null;
    }

    /**
     *
     */
    private function setupDates() {
        foreach ($this->dateFields as $dateField => $dateFieldName) {
            $this->$dateField = date('d.m.Y', $this->$dateFieldName);
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        $type = null;
        Yii::info(get_class($this));
        foreach (Page::$availableTypes as $typeName => $availableType) {
            if ($availableType['class'] == get_class($this)) {
                $type = $typeName;
            }
        }
        return $type ? $this->hasOne(Page::class, ['relation_id' => 'id'])->onCondition(['type' => $type]) : null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPageRelations()
    {
        return $this->hasMany(PageRelation::className(), ['page_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelated()
    {
        $relatedPages = [];
        foreach (PageRelation::find()->select('related_id')->where(['page_id' => $this->page->id])->column() as $relatedPageId) {
            $relatedPages[] = Page::findOne($relatedPageId);
        }
        return $relatedPages;
        return $this->hasMany(Page::className(), ['id' => 'related_id'])->via('pageRelations');
    }

}
