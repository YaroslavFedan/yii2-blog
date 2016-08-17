<?php

namespace dongrim\blog;
use Yii;

/**
 * blog module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'dongrim\blog\controllers';
    public $userClass = 'common\models\User';
    //public $userClass = 'app\modules\admin\models\User';
    public $uploadDir = '@webroot/upload';
    public $uploadURL = '@web/upload';
    public $enableScriptsPage = true;
    public $enableUpload = true;
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        self::registerTranslations();
        $this->registerAssets();
        // custom initialization code goes here
    }

    public static function registerTranslations()
    {
        Yii::$app->i18n->translations['app'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@dongrim/blog/messages',
            'forceTranslation' => true,
            'fileMap' => [
                'app' => 'app.php'
            ]
        ];
    }

    private $_view;

    /**
     * Returns the view object that can be used to render views or view files.
     * The [[render()]] and [[renderFile()]] methods will use
     * this view object to implement the actual view rendering.
     * If not set, it will default to the "view" application component.
     * @return \yii\web\View the view object that can be used to render views or view files.
     */
    public function getView()
    {
        if ($this->_view === null) {
            $this->_view = Yii::$app->getView();
        }

        return $this->_view;
    }

    protected function registerAssets()
    {
        $view = $this->getView();
        BlogAsset::register($view);
    }
}
