<?php namespace Fanky\Admin\Controllers;

use Fanky\Admin\Models\Order;
use Fanky\Admin\Models\Redirect;
use Request;
use Validator;
use DB;

class AdminOrderController extends AdminController {

    public function getIndex() {
        $items = Order::query()->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('admin::order.main', ['items' => $items]);
    }

    public function view(Order $order) {
        return view('admin::order.view', ['item' => $order]);
    }

    public function postDelete(Order $order) {
        $order->delete();
        return ['success' => true];
    }

}
