<?php

/* @var $this yii\web\View */
/* @var $model dongrim\blog\models\Category */

$this->title = Yii::t('app', 'Create category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog'), 'url' => ['/admin/blog/default']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['/admin/blog/category']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>