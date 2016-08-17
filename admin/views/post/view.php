<?php

use dongrim\blog\models\Post;
use yii\widgets\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model dongrim\blog\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog'), 'url' => ['/admin/blog/default']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['/admin/blog/post']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="post-view">

    <section>
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
                            <?=Html::a('Отмена', ['/admin/blog/post'], ['class' => 'btn btn-default'])?>
                        </div>
                    </div>
                    <div class="box-body">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                [
                                    'attribute' => Yii::t('app','Author'),
                                    'value' => call_user_func(function ($data){
                                        if($data->author){
                                            return $data->author->username;
                                        }
                                    }, $model),
                                ],
                                'time',
                                'tags',
                                [
                                    'attribute' => Yii::t('app','Categories'),
                                    'value' => Post::getRelatedCategories($model),
                                ],
                                'title',
                                'description',
                                [
                                    'attribute'=>'image',
                                    'format'=>'html',
                                    'value'=>Html::img($model->image,['style'=>'width: 200px;'])
                                ],
                                [
                                    'attribute'=>'content',
                                    'format'=>'html'
                                ],
                                [
                                    'attribute' => Yii::t('app','isFeatured'),
                                    'format'=>'html',
                                    'value'=>call_user_func(function ($data) {
                                        (!$data->isfeatured)? $class = 'default': $class = 'success';
                                        return Html::tag('span', Html::encode($data->itemAlias('isfeatured',$data->isfeatured ? 1 : 0)),
                                            ['class' => 'label label-' . $class]);
                                    }, $model),
                                ],

                                [
                                    'attribute'=>'status',
                                    'format'=>'html',
                                    'value'=>call_user_func(function ($data) {
                                        return Post::getStatusName($data);
//                                    ($data->status)? $class = 'success': $class = 'warning';
//                                    return Html::tag('span', Html::encode(CategorySearch::getStatusArray()[$data->status]),
//                                        ['class' => 'label label-' . $class]);
                                    }, $model),
                                ],

                            ]
                        ]);?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
