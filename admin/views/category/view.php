<?php
use dongrim\blog\BlogAsset;
use dongrim\blog\models\CategorySearch;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model dongrim\blog\models\Category */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog'), 'url' => ['/admin/blog/default']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['/admin/blog/category']];
$this->params['breadcrumbs'][] = $this->title;

$module = Yii::$app->getModule('blog');
$assets = BlogAsset::register($this);

?>
<div class="category-view">
    <div class="section">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><?=$this->title;?></h3>
                        <div class="box-tools pull-right">
                            <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                            <?= Html::a(Yii::t('yii', 'Delete'), ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    'method' => 'post',
                                ],
                            ]) ?>
                            <?=Html::a('Отмена', ['index'], ['class' => 'btn btn-default'])?>
                        </div>
                    </div>
                    <div class="box-body">
                        <?= DetailView::widget([
                            'model' => $model,

                            'attributes' => [
                                'id',
                                'title',
                                'parent_id',
                                'description:ntext',
                                [
                                    'attribute'=>'image',
                                    'format'=>'html',
                                    'value'=>(!empty($model->image) ?
                                        (Html::img(str_replace("/".$module->uploadDir."/","/".$module->uploadDir."/.thumbs/",$model->image))):
                                        Html::img($assets->baseUrl .'/image/image-not-found.png',['style'=>'width:150px'])),
                                ],
                                [
                                    'attribute'=>'status',
                                    'format'=>'html',
                                    'value'=>call_user_func(function ($data) {
                                        ($data->status)? $class = 'success': $class = 'warning';
                                        return Html::tag('span', Html::encode(CategorySearch::getStatusArray()[$data->status]),
                                            ['class' => 'label label-' . $class]);
                                    }, $model),
                                ],
                                //'isdel',
                            ],
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>