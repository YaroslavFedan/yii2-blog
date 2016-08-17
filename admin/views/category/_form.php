<?php

use iutbay\yii2kcfinder\KCFinderInputWidget;
use kartik\switchinput\SwitchInput;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\helpers\Html;

$module = Yii::$app->getModule('blog');

if ($module->enableUpload)
{
    // kcfinder options
    // http://kcfinder.sunhater.com/install#dynamic
    $kcfOptions = array_merge([], [
        'uploadURL' => Yii::getAlias($module->uploadURL),
        'uploadDir' => Yii::getAlias($module->uploadDir),
        'access' => [
            'files' => [
                'upload' => true,
                'delete' => true,
                'copy' => true,
                'move' => true,
                'rename' => true,
            ],
            'dirs' => [
                'create' => true,
                'delete' => true,
                'rename' => true,
            ],
        ],
        'types'=>[
            'files'    =>  "",
            'images'   =>  "*img",
        ],
        'thumbWidth' => 260,
        'thumbHeight' => 260,
    ]);
    // Set kcfinder session options
    Yii::$app->session->set('KCFINDER', $kcfOptions);
}

/* @var $this yii\web\View */
/* @var $model app\modules\blog\models\Category */
/* @var $form yii\widgets\ActiveForm */

$listParent = []+ArrayHelper::map(($model->isNewRecord?$model->parents():$model->parents($model->id)), 'id', 'title');
?>
<div class="category-form">
    <section>
        <div class="row">
            <div class="col-md-12">
                <?php $form = ActiveForm::begin(); ?>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><?=$this->title?></h3>
                        <div class="box-tools pull-right">
                            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') :
                                Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

                            <?=Html::a('Отмена', ['index'], ['class' => 'btn btn-default'])?>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="row">
                                    <div class="col-xs-4">
                                        <?= $form->field($model, 'status')->widget(SwitchInput::classname(), [
                                            'type' => SwitchInput::CHECKBOX,
                                            'pluginOptions'=>[
                                                'handleWidth'=>100,
                                                'onText'=>Yii::t('app','Active'),
                                                'offText'=>Yii::t('app','Inactive')
                                            ]
                                        ]);
                                        ?>
                                    </div>
                                    <div class="col-xs-12">
                                        <?= $form->field($model, 'title')
                                            ->textInput(['maxlength' => 65,'placeholder'=>Yii::t('app','Title contain a seo keyword if possible')]) ?>
                                    </div>

                                </div>

                                <?= $form->field($model, 'description')->textArea(['maxlength' => 155,'placeholder'=>Yii::t('app','This description also used as meta description')]) ?>

                            </div>

                            <div class="col-md-6 well">
                                <?= $form->field($model, 'parent_id')->widget(Select2::classname(), [
                                    'model'=>$model,
                                    'attribute'=>'parent_id',
                                    'data' => $listParent,
                                    'options' => ['placeholder' => Yii::t('app','Select a account parent...')],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                    'pluginEvents' => [
                                        "change" => 'function() { 														
								    }',
                                    ],
                                ]);?>

                                <?php
                                if ($module->enableUpload)
                                {
                                    echo $form->field($model, 'image')->widget(KCFinderInputWidget::className(), [
                                        'multiple' => false,
                                        'kcfOptions'=>$kcfOptions,
                                        'kcfBrowseOptions'=>[
                                            'type'=>'images',
                                            'lng'=>substr(Yii::$app->language,0,2),
                                        ]
                                    ]);

                                }else{
                                    echo $form->field($model, 'image')->textInput(['placeholder'=>Yii::t('app','Url of image')]);
                                }
                                ?>
<!--                                --><?php //if($model->image): ?>
<!--                                    <div class="form-group ">-->
<!--                                        <div class="kcf-input-group">-->
<!--                                            <ul id="w1-thumbs" class="kcf-thumbs">-->
<!--                                                <li class="sortable">-->
<!--                                                    <div class="remove remove-preview">-->
<!--                                                        <span class="fa fa-trash"></span>-->
<!--                                                    </div>-->
<!--                                                    <img src="--><?//=ImagePath::setPathToThumbs($model->image, $kcfOptions['uploadURL'])?><!--" id="preview-img">-->
<!---->
<!--                                                    <input type="hidden" id="field-preview-img" name="--><?//=$model->formName()?><!--[image]" value="--><?//=$model->image;?><!--">-->
<!--                                                </li>-->
<!--                                            </ul>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                --><?php //endif;?>
                            </div>
                        </div>

                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </section>
</div>

<?php //$this->beginBlock('PHOTO') ?>
<!--    $('#images .kcf-thumbs').bind("DOMSubtreeModified",function(){-->
<!--        $("#preview-img").css("display",'none');-->
<!--    })-->
<!--    $('.remove-preview').on('click', function(){-->
<!--        $("#preview-img").css("display",'none');-->
<!--        $('#field-preview-img').val('');-->
<!--    })-->
<?php //$this->endBlock();
//yii\web\YiiAsset::register($this);
//$this->registerJs($this->blocks['PHOTO'], yii\web\View::POS_END);
//?>
