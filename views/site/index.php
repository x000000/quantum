<?php

use yii\grid\GridView;
use yii\bootstrap\Html;

?>
<div class="body-content">
    <div class="row">
	    <?= GridView::widget([
		    'id' => 'users-data-grid',
		    'dataProvider' => $dataProvider,
		    'filterModel'  => $searchModel,
		    'columns' => [
			    [
				    'attribute' => 'id',
				    'filterOptions'  => ['style' => 'max-width: 60px;'],
				    'contentOptions' => ['style' => 'max-width: 60px;'],
			    ],
			    [
				    'attribute' => 'country.id',
				    'filter' => $countries,
				    'filterInputOptions' => [
					    'class' => 'form-control',
				    ],
				    'format' => 'raw',
				    'value' => function($data) use ($countries) {
					    return Html::activeDropDownList($data, 'country_id', $countries, [
						    'id'    => false,
						    'class' => 'form-control',
					    ]);
				    },
			    ],
			    [
				    'attribute' => $attr = 'name',
				    'format' => 'raw',
				    'value' => function($data) use ($attr) {
					    return Html::activeTextInput($data, $attr, [
						    'id'    => false,
						    'class' => 'form-control',
					    ]);
				    },
			    ],
			    [
				    'attribute' => $attr = 'phone',
				    'format' => 'raw',
				    'value' => function($data) use ($attr) {
					    return Html::activeTextInput($data, $attr, [
						    'id'    => false,
						    'class' => 'form-control',
					    ]);
				    },
			    ],
		    ],
	    ]); ?>
    </div>
</div>
