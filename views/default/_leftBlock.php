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
<hr>
<?php if(Yii::$app->user->isGuest):?>
    <?//= AuthorizationWidget::widget() ?>
<?php endif;?>

<h4><?= Yii::t("app","Recent Posts")?></h4>
<ul class="list-unstyled">
    <?php
    foreach ($model->getRecent() as $m){
        echo '<li>'.Html::a($m->title,["//blog/default/view","id"=>$m->id,"title"=>$m->title]).'</li>';
    }
    ?>
</ul>
<hr>

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

<h4><?= Yii::t("app","Archive")?></h4>
<ul class="nav nav-pills">
    <?php
    foreach ($model->getArchived() as $m){
        echo '<li>'.Html::a(date('M Y',strtotime($m["month"])),["//blog/default/index","time"=>$m["month"]]).'</li>';
    }
    ?>
</ul>


