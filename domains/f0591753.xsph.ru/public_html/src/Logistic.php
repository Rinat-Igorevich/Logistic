<?php

class Logistic
{
    private static function getPDO()
    {
        $dsn = 'mysql:host=' . DB_CONNECTION_HOST . ';
                dbname=f0591753_logistic';

        return new PDO(
            $dsn,
            DB_CONNECTION_USER_NAME,
            DB_CONNECTION_PASSWORD
        );
    }

    public static function getStorages()
    {
        $pdo = self::getPDO();
        $statement = $pdo->prepare('SELECT * FROM storages');
        $statement->execute();
        $storages = $statement->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
        return $storages;

    }

    public static function getProductsStock()
    {
        $pdo = self::getPDO();
        $statement = $pdo->prepare('SELECT p.id, p.name AS product, s.name AS storage, stock FROM product_storage
                                            LEFT JOIN products AS p on p.id=product_storage.product_id
                                            LEFT JOIN storages AS s on s.id=product_storage.storage_id
                                         ORDER BY product_id');
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
        return $result;
    }

    public static function getProducts()
    {
        $pdo = self::getPDO();
        $statement = $pdo->prepare('SELECT * FROM products');
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
        return $result;
    }

    public static function getArrivals()
    {
        $pdo = self::getPDO();
        $statement = $pdo->prepare('SELECT date, storage_id, s.name AS storage, p.id, p.name, count  from arrivals
                                        LEFT JOIN product_arrival pa on arrivals.id = pa.arrival_id
                                        LEFT JOIN storages s ON arrivals.storage_id = s.id
                                        LEFT JOIN products p on pa.product_id = p.id');
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
        return $result;
    }

    public static function getMoves()
    {
        $pdo = self::getPDO();
        $statement = $pdo
            ->prepare( 'SELECT date, p.id, p.name, count, sf.name AS storageFrom, st.name AS storageTo  from moves
                                   LEFT JOIN product_move pm ON moves.id = pm.move_id
                                   LEFT JOIN storages sf ON moves.storage_id_from = sf.id
                                   LEFT JOIN storages st ON moves.storage_id_to = st.id
                                   LEFT JOIN products p ON pm.product_id = p.id');

        $statement->execute();
        $moves = $statement->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
        return $moves;
    }

    public static function getSales()
    {
        $pdo = self::getPDO();
        $statement = $pdo
            ->prepare( 'SELECT date, storage_id, s.name as storage, p.id, p.name, count  from sales
                               LEFT JOIN product_sale ps on sales.id = ps.sale_id
                               LEFT JOIN products p on ps.product_id = p.id
                               LEFT JOIN storages s on sales.storage_id = s.id');

        $statement->execute();
        $sales = $statement->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
        return $sales;
    }

    public static function createArrival()
    {
        $pdo = self::getPDO();
        $statement = $pdo
            ->prepare('INSERT INTO arrivals (storage_id) values (?)');
        $statement->execute([$_POST['storageID']]);
        $error = $statement->errorCode();
        $lastID = $pdo->lastInsertId();
        $pdo = null;
        $error .= self::createArrivalProducts($lastID);
        $error .= self::changeStock($_POST['storageID'], $_POST['productID'], $_POST['productCount'], 'increase');
        return $error;

    }

    public static function createArrivalProducts($lastInsertID)
    {
        $pdo = self::getPDO();
        $statement = $pdo
            ->prepare('INSERT INTO product_arrival (arrival_id, product_id, count) 
                                VALUES (?,?,?)');
        $statement->execute([$lastInsertID, $_POST['productID'], $_POST['productCount']]);
        $pdo = null;
        return $statement->errorCode();
    }

    public static function changeStock($storageID, $productID, $count, $action)
    {
        $pdo = self::getPDO();

        if ($action == 'decrease') {
            $count = -intval($count);
        }

        $statement = $pdo
            ->prepare('UPDATE product_storage SET 
                                    stock = stock + ?
                             WHERE storage_id = ? AND product_id = ?');
        $statement
            ->execute([$count, $storageID, $productID ]);
        $pdo = null;
        return $statement->errorCode();
    }
    public static function getStock()
    {
        $pdo = self::getPDO();
        $statement = $pdo
                ->prepare('SELECT stock FROM product_storage
                                    WHERE product_id = ? AND storage_id = ?
                ');
        $statement
            ->execute([intval($_POST['productID']), intval($_POST['storageID'])]);
        return $statement->fetchColumn();
    }

    public static function createMove()
    {
        $pdo = self::getPDO();
        $statement = $pdo
            ->prepare('INSERT INTO moves(storage_id_from, storage_id_to)
                                    VALUES(?,?)
                     ');
        $statement->execute([$_POST['fromStorageID'], $_POST['toStorageID']]);
        $lastInsertID = $pdo->lastInsertId();
        $error = $statement->errorCode();
        $pdo = null;
        $error .= ' ' . self::createProductMove($lastInsertID, intval($_POST['productID']), $_POST['productCount']);
        $error .= ' ' . self::changeStock($_POST['fromStorageID'], $_POST['productID'], $_POST['productCount'], 'decrease');
        $error .= ' ' . self::changeStock($_POST['toStorageID'], $_POST['productID'], $_POST['productCount'], 'increase');
        return $error;
    }

    public static function createProductMove($moveID, $productID, $count)
    {
        $pdo = self::getPDO();
        $statement = $pdo
            ->prepare('INSERT INTO product_move(move_id, product_id, count) 
                                VALUES(?, ?, ?)'
                     );
        $statement->execute([$moveID, $productID, $count]);
        $pdo = null;
        return $statement->errorCode();
    }

    public static function createSale()
    {
        $pdo = self::getPDO();
        $statement = $pdo
            ->prepare('INSERT INTO sales (storage_id) values (?)');
        $statement->execute([$_POST['storageID']]);
        $error = $statement->errorCode();
        $lastID = $pdo->lastInsertId();
        $pdo = null;
        $error .= self::createProductsSale($lastID);
        $error .= self::changeStock($_POST['storageID'], $_POST['productID'], $_POST['productCount'], 'decrease');
        return $error;

    }

    public static function createProductsSale($id)
    {
        $pdo = self::getPDO();
        $statement = $pdo
            ->prepare('INSERT INTO product_sale (sale_id, product_id, count) 
                                VALUES (?,?,?)');
        $statement->execute([$id, $_POST['productID'], $_POST['productCount']]);
        $pdo = null;
        return $statement->errorCode();
    }
}