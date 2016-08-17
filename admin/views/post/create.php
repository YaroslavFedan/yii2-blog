<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model dongrim\blog\models\Post */

$this->title = Yii::t('app', 'Create Post');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog'), 'url' => ['/admin/blog/default']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['/admin/blog/post']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
