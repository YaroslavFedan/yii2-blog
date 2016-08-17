<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(['name' => 'title', 'content' => Html::encode($model->title)]);
$this->registerMetaTag(['name' => 'description', 'content' => Html::encode($model->description)]);

$module = Yii::$app->getModule('blog');

?>
<div class="post-view">
    <div class="row">
        <div class="col-md-8">
            <h1><?= Html::encode($this->title) ?></h1>
            <h3><?= Html::encode($model->author?$model->author->username:"") ?>
                <small><i class="glyphicon glyphicon-time"></i>  <?= date('D d M, Y',strtotime($model->time)) ?> </small>
            </h3>
            <div class="col-md-6" style="padding-left: 0">
                <?php if ($model->image != null)
                    echo Html::img($model->image,["style"=>"width:100%;margin-bottom:20px;","alt"=>$model->title]); ?>
            </div>
            <div>
                <?= HtmlPurifier::process($model->content,[
                    'HTML.SafeIframe'=>true,
                    'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/|'.str_replace(['http://','https://'],'',$module->uploadURL).')%'
                ]) ?>
            </div>
        </div>
        <div class="col-md-4">
            <?php echo $this->render('/default/_leftBlock');?>
        </div>
    </div>




</div>
