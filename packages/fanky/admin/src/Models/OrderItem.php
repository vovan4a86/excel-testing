<?php

namespace Fanky\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model {
    protected $guarded = ['id'];

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function stockItems() {
        return $this->belongsTo(StockItem::class);
    }
}