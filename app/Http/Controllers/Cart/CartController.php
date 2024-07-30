<?php
namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::getCartItems();
        $ids = Arr::pluck($cartItems, 'product_id');
        $products = Product::whereIn('id', $ids)->get();
        $cartItems = Arr::keyBy($cartItems, 'product_id');
        $total = 0;
        foreach ($products as $product) {
            $total += $product->price * $cartItems[$product->id]['quantity'];
        }

        return response()->json([
            'cartItems' => $cartItems,
            'products' => $products,
            'total' => $total,
        ], 200);
    }

    public function add(Request $request, Product $product)
    {
        $quantity = $request['quantity'] ?? 1;
        $user = $request->user();
        if ($user) {
            $cartItem = CartItem::where([
                'user_id' => $user->id,
                'product_id' => $product->id
            ])->first();

            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                CartItem::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                ]);
            }

            return response()->json([
                'count' => Cart::getCartItemsCount(),
                'message' => 'Product added to cart successfully',
            ]);
        } else {
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);

            if (is_array($cartItems)) {
                $productFound = false;
                foreach ($cartItems as &$item) {
                    if ($item['product_id'] == $product->id) {
                        $item['quantity'] += $quantity;
                        $productFound = true;
                        break;
                    }
                }

                if (!$productFound) {
                    $cartItems[] = [
                        'user_id' => null,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                    ];
                }

                $cookieValue = json_encode($cartItems);

            }
                $cookie =cookie('cart_items', $cookieValue, 60 * 24 * 30);

            return response()->json([
                'count' => Cart::getCountFromItems($cartItems),
                'message' => 'Product added to cart successfully',
            ])->cookie($cookie);
        }
    }


    public function remove(Request $request, Product $product)
    {
        $user = $request->user();
        if ($user) {
            $cartItem = CartItem::where([
                'user_id' => $user->id,
                'product_id' => $product->id
            ])->first();

            if ($cartItem) {
                $cartItem->delete();
            }

            return response()->json([
                'count' => Cart::getCartItemsCount(),
                'message' => 'Product removed from cart successfully',
            ]);
        } else {
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);
            foreach ($cartItems as $i => $item) {
                if ($item['product_id'] == $product->id) {
                    array_splice($cartItems, $i, 1);
                    break;
                }
            }

            $cookie =cookie('cart_items', json_encode($cartItems), 60 * 24 * 30);

            return response()->json([
                'count' => Cart::getCountFromItems($cartItems),
                'message' => 'Product removed from cart successfully',
            ])->cookie($cookie);;
        }
    }

    public function updateQuantity(Request $request, Product $product)
    {
        $quantity = (int)$request['quantity'];
        $user = $request->user();
        if ($user) {
            CartItem::where([
                'user_id' => $user->id,
                'product_id' => $product->id
            ])->update([
                'quantity' => $quantity
            ]);

            return response()->json([
                'count' => Cart::getCartItemsCount(),
                'message' => 'Product quantity updated successfully',
            ]);
        } else {
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);
            foreach ($cartItems as &$item) {
                if ($item['product_id'] == $product->id) {
                    $item['quantity'] = $quantity;
                    break;
                }
            }

            $cookie =cookie('cart_items', json_encode($cartItems), 60 * 24 * 30);

            return response()->json([
                'count' => Cart::getCountFromItems($cartItems),
                'message' => 'Product quantity updated successfully',
            ])->cookie($cookie);;
        }
    }

}
