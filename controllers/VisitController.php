<?php

namespace app\controllers;

use app\components\Helpers;
use app\models\Patient;
use app\models\User;
use app\models\Visit;
use app\models\VisitForm;
use app\models\VisitUser;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\components\Calendar;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * OrderController implements the CRUD actions for Visit model.
 */
class VisitController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param $action
     * @return bool
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function beforeAction($action)
    {
        if(User::disabledAccess($action->controller->id)) {
            throw new HttpException(403, 'У Вас недостаточно прав для посещения данной страницы');
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all Order models.
     *
     * @return mixed
     */
    public function actionIndex($week = 0)
    {
        $calendar = new Calendar();
        $actual_date = $week ? (strtotime(date('d.m.Y')) + 86400 * Visit::SHOW_DAYS * $week) : strtotime(date('d.m.Y'));
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
        $date = Yii::$app->request->get('date');
        return $this->render('index', [
            'calendar' => $calendar,
            'actual_date' => $actual_date,
            'model' => $model,
            'week_count' => $week_count,
            'visitForm' => $date ? new VisitForm(['date' => $date]) : new VisitForm(),
            //'visitForm' => new VisitForm(),
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if($model->delete()) {
            Yii::$app->session->setFlash('success', 'Запись успешно удалена');
            return Yii::$app->request->referrer ? $this->redirect(Yii::$app->request->referrer) : $this->redirect('visit/index');
        }
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
                $patient->address = $model->address ? $model->address : '---';
                $patient->passport_data = $model->passport_data ? $model->passport_data : '---';
                if($patient->save()) {
                    $new_model->patient_id = $patient->id;
                    $new_model->name = $model->name;
                    $new_model->phone = $model->phone;
                    $new_model->visit_date = strtotime($model->visit_date);
                    $new_model->visit_time = Calendar::getSecondsInTime($model->visit_time);
                    $new_model->reserved = $model->reserved;
                    if($new_model->save()) {
                        $new_model->sendMessage();
                        Yii::$app->session->setFlash('success', 'Сохранено успешно');
                    }
                }
            } else {
                $patient = new Patient(true);
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
                    $new_model->reserved = $model->reserved;
                    if($new_model->save()) {
                        $new_model->sendMessage();
                        Yii::$app->session->setFlash('success', 'Сохранено успешно');
                    }
                }
            }
            return $this->redirect('/visit');
        }
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

    public function actionUser()
    {
        $this->view->title = 'Редактирование пользователей';
        $model = new VisitUser();
        $calendar = new Calendar();

        $tableValues = $calendar->getTableValues();
        return $this->render('user', [
            'model' => $model,
            'calendar' => $calendar,
            'tableValues' => $tableValues,
        ]);
    }

    public function actionChangeCell()
    {
        $response = [
            'result' => 0,
            'html' => null,
        ];
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($visit_date = Yii::$app->request->post('time')) {
            $visitUser = VisitUser::find()->where(['visit_date' => $visit_date])->one();
            $user = Yii::$app->user->identity;
            if($user->role == 'superadmin') {
                if($visitUser) {
                    $visitUser->changeUserInCell();
                }
                else {
                    VisitUser::createCell($visit_date);
                }
            }
            else {
                if($visitUser) {
                    $visitUser->deleteCell();
                }
                else {
                    VisitUser::createCell($visit_date, $user->id);
                }
            }
            $calendar = new Calendar();
            $tableValues = $calendar->getTableValues();
            $html = $this->renderAjax('_user_table', [
                'tableValues' => $tableValues,
            ], true);
            if($html) {
                $response['result'] = 1;
                $response['html'] = $html;
            }
        }
        return $response;
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

    public function actionChangeVisitWeek()
    {
        $model = new VisitForm();
        if($model->load(Yii::$app->request->get())) {
            if($selected_date = strtotime($model->modelDate)) {
                if($weekNumber = Visit::getWeek($selected_date)) {
                    return $weekNumber ? $this->redirect(['/visit?week='.$weekNumber.'&date='.$model->modelDate]) : $this->redirect(['/visit?date='.$model->modelDate]);
                }
            }
        }
        return $this->redirect(['/visit']);
    }
    public function actionFreeWeek()
    {
        $weekNumber = Visit::getFreeWeek();

        return $weekNumber ? $this->redirect(['/visit?week='.$weekNumber]) : $this->redirect(['/visit']);
    }

    public function actionReserveCells()
    {
        $response = [
            'result' => 0,
            'message' => null,
        ];
        $saved_count = 0;
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(Yii::$app->request->isAjax) {
            if($reserved_cells = Yii::$app->request->post('data')) {
                foreach($reserved_cells as $reserved_cell) {
                    $visit = new Visit();
                    $visit->name = 'Резерв';
                    $visit->phone = '+79999999999';
                    $visit->visit_date = $reserved_cell['date'];
                    $visit->visit_time = Calendar::getSecondsInTime($reserved_cell['time']);
                    $visit->reserved = 1;
                    if($visit->save()) {
                        $saved_count++;
                    }
                }
            }
            if($saved_count) {
                $response['message'] = 'Забронировано '.$saved_count.' ячеек';
                $response['result'] = 1;
                Yii::$app->session->setFlash('success', $response['message']);
            }
            return $response;
        }
    }


}

