<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontEndController extends Controller
{
    public function home()
    {
        $datas = Service::with('category')->orderBy('service_name', 'asc')->get();

        return view('frontend.home', compact('datas'));
    }

    public function detail(Request $request, Service $service)
    {
        $data = $service;

        return view('frontend.detail', compact('data'));
    }

    public function cart(Request $request)
    {
        $cart = $request->session()->get('cart');

        if (!$cart) {
            $cart = array();
        }

        for ($i = 0; $i < count($cart); $i++) {
            $cart[$i]['service'] = Service::find($cart[$i]['id']);
        }

        return view('frontend.cart', compact('cart'));
    }

    public function putCart(Request $request, Service $service)
    {
        $cart = $request->session()->get('cart');

        if (!$cart) {
            $cart = array();
        }

        $idx = -1;
        for ($i = 0; $i < count($cart); $i++) {
            if ($cart[$i]['id'] == $service->id) {
                $idx = $i;
            }
        }

        if ($idx < 0) {
            $cart[] = ['id' => $service->id, 'quantity' => $request->quantity];
        } else {
            $cart[$idx]['quantity'] = $request->quantity;
        }

        $request->session()->put('cart', $cart);

        return redirect('/cart')->with('status', 'Service berhasil ditambahkan ke cart!');
    }

    public function deleteCart(Request $request, Service $service)
    {
        $cart = $request->session()->get('cart');

        if (!$cart) {
            $cart = array();
        }

        $idx = -1;
        for ($i = 0; $i < count($cart); $i++) {
            if ($cart[$i]['id'] == $service->id) {
                $idx = $i;
            }
        }

        if ($idx >= 0) {
            array_splice($cart, $idx, 1);
        }

        $request->session()->put('cart', $cart);

        return redirect('/cart')->with('status', 'Service berhasil dihapus dari cart!');
    }

    public function checkout(Request $request)
    {
        $cart = $request->session()->get('cart');

        if (!$cart) {
            return redirect()->back()->with('status', 'Cart masih kosong!');
        }

        $transaction = Transaction::createFromCart($cart);

        foreach ($cart as $r) {
            $transaction->services()->attach($r['id'], ['quantity' => $r['quantity']]);
        }

        $request->session()->forget('cart');

        return redirect('/cart')->with('status', 'Checkout berhasil! Transaksi telah disimpan.');
    }
}