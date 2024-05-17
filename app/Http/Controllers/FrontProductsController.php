<?php

namespace App\Http\Controllers;
use DB;
use App\HomePageSection;
use App\ProductVariation;
use App\VariationsOption;
use Illuminate\Http\Request;
use App\Product;
use App\Hotdeal;
use App\Category;
use App\Models\SeoPage;
use App\Products_categories;
use App\Slider;
use Jorenvh\Share\Share;

class FrontProductsController extends Controller
{
    public function index()
    {
        $home_options = HomePageSection::latest()->first();

        if ($home_options->hotdeals) {
            $hotdeals1 = Hotdeal::with('product')
                ->with('product.product_variations')
                ->whereHas('product', function ($query) {
                    $query->where('status', 'publish');
                })
                ->orderBy('id', 'DESC')
                ->take(12)
                ->inRandomOrder()
                ->get();

            $hotdeals2 = Hotdeal::with('product')
                ->with('product.product_variations')
                ->whereHas('product', function ($query) {
                    $query->where('status', 'publish');
                })
                ->orderBy('id', 'DESC')
                ->skip(12)
                ->take(12)
                ->inRandomOrder()
                ->get();
        } else {
            $hotdeals1 = [];
            $hotdeals2 = [];
        }

        if ($home_options->section_1) {
            $latest_products = Product::with('products_categories', 'product_variations')
                ->where('status', 'publish')
                ->orderBy('id', 'DESC')
                ->groupBy('id')
                ->paginate(30);
        } else {
            $latest_products = [];
        }

        $categories = Category::where('sts', '=', 1)
            ->orderBy('id', 'ASC')
            ->get();

        $sliders = Slider::orderBy('id', 'DESC')->get();

        $seo = SeoPage::where('slug', 'home')->first();
        if ($seo) {
            perform_seo($seo);
        }

        return view('front-end.home', [
            'latest_products' => $latest_products,
            'hotdeals1' => $hotdeals1,
            'hotdeals2' => $hotdeals2,
            'categories' => $categories,
            'sliders' => $sliders,
            'home_options' => $home_options,
        ]);
    }

    public function allProduct()
    {
        $products = Product::with('products_categories', 'product_variations')
            ->where('status', 'publish')
            ->orderBy('id', 'DESC')
            ->groupBy('id')
            ->paginate(30);

        $seo = SeoPage::where('slug', 'product')->first();
        if ($seo) {
            perform_seo($seo);
        }

        return view('front-end.hotdeals', [
            'products' => $products,
        ]);
    }

    public function hotdeals()
    {
        $products = Product::with('products_categories', 'product_variations')
            ->where('status', 'publish')
            ->orderBy('id', 'DESC')
            ->paginate(40);

        return view('front-end.hotdeals', [
            'products' => $products,
        ]);
    }

    public function single($slug)
    {
        $product = Product::with('multiple_images')
            ->where('slug', $slug)
            ->first();

        $seo = SeoPage::where('slug', $slug)->first();
        if ($seo) {
            perform_seo($seo);
        }

        $category = Products_categories::select('categories.id')
            ->join('categories', 'categories.id', 'products_categories.category_id')
            ->where('products_categories.product_id', $product->id)
            ->first();

        $more = Product::select('products.*')
            ->join('products_categories', 'products_categories.product_id', 'products.id')
            ->where('products.status', 'publish')
            ->where('products_categories.category_id', $category->id)
            ->orderBy('products.id', 'DESC')
            ->take(30)
            ->get();

        $colors = ProductVariation::select('variations_options.id', 'variations_options.variation_id', 'variations_options.option')
            ->join('variations_options', 'variations_options.id', 'product_variations.variation_id')
            ->where('product_variations.product_id', $product->id)
            ->where('variations_options.variation_id', 1)
            ->get();

        $sizes = ProductVariation::select('variations_options.id', 'variations_options.variation_id', 'variations_options.option')
            ->join('variations_options', 'variations_options.id', 'product_variations.variation_id')
            ->where('product_variations.product_id', $product->id)
            ->where('variations_options.variation_id', 2)
            ->get();

        return view('front-end.product', [
            'product' => $product,
            'colors' => $colors,
            'sizes' => $sizes,
            'related' => $more,
        ]);
    }

