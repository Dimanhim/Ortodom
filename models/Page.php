<?php

namespace app\models;

use app\modules\directory\models\AgeGroup;
use app\modules\directory\models\ShoesBrand;
use himiklab\sortablegrid\SortableGridBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * This is the model class for table "pages".
 *
 * @property int $id
 * @property string $alias
 * @property int|null $parent_id
 * @property string $name
 * @property string|null $h1
 * @property string|null $title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string $type
 * @property string $template
 * @property string $custom_code
 * @property int|null $relation_id
 * @property int|null $is_active
 * @property int $position
 * @property int $created_at
 * @property int $updated_at
 *
 * @property object $dataSource
 * @property Page $parent
 * @property string $fullUri
 * @property string $typeTitle
 * @property Page[] $children
 * @property int|string $countChildren
 * @property string $templatePath
 * @property Page $current
 */
class Page extends \yii\db\ActiveRecord
{
    const TYPE_CONTENT = 'content-pages';
    const TYPE_SERVICE = 'service';
    const TYPE_PRODUCT = 'product';
    const TYPE_ARTICLE = 'article';

    const MAN_SHOES_ID       = 30;
    const WOMAN_SHOES_ID     = 31;
    const CHILD_SHOES_ID     = 32;
    const TEENAGER_SHOES_ID  = 113;

    const NEWS_ID = 15;

    public static $current;

