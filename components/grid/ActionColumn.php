<?php

namespace dongrim\blog\components\grid;

use yii\grid\ActionColumn as Column;

class ActionColumn extends Column
{
    public $contentOptions = [
        'style' => 'white-space: nowrap; text-align: center; letter-spacing: 0.1em; max-width: 7em;',
    ];
}