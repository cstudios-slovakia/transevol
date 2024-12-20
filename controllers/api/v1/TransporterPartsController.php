<?php

namespace app\controllers\api\v1;

use app\models\Transporter;
use Yii;
use app\models\TransporterParts;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\support\Places\Relations\PlaceRelationAssistance;
/**
 * TransporterPartsController implements the CRUD actions for TransporterParts model.
 */
class TransporterPartsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TransporterParts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => TransporterParts::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TransporterParts model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TransporterParts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TransporterParts();

        $transportType = Yii::$app->request->get('transport-type');
        $transporterId = (int) Yii::$app->request->get('on');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {



            $model->save(false);


            if($transporterId){
                $transporter    = Transporter::findOne(['id' => $transporterId]);
                $model->link('transporter', $transporter);
                return $this->redirect(Url::toRoute('/api/v1/transporter/view?id=' . $transporterId));

            }


            return $this->redirect(['view', 'id' => $model->id]);
        }

        $placesSelectOptions = PlaceRelationAssistance::ownedPlacesSelectOptions($transportType);

        return $this->render('create', [
            'model' => $model,
            'placesSelectOptions' => $placesSelectOptions,
            'transporterId' => $transporterId
        ]);
    }

    /**
     * Updates an existing TransporterParts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TransporterParts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TransporterParts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TransporterParts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TransporterParts::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
