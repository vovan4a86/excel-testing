<?php

namespace Fanky\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $guarded = ['id'];

    public function orderItems() {
        return $this->hasMany(OrderItem::class);
    }

    public function stockItems() {
        return $this->belongsToMany(StockItem::class, 'order_items');
    }

    public function delete() {
        foreach($this->orderItems as $orderItem) {
            $orderItem->delete();
        }

        parent::delete();
    }
}