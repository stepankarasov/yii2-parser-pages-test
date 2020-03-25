<?php

namespace app\controllers;

use app\models\page\Page;
use app\models\page\PageSearch;
use app\jobs\ParsingJob;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends Controller
{
    /**
     * Lists all Page models.
     * @return mixed
     * @throws \Exception
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;
        $searchModel = new PageSearch();
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Page model.
     * @return mixed
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $model = new Page();

        if ($model->load(Yii::$app->request->post(), null) && $model->save()) {
            /** @var yii\queue\redis\Queue $queue */
            $queue = Yii::$app->get('queue');

            $queue->push(new ParsingJob([
                'url'  => $model->url,
                'page' => $model
            ]));

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Page model.
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
     * Delete Page model.
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не найдена');
        }
    }
}
