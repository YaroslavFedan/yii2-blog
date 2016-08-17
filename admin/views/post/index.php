<?php


use dongrim\blog\components\grid\ActionColumn;
use dongrim\blog\models\Post;
use kartik\grid\GridView;
use yii\helpers\Html;



/* @var $this yii\web\View */
/* @var $searchModel dongrim\blog\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Posts');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog'), 'url' => ['/admin/blog/default']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-admin">
    <section>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><?=$this->title;?></h3>
                        <div class="box-tools pull-right">
                            <?= Html::a(Yii::t('app', 'Create Post'), ['create'], ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>
                    <div class="box-body">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'pjax' => true,

                            'tableOptions' => [
                                'class' => 'table table-striped table-bordered '
                            ],
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'attribute' => 'term',
                                    'value' => 'title',
                                ],

                                [
                                    'attribute'=>'description',
                                    'value'=>function($data){
                                        return Post::substrText($data->description, 150);
                                    },
                                   // 'contentOptions'=>['style'=>'white-space: nowrap;']
                                ],
                                [
                                    'attribute'=>'content',
                                    'value'=>function($data){
                                        return Post::substrText($data->content, 200);
                                    },
                                   // 'contentOptions'=>['style'=>'white-space: nowrap;']
                                ],
                                'tags',
                                // 'image:ntext',
//                                [
//                                    'attribute' => 'authorName',
//                                    'value' => 'author.username',
//                                ],
//								[
//									'attribute' => 'categories',
//									'value' => function($data){
//										return Post::getRelatedCategories($data);
//									}
//								],
                                [
                                    'attribute' => 'time',
                                    'value' => 'time',
                                    'filterType'=>GridView::FILTER_DATE_RANGE,
                                    'filterWidgetOptions'=>[
                                        'pluginOptions'=>[
                                            'todayHighlight' => true,
                                            'timePicker'=>true,
                                            'timePickerIncrement'=>15,
                                            'locale'=>['format'=>'YYYY-MM-DD HH:mm:ss'], // from demo config
                                            'separator'=>'-',       // from demo config
                                            'opens'=>'left'
                                        ],
                                        'pluginEvents' => [
                                            "apply.daterangepicker" => 'function() {
												$(this).change();
											}',
                                        ],
                                    ],

                                ],
                                [
                                    'attribute'=>'isfeatured',
                                    'value'=>function($data){
                                        (!$data->isfeatured)? $class = 'default': $class = 'success';
                                        return Html::tag('span', Html::encode($data->itemAlias('isfeatured',$data->isfeatured ? 1 : 0)),
                                            ['class' => 'label label-' . $class]);
                                    },
                                    'format'=>'html',
                                    'filterType'=>GridView::FILTER_SELECT2,
                                    'filterWidgetOptions'=>[
                                        'data'=>$searchModel->itemAlias('isfeatured'),
                                        'options' => ['placeholder' => Yii::t('app','Is Featured?')],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],

                                    ],
                                    'contentOptions'=>['style'=>'max-width:150px; width: 150px;']
                                ],
                                [
                                    'attribute'=>'status',
                                    'value'=>function($data){
                                        return Post::getStatusName($data);
                                    },
                                    'format'=>'html',
                                    'filterType'=>GridView::FILTER_SELECT2,
                                    'filterWidgetOptions'=>[
                                        'data'=>$searchModel->itemAlias('status'),
                                        'options' => ['placeholder' => Yii::t('app','Filter by status...')],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],

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
