<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Models\Product;



class ProductController extends Controller

{

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function index()

    {

        $products = Product::all();

        return view('products', compact('products'));
    }



    /**

     * Write code on Method

     *

     * @return response()

     */

    public function cart()

    {

        return view('cart');
    }



    /**

     * Write code on Method

     *

     * @return response()

     */

    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->id);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->id])) {
            $cart[$request->id]['quantity']++;
        } else {
            $cart[$request->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);

        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        $cartCount = count($cart);
        $cartItems = array_values($cart); // Convert associative array to indexed array

        return response()->json([
            'message' => 'Product added to cart successfully!',
            'cartCount' => $cartCount,
            'cartTotal' => $total,
            'cartItems' => $cartItems
        ]);
    }




    /**

     * Write code on Method

     *

     * @return response()

     */

    public function update(Request $request)

    {

        if ($request->id && $request->quantity) {

            $cart = session()->get('cart');

            $cart[$request->id]["quantity"] = $request->quantity;

            session()->put('cart', $cart);

            session()->flash('success', 'Cart updated successfully');
        }
    }



    /**

     * Write code on Method

     *

     * @return response()

     */

    public function remove(Request $request)

    {

        if ($request->id) {

            $cart = session()->get('cart');

            if (isset($cart[$request->id])) {

                unset($cart[$request->id]);

                session()->put('cart', $cart);
            }

            session()->flash('success', 'Product removed successfully');
        }
    }
}
