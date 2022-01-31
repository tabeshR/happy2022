<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment as ShetabitPayment;

class PaymentController extends Controller
{
    public function redirect()
    {
        $carts = \Cart::all();
        if (!\Cart::count()) {
            return back();
        }
        $total = $carts->sum(function ($cart) {
            $discount = $cart['discount_percent'] ? $cart['discount_percent'] * $cart['product']->price : 0;
            return $cart['quantity'] * ($cart['product']->price - $discount);
        });
        $order = auth()->user()->orders()->create([
            'status' => 'unpaid',
            'price' => $total
        ]);
        \Cart::all()->map(function ($cart) use ($order) {
            $order->products()->attach($cart['product']->id, [
                'quantity' => $cart['quantity'],
                'price' => $cart['product']->price
            ]);
        });

        return ShetabitPayment::callbackUrl(route('payment.callback'))->purchase(
            (new Invoice)->amount($total),
            function ($driver, $transactionId) use ($order, $total) {
                $order->payments()->create([
                    'res_number' => $transactionId,
                    'price' => $total
                ]);
            }
        )->pay()->render();
    }

    public function verify(Request $request)
    {
        $payment = Payment::where('res_number', $request->Authority)->first();
        if (!$payment) throw new \Exception('کد نامعتبر است');
        try {
            $receipt = ShetabitPayment::amount($payment->price)->transactionId($request->Authority)->verify();
            $payment->update([
                'status' => true
            ]);
            $payment->order()->update([
                'tracking_serial' => $receipt->getReferenceId(),
                'status' => 'paid'
            ]);
            \Cart::all()->map(function ($cart){
                $product = Product::find($cart['product']->id);
                $product->update([
                    'inventory' => $product->inventory - $cart['quantity']
                ]);
            });
            \Cart::flush();
            // You can show payment referenceId to the user.
            alert()->success("خرید شما با موفقیت انجام شد و کد رهگیری شما {$receipt->getReferenceId()} میباشد")->persistent('باشه');
            return redirect(route('products.index'));

        } catch (\Exception $exception) {
            $payment->order()->delete();
            /**
             * when payment is not verified, it will throw an exception.
             * We can catch the exception to handle invalid payments.
             * getMessage method, returns a suitable message that can be used in user interface.
             **/
          alert()->error($exception->getMessage())->persistent();
          return redirect('/cart');
        }
    }
}
