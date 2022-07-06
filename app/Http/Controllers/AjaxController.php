<?php namespace App\Http\Controllers;

use Fanky\Admin\Models\Feedback;
use Fanky\Admin\Models\Order;
use Fanky\Admin\Models\StockItem;
use Mail;
use Request;
use Mailer;
use Settings;
use Cart;
use Validator;

class AjaxController extends Controller {
    private $fromMail = 'info@regionmetprom.ru';
    private $fromName = 'regionmetprom';

    /*

            отправка письма
            Mail::queue('mail.feedback', [], function($message){
                $message->to('as@klee.ru')->subject('test');
            });
     * */

    public function postCallback() {
        $data = Request::only(['name', 'phone', 'text']);
        $valid = Validator::make($data, [
            'name'  => 'required',
            'phone' => 'required',
            'text'  => 'max:250'
        ], [
            'name.required'  => 'Не заполнено поле Имя',
            'phone.required' => 'Не заполнено поле Телефон',
            'text.max'       => 'Слишком длинное сообщение',
        ]);

        if($valid->fails()) {
            return ['errors' => $valid->messages()];
        } else {
            $feedback_data = [
                'type' => 1,
                'data' => $data
            ];
            $feedback = Feedback::create($feedback_data);
            Mail::send('mail.feedback', ['feedback' => $feedback], function ($message) use ($feedback) {
                $title = $feedback->id . ' | Заказ звонка | ' . $this->fromName;
                $message->from($this->fromMail, $this->fromName)
                    ->to(Settings::get('feedback_email'))
//					->to('as@klee.ru')
                    ->subject($title);
            });

            return ['success' => true];
        }
    }

    public function postQuestion() {
        $data = Request::only(['name', 'phone', 'email', 'text']);
        $valid = Validator::make($data, [
            'name'  => 'required',
            'phone' => 'required',
            'text'  => 'max:500'
        ], [
            'name.required'  => 'Не заполнено поле Имя',
            'phone.required' => 'Не заполнено поле Телефон',
            'text.max'       => 'Слишком длинное сообщение',
        ]);

        if($valid->fails()) {
            return ['errors' => $valid->messages()];
        } else {
            $feedback_data = [
                'type' => 1,
                'data' => $data
            ];
            $feedback = Feedback::create($feedback_data);
            Mail::send('mail.feedback', ['feedback' => $feedback], function ($message) use ($feedback) {
                $title = $feedback->id . ' | Вопрос с сайта | ' . $this->fromName;
                $message->from($this->fromMail, $this->fromName)
                    ->to(Settings::get('feedback_email'))
//					->to('as@klee.ru')
                    ->subject($title);
            });

            return ['success' => true];
        }
    }

    public function toCart(StockItem $stockItem) {
        Cart::addModel($stockItem);

        return [
            'header_order' => view('blocks.header_order')->render()
        ];
    }

    public function removeFromCart(StockItem $stockItem) {
        Cart::delete($stockItem->id);

        return [
            'header_order' => view('blocks.header_order')->render()
        ];
    }

    public function order() {
        $data = Request::only([
            'name', 'phone', 'email', 'text', 'cut', 'delivery', 'stock'
        ]);
        $valid = Validator::make($data, [
            'name'  => 'required',
            'phone' => 'required',
            'text'  => 'max:500'
        ], [
            'name.required'  => 'Не заполнено поле Имя',
            'phone.required' => 'Не заполнено поле Телефон',
            'text.max'       => 'Слишком длинное сообщение',
        ]);

        if($valid->fails()) {
            return ['errors' => $valid->messages()];
        } else {
            /** @var Order $order */
            $order = Order::create($data);
            foreach(Cart::getCart() as $item) {
                $order->orderItems()->create([
                    'stock_item_id' => $item['model']->id
                ]);
            }
            Cart::purge();
            return ['success' => true];
        }
    }
}
