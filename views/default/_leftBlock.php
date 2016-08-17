<?php

//use budyaga\users\components\AuthorizationWidget;
use \dongrim\blog\models\Post;
use \dongrim\blog\models\CategorySearch;
use yii\helpers\Html;
use yii\widgets\Menu;

$cat = new CategorySearch();
$model = new Post();
?>
<style>
    .nav-pills{
        padding-left: 15px;
    }

</style>

<h4><?=Yii::t("app","Search our Posts")?></h4>
<form action="<?=Yii::$app->urlManager->createUrl("/blog/default")?>" method="get">
    <div class="input-group">
        <input class="form-control input-md" name="PostSearch[term]" id="appendedInputButtons" type="text">
        <span class="input-group-btn">
                <button class="btn btn-md" type="submit"><?= Yii::t("app","Search")?></button>
            </span>
    </div>
</form>

<?php if(Yii::$app->user->isGuest):?>
    <?//= AuthorizationWidget::widget() ?>
<?php endif;?>

<?php
if($items = $model->getRecent())
{
    echo Html::beginTag('h4');
    echo Yii::t("app","Recent Posts");
    echo Html::endTag('h4');

    echo Html::beginTag('ul',['class'=>'list-unstyled']);
    foreach ($items as $m){
        echo '<li>'.Html::a($m->title,["//blog/default/view","id"=>$m->id,"title"=>$m->title]).'</li>';
    }
    echo Html::endTag('ul');
    echo Html::tag('hr');
}
?>
<?php
if($items = $cat->getStructure()){

    echo Html::beginTag('h4');
    echo Yii::t("app","Categories");
    echo Html::endTag('h4');

    echo Menu::widget([
        'items' => $items,
        'submenuTemplate' => "\n<ul class='nav nav-pills nav-stacked my_menu' role='menu'>\n{items}\n</ul>\n",
        //'linkTemplate' => ' < a href = "{url}" class = "href_class" id = "href_id" style = "" > {label}</a > ',
        'itemOptions'=>array('id'   =>'item_id','class'=>'nav nav-pills nav-stacked'),
        'activateParents'=>true,
        'options' => [
            'class' => 'nav nav-pills nav-stacked my_menu',
            'id'=>'navbar-id',
            'style'=>'font-size: 14px;',
            'data-tag'=>'yii2-menu',
        ],
    ]);
    echo Html::tag('hr');
}
?>

<?php
if($items = $model->getArchived()){
    echo Html::beginTag('h4');
    echo Yii::t("app","Archive");
    echo Html::endTag('h4');
    echo Html::beginTag('ul',['class'=>'list-unstyled']);
    foreach ($model->getArchived() as $m){
        echo '<li>'.Html::a(date('M Y',strtotime($m["month"])),["//blog/default/index","time"=>$m["month"]]).'</li>';
    }
    echo Html::endTag('ul');
    echo Html::tag('hr');
}
?>



