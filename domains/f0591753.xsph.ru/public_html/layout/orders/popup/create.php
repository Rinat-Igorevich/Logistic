<?php

?>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="createOrder" >
                <div class="modal-header">
                    <div>
<!--                        <h6 class="modal-title" id="orderLabel">Заказ</h6>-->
                        <H6 class="modal-title">Заказ №</H6>
                        <input id="orderID" disabled><?= $_GET['orderID'] ?? '' ?>
                    </div>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>

                <div class="modal-body">
                    <label class="">
                        <input id="customer" required style="margin-bottom: 10px">
                    </label> ФИО
                    <label class="">
                        <input id="phone" required> Телефон
                    </label>
                    <hr>
                    <label class="">
                        <select id="product" onchange="products.setStockAndPrice(event)">
                            <option disabled selected>Выберите товар</option>
                            <?php foreach ($products as $product): ?>
                                <option value="<?= $product['id'] ?>"><?= $product['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label> Товар
                    <hr>
                    <label class="">
                        <input type="number" id="count" required style="margin-bottom: 10px"
                               oninput="products.changeCost()"> количество
                    </label>
                    <label class="">
                        <input id="onStock" disabled> Остаток
                    </label>
                    <table style="width: 100%">
                        <thead>
                        <tr>
                            <th>Цена</th>
                            <th>Сумма</th>
                            <th>Скидка</th>
                            <th>Итого</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><input id="price" disabled style="width: 70px"></td>
                            <td><input id="sum" disabled style="width: 70px"></td>
                            <td><input id="discount" max="500" style="width: 100px" oninput="products.changeCost()">
                            </td>
                            <td><input id="cost" disabled style="width: 70px"></td>
                        </tr>
                        </tbody>
                    </table>
                    <hr>
                    <label class="">
                        <select id="type">
                            <option value="online">online</option>
                            <option value="offline">offline</option>
                        </select> тип заказа
                        <select id="user">
                            <?php foreach ($users as $user): ?>
                                <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
                            <?php endforeach; ?>
                        </select> Менеджер
                        <select id="status" disabled>
                            <option value="active">active</option>
                            <option value="completed">completed</option>
                            <option value="canceled">canceled</option>
                        </select> статус
                    </label>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="products.reset()">
                        Закрыть
                    </button>
                    <button type="submit" id="submit" value="createOrder" form="createOrder" class="btn btn-primary" onclick="orders.createOrChangeOrder()">
                        Сохранить
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
