<?php
?>

<div class="modal fade" id="moveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="createOrder" >
                <div class="modal-header">
                    <div>
                        <!--                        <h6 class="modal-title" id="orderLabel">Заказ</h6>-->
                        <H6 class="modal-title">Поступление товаров</H6>

                    </div>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>

                <div class="modal-body">
                    <label class="">
                        <select required id="fromStorage" onchange="move.checkStock(event)"">
                            <option disabled selected>Выберите склад отправитель</option>
                            <?php foreach ($storages as $storage): ?>
                                <option value="<?= $storage['id'] ?>"><?= $storage['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label> Склад отправитель
                    <label class="">
                        <select required id="toStorage" onchange="move.checkStock(event)">
                            <option disabled selected>Выберите склад получатель</option>
                            <?php foreach ($storages as $storage): ?>
                                <option value="<?= $storage['id'] ?>"><?= $storage['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label> Склад получатель
                    <hr>

                    <table style="width: 100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Товар</th>
                            <th>На складе</th>
                            <th>Количество</th>

                        </tr>
                        </thead>
                        <tbody id="arrival">
                        <tr id="row">
                            <th></th>

                            <td><select required id="productIDToMove" onchange="move.checkStock(event)">
                                    <option disabled selected>Выберите товар</option>
                                    <?php foreach ($products as $product): ?>
                                        <option  value="<?= $product['id'] ?>"><?= $product['name'] ?></option>
                                    <?php endforeach; ?>
                                </select></td>
                            <td>
                                <input id="onStock" disabled style="width: 70px">
                            </td>
                            <td>
                                <label for="countTo"></label>
                                <input required type="number" id="countToMove" oninput="move.checkStock(event)" style="width: 70px">
                            </td>

                        </tr>
                        <!--                        <tr style="text-align: left">-->
                        <!--                            <td></td>-->
                        <!--                            <td>-->
                        <!--                                <button class="btn btn-outline-dark" onclick="arrival.addRow(event)">добавить строку-->
                        <!--                            </td>-->
                        <!--                        </tr>-->
                        </tbody>
                    </table>
                    <hr>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="products.reset()">
                        Закрыть
                    </button>
                    <button type="submit" id="createMove"
                            value="createMove"
                            form="createOrder"
                            class="btn btn-primary"
                            disabled
                            onclick="move.create()">
                        Сохранить
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>