<?php
use frontend\models\Proposal;
use yii\helpers\Html;

$this->title = 'Админка';


/* @var Proposal[] $newItems */
/* @var Proposal[] $reviewedItems */
?>
<h3>Работы на проверку</h3>

<?php if (count($newItems) > 0): ?>
    <table class="table">
        <tr>
            <th>Имя</th>
            <th>Почта</th>
            <th>Проверить</th>
        </tr>
        <?php foreach ($newItems as $proposal): ?>
            <tr>
                <td><a href="tel:<?= Html::encode($proposal->phone) ?>"><?= Html::encode($proposal->name ? : 'не указано'); ?></a></td>
                <td><?= Html::encode($proposal->email) ?></td>
                <td><?=Html::a('Проверить', ['/admin/review/view', 'id' => $proposal->getPrimaryKey()], ['class' => 'btn btn-success btn-xs']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p><i>Нет работ</i></p>
<?php endif; ?>


<br><br>

<h3>Проверенные работы</h3>
<?php if (count($reviewedItems) > 0): ?>
    <table class="table">
        <tr>
            <th>Имя</th>
            <th>Почта</th>
            <th colspan="3">Оценки</th>
        </tr>
        <?php foreach ($reviewedItems as $proposal): ?>
            <tr>
                <td><a href="tel:<?= Html::encode($proposal->phone) ?>"><?= Html::encode($proposal->name ? : 'не указано'); ?></a></td>
                <td><?= Html::encode($proposal->email) ?></td>

                <td><?=$proposal->grade1; ?></td>
                <td><?=$proposal->grade2; ?></td>
                <td><?=$proposal->grade3; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p><i>Нет работ</i></p>
<?php endif; ?>
