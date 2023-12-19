<?php

namespace app\controllers;

use app\models\Patient;
use app\models\Visit;
use Yii;
use yii\web\Controller;
use app\components\Calendar;
use yii\web\Response;

/**
 * OrderController implements the CRUD actions for Visit model.
 */
class RecordController extends Controller
{
    public $layout = 'empty';
    /**
     * Lists all Order models.
     *
     * @return mixed
     */
    public function actionIndex($week = 0)
    {
        $calendar = new Calendar();
        $actual_date = $week ? (strtotime(date('d.m.Y')) + 86400 * Visit::SHOW_DAYS_RECORDS * $week) : strtotime(date('d.m.Y'));
        $week_count = $week ? $week : 0;
        $model = new Visit();
        if($model->load(Yii::$app->request->post())) {
            if($model->sendMessage()) {
                if($model->save()) {
                    if(!$model->patient_id) {
                        $patient = new Patient();
                        $patient->full_name = $model->name;
                        $patient->birthday = '---';
                        $patient->address = '---';
                        $patient->phone = $model->phone;
                        $patient->passport_data = '---';
                        if($patient->save()) {
                            $model->patient_id = $patient->id;
                            $model->save();
                        }
                    }
                    return $this->redirect('/visit');
                }
            }
        }
        return $this->render('index', [
            'calendar' => $calendar,
            'actual_date' => $actual_date,
            'model' => $model,
            'week_count' => $week_count,
        ]);
    }

    /*
     *
     * AJAX
     *
     */
    public function actionGetFieldValues($id)
    {
        $model = Patient::findOne($id);
        $result = [
            'name' => $model->full_name,
            'phone' => $model->phone,
            'patient_id' => $model->id,
        ];
        return json_encode($result);
    }
    public function actionShowModal($id = false)
    {
        if($id) {
            $model = $this->findModel($id);
            if($patient = Patient::findOne($model->patient_id)) {
                $model->address = $patient->address;
                $model->birthday = (strtotime($patient->birthday) > 100) ? $patient->birthday : date('d.m.Y') ;
                $model->passport_data = $patient->passport_data;
            }
            $model->visit_date = date('d.m.Y', $model->visit_date);
            $model->visit_time = Calendar::getTimeAsString($model->visit_time);
            return $this->renderAjax('_visit_modal', [
                'model' => $model,
                'calendar' => new Calendar(),
            ]);
        }
        $model = new Visit();
        return $this->renderAjax('_visit_modal', [
            'model' => $model,
            'calendar' => new Calendar(),
        ]);

    }
    public function actionSaveModal()
    {
        $model = new Visit();
        if($model->load(Yii::$app->request->post())) {
            if(!$new_model = Visit::findOne($model->model_id)) {
                $new_model = new Visit();
            }
            $format_date = date('Y-m-d', strtotime($model->birthday));
            if($patient = Patient::findOne($model->patient_id)) {
                $patient->full_name = $model->name;
                $patient->phone = $model->phone;
                $patient->birthday = $format_date ? $format_date : date('Y-m-d');
                $patient->address = $model->address;
                $patient->passport_data = $model->passport_data;
                if($patient->save()) {
                    $new_model->patient_id = $patient->id;
                    $new_model->name = $model->name;
                    $new_model->phone = $model->phone;
                    $new_model->visit_date = strtotime($model->visit_date);
                    $new_model->visit_time = Calendar::getSecondsInTime($model->visit_time);
                    if($new_model->save()) {
                        Yii::$app->session->setFlash('success', 'Сохранено успешно');
                    }
                    else {
                        Yii::info($new_model->errors);
                    }
                }
            } else {
                $patient = new Patient(true);
                $patient->insert_order = true;
                $patient->full_name = $model->name;
                $patient->phone = $model->phone;
                $patient->birthday = $format_date ? $format_date : date('Y-m-d');
                $patient->address = $model->address ? $model->address : '---';
                $patient->passport_data = $model->passport_data ? $model->passport_data : '---';
                $new_model->name = $patient->full_name;
                if($patient->save()) {
                    $new_model->patient_id = $patient->id;
                    $new_model->name = $patient->full_name;
                    $new_model->phone = $patient->phone;
                    $new_model->visit_date = strtotime($model->visit_date);
                    $new_model->visit_time = Calendar::getSecondsInTime($model->visit_time);
                    if($new_model->save()) {
                        Yii::$app->session->setFlash('success', 'Сохранено успешно');
                    }
                    else {
                        Yii::info($new_model->errors);
                    }
                }
            }
            $new_model->sendMessage();
            return $this->redirect(['record/success', 'visit_date' => $new_model->visit_date, 'visit_time' => $new_model->visit_time]);
        }
    }

    public function actionUserByPhone()
    {
        $response = [
            'result' => 0,
            'id' => null,
            'name' => null,
        ];
        $saved_count = 0;
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(Yii::$app->request->isAjax) {
            if($phone = Yii::$app->request->post('phone')) {
                \Yii::$app->infoLog->add('phone', $phone);
                $phones = [
                    'phone_1' => $phone,
                    'phone_2' => $phone,
                    'phone_3' => $phone,
                ];
                foreach($phones as $phoneNumber) {
                    if($patient = Patient::findOne(['phone' => $phoneNumber])) {
                        break;
                    }
                }
                if($patient) {
                    $response['id'] = $patient->id;
                    $response['name'] = $patient->full_name;
                    $response['result'] = 1;
                }

            }
            return $response;
        }
    }

    public function actionSuccess($visit_date, $visit_time)
    {
        return $this->render('success', [
            'visit_date' => date('d.m.Y', $visit_date),
            'visit_time' => Calendar::getTimeAsString($visit_time),
            //'visit_date' => '23.05.2022',
            //'visit_time' => '11:30',
        ]);
    }
    public function actionChangePatient($id)
    {
        $model = Patient::findOne($id);
        $responce = [
            'name' => $model->full_name,
            'phone' => $model->phone,
            'address' => $model->address,
            'birthday' => (strtotime($model->birthday) > 100) ? $model->birthday : date('d.m.Y'),
            //'birthday' => $model->birthday,
            'passport' => $model->passport_data,
        ];
        return json_encode($responce);
    }
    public function actionSelectTime($date, $time = false)
    {
        $date = strtotime($date);
        $cal = new Calendar();
        $str = '';
        $dates_array = [];
        if($visits = Visit::findAll(['visit_date' => $date])) {
            foreach($visits as $visit) {
                $dates_array[] = $visit->visit_time;
            }
        }
        foreach($cal->getWorkTimeArray() as $val) {
            //if (!empty($dates_array)) {
                if (!in_array(Calendar::getSecondsInTime($val), $dates_array) || ($val == $time)) {
                    if($val == $time) {
                        $str .= '<option value="' . $val . '" selected="selected">' . $val . '</option>';
                    } else {
                        $str .= '<option value="' . $val . '">' . $val . '</option>';
                    }
                }
            //} else {
            //    $str .= '<option value="' . $val . '">' . $val . '</option>';
            //}
        }
        return $str;
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @throws NotFoundHttpException if the model cannot be found
     *
     * @return Order the loaded model
     */
    protected function findModel($id)
    {
        if (($model = Visit::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

