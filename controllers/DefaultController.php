<?php

namespace dongrim\blog\controllers;

use dongrim\blog\models\Post;
use dongrim\blog\models\PostSearch;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use Yii;



/**
 * Default controller for the `blog` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($term = false,$category = false,$time = false)
    {
        $searchModel = new PostSearch();
        $req = Yii::$app->request->queryParams;

        if ($term) { $req[basename(str_replace("\\","/",get_class($searchModel)))]["term"] = $term;}
        if ($category) { $req[basename(str_replace("\\","/",get_class($searchModel)))]["category"] = $category;}
        if ($time) { $req[basename(str_replace("\\","/",get_class($searchModel)))]["time"] = $time;}

        $req[basename(str_replace("\\","/",get_class($searchModel)))]["status"] = 1;

        $dataProvider = $searchModel->search($req);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);

    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
