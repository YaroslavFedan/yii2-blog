Установка
------------

####Download:

Download from [Github](https://github.com/YaroslavFedan/yii2-blog).

**Composer**
```
composer require dongrim/yii2-blog
```

База данных миграция
--------
```
php yii migrate/up --migrationPath=@dongrim/blog/migrations
```


Конфигурация
---------

```
'gridview' =>  [
    'class' => 'kartik\grid\Module',
],

'blog' => [
    'class' => 'dongrim\blog\Module',
    //'userClass' => 'budyaga\users\models\User',  /* example if use another user class */
    //'uploadDir'=>'', // path to upload dir
    //'uploadURL'=>''  
    'modules' =>[
        'admin'=>[
            'class' => 'dongrim\blog\admin\Module',
        ]
    ]
],

```
