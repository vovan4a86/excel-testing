<?php namespace Fanky\Admin;

use Fanky\Admin\Models\Product;
use Session;
/**
 *
 *
 * array(
 *    [0] => array(
 *       [model] => модель товара
 *       [count] => Количество товаров
 *       [price] => Цена за 1 единицу товара
 *        )
 *    ),
 *  [1] => ....
 */
class Cart {

    private static $key = 'cart';
    private $price_field = 'price';
    private $id_field = 'id';

    public static function getCart() {
        $cart = session(self::$key, []);
        $cart = array_map(function($item){
            $item['price'] = str_replace([' ', ','] , ['', '.'], $item['price']);
            return $item;
        }, $cart);

        return (is_array($cart))? $cart: [];
    }

    public static function getCountById($id, $default = 0) {
        $cart = self::getCart();
        foreach ($cart as $item) {
            if ($item['model']->id == $id) {
                return $item['count'];
            }
        }

        return $default;
    }

    public static function addModel($model) {
        $cart = new self();
        $cart->add($model);
    }

    /**
     * Добавление товара
     *
     * @param     $model
     * @param int $count
     *
     * @return bool
     */
    public function add($model, $count = 1): bool {
        $id = $model->id;

        $cart = self::getCart();

        if (!isset($cart[$id]))
            $cart[$id]['count'] = $count;
        else
            $cart[$id]['count'] += $count;

        $cart[$id]['model'] = $model;
        $cart[$id]['price'] = str_replace([' ', ','] , ['', '.'], $model->price);

        session([self::$key => $cart]);

        return true;
    }

    /**
     * Изменение количества товара
     *
     * @param $model
     * @param $count
     *
     * @return bool
     */
    public function update($model, $count) {
        $id = $model->{$this->id_field};

        $cart = self::getCart();

        if ($count > 0) {
            $cart[$id]['count'] = $count;
            $cart[$id]['model'] = $model;
            $cart[$id]['price'] = $model->{$this->price_field};
            session([self::$key => $cart]);
        } else {
            self::delete($id);
        }

        return true;
    }

    /**
     * Количество наименований товаров
     *
     * @static
     * @return int
     */
    public static function getCount() {
        $cart = self::getCart();

        return count($cart);
    }

    /**
     * Общее количество товаров
     *
     * @static
     * @return int
     */
    public static function getTotalCount() {
        $cart = self::getCart();

        $count = 0;
        foreach ($cart as $item)
            $count += (int)$item['count'];

        return $count;
    }

    /**
     * Удаляет наименовалие товара
     *
     * @static
     *
     * @param $id
     *
     * @return bool
     */
    public static function delete($id) {
        $cart = self::getCart();

        if (isset($cart[$id]))
            unset($cart[$id]);

        session([self::$key => $cart]);

        return true;
    }

    /**
     * Очистка корзины
     *
     * @static
     * @return bool
     */
    public static function purge() {
        session([self::$key => []]);

        return true;
    }

    /**
     * Общая стоимость всх товаров
     *
     * @return int
     */
    public static function getTotalSum() {
        $items = self::getCart();

        $total = 0;
        foreach ($items as $item) {
            $total += (float)$item['price'] * (float)$item['count'];
        }

        return number_format($total, 2, '.', ' ');
    }

    public static function getAmount() {
        $items = self::getCart();

        $total = 0;
        foreach ($items as $item) {
            $total += (float)$item['price'] * (float)$item['count'];
        }

        return $total;
    }
}
