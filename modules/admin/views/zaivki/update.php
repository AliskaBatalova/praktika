<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Zaivki $model */

$this->title = 'Редактировать запись: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Zaivkis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="zaivki-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
