<?php
use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = Yii::t('app', 'Blog');

$dataProvider->pagination = [
    'pageSize'=> 12,
];
$this->registerMetaTag(['name' => 'title', 'content' => Html::encode($this->title)]);
$this->registerMetaTag(['name' => 'description', 'content' => Html::encode($this->title)]);
/*
 * 'enablePushState'=>false удаляет пагинацию из url
 */
?>
<div class="blog-default-index">
    <div class="col-md-8">
        <?php \yii\widgets\Pjax::begin([
            'timeout' => 10000, 
            'clientOptions' => ['container' => 'pjax-container'], 
            'enablePushState'=>false
            ]);
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            //'itemOptions' => ['class' => 'col-md-8','tag'=>'div'],
            //'summary'=>Yii::t('app','List of account codes where increase on receipt or revenues'),
            'itemView'=>'_itemIndex',
            'options' => ['class' => 'row '],
            'layout'=>"{items}{pager}",
        
        ]);
        \yii\widgets\Pjax::end(); ?>
    </div>
   <div class="col-md-4">
       <?php echo $this->render('/default/_leftBlock');?>
   </div>

</div>
