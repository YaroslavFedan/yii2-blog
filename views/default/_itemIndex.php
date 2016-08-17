<?php

use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
$module = Yii::$app->getModule('blog');
$assets = \dongrim\blog\BlogAsset::register($this);
?>

<div class="row" style="margin-bottom: 30px;">
    <div class="col-xs-4">
        <?php
        if($model->image != null)
            echo Html::img($model->image, ['style'=>'width:100%']);
        else
            echo Html::img($assets->baseUrl.'/image/image-not-found.png', ['style'=>'width:100%']);
        ?>
    </div>
    <div class="col-xs-8">
        <h4><?= Html::a($model->title,Url::to(["//blog/default/view","id"=>$model->id,"title"=>$model->title])) ?></h4>
        <h5><?= Html::encode($model->author?$model->author->username:"") ?> <small><?= Html::encode(date('D d M, Y H:m:s',strtotime($model->time))) ?></small></h5>
        <p ><?= Html::encode($model->description) ?></p>
        <p class="pull-right" style="padding-right: 15px;">
            <?= Html::a(Yii::t('app','Read More'),Url::to(["//blog/default/view","id"=>$model->id,"title"=>$model->title]),['class'=>'btn btn-small btn-default']); ?>
        </p>
    </div>
</div>


