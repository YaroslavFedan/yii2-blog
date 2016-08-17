<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model dongrim\blog\models\Post */

$this->title = Yii::t('app', 'Update Post: ').' '.$model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog'), 'url' => ['/admin/blog/default']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['/admin/blog/post']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="post-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
