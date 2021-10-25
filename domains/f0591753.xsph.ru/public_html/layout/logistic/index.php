<?php
require '../header.php';
$productsStock = Logistic::getProductsStock();
$storages = Logistic::getStorages();
$products = Logistic::getProducts();
$arrivals = Logistic::getArrivals();
$moves = Logistic::getMoves();
$sales = Logistic::getSales();

?>
<h3>Логистика</h3>
<div class="container" style="margin-bottom: 30px; text-align: center">
    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#arrivalModal">Создать поступление</button>
    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#moveModal">Создать перемещение</button>
    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#saleModal">Создать продажу</button>
</div>
<?php include 'popup/arrival.php'?>
<?php include 'popup/move.php'?>
<?php include 'popup/sale.php'?>
    <h4>Товары</h4>
    <div class="list-group" style="width: 10%;
                            float: left;
                            display: block;">

    <?php foreach ($products as $product): ?>
        <a href="/layout/logistic/?productID=<?= $product['id'] ?>"
           class="list-group-item list-group-item-action <?= $_GET['productID'] == $product['id'] ? 'active' : '' ?>">
            <?= $product['name'] ?>
        </a>
    <?php endforeach; ?>

    </div>
    <div style="float: left;
                width: 85%;
                display: block;
                margin-left: 10px">
        <table class="table table-bordered">
            <thead>
            <tr style="text-align: center">
                <th colspan="2">Остатки</th>
                <th colspan="3">Поступления</th>
                <th colspan="4">Перемещения</th>
                <th colspan="3">Продажи</th>
            </tr>

            </thead>
            <tbody>
            <td colspan="2">
                <table class="table mb-0 table-bordered">
                    <th>склад</th>
                    <th>кол-во</th>
                    <?php if (isset($_GET['productID'])): ?>
                        <?php foreach ($productsStock as $item): ?>
                             <?php if ($_GET['productID'] == $item['id']): ?>
                            <tr>
                                <td><?= $item['storage']?></td>
                                <td><?= $item['stock']?></td>
                            </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </table>
            </td>
            <td colspan="3">
                <table class="table mb-0 table-bordered" style="text-align: left">
                    <th>дата</th>
                    <th>склад</th>
                    <th>кол-во</th>
                    <?php if (isset($_GET['productID'])): ?>
                        <?php foreach ($arrivals as $item): ?>
                            <?php if ($_GET['productID'] == $item['id']): ?>
                                <tr>
                                    <td><?= $item['date']?></td>
                                    <td><?= $item['storage']?></td>
                                    <td><?= $item['count']?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </table>
            </td>
            <td colspan="4">
                <table class="table mb-0 table-bordered" style="text-align: left">

                    <th>дата</th>
                    <th>склад</th>
                    <th>склад</th>
                    <th>кол-во</th>
                    <?php if (isset($_GET['productID'])): ?>
                        <?php foreach ($moves as $item): ?>
                            <?php if ($_GET['productID'] == $item['id']): ?>
                                <tr>
                                    <td><?= $item['date']?></td>
                                    <td><?= $item['storageFrom']?></td>
                                    <td><?= $item['storageTo']?></td>
                                    <td><?= $item['count']?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </table>
            </td>
            <td colspan="3">
                <table class="table mb-0 table-bordered" style="text-align: left">

                    <th>дата</th>
                    <th>склад</th>
                    <th>кол-во</th>
                    <?php if (isset($_GET['productID'])): ?>
                        <?php foreach ($sales as $item): ?>
                            <?php if ($_GET['productID'] == $item['id']): ?>
                                <tr>
                                    <td><?= $item['date']?></td>
                                    <td><?= $item['storage']?></td>
                                    <td><?= $item['count']?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </table>
            </td>

            </tbody>
        </table>
    </div>

<?php
require '../footer.php';