    public function productsearch($words)
    {
        if ($words == 'null') {
            $products = Product::orderBy('id', 'DESC')
                ->take(30)
                ->get();
        } else {
            $products = Product::where('title', 'LIKE', "%{$words}%")
                ->orderBy('id', 'DESC')
                ->get();
        }

        return view('front-end.searchproduct', [
            'products' => $products,
        ]);
    }

    public function itemsbyctg($name)
    {
        $category = Category::where('slug', $name)->first();

        $products = Product::with('products_categories', 'product_variations')
            ->where('status', 'publish')
            ->whereHas('products_categories', function ($query) use ($category) {
                $query->where('category_id', $category->id);
            })
            ->orderBy('id', 'DESC')
            ->groupBy('id')
            ->paginate(30);

        $seo = SeoPage::where('slug', $name)->first();
        if ($seo) {
            perform_seo($seo);
        }
        return view('front-end.itemsbyctg', [
            'products' => $products,
            'category' => $category,
        ]);
    }

    public function latest()
    {
        $products = Product::with('products_categories', 'product_variations')
            ->where('status', 'publish')
            ->orderBy('id', 'DESC')
            ->groupBy('products.id')
            ->paginate(40);

        return view('front-end.latest_items', [
            'products' => $products,
        ]);
    }

    public function verify()
    {
        session_start();

        if (isset($_SESSION['mobileNumber'])) {
            return redirect()->route('cart');
        } else {
            return view('front-end.verify_mobile');
        }
    }

    public function send_otp(Request $request)
    {
        session_start();

        $toUser = $request->mobileNumber;
        $api_function = DB::table('sms_config')
            ->where('id', 1)
            ->first();
        $customer = DB::table('customer')
            ->where('mobile', $toUser)
            ->first();

        if (!$customer) {
            // If customer does not exist, insert new customer
            DB::table('customer')->insert([
                'mobile' => $toUser,
            ]);

            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['mobileNumber'] = $toUser;
            $curl = curl_init();
            $api_key = $api_function->api_key;
            $sender_id = $api_function->sender_id;

            $data = [
                'api_key' => $api_key,
                'msg' => 'Your Kinivalo OTP is ' . $otp . '',
                'sender_id' => $sender_id,
                'to' => $toUser,
            ];

            $post_fields = http_build_query($data);
            curl_setopt_array($curl, [
                CURLOPT_URL => $api_function->api_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $post_fields,
            ]);

            $response = curl_exec($curl);
            curl_close($curl);

            return redirect()->route('verify_otp');
        } elseif ($customer->verify == 0) {
            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['mobileNumber'] = $toUser;
            $curl = curl_init();
            $api_key = $api_function->api_key;
            $sender_id = $api_function->sender_id;

            $data = [
                'api_key' => $api_key,
                'msg' => 'Your Kinivalo OTP is ' . $otp . '',
                'sender_id' => $sender_id,
                'to' => $toUser,
            ];

            $post_fields = http_build_query($data);
            curl_setopt_array($curl, [
                CURLOPT_URL => $api_function->api_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $post_fields,
            ]);

            $response = curl_exec($curl);
            curl_close($curl);
            return redirect()->route('verify_otp');
        } else {
            $_SESSION['mobileNumber'] = $toUser;
            return redirect()->route('cart');
        }
    }

    public function verify_otp_number()
    {
        session_start();

        if (isset($_SESSION['otp'])) {
            $otp = $_SESSION['otp'];
            $mobileNumber = $_SESSION['mobileNumber'];

            return view('front-end.verify_otp', ['mobileNumber' => $mobileNumber]);
        } else {
            return redirect()->route('verify');
        }
    }

    public function otp_submit(Request $request)
    {
        session_start();

        $userOTP = $request->user_otp;
        $otp = isset($_SESSION['otp']) ? $_SESSION['otp'] : null;
        $mobileNumber = isset($_SESSION['mobileNumber']) ? $_SESSION['mobileNumber'] : null;

        if ($otp && $otp == $userOTP && $mobileNumber) {
            // Unset the 'otp' session variable
            unset($_SESSION['otp']);

            // Update the 'customer' table based on the mobile number
            DB::table('customer')
                ->where('mobile', $mobileNumber)
                ->update([
                    'verify' => 1, // Assuming 'verify' is the column you want to update
                    // Add other fields as needed
                ]);

            // Redirect to the 'cart' route
            return redirect()->route('cart');
        } else {
            // Destroy the session variables and redirect to the 'verify' route
            session_destroy();
            return redirect()->route('verify');
        }
    }
}
