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

namespace app\models;

use app\components\Helpers;
use app\modules\directory\models\Appointment;
use app\modules\directory\models\Diagnosis;
use app\modules\directory\models\OrderStatus;
use app\modules\directory\models\Payment;
use app\modules\directory\models\Shoes;
use app\modules\directory\models\ShoesBrand;
use app\modules\directory\models\ShoesColor;
use app\modules\directory\models\ShoesHeel;
use app\modules\directory\models\ShoesLast;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\helpers\Html;

/**
 * This is the model class for table "{{%orders}}".
 *
 * @property int $id
 * @property string $fullId
 * @property int $patient_id
 * @property string $representative_name
 * @property int $payment_id
 * @property string $diagnosis_id
 * @property string $referral
 * @property int $shoes_id
 * @property string $accepted
 * @property string $issued
 * @property string $prepaid
 * @property string $cost
 * @property Patient $patient
 * @property Diagnosis $diagnosis
 * @property Payment $payment
 * @property Shoes $shoes
 * @property string $model
 * @property string $color
 * @property string $size
 */
class Order extends BaseOrder
{
    const YANDEX_REVIEW_SMS_SEND_YES = 1;
    const YANDEX_REVIEW_SMS_SEND_NO = 2;

    public $file;

    public $checkbox;

    public $changeStatusForm;

    public $changeColorForm;

    public $highlightLine;

    public $order_statuses = [
        1,2,3,4,5,10,11
    ];

