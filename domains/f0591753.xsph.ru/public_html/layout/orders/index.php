<?php
require '../header.php';
$orders = Orders::getOrders();

$products = Products::getProducts();
$users = Users::getUsers();

?>
<h3>Заказы</h3>
<div class="">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" style="margin-bottom: 30px">
        Создать новый заказ
    </button>

    <table class="table table-bordered table-striped table-sm ">
        <thead style="border: darkgray">
            <tr style="text-align: center">
                <th rowspan="2" scope="rowgroup">№</th>

                <th scope="rowgroup">Покупатель</th>
                <th scope="col">Дата создания</th>
                <th rowspan="2" scope="col" style="text-align: center">Менеджер</th>
                <th scope="col">Тип заказа</th>
                <th>Товар</th>
                <th>Цена</th>
                <th rowspan="2">Скидка</th>
                <th rowspan="2">Итого</th>

                <th rowspan="2" scope="col">Редактировать</th>
            </tr>
            <tr style="text-align: center">
                <th scope="rowgroup">телефон</th>
                <th scope="col">Дата закрытия</th>
                <th scope="col">Статус</th>
                <th scope="col">Количество</th>
                <th scope="col">Сумма</th>


            </tr>
        </thead>
        <tbody class="page-products__list" >
        <?php foreach ($orders as $order): ?>
            <tr id="firstRowOrder<?= $order['id'] ?>" style="text-align: center" >
                <th rowspan="2" scope="row"><?= $order['id'] ?></th>

                <td class="orderItem"><?= $order['customer'] ?></td>

                <td  class="orderItem"><?= $order['created_at'] ?></td>

                <td rowspan="2"  class="orderItem" style="vertical-align: middle;"><?= $order['user'] ?></td>

                <td class="orderItem"><?= $order['type'] ?></td>
                <td class="orderItem"><?= $order['product_name'] ?></td>

                <td class="orderItem"><?= $order['price'] ?></td>
                <td class="orderItem" rowspan="2" style="vertical-align: middle"><?= $order['discount'] ?></td>
                <td class="orderItem" rowspan="2" style="vertical-align: middle"><?= $order['cost'] ?></td>
                <td rowspan="2" style="vertical-align: middle">
                    <button type="button" class="btn btn-dark" value="<?= $order['id'] ?>" onclick="orders.changeOrder(event)">🖉</button>
                </td>

            </tr>
            <tr id="secondRowOrder<?= $order['id'] ?>" style="text-align: center">
                <td class="orderItem"><?= $order['phone'] ?></td>
                <td class="orderItem"><?= $order['completed_at'] ?></td>
                <td class="orderItem"><?= $order['status'] ?></td>
                <td class="orderItem"><?= $order['count'] ?></td>
                <td class="orderItem"><?= $order['count'] * $order['price'] ?></td>
            </tr>

        <?php endforeach; ?>

        </tbody>
    </table>

    <!-- Modal -->
    <?php require 'popup/create.php' ?>
</div>
<?php
require '../footer.php';

