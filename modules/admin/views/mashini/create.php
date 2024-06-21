<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Mashini $model */

$this->title = 'Create Mashini';
$this->params['breadcrumbs'][] = ['label' => 'Mashinis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mashini-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
