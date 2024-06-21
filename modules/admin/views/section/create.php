<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Section $model */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Sections', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="section-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
