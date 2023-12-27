<?php

namespace app\controllers;

use app\models\Order;
use app\models\OrderStatusDate;
use app\models\PatientsOld;
use Yii;
use app\models\Patient;
use app\models\Visit;
use yii\web\Controller;
use app\components\RedsmsApiSimple;
use app\components\Calendar;

use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\filters\Cors;

/**
 * OrderController implements the CRUD actions for Visit model.
 */
class ApiController extends Controller
{
    const API_KEY = 'a7d8aed690dcc40bf6194194f1e06b41';

    public function behaviors() {
        return [
            [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'corsFilter' => [
                'class' => Cors::class,
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (in_array($action->id, ['add-new'])) {
            $this->enableCsrfValidation = false;
        }
        if (in_array($action->id, ['modal-time'])) {
            $this->enableCsrfValidation = false;
        }
        if (in_array($action->id, ['modal-dates'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionAdd($key, $name, $phone, $date, $time, $string = false)
    {
        $message = 'Ошибка';
        if($key != self::API_KEY) return $message;
        $success = false;
        $model = new Visit();
        $model->name = $name;
        $model->phone = $phone;
        $model->visit_date = $string ? strtotime($date) : $date;
        $model->visit_time = $string ? Calendar::getSecondsInTime($time) : $time;

        if(Visit::findOne(['visit_date' => $date, 'visit_time' => $time])) return 'Указанное время занято';
        //if(!$model->validateApiValues()) return 'Указано нерабочее время';

        if($model->save()) {
            $model->sendMessage();
            $message = 'Прием успешно добавлен';
                $patient = new Patient(true);
                $patient->full_name = $model->name;
                $patient->birthday = 0;
                $patient->address = '---';
                $patient->phone = $model->phone;
                $patient->passport_data = '---';
                if($patient->save()) {
                    $model->patient_id = $patient->id;
                    $model->save();
                }
        }
        return $message;
    }
    public function actionAddNew()
    {
        $site_name = 'https://orthodom.ru/';
        $this->enableCsrfValidation = false;
        $key = Yii::$app->request->post('key');
        $name = Yii::$app->request->post('name');
        $phone = Yii::$app->request->post('phone');
        $date = Yii::$app->request->post('date');
        $time = Yii::$app->request->post('time');

        if($key != self::API_KEY) {
            return $this->redirect($site_name);
            return 'Ошибка';
        }

        $success = false;
        $model = new Visit();
        $model->name = $name;
        $model->phone = $phone;
        $model->visit_date = strtotime($date);
        $model->visit_time = Calendar::getSecondsInTime($time);
        if(Visit::findOne(['visit_date' => $model->visit_date, 'visit_time' => $model->visit_time])) {
            return $this->redirect($site_name.'?message=2');
        }
        if($model->save()) {
            $message = 'Прием успешно добавлен';
            $model->sendMessage();
            if(!Patient::findOne(['phone' => $model->phone])) {
                $patient = new Patient(true);
                $patient->full_name = $model->name;
                $patient->birthday = 0;
                $patient->address = '---';
                $patient->phone = $model->phone;
                $patient->passport_data = '---';
                if($patient->save()) {
                    $model->patient_id = $patient->id;
                    $model->save();
                }
            }
            return $this->redirect($site_name.'?message=1');
        }
        //return $message;
    }
    public function actionModalTime()
    {
        $this->enableCsrfValidation = false;

        $key = Yii::$app->request->get('key');
        $val = Yii::$app->request->get('val');

        if($key != self::API_KEY) {
            return json_encode(['result' => false, 'html' => 'Произошла ошибка']);
        }
        if($visits = Visit::findAll(['visit_date' => $val])) {
            $dates_array = [];
            foreach($visits as $visit) {
                $dates_array[] = $visit->visit_time;
            }
        }

        $str = '';
        $cal = new Calendar();
        if(count($cal->getWorkTimeArray()) == count($dates_array)) {
            return json_encode(['result' => false, 'html' => 'На указанную дату все время занято']);
        }
        foreach($cal->getWorkTimeArray() as $time) {
            if (!empty($dates_array)) {
                if (!in_array(Calendar::getSecondsInTime($time), $dates_array)) {
                    $str .= '<option value="' . $time . '">' . $time . '</option>';
                }
            } else {
                $str .= '<option value="' . $time . '">' . $time . '</option>';
            }
        }
        return json_encode(['result' => true, 'html' => $str]);
    }
    public function actionModalDates()
    {
        $this->enableCsrfValidation = false;

        $cal = new Calendar();
        $count_dates = count($cal->getWorkTimeArray());
        $dates_array = [];
        $visits_array = [];
        if($visits = Visit::find()->where(['>', 'visit_date', strtotime(date('d.m.Y'))])->asArray()->all()) {
            foreach($visits as $visit) {
                if(isset($visits_array[$visit['visit_date']])) {
                    $visits_array[$visit['visit_date']]++;
                } else {
                    $visits_array[$visit['visit_date']] = 1;
                }
            }
            if(!empty($visits_array)) {

                foreach($visits_array as $key => $value) {
                    if($value >= $count_dates) $dates_array[] = date('d-m-Y', $key);
                }
            }
        }
        return json_encode($dates_array);
    }
    public function actionCronSms()
    {
        return true;
        $today_date = strtotime(date('d.m.Y'));
        $next_date = $today_date + 86400;
        $today_time = time() - $today_date;
        $searched_time = Calendar::getStaticTime($today_time);
        if($visits = Visit::findAll(['visit_date' => $next_date, 'visit_time' => $searched_time, 'send_reminder_sms' => 0])) {
            foreach($visits as $visit) {
                $visit->sendReminderSms();
            }
        }
    }

    public function actionCronYandexSms()
    {
        $minutes = 3 * 3600;
        $queryTimeBegin = time() - $minutes - 60;
        $queryTimeEnd = time() - $minutes + 60;

        $orders = Order::find()->where(['sms_yandex_review' => 1])
            ->andWhere(['>=', 'sms_yandex_datetime', $queryTimeBegin])
            ->andWhere(['<=', 'sms_yandex_datetime', $queryTimeEnd])
            ->andWhere(['sms_yandex_result' => null])
            ->all();
        if($orders) {
            foreach($orders as $order) {
                $order->sendYandexReviewSms();
            }
        }
        return false;
/*



        $today_date = strtotime(date('d.m.Y'));
        $next_date = $today_date + 86400;
        $today_time = time() - $today_date;
        $searched_time = Calendar::getStaticTime($today_time);
        if($visits = Visit::findAll(['visit_date' => $next_date, 'visit_time' => $searched_time, 'send_reminder_sms' => 0])) {
            foreach($visits as $visit) {
                $visit->sendReminderSms();
            }
        }*/
    }

    public function actionProduct()
    {
        $responce = [
            //'html' => $this->renderPartial('tilda'),
            'html' => '',
        ];
        return json_encode($responce);
    }

    /**
            CRON
     */

    /**
    Отправляет смс (повторное) с сообщением о готовности заказа
    если заказ перешел в статус "Готов к выдаче" 7 дней назад и до сегодняшнего дня его статус не изменился
     */
    public function actionCronRemainderReadySms()
    {
        //return true;
        $orderIds = [];

        // день, когда должен был измениться статус
        $today = strtotime(date('d.m.Y')) - 86400 * 3;
        $orderStatusDates = OrderStatusDate::find()
            ->joinWith('order')
            // дата создания в день неделей ранее
            ->where(['between', 'order_status_dates.created_at', $today, $today + 86399])
            // статус Готов к выдаче
            ->andWhere(['order_status_dates.status_id' => 3])
            ->andWhere(['orders.status_id' => 3])
            //->andWhere('orders.status_date = order_status_dates.created_at')
            ->orderBy(['order_status_dates.order_id' => SORT_ASC])
            ->all();

        if($orderStatusDates) {
            foreach($orderStatusDates as $orderStatusDate) {
                //echo $count.'. order_id='.$orderStatusDate->order->id.'<br>';
                if($statusDates = $orderStatusDate->order->statusDates) {
                    foreach($statusDates as $statusDate) {
                        if($statusDate->created_at == $orderStatusDate->order->status_date) {
                            //echo 'order_id - '.$statusDate->order_id.' --- status_id='.$statusDate->status_id.' '.date('d.m.Y H:i:s', $statusDate->created_at).' status_date='.date('d.m.Y H:i:s',$orderStatusDate->order->status_date).' order_status_id='.$statusDate->order->status_id.'<br>';
                            $orderIds[] = $orderStatusDate->order->id;
                        }

                    }
                }
            }
            Order::updatePacketStatus($orderIds);

            /*foreach($orderStatusDates as $orderStatusDate) {
                if(!$orderStatusDate->order) continue;
                $symbols = ['(', ')'];
                $replaced = ['', ''];
                $lastChangeStatus = str_replace($symbols, $replaced, $orderStatusDate->order->lastChangeStatus());
                if($orderStatusDate->order && $orderStatusDate->order->status_id == 3 && strtotime($lastChangeStatus) == $today) {
                    $orderIds[] = $orderStatusDate->order->id;
                }
            }
            Order::updatePacketStatus($orderIds);*/
        }
        file_put_contents('log-sms-remainder.txt', date('d.m.Y H:i:s').' id заказов  - '.print_r($orderIds, true)."\n", FILE_APPEND);
        return count($orderIds);
    }

    public function actionCronRemainderReadyEmail()
    {
        //return true;
        $orderIds = [];
        $today = strtotime(date('d.m.Y')) - 86400 * 14;
        if($orderStatusDates = OrderStatusDate::find()->where(['between', 'created_at', $today, $today + 86399])->andWhere(['status_id' => 3])->all()) {
            foreach($orderStatusDates as $orderStatusDate) {
                if(!$orderStatusDate->order) continue;
                $symbols = ['(', ')'];
                $replaced = ['', ''];
                $lastChangeStatus = str_replace($symbols, $replaced, $orderStatusDate->order->lastChangeStatus());
                if($orderStatusDate->order->status_id == 3 && strtotime($lastChangeStatus) == $today) {
                    $orderIds[] = $orderStatusDate->order->id;
                }
            }
            if($orderIds && ($orders = Order::find()->where(['in', 'id', $orderIds])->all())) {
                Yii::$app->mailer->compose('ready-remainder', ['orders' => $orders])
                    ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                    ->setTo(Yii::$app->params['adminEmail'])
                    //->setTo('dimanhim@list.ru')
                    ->setSubject('Заказы со статусом "готов к выдаче" не выданные за 14 суток')
                    ->send();
            }
        }
        file_put_contents('log-email-remainder.txt', date('d.m.Y H:i:s').' id заказов  - '.print_r($orderIds, true)."\n", FILE_APPEND);
        return count($orderIds);
    }
    public function actionVisitRemainderNew()
    {
        return true;
        $send_date = strtotime(date('d.m.Y', strtotime('+1 day')));

        $visits = Visit::find()
            ->where(['visit_date' => $send_date])
            ->andWhere(['send_reminder_day_sms' => null])
            ->all();
        if($visits) {
            foreach($visits as $visit) {
                $visit->sendReminderDaySms();
            }
        }
    }

    public function actionVisitRemainder()
    {
        //return true;
        // записи скольки дней назад нужно выбирать
        $days_ago = 1;

        // искомая дата
        $searchedDate = strtotime(date('d.m.Y', strtotime("+{$days_ago} day")));

        // настоящее время в секундах 36000
        $nowTime = Calendar::getSecondsInTime(date('H:i'));
        $searchedTimeBegin = floor($nowTime / 3600) * 3600;
        $searchedTimeEnd = ceil($nowTime / 3600) * 3600;

        $visits = Visit::find()
            ->where(['visit_date' => $searchedDate])
            ->andWhere(['between', 'visit_time', $searchedTimeBegin, $searchedTimeEnd])
            ->andWhere(['send_reminder_day_sms' => null])
            ->all();
        if($visits) {
            foreach($visits as $visit) {
                $visit->sendReminderDaySms();
            }
        }
    }

    public function actionBackupPatients()
    {
        // поменять afterFind в модели Patient
        $time_begin = time();
        $count = 0;
        $attributeName = 'passport_data';
        $attributeValue = '---';
        if($patients = Patient::find()->where([$attributeName => $attributeValue])->all()) {
            foreach($patients as $patient) {
                if($patientOld = PatientsOld::findOne($patient->id)) {
                    if($patientOld->$attributeName != $patient->$attributeName) {
                        //echo $patientOld->$attributeName.' '.$patient->$attributeName.'<br>';
                        $patient->$attributeName = $patientOld->$attributeName;
                        if($patient->save()) {
                            $count++;
                        }
                    }
                }
            }
        }
        //  "Изменено 152 за 4 секунд"
        $mes = 'Изменено '.$count.' за '.(time() - $time_begin).' секунд';
        file_put_contents('patient-log.txt', date('d.m.Y H:i:s').' - '.print_r($mes, true)."\n", FILE_APPEND);
        return $mes;
    }

    public function actionShowModal()
    {
        $response = [
            'result' => 0,
            'html' => null,
        ];
        $html = $this->renderPartial('//layouts/_front_record');
        if($html) {
            $response['result'] = 1;
            $response['html'] = $html;
        }
        return $response;
    }
}

