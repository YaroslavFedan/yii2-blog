<?php

use dongrim\blog\BlogAsset;
use dongrim\blog\components\grid\ActionColumn;
use dongrim\blog\models\CategorySearch;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel dongrim\blog\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog'), 'url' => ['/admin/blog/default']];
$this->params['breadcrumbs'][] = $this->title;

$module = Yii::$app->getModule('blog');

?>
<div class="category-index">
    <section>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><?=$this->title;?></h3>
                        <div class="box-tools pull-right">
                            <?= Html::a(Yii::t('app', 'Create category'), ['create'], ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>
                    <div class="box-body ">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'pjax' => true,
                            'tableOptions' => [
                                'class' => 'table table-striped table-bordered '
                            ],
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                'id',
                                'title',
                                [
                                    'attribute'=>'parent_id',
                                    'value'=>'parent.title',
                                    'filterType'=>GridView::FILTER_SELECT2,
                                    'filterWidgetOptions'=>[
                                        'data'=>ArrayHelper::map($searchModel->parents(),"id","title"),
                                        'options' => ['placeholder' => Yii::t('app','Select a parent category...')],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],

                                    ],
                                ],
                                'description:ntext',
                                [
                                    'attribute' => 'image',
                                    'format'=>'html',
                                    'value' => function($data) use ($module) {
                                        return ($data->image != null ?
                                            Html::img(str_replace("/".$module->uploadDir."/","/".$module->uploadDir."/.thumbs/",$data->image),
                                            ['class'=>'pull-left','style'=>'margin:0 10px 10px 0; width:150px;']) :
                                            Html::img(BlogAsset::register($this)->baseUrl .'/image/image-not-found.png',['style'=>'width:150px']));
                                    },
                                ],
                                [
                                    'attribute'=>'status',
                                    'value'=>function($data){
                                        ($data->status)? $class = 'success': $class = 'warning';
                                        return Html::tag('span', Html::encode(CategorySearch::getStatusArray()[$data->status]),
                                            ['class' => 'label label-' . $class]);
                                    },
                                    'format'=>'html',
                                    'filterType'=>GridView::FILTER_SELECT2,
                                    'filter'=>$searchModel::getStatusArray(),
                                    'filterWidgetOptions'=>[
                                        'pluginOptions'=>['allowClear'=>true],
                                        'options' => ['placeholder' => Yii::t('app','Select a status...')],
                                    ],
                                ],
                                // 'isdel',

                                ['class' => ActionColumn::className(),
                                    'buttons' => [
                                        'view' => function ($url, $model, $key) {
                                            $options = [
                                                'title' => Yii::t('yii', 'View'),
                                                'aria-label' => Yii::t('yii', 'View'),
                                                'data-pjax' => '0',
                                                'data-toggle'=>'tooltip',
                                            ];
                                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
                                        },
                                        'update' => function ($url, $model, $key) {
                                            $options = [
                                                'title' => Yii::t('yii', 'Update'),
                                                'aria-label' => Yii::t('yii', 'Update'),
                                                'data-pjax' => '0',
                                                'data-toggle'=>'tooltip',
                                            ];
                                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
                                        },
                                        'delete' => function($url, $model, $key) {
                                            $options = [
                                                'title' => Yii::t('yii', 'Delete'),
                                                'aria-label' => Yii::t('yii', 'Delete'),
                                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                'data-method' => 'post',
                                                'data-pjax' => '0',
                                                'data-toggle'=>'tooltip',
                                            ];
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                                        }
                                    ]
                                ],
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
