<?php
require '../header.php';
$orders = Orders::getOrders();
$report = Orders::getReport();
?>

<h3>Отчет</h3>

<div class="">

    <table class="table">
        <thead>
            <tr style="text-align: center;">
                <th>Дата</th>
                <th>Колличество закрытых заказов</th>
                <th>Сумма</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($report as $row): ?>
            <tr style="text-align: center;">
                <td><?= $row['date'] ?></td>
                <td><?= $row['count'] ?></td>
                <td><?= number_format($row['sum'], 0, ',', ' ') . ' р.' ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>

    </table>
</div>
<?php
require '../footer.php';