    public $production_statuses = [
        6,7,8,9
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%orders}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['patient_id', 'accepted'], 'required'],
            [['payment_id', 'status_id', 'status_date', 'patient_id', 'diagnosis_id', 'shoes_id', 'checkbox', 'appointment_left_id', 'appointment_right_id', 'prepaid_date', 'sms_yandex_review', 'sms_yandex_datetime', 'sms_yandex_result', 'sms_ready'], 'integer'],
            [['accepted', 'issued', 'changeStatusForm', 'changeColorForm', 'highlightLine'], 'safe'],
            [['prepaid', 'cost'], 'number'],
            [['file'], 'file'],
            [['representative_name', 'referral', 'model', 'color', 'size', 'scan', 'block'], 'string', 'max' => 255],
            [['patient_id'], 'exist', 'skipOnError' => true, 'targetClass' => Patient::className(), 'targetAttribute' => ['patient_id' => 'id']],
            [['diagnosis_id'], 'exist', 'skipOnError' => true, 'targetClass' => Diagnosis::className(), 'targetAttribute' => ['diagnosis_id' => 'id']],
            [['payment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Payment::className(), 'targetAttribute' => ['payment_id' => 'id']],
            [['shoes_id'], 'exist', 'skipOnError' => true, 'targetClass' => Shoes::className(), 'targetAttribute' => ['shoes_id' => 'id']],
            [['appointment_left', 'appointment_right'], 'string'],

            [['brand_id', 'material_id', 'lining_id', 'color_id', 'sole_id', 'last_id'], 'integer'],
            [['appointment_left_data', 'appointment_right_data', 'heel_left', 'heel_right', 'heel_left_data', 'heel_right_data', 'shoes_data', 'brand_data', 'material_data', 'lining_data', 'color_data', 'sole_data', 'last_data'], 'string'],
        ];
    }

    public function yandexSmsRequired()
    {
        if ($this->issued && !$this->sms_yandex_review) {
            $this->addError('sms_yandex_review', 'Выберите значение - присылать ли клиенту смс');
            return false;
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'patient_id' => 'ФИО',
            'status_id' => 'Статус',
            'status_date' => 'Дата',
            'representative_name' => 'ФИО представителя',
            'payment_id' => 'Форма оплаты',
            'diagnosis_id' => 'Диагноз',
            'referral' => '№ и дата направления',
            'shoes_id' => 'Вид обуви',
            'accepted' => 'Принят',
            'issued' => 'Выдан',
            'prepaid' => 'Аванс',
            'prepaid_date' => 'Дата аванса',
            'cost' => 'Стоимость',
            'model' => 'Прежняя модель',
            'color' => 'Цвет',
            'size' => 'Подошва/размер',
            'scan' => 'Скан стопы',
            'file' => 'Скан стопы',
            'checkbox' => 'Выбрать',
            'changeStatusForm' => 'Пакетно изменить статус',
            'changeColorForm' => 'Пакетно изменить цвет',
            'appointment_left_id' => 'Назначение левая',
            'appointment_left' => 'Назначение левая',
            'appointment_right_id' => 'Назначение правая',
            'appointment_right' => 'Назначение правая',
            'block' => 'Колодка',

            'shoes_data' => 'Вписать допданные',
            'brand_id' => 'Модель',
            'brand_data' => 'Вписать допданные',
            'material_id' => 'Материал верха/цвет',
            'material_data' => 'Вписать допданные',
            'lining_id' => 'Подкладка',
            'lining_data' => 'Вписать допданные',
            'color_id' => 'Цвет',
            'color_data' => 'Вписать допданные',
            'appointment_left' => 'Назначение левая',
            'appointment_left_data' => 'Вписать допданные',
            'appointment_right' => 'Назначение правая',
            'appointment_right_data' => 'Вписать допданные',
            'heel_left' => 'Задник левая',
            'heel_left_data' => 'Вписать допданные',
            'heel_right' => 'Задник правая',
            'heel_right_data' => 'Вписать допданные',
            'sole_id' => 'Подошва',
            'sole_data' => 'Вписать допданные',
            'last_id' => 'Колодка',
            'last_data' => 'Вписать допданные',

            'highlightLine' => 'Выделить строку цветом',

            'sms_yandex_review' => 'Оставить отзыв на Яндексе',
        ];
    }

    public function getFullId()
    {
        return \str_pad($this->id, 4, 0, STR_PAD_LEFT);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPatient()
    {
        return $this->hasOne(Patient::className(), ['id' => 'patient_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiagnosis()
    {
        return $this->hasOne(Diagnosis::className(), ['id' => 'diagnosis_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayment()
    {
        return $this->hasOne(Payment::className(), ['id' => 'payment_id']);
    }

    public function getAppointmentLeftId()
    {
        return $this->hasOne(Appointment::className(), ['id' => 'appointment_left_id']);
    }
    public function getAppointmentRightId()
    {
        return $this->hasOne(Appointment::className(), ['id' => 'appointment_right_id']);
    }
    public function getAppointmentLeft()
    {
        return $this->hasOne(Appointment::className(), ['id' => 'appointment_left']);
    }
    public function getAppointmentRight()
    {
        return $this->hasOne(Appointment::className(), ['id' => 'appointment_right']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShoes()
    {
        return $this->hasOne(Shoes::className(), ['id' => 'shoes_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(ShoesBrand::className(), ['id' => 'brand_id']);
    }
    public function getStatus()
    {
        return $this->hasOne(OrderStatus::className(), ['id' => 'status_id']);
    }
    public static function getOrderStatusesArray($attribute = 'name', $sort = true)
    {
        $result = [];
        if($sort) {
            $statusesArray = OrderStatus::find()->orderBy(['position' => SORT_ASC])->asArray()->all();
        }
        else {
            $statusesArray = OrderStatus::find()->asArray()->all();
        }
        if($statusesArray) {
            foreach($statusesArray as $status) {
                $result[$status['id']] = $status[$attribute];
            }
        }
        return $result;

        return $sort ?
            ArrayHelper::map(OrderStatus::find()->orderBy(['position' => SORT_ASC])->asArray()->all(), 'id', $attribute)
            :
            ArrayHelper::map(OrderStatus::find()->asArray()->all(), 'id', $attribute)
            ;
    }

    public function statusesArray()
    {
        return array_merge([0 => '--Выбрать--'], self::getOrderStatusesArray());


        return [
            0 => '--Выбрать--',
            1 => 'Заказ принят врачом',
            2 => 'Заказ к отправке',
            6 => 'В колодочном',
            7 => 'В закройном',
            8 => 'В швейном',
            9 => 'В затяжном',
            3 => 'Заказ готов к выдаче',
            4 => 'Заказ на переделку',
            5 => 'Заказ выдан',
            10 => 'Заказ принят в производство',
        ];
    }
    public function statusesSearchArray()
    {
        return self::getOrderStatusesArray();

        return [
            1 => 'Заказ принят врачом',
            2 => 'Заказ к отправке',
            6 => 'В колодочном',
            7 => 'В закройном',
            8 => 'В швейном',
            9 => 'В затяжном',
            3 => 'Заказ готов к выдаче',
            4 => 'Заказ на переделку',
            5 => 'Заказ выдан',
            10 => 'Заказ принят в производство',
        ];
    }
    public function getStatusValue()
    {
        $arr = [
            1 => false,
            2 => 'Отправлен в производство. '.date('d.m.Y', $this->status_date),
            3 => 'Готов к выдаче. '.date('d.m.Y', $this->status_date),
            4 => 'На переделку. '.date('d.m.Y', $this->status_date),
            5 => false,
        ];
        return $arr[$this->status_id];
    }

    /**
     * @return mixed
     */
    public function getSearchStatusStyle()
    {
        $model = new JournalSearch();
        if($model->load(Yii::$app->request->get()) && $model->highlightLine) {
            $statusStyles = array_merge([0 => 'background: transparent;'], self::getOrderStatusesArray('styles'));
            return $statusStyles[$model->highlightLine];
        }
        return $this->getStatusStyle();
    }

    public function getStatusStyle()
    {
        //$arr = array_merge([0 => 'background: transparent;'], self::getOrderStatusesArray('styles'));
        $arr = self::getOrderStatusesArray('styles');
        /*$arr = [
            0 => 'background: transparent;',
            1 => 'background: #d6d813;',
            2 => 'background: #FCB322;',
            3 => 'background: #098d1c; color: #fff !important',
            4 => 'background: #b90a2f; color: #fff !important',
            5 => 'background: #ccc;',
            6 => 'background: #ccc;',
            7 => 'background: #ccc;',
            8 => 'background: #ccc;',
            9 => 'background: #ccc;',
            10 => 'background: #ccc;',
        ];*/
        return $arr[$this->status_id];
    }
    public static function statusNamesArray()
    {
        $statuses = self::getOrderStatusesArray('name', true);
        $statuses[0] = 'Без статуса';
        return $statuses;
    }
    public static function statusStylesArray()
    {
        $statuses = self::getOrderStatusesArray('styles', true);
        $statuses[0] = 'background: transparent;';
        return $statuses;

        return [
            0 => 'background: transparent;',
            1 => 'background: #d6d813;',
            2 => 'background: #FCB322;',
            3 => 'background: #098d1c; color: #fff',
            4 => 'background: #b90a2f; color: #fff',
            5 => 'background: #ccc;',
            6 => 'background: #ccc;',
            7 => 'background: #ccc;',
            8 => 'background: #ccc;',
            9 => 'background: #ccc;',
            10 => 'background: #ccc;',
        ];
    }
    public function getDisabledStatuses()
    {
        /*if(Yii::$app->user->getIdentity()->role == 'admin') return [
            1 => ['disabled' => true],
            2 => ['disabled' => true],
            3 => ['disabled' => true],
            5 => ['disabled' => true],
        ];*/
        if(Yii::$app->user->getIdentity()->role == 'admin') return [
            1 => ['disabled' => true],
            5 => ['disabled' => true],
        ];
        if(Yii::$app->user->getIdentity()->role == 'superadmin') return [
            1 => ['disabled' => true],
            5 => ['disabled' => true],
        ];
    }

    public function getStatusName()
    {
        return self::getOrderStatusesArray()[$this->status_id];
    }

    /**
     * {@inheritdoc}
     */
    public function afterFind()
    {
        parent::afterFind();

        $this->accepted = date('d.m.Y', strtotime($this->accepted));

        if ($this->issued != null) {
            $this->issued = date('d.m.Y', strtotime($this->issued));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->accepted = date('Y-m-d', strtotime($this->accepted));

            if ($this->issued != null) {
                $this->issued = date('Y-m-d', strtotime($this->issued));
            }

            if($this->status_id == 5) {
                $this->issued = date('Y-m-d', time());
            }

            if (!in_array($this->payment_id, [Payment::CASH, Payment::REDRESS, Payment::NR])) {
                $this->prepaid = $this->cost = null;
            }

            return true;
        }

        return false;
    }
    public function afterSave($insert, $changedAttributes)
    {
        $this->updateOrderStatusDate();
        return parent::afterSave($insert, $changedAttributes);
    }
    public function uploadScan()
    {
        $this->file = UploadedFile::getInstance($this, 'file');
        if($this->file->baseName) {
            $fileName = time().".".$this->file->extension;
            $this->file->saveAs("images/scan/".$fileName);
            $this->scan = $fileName;
            $this->update(false);
        }
    }
    public function getChangeStatus()
    {
        if($this->issued) {
            $this->status_id = 5;
        }
    }

    public function measureStatusSms()
    {
        $visit = new Visit();
        if(($this->status_id == 11) && ($this->patient) && ($phone = $this->patient->phone)) {
            $text = "Ваш заказ № {$this->id} к примерке готов! Ждем Вас по адресу: \nВыборгское шоссе 5/1 \nт.8(800)2227002\n Пн-Сб., с 10-20 ч., \nперерыв с 14-15ч.";
            //$text_voice = "Ваш заказ ортопедической обуви готов к выдаче! Ждём Вас по адресу: Выборгское шоссе 5 дробь 1 Телефон для связи 8(800)2227002";
            $text_voice = "Ваш заказ номер {$this->id} к примерке №{$this->countMeasure} готов. Ждём Вас по адресу: Выборгское шоссе 5 дробь 1 Телефон для связи 8(800)2227002 С понедельника по субботу с десяти до двадцати часов, перерыв с четырнадцати до пятнадцати часов.";
            //$phone = '+79887608134';
            $visit->sendSmsText($phone, $text);
            $visit->sendVoiceText($phone, $text_voice);
        }
    }

    /**
     *  sends sms message after change order status to 'Заказ готов к выдаче'
     */
    public function getUpdateStatus()
    {
        $visit = new Visit();
        if(($this->status_id == 3) && ($this->patient) && ($phone = $this->patient->phone)) {
            $text = "Ваш заказ ортопедической обуви / стелек №{$this->id}, готов к выдаче! \nПолучение заказа БЕЗ ЗАПИСИ по адресу: \nВыборгское шоссе 5/1 \nт.8(800)2227002\n Пн-Сб., с 10-20 ч., \nперерыв с 14-15ч.";
            //$text_voice = "Ваш заказ ортопедической обуви готов к выдаче! Ждём Вас по адресу: Выборгское шоссе 5 дробь 1 Телефон для связи 8(800)2227002";
            $text_voice = "Ваш заказ ортопедической обуви готов к выдаче! Ждём Вас по адресу: Выборгское шоссе 5 дробь 1 Телефон для связи 8(800)2227002 С понедельника по субботу с десяти до двадцати часов, перерыв с четырнадцати до пятнадцати часов.";
            //$phone = '+79887608134';
            $visit->sendSmsText($phone, $text);
            $visit->sendVoiceText($phone, $text_voice);
        }
        elseif(($this->status_id == 11) && ($this->patient) && ($phone = $this->patient->phone)) {
            $text = "Ваш заказ № {$this->id} к примерке №{$this->countMeasure} готов! Ждем Вас по адресу: \nВыборгское шоссе 5/1 \nт.8(800)2227002\n Пн-Сб., с 10-20 ч., \nперерыв с 14-15ч.";
            //$text_voice = "Ваш заказ ортопедической обуви готов к выдаче! Ждём Вас по адресу: Выборгское шоссе 5 дробь 1 Телефон для связи 8(800)2227002";
            $text_voice = "Ваш заказ номер {$this->id} к примерке готов. Ждём Вас по адресу: Выборгское шоссе 5 дробь 1 Телефон для связи 8(800)2227002 С понедельника по субботу с десяти до двадцати часов, перерыв с четырнадцати до пятнадцати часов.";
            //$phone = '+79887608134';
            $visit->sendSmsText($phone, $text);
            $visit->sendVoiceText($phone, $text_voice);
        }
    }
    public static function updatePacketStatus($order_ids)
    {
        $patients = [];

        // из пакетно выбранных заказов получаем массив
        // с ключами patient_id, а значения - массив объектов заказов
        if($order_ids) {
            foreach($order_ids as $order_id) {
                if($order = Order::findOne($order_id)) {
                    if($order->patient) {
                        $patients[$order->patient->id][] = $order;
                    }
                }
            }
        }
        if($patients) {

            // перебираем полученный массив
            foreach($patients as $patientId => $patientOrders) {

                if(!$patient = Patient::findOne($patientId)) continue;

                // получаем id заказов со статусом Готов для вставки их в текст сообщения
                $orderIds = [];
                if($patientOrders) {
                    foreach($patientOrders as $patientOrder) {
                        // сделать новый массив по примерке
                        if($patientOrder->status_id == 3) {
                            $orderIds[] = $patientOrder->id;
                        }
                    }
                }

                // продублировать этот код, только уже с заказами по примерке + новый метод для отсылки смс
                if($orderIds) {

                    // получаем текст id заказов
                    $orderIdsText = implode(', ', $orderIds);

                    if(($phone = $patient->phone)) {

                        self::sendReadySms($orderIdsText, $phone);
                        /*$visit = new Visit();
                        $text = "Ваш заказ ортопедической обуви / стелек №{$orderIdsText}, готов к выдаче!  \nПолучение заказа БЕЗ ЗАПИСИ по адресу: \nВыборгское шоссе 5/1 \nт.8(800)2227002\n Пн-Сб., с 10-20 ч., \nперерыв с 14-15ч.";
                        $text_voice = "Ваш заказ ортопедической обуви готов к выдаче! Ждём Вас по адресу: Выборгское шоссе 5 дробь 1 Телефон для связи 8(800)2227002 С понедельника по субботу с десяти до двадцати часов, перерыв с четырнадцати до пятнадцати часов.";

                        $visit->sendSmsText($phone, $text);
                        $visit->sendVoiceText($phone, $text_voice);*/

                    }
                }
            }
        }
        return true;
    }
    public function getStatusDates()
    {
        return $this->hasMany(OrderStatusDate::className(), ['order_id' => 'id']);
    }
    public function getStatusMeasureCount()
    {
        return OrderStatusDate::find()->where(['order_id' => $this->id, 'status_id' => 11])->count();
    }
    public function getCountMeasure()
    {
        return $this->getStatusMeasureCount() + 1;
    }
    public static function sendReadySms($orderIdsText, $phone)
    {
        $visit = new Visit();
        $text = "Ваш заказ ортопедической обуви / стелек №{$orderIdsText}, готов к выдаче!  \nПолучение заказа БЕЗ ЗАПИСИ по адресу: \nВыборгское шоссе 5/1 \nт.8(800)2227002\n Пн-Сб., с 10-20 ч., \nперерыв с 14-15ч.";
        $text_voice = "Ваш заказ ортопедической обуви готов к выдаче! Ждём Вас по адресу: Выборгское шоссе 5 дробь 1 Телефон для связи 8(800)2227002 С понедельника по субботу с десяти до двадцати часов, перерыв с четырнадцати до пятнадцати часов.";

        $visit->sendSmsText($phone, $text);
        $visit->sendVoiceText($phone, $text_voice);
    }
    public function getHeaderId()
    {
        $sortName = '';
        $className = '';
        $str = '';
        if($request = Yii::$app->request->get('sort')) {
            if(($request == 'id') || ($request == '-id')) {
                if($request == 'id') {
                    $sortName = '-id';
                    $className = 'desc';
                } else {
                    $sortName = 'id';
                    $className = 'asc';
                }
            }
        } else {
            $sortName = '-id';
        }
        $str .= Html::a('№', Yii::$app->urlManager->createUrl(['order/index', 'sort' => $sortName]), ['data-sort' => $sortName, 'class' => $className]);
        $str .= ' '.Html::a('<span class="glyphicon glyphicon-search" style="margin-left:20px"></span>', '#', ['class' => 'view-modal-select-id']);
        return $str;
    }



    /**
     * @return string
     */
    public function getBarcodeNumber()
    {
        $values = 11;
        $barcodeNumber = str_pad($this->id, $values, "0", STR_PAD_LEFT);
        return $barcodeNumber;
    }

    /**
     * @return string
     */
    public function getBarcodeView()
    {
        return Helpers::generateBarcode($this->getBarcodeNumber());
    }

    /**
     * @param $code
     * @return int
     */
    public function getIdByBarcode($code)
    {
        return (integer) $code;
    }

    /**
     * @return string
     */
    public function getBarcodeBlock()
    {
        return Yii::$app->controller->renderPartial('//order/print/_barcode_template', [
            'model' => $this,
        ]);
    }

    /**
     * @return string
     */
    public function modelImage()
    {
        return '/images/ortodom.png';
    }

    /**
     * @return string
     */
    public function modelImageBlock()
    {
        return '
            <div class="ready-model-photo">
                <img src="'.$this->modelImage().'" alt="" />
            </div>
        ';
    }

    public function highlightsColors($text = true)
    {
        return [
            1 => $text ? 'background-color: #5cb85c' : '', // зеленый
            2 => $text ? 'background-color: #d9534f' : '', // красный
            3 => $text ? 'background-color: #f0ad4e' : '', // желтый
        ];
    }

    public function colorsArray()
    {
        return ArrayHelper::map(ShoesColor::find()->asArray()->all(), 'id', 'name');
    }

    public function getJournalColorsArray()
    {
        $arr = [
            10 => 'background-color: #F8CBAD',
            2 => 'background-color: #BDD7EE',
            7 => 'background-color: #FFE699',
            8 => 'background-color: #E7D5FF',
            9 => 'background-color: #C6E0B4',
            4 => 'background-color: #FF0000; color: #fff',
        ];
        return array_key_exists($this->status_id, $arr) ? $arr[$this->status_id] : '';
    }

    public function sendYandexReviewSms()
    {
        $visit = new Visit();
        if($this->patient && $this->patient->phone) {
            $smsText = "Благодарим Вас за то, что вы являетесь клиентом «ОртоДом».\n
            Мы будем искренне рады вашему отзыву https://yandex.ru/maps/org/ortodom/204069446950/reviews/";
            $visit->sendSms($this->patient->phone, $smsText);
            $this->sms_yandex_result = 1;
            $this->save(false);
        }
        return true;
    }
    public function updateOrderStatusDate()
    {
        if($this->id && $this->status_id) {
            $statusDate = new OrderStatusDate();
            $statusDate->order_id = $this->id;
            $statusDate->status_id = $this->status_id;
            $statusDate->save();
        }
    }
    public function getIssuedDates()
    {
        if($orderDates = OrderStatusDate::find()->where(['order_id' => $this->id, 'status_id' => 5])->orderBy(['created_at' => SORT_DESC])->all()) {
            //$str = $this->issued;
            $str = '';
            foreach($orderDates as $key => $orderDate) {
                //if(array_key_exists(($key + 1), $orderDates) && ($orderDates[$key + 1]->status_id == 4))
                if($key == 0) {
                    $str .= date('d.m.Y', $orderDate->created_at).'<br>';
                }
                else {
                    $str .= '('.date('d.m.Y', $orderDate->created_at).')<br>';
                }

            }
            return $str;
        }
        return $this->issued;
    }
    public function getRedoneDates()
    {
        $str = '';
        if($orderDates = OrderStatusDate::find()->where(['order_id' => $this->id, 'status_id' => 4])->orderBy(['created_at' => SORT_DESC])->all()) {
            foreach($orderDates as $orderDate) {
                $str .= '('.date('d.m.Y', $orderDate->created_at).')<br>';
            }

        }
        return $str;
    }

    public function lastChangeStatus()
    {
        if($orderDates = OrderStatusDate::find()->where(['order_id' => $this->id, 'status_id' => $this->status_id])->orderBy(['created_at' => SORT_DESC])->one()) {
            return '('.date('d.m.Y', $orderDates->created_at).')';
        }
        if($this->status_date) {
            return '('.date('d.m.Y', $this->status_date).')';
        }
        return false;
    }
    public function getOrderSteps()
    {
        if($orderStatusDates = $this->getStepsModels($this->order_statuses)) {
            return $this->getStepsString($orderStatusDates);
        }
    }

    public function getProductionSteps()
    {
        if($orderStatusDates = $this->getStepsModels($this->production_statuses)) {
            return $this->getStepsString($orderStatusDates);
        }
    }

    protected function getStepsString($orderStatusDates)
    {
        $statusArr = [];
        $countStatusId = null;
        if($orderStatusDates) {
            foreach($orderStatusDates as $orderStatusDate) {
                if($orderStatusDate->status_id != $countStatusId) {
                    $statusArr[] = ['status_id' => $orderStatusDate->status_id, 'text' => $orderStatusDate->statusName.' ('.date('d.m.Y', $orderStatusDate->created_at).')'];
                    $countStatusId = $orderStatusDate->status_id;
                }
            }
        }
        else {
            $statusArr[] = ['status_id' => $this->status_id, 'text' => $this->statusName.' ('.date('d.m.Y', $this->status_date).')'];
        }
        $str = '';
        if(!empty($statusArr)) {
            $count = 1;
            foreach($statusArr as $statusStr) {
                if($count == count($statusArr) && $statusStr['status_id'] == $this->status_id) {
                    $str .= '<b>'.$statusStr['text'].'</b><br>';
                }
                else {
                    $str .= $statusStr['text'].'<br>';
                }
                $count++;
            }
        }
        return $str;
    }

    protected function getStepsModels($statusIds)
    {
        return OrderStatusDate::find()->where(['in', 'status_id', $statusIds])->andWhere(['order_id' => $this->id])->all();
    }

    public function priceLo()
    {
        switch ($this->payment_id) {
            case 11 : return PrintTypes::PRICE_LO_TEXT;
                break;
            case 18 : return PrintTypes::PRICE_LO_TEXT_2023;
                break;
        }
        return false;
    }

}
