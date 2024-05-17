<?php
namespace App;

use Illuminate\Support\Collection;

class Cart
{
  public static function add($product_data = [])
  {
      $product_id = $product_data['id'];
      $product_options = $product_data['options'] ?? [];
  
      $cart = self::content();
  
      // Generate a unique cart key based on product ID, size, and color
      $cart_key = $product_id;
  
      // Include size in the cart key if present
      if (isset($product_options['size'])) {
          $cart_key .= '_size_' . $product_options['size'];
      }
  
      // Include color in the cart key if present
      if (isset($product_options['color'])) {
          $cart_key .= '_color_' . $product_options['color'];
      }
  
      // If cart is empty or item doesn't exist, add it to the cart
      if (!$cart || !isset($cart[$cart_key])) {
          $cart[$cart_key] = $product_data;
      } else {
          // If item already exists, update the quantity
          $cartItem = $cart[$cart_key];
          $quantity = intval($cartItem['qty']);
          $productQty = intval($product_data['qty']);
          $updatedQuantity = $quantity + $productQty;
  
          $cartItem['qty'] = $updatedQuantity;
          $cart[$cart_key] = $cartItem;
      }
  
      // Update the session with the modified cart
      session()->put('cart', $cart);
  
      return $cart;
  }
  

//   public static function add($product_data = [])
// {
//     $product_id = $product_data['id'];
//     $product_options = $product_data['options'] ?? []; // Use the null coalescing operator to handle the case when 'options' is not present

//     $cart = self::content();

//     // If cart is empty, then this is the first product
//     if (!$cart) {
//         $cart_key = $product_id;
//         if (isset($product_options['color'])) {
//             $cart_key .= '_' . $product_options['color'];
//         }

//         $cart = [
//             $cart_key => $product_data
//             // Rest of the items from the controller
//         ];
//         session()->put('cart', $cart);
//         return $cart;
//     }

//     // If cart is not empty, check if the product with the same color exists and increment the quantity
//     $cart_key = $product_id;
//     if (isset($product_options['color'])) {
//         $cart_key .= '_' . $product_options['color'];
//     }

//     if (isset($cart[$cart_key])) {
//         $cartItem = $cart[$cart_key];
//         $quantity = intval($cartItem['qty']);
//         $productQty = intval($product_data['qty']);
//         $updatedQuantity = $quantity + $productQty;

//         $cartItem['qty'] = $updatedQuantity;
//         $cart[$cart_key] = $cartItem;

//         session()->put('cart', $cart);
//         return $cart;
//     }

//     // If item does not exist in the cart, add it with quantity = 1
//     $cart[$cart_key] = $product_data;

//     session()->put('cart', $cart);

//     return $cart;
// }


  // public static function add($product_data = [])
  // {
  //     $product_id = $product_data['id'];
  //     $product_options = $product_data['options']; // Assuming 'options' is a key in your $product_data array
  
  //     $cart = self::content();
  
  //     // If cart is empty, then this is the first product
  //     if (!$cart) {
  //         $cart = [
  //             $product_id . '_' . $product_options['color'] => $product_data
  //             // Rest of the items from controller
  //         ];
  //         session()->put('cart', $cart);
  //         return $cart;
  //     }
  
  //     // If cart is not empty, check if the product with the same color exists and increment the quantity
  //     $cart_key = $product_id . '_' . $product_options['color'];
  //     if (isset($cart[$cart_key])) {
  //         $cartItem = $cart[$cart_key];
  //         $quantity = intval($cartItem['qty']);
  //         $productQty = intval($product_data['qty']);
  //         $updatedQuantity = $quantity + $productQty;
  
  //         $cartItem['qty'] = $updatedQuantity;
  //         $cart[$cart_key] = $cartItem;
  
  //         session()->put('cart', $cart);
  //         return $cart;
  //     }
  
  //     // If item does not exist in the cart, add it with quantity = 1
  //     $cart[$cart_key] = $product_data;
  
  //     session()->put('cart', $cart);
  
  //     return $cart;
  // }
  

  // public static function add($product_data = [])
  // {
  //     $product_id = $product_data['id'];

  //     $cart = self::content();

  //     // If cart is empty, then this is the first product
  //     if (!$cart) {
  //         $cart = [
  //           $product_id => 
  //             $product_data

  //             // below items from controller 
  //             // 'id' => $product->id,
  //             // 'name' => $product->name,
  //             // 'qty' => $product->quantity,
  //             // 'price' => $product->selling_price,
  //             // 'thumbnail' => $product->thumbnail
            
  //         ];
  //         session()->put('cart', $cart);
  //         return $cart;
  //     }

  //     // If cart is not empty, check if the product exists and increment the quantity
  //     if (isset($cart[$product_id])) {
  //       $cartItem = $cart[$product_id];
  //       $quantity = intval($cartItem['qty']);
  //       $productQty = intval($product_data['qty']);
  //       $updatedQuantity = $quantity + $productQty;
    
  //       $cartItem['qty'] = $updatedQuantity;
  //       $cart[$product_id] = $cartItem;
        
  //       session()->put('cart', $cart);
  //       return $cart;
  //     }

  //     // If item does not exist in the cart, add it with quantity = 1
  //     $cart[$product_id] = $product_data;

  //     session()->put('cart', $cart);

  //     return $cart;
  // }

  // public static function addVariant($product_data = [], $color_id = null)
  // {
  //   $product_id = $product_data['id'];
  //   $cart = self::content();

  //   $cart->push([
  //     'id' => $product_id,
  //     'name' => $product_data['name'],
  //     'qty' => $product_data['qty'],
  //     'price' => $product_data['price'],
  //     'weight' => 0,
  //     'options' => ['color' => $color_id],
  // ]);

  //   // Update the session with the modified cart
  //   session()->put('cart', $cart);

  //   return $cart;
  // }
  
  public static function update($id, $qty)
  {
      $cart = session()->get('cart');
      $cartItem = $cart[$id];
      $quantity = intval($qty);
      $cartItem['qty'] = $quantity;
      $cart[$id] = $cartItem;
      
      session()->put('cart', $cart);
      return $cart;
  }

  public static function find($id)
  {
    $cart = session()->get('cart');
    $cartItem = $cart[$id] ?? [];
    return $cartItem;
  }

  public static function total($id)
  {
    $cart = session()->get('cart');
    $cartItem = $cart[$id];
    $total = $cartItem['qty'] * $cartItem['price'];
    return $total;
  }
  
  public static function remove($id)
  {
    if($id) {
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return response()->json($cart);
    }
  }

  public static function subtotal()
  {
      $subtotal = 0;
        if (session()->get('cart') != null) {
            foreach (session()->get('cart') as $product_data) {
                $quantity = $product_data['qty'];
                $price = $product_data['price'];
                $subtotal += $quantity * $price;
            }
        }
        return $subtotal;
  }

  public static function count()
  {
      $count = 0;
      if (session()->get('cart') != null) {
        foreach (session()->get('cart') as $product_data) {
            $count += $product_data['qty'];
        }
      }
      return $count;
  }
  public static function forget()
  {
    return session()->forget('cart');
  }

  public static function content()
  {
    if (session()->get('cart') === null) {
      return [];
    }
  
    return collect(session()->get('cart'));
  }
}
