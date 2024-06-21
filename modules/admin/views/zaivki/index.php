<?php

use app\models\Zaivki;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ZaivkiSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Записи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zaivki-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить запись', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'surname',
            'patronymic',
            'phone',
//'status',
//'category_id',
//'section_id',
//'user_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Zaivki $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
            [
                'attribute'=>'status',
                'value'=>function($zaivki){
                    return $zaivki->getStatus();
                }
            ],
            [
                'attribute'=>'Администрирование',
                'format'=>'html',
                'value'=>function($data){
                    switch ($data->status){
                        case 0:
                            return Html::a('Одобрить','zaivki/good/?id='.$data->id)."|".
                                Html::a('Отклонить','zaivki/verybad/?id'.$data->id);
                        case 1:
                            return Html::a('Одобрить','zaivki/good/?id='.$data->id);
                        case 2:
                            return Html::a('Отклонить','zaivki/verybad/?id='.$data->id);
                    }
                }
            ]
        ],
    ]); ?>


</div>