    public static $availableTypes = [
        self::TYPE_CONTENT => [
            'class' => ContentPage::class,
            'title' => 'Страницы контента',
            'imagePath' => 'Страницы контента',
        ],
        self::TYPE_SERVICE => [
            'class' => Service::class,
            'title' => 'Страницы услуг',
            'imagePath' => 'Страницы услуг',
        ],
        self::TYPE_PRODUCT => [
            'class' => Product::class,
            'title' => 'Страницы моделей обуви',
            'imagePath' => 'Страницы моделей обуви',
        ],
        self::TYPE_ARTICLE => [
            'class' => Article::class,
            'title' => 'Страницы статей',
            'imagePath' => 'Страницы статей',
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pages';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            'sort' => [
                'class' => SortableGridBehavior::className(),
                'sortableAttribute' => 'sortOrder',
            ],
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
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['alias', 'name', 'type'], 'required'],
            [['parent_id', 'position', 'relation_id', 'is_active', 'search_indexing'], 'integer'],
            [['alias', 'name', 'h1', 'title', 'meta_description', 'meta_keywords', 'type', 'template', 'external_link'], 'string', 'max' => 255],
            [['custom_code'], 'string'],
            [['sortOrder'], 'safe'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDataSource()
    {
        return $this->hasOne(static::$availableTypes[$this->type]['class'], ['id' => 'relation_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'alias' => 'Алиас',
            'parent_id' => 'Родитель',
            'parent' => 'Родитель',
            'name' => 'Название',
            'h1' => 'H1',
            'title' => 'Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'type' => 'Тип',
            'relation_id' => 'Связанный объект',
            'is_active' => 'Активность',
            'search_indexing' => 'Запретить индексацию поисковиками',
            'custom_code' => 'Произвольный код',
            'template' => 'Шаблон',
            'external_link' => 'Внешняя ссылка',
            'position' => 'Позиция',
            'sortOrder' => 'Сортировка',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Page::className(), ['id' => 'parent_id'])
            ->from(Page::tableName() . ' parent');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(Page::className(), ['parent_id' => 'id'])->orderBy('position ASC');
    }

    /**
     * @return int|string
     */
    public function getCountChildren()
    {
        return $this->hasMany(Page::className(), ['parent_id' => 'id'])->count();
    }

    /**
     * @return bool
     */
    public function validateType() {
        return isset(static::$availableTypes[$this->type]['class']);
    }

    /**
     * @return mixed
     */
    public function getModelInstance() {
        return new static::$availableTypes[$this->type]['class'];
    }

    /**
     * @return string
     */
    public function getTypeTitle() {
        return static::$availableTypes[$this->type]['title'];
    }

    /**
     * @param $type
     * @param string $default
     * @return string
     */
    public static function getTitleOfType($type, $default = '') {
        return isset(static::$availableTypes[$type]) ? static::$availableTypes[$type]['title'] : $default;
    }

    /**
     * @param null $type
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getList($type = null) {
        return self::find()
            ->andFilterWhere(['type' => $type])
            ->all();
    }

    public static function getAgeList($type = null) {
        return array_merge(self::find()
            ->andFilterWhere(['type' => $type])
            ->andFilterWhere(['parent_id' => 2])
            ->all(), self::getParentPageList());
    }

    public static function getParentPageList()
    {
        return self::find()
            ->where(['type' => 'content-pages'])
            ->andWhere(['parent_id' => 0])
            ->all();
    }

    public function getNews()
    {
        return self::find()->where(['parent_id' => self::NEWS_ID])->orderBy(['sortOrder' => SORT_ASC, 'created_at' => SORT_DESC])->limit(6)->all();
    }

    /**
     * @return string
     */
    public function getFullUri() {
        $fullPath = [];
        $page = $this;

        if ($page->alias == '/') {
            return '/';
        }

        do {
            $fullPath[] = $page->alias;
            if ($page->parent_id) {
                $page = $page->parent;
            } else {
                $page = null;
            }
        } while ($page);

        return '/'.implode('/', array_reverse($fullPath));
    }
    public function getFrontFullUri()
    {
        return 'http://'.BasePage::URL_FRONT.$this->getFullUri();
    }
    public function getFullLink()
    {
        return $this->external_link ? $this->external_link : $this->getFullUri();
    }
    public function getFullAbsoluteUrl($get = false)
    {
        $home = substr(Url::home(true), 0, -1);
        $uri = $this->getFullUri();
        $getStr = '';
        if($params = $_GET) {
            $i = 0;
            foreach($params as $k => $v) {
                if($k != 'page') {
                    $getStr .= $i ? '&'.$k.'='.$v : '?'.$k.'='.$v;
                    $i++;
                }
            }
        }
        return $get ? $home.$uri : $home.$uri.$getStr;
    }

    /**
     * @return string
     */
    public function getTemplatePath() {
        if($this->template) {
            return "//pages/front/custom-templates/{$this->template}";
        }
        switch ($this->type) {
            case Page::TYPE_PRODUCT : {
                if($this->parent_id != Product::PRODUCT_CATALOG_ID) {
                    return "//pages/front/_product_inner";
                }
            }
        }
        return "//pages/front/{$this->type}";
    }

    /**
     * @return string|null
     */
    public function getTitle() {
        return $this->title ? $this->title : $this->name;
    }

    /**
     * @return string|null
     */
    public function getH1() {
        return $this->h1 ? $this->h1 : $this->name;
    }
    public function getShortDescription()
    {
        $str = '';
        switch($this->type) {
            case self::TYPE_ADVICE : $str = '' /*$str = " | Советы от бренда"*/;
                break;
            case self::TYPE_EVENT : $str = '' /*$str = " | Советы от бренда"*/;
                break;
            case self::TYPE_MENTOR;
                $mentor = Mentor::findOne($this->relation_id);
                $str = ' | '.$mentor->name.", ".$mentor->description;
                break;
        }
        return $str;
    }
    public function getAllowedTags()
    {
        return [
            'meta',
            'a', 'span', 'img', 'b',
            'h1', 'h2', 'h3', 'h4',
            'div','p',  'ul', 'ol', 'li',
            'strong', 'sub', 'sup', 'small', 'br',
            'iframe', 'script', 'style',
            'table', 'thead', 'tbody', 'tr', 'th', 'td',
        ];
    }

    public function showH1BreadCrumb()
    {
        if($this->type != self::TYPE_PRODUCT) {
            return true;
        }
        elseif($this->parent_id == Product::PRODUCT_CATALOG_ID) {
            return true;
        }
        return false;
    }

    public static function ageGroupsArray()
    {
        return [
            self::MAN_SHOES_ID,
            self::WOMAN_SHOES_ID,
            self::CHILD_SHOES_ID,
            self::TEENAGER_SHOES_ID,
        ];
    }

    public function getParentsAgePages($limit = null)
    {
        $count = 0;
        $productIds = [];
        if(!in_array($this->id, self::ageGroupsArray())) return $productIds;

        if($brands = ShoesBrand::find()->all()) {
            $ageGroupIdRelation = array_key_exists($this->id, AgeGroup::relationsBrands()) ? AgeGroup::relationsBrands()[$this->id] : null;
            foreach($brands as $brand) {
                if(in_array($ageGroupIdRelation, $brand->age_group_id) && ($product = $brand->product)) {
                    if($limit && $limit == $count) break;
                    $productIds[] = $product->id;
                    $count++;
                }

            }
        }
        return Product::find()->where(['in', 'id', $productIds])->all();



        $products = Page::findAll(['type' => Page::TYPE_PRODUCT, 'parent_id' => $this->id]);
        return $products;
    }


}
