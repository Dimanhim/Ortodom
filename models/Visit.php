<?php

namespace app\models;

use app\components\Calendar;
use Yii;
use app\components\RedsmsApiSimple;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "visits".
 *
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property integer $visit_date
 * @property integer $visit_time
 */
class Visit extends \yii\db\ActiveRecord
{
    const SHOW_DAYS = 5;
    const SHOW_DAYS_RECORDS = 14;

    const STATUS_CELL_AVALIABLE    = 1;
    const STATUS_CELL_DISABLED     = 2;
    const STATUS_CELL_RESERVED     = 3;

    public $birthday;
    public $address;
    public $passport_data;
    public $model_id;

    private $sms_config = [
        'api_key' => 'ukJeYtohGxJcdqbGxiBHgUJi',
        'login' => 'ortodom-spb',
        'phone' => '+79383542735',
        //'smsSenderName' => 'REDSMS.RU',
        'smsSenderName' => 'OrtoDom',
        'smsSenderNameVoice' => '79587091516',
        'viberSenderName' => 'REDSMS.RU',
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'visits';
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
            [['name', 'phone', 'visit_date', 'visit_time'], 'required'],
            [['patient_id', 'send_reminder_sms', 'send_reminder_day_sms', 'reserved', 'is_insoles', 'is_children', 'is_fitting'], 'integer'],
            [['name', 'phone'], 'string', 'max' => 255],
            [['visit_date', 'visit_time', 'birthday', 'address', 'passport_data', 'model_id', 'created_at', 'updated_at'], 'safe'],
        ];
    }
    public function getPatient()
    {
        return $this->hasOne(Patient::className(), ['id' => 'patient_id']);
    }

    public function beforeSave($insert)
    {
        if($insert and self::find()->where(['visit_date' => $this->visit_date, 'visit_time' => $this->visit_time])->exists()) return false;
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'ФИО',
            'phone' => 'Телефон',
            'birthday' => 'Дата рождения',
            'address' => 'Адрес',
            'passport_data' => 'Паспортные данные',
            'visit_date' => 'Дата',
            'visit_time' => 'Время',
            'patient_id' => 'Пациент',
            'reserved' => 'Бронь',
            'is_insoles' => 'Стельки',
            'is_children' => 'Дети',
            'is_fitting' => 'Примерка',
            'send_reminder_sms' => 'Смс с напоминанием',
            'send_reminder_day_sms' => 'Смс с напоминанием за сутки',
        ];
    }

    /** sends email and sms after create new visit
     *
     * @return bool|mixed
     */
    public function sendMessage()
    {
        //return true;
        if($this->sendEmail()) {
            return $this->sendSmsOrder;
        }
        return false;
    }
    public function sendEmail()
    {
        //return true;
        return Yii::$app->mailer->compose()
            ->setTo(Yii::$app->params['adminEmail'])
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setSubject('Запись на прием')
            ->setTextBody("Пациент: " . $this->patient->full_name . "\n". "Имя: " . $this->name . "\n" . "Телефон: " . $this->phone . "\n" . "Дата: " . date('d.m.Y', $this->visit_date) . "\n" . "Время: " . Calendar::getTimeAsString($this->visit_time) . "\n")
            ->send();
    }
    public function setApiValues()
    {
        return new RedsmsApiSimple($this->sms_config['login'], $this->sms_config['api_key']);
    }
    public function validateApiValues()
    {
        $allowed = [
            'weekday' => 7,
            'first_time' => Calendar::getSecondsInTime('10:00'),
            'launch_break_begin' => Calendar::getSecondsInTime('14:00'),
            'launch_break_end' => Calendar::getSecondsInTime('15:00'),
            'last_time' => Calendar::getSecondsInTime('19:30'),
        ];
        if(date('N', $this->visit_date) == $allowed['weekday']) return false;
        elseif($this->visit_time < $allowed['first_time'])
            return false;
        elseif($this->visit_time > $allowed['first_time'])
            return false;
        elseif($this->visit_time >= $allowed['launch_break_begin'] && $this->visit_time < $allowed['launch_break_begin'])
            return false;
        return true;
    }

    /**
     * method prepares to send sms of create new visit
     *
     * @return bool
     */
    public function getSendSmsOrder()
    {
        $full_text = 'Вы записались на прием '.date('d.m.Y', $this->visit_date).' в '.Calendar::getTimeAsString($this->visit_time).". \nЖдем Вас по адресу: \nВыборгское шоссе 5/1 \n 8(800)2227002\n".Yii::$app->params['navigator'];
        $this->sendSMS($this->phone, $full_text);
        return true;
    }

    /** method prepares to send sms for remind user about visit - Put on Crontab
     * for cronSendSms.php
     *
     * @return bool
     */
    public function sendReminderSms()
    {
        //$full_text = 'не забудьте, завтра '.date('d.m.Y', $this->visit_date).' в '.Calendar::getTimeAsString($this->visit_time).' у вас запись на прием в Ортодом. если что-то поменялось - позвоните нам!';
        $full_text = "Вы записались на приём ".date('d.m.Y', $this->visit_date)." в ".Calendar::getTimeAsString($this->visit_time).". \nЖдем Вас по адресу: \nВыборгское шоссе 5/1 \n 8(800)2227002";
        $this->sendSMS($this->phone, $full_text);
        $this->send_reminder_sms = 1;
        $this->save();
        return true;
    }

    public function sendReminderDaySms()
    {
        $symbols = ['-', '(', ')', ' '];
        $replaced = ['', '', '', ''];
        $phone = str_replace($symbols, $replaced, $this->phone);
        $full_text = "Напоминаем , что завтра в ".Calendar::getTimeAsString($this->visit_time)." вы записаны на приём в ОртоДом!";
        $this->send_reminder_day_sms = 1;
        if($this->update(false)) {
            $this->sendSMS($phone, $full_text);
        }
        else {
            file_put_contents('sms-logs.txt', date('d.m.Y H:i:s').' errors - '.print_r($this->errors, true)."\n", FILE_APPEND);
        }
        return true;
    }

    /**
     * method prepares to send sms
     *
     * @param $phone
     * @param $full_text
     */
    public function sendSmsText($phone, $full_text)
    {
        $this->sendSMS($phone, $full_text);
    }
    public function sendVoiceText($phone, $full_text)
    {
        $this->sendVoice($phone, $full_text);
    }

    /**
     * method sends SMS with params
     *
     * @param $phone
     * @param $text
     * @return bool
     */
    public function sendSms($phone, $text)
    {
        //return true;
        $api = $this->setApiValues();
        $result = $api->sendSMS($phone, $text, $this->sms_config['smsSenderName']);
        file_put_contents('sms-logs.txt', date('d.m.Y H:i:s').' result send - '.print_r($result, true)."\n", FILE_APPEND);
        file_put_contents('sms-logs.txt', date('d.m.Y H:i:s').' phone - '.print_r($phone, true)."\n", FILE_APPEND);
        file_put_contents('sms-logs.txt', ' message - '.print_r($text, true)."\n", FILE_APPEND);
        file_put_contents('sms-logs.txt', "\n", FILE_APPEND);
        return true;
    }
    public function sendVoice($phone, $text)
    {
        //return true;
        $api = $this->setApiValues();
        $api->sendVoice($phone, $text, $this->sms_config['smsSenderNameVoice']);
        return true;
    }
    public static function getWeek($selected_date, $show_days = Visit::SHOW_DAYS)
    {
        $avaliable = [
            'from' => -30,
            'to' => 30,
        ];
        $calendar = new Calendar();
        $weekNumber = null;
        for($i = $avaliable['from']; $i < $avaliable['to']; $i++) {
            $actual_date = strtotime(date('d.m.Y')) + 86400 * $show_days * $i;
            if($dates = $calendar->getDatesArray($actual_date, $show_days)) {
                foreach($dates as $date) {
                    if($date['timestamp'] == $selected_date) {
                        return $i;
                    }
                }
            }
        }
        return false;
    }

    public static function getFreeWeek($show_days = Visit::SHOW_DAYS)
    {
        $weekNumber = 0;
        $selected_date = strtotime(date('d.m.Y'));
        $selected_time = Calendar::getSecondsInTime(date('H:i'));

        // выбираем все визиты, начиная с начала сегодняшнего дня
        $visits = Visit::find()
            ->where(['>=', 'visit_date', $selected_date])
            //->andWhere(['>=', 'visit_time', $selected_time])
            ->all();
        $visitsArray = [];

        // преобразуем выбранные визиты в массив
        if($visits) {
            foreach($visits as $visit) {
                $full_time = $visit->visit_date + $visit->visit_time;
                $visitsArray[] = [
                    'id' => $visit->id,
                    'visit_date' => $visit->visit_date,
                    'visit_time' => $visit->visit_time,
                    'full_time' => $full_time,
                    'full_time_str' => date('d.m.Y H:i', $full_time),
                ];

            }

            // сортируем по времени - первые самые ранние
            usort($visitsArray, function($a, $b) {
                if($a['full_time'] > $b['full_time']) return 1;
                if($b['full_time'] >= $a['full_time']) return -1;
            });

            // получаем массив времени работы в timestamp
            $timesArray = Calendar::getTimestampTimesArray();

            // сколько всего в день отрезком времени
            $timesCount = count($timesArray);

            foreach($visitsArray as $visitKey => $visitValue) {

                // получаем ключ массива времен
                // по соответствию с массивом визитов
                // чтобы сравнить время из массива со временем из визита
                if($visitKey < $timesCount) {
                    $totalKey = $visitKey;
                }
                else {
                    $totalKey = $visitKey%$timesCount;
                }
                // если эти времена не совпадают, это и есть свободная дата
                if($visitValue['visit_time'] != $timesArray[$totalKey]) {
                    $emptyVisitDate = $visitValue['visit_date'];

                    // получаем номер недели искомой даты
                    $weekNumber = Visit::getWeek($emptyVisitDate, $show_days);
                    return $weekNumber;
                }
            }

        }
        return $weekNumber;
    }
}
