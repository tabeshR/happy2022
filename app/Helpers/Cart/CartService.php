<?php


namespace App\Helpers\Cart;


use App\Models\Discount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CartService
{
    protected $cart;

    public function __construct()
    {
        $this->cart = session()->get('cart') ?: collect([
            'items' => [],
            'discount_code' => null
        ]);
    }

    public function count()
    {
        return collect($this->cart['items'])->count();
    }

    public function add(array $array, Model $model = null)
    {
        if (!is_null($model) && $model instanceof Model) {
            if ($model->inventory < 1) {
                return false;
            }
            $array = array_merge($array, [
                'id' => Str::random(10),
                'subject_id' => $model->id,
                'subject_type' => get_class($model),
                'discount_percent' => 0
            ]);
        } elseif (!isset($array['id'])) {
            $array = array_merge($array, [
                'id' => Str::random(10),
            ]);
        }
        $this->cart['items'] = collect($this->cart['items'])->put($array['id'], $array);
        session()->put('cart', $this->cart);
        return $this;
    }

    public function get($key)
    {
        $item = $key instanceof Model ? collect($this->cart['items'])->where('subject_id', $key->id)->where('subject_type', get_class($key))->first() : collect($this->cart['items'])->where('id', $key->id)->first();
        return $this->get_relationship($item);
    }

    public function has($key)
    {
        $item = $this->get($key);
        return !is_null($item);
    }

    public function all()
    {
        return collect($this->cart['items'])->map(function ($item) {
            $item = $this->get_relationship($item);
            $item = $this->checkDiscountValidate($item, $this->cart['discount_code']);
            return $item;
        });
    }

    protected function get_relationship($model)
    {
        if (isset($model['subject_id']) && isset($model['subject_type'])) {
            $class = $model['subject_type'];
            $obj = (new $class())->find($model['subject_id']);
            $model[strtolower(class_basename($class))] = $obj;
        }
        return $model;
    }

    public function update($key, $option)
    {
        $item = $this->get($key);
        if (is_numeric($option)) {
            if ($item['quantity'] + 1 > $item['product']->inventory) {
                return false;
            }
            $item = collect($item)->merge([
                'quantity' => $item['quantity'] + 1
            ]);
        } else if (is_object($option)) {
            if ($item['product']->inventory < $option->quantity) {
                return false;
            }
            $item = collect($item)->merge(['quantity' => $option->quantity]);
        }
        $this->add($item->toArray());
        return $this;
    }

    public function deleteItem($key)
    {
        $this->cart['items'] = collect($this->cart['items'])->filter(function ($item) use ($key) {
            return $item['id'] != $key->id;
        });
        session()->put('cart', $this->cart);
    }

    public function flush()
    {
        $this->cart = collect([
            'items' => [],
            'discount_code' => null
        ]);
    }

    public function addDiscount($discount_code)
    {
        $this->cart['discount_code'] = $discount_code;
        session()->put('cart', $this->cart);
    }

    private function checkDiscountValidate($item, $discount_code)
    {
        if($discount_code){
            $discount = Discount::whereCode($discount_code)->first();
            if(!$discount->products->count() || in_array($discount->id,$item['product']->discounts->pluck('id')->toArray())){
                $item['discount_percent'] = $discount->percent / 100;
            }
        }
        return $item;
    }
}
