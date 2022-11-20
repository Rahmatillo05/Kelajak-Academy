<?php

use yii\widgets\LinkPager;
use yii\widgets\ListView;

?>
<div>
    <div class="h4">O'qituvchilar</div>
    <?=ListView::widget([
        'dataProvider'=>$teacher,
        'itemView' => '_teacherItem',
        'layout' => "{items}",
        'emptyText' => '',
        'options' => [
            'class' => 'row'
        ],
        'itemOptions' => [
            'class' => 'col-6 col-md-4 col-lg-3'
        ]
    ])?>
        <div class="text-center">
            <?=LinkPager::widget([
                'pagination'=>$teacher->pagination,
                'firstPageLabel' => 'Boshi',
                'lastPageLabel' => 'Oxiri',
                'options'=>[
                    'class'=>'btn-group'
                ],
                'linkContainerOptions'=>[
                    'class'=>'btn btn-outline-info'
                ],
            ])?>
        </div>  
</div>
<div>
    <div class="h4">O'quchilar</div>
    <?=ListView::widget([
        'dataProvider'=>$child,
        'itemView' => '_teacherItem',
        'layout' => "{items}",
        'emptyText' => '',
        'options' => [
            'class' => 'row'
        ],
        'itemOptions' => [
            'class' => 'col-6 col-md-4 col-lg-3'
        ]
    ])?>
        <div class="text-center">
            <?=LinkPager::widget([
                'pagination'=>$child->pagination,
                'firstPageLabel' => 'Boshi',
                'lastPageLabel' => 'Oxiri',
                'options'=>[
                    'class'=>'btn-group'
                ],
                'linkContainerOptions'=>[
                    'class'=>'btn btn-outline-info'
                ],
            ])?>
        </div>  
</div>