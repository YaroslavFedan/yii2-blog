<?php



/* @var $this yii\web\View */
/* @var $model dongrim\blog\models\Category */

$this->title = Yii::t('app', 'Update Category:') . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog'), 'url' => ['/admin/blog/default']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['/admin/blog/category']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<div class="category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>