<?php

namespace App\Http\Controllers;

use App\ProductVariation;
use App\Variation;
use App\VariationsOption;
use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Hotdeal;
use App\Models\ProductImg;
use App\Products_categories;
use Illuminate\Support\Facades\Auth;
use Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use App\Models\SeoPage;
use Illuminate\Support\Facades\URL;

class BackProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['products'] = Product::with('order_details')
            ->latest()
            ->paginate(10);
        return view('back-end.products', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::whereNull('mctg')->get();
        $variations = Variation::all();

        return view('back-end.addproduct', [
            'categories' => $categories,
            'variations' => $variations,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::check()) {
            request()->validate([
                'name' => 'required|min:3',
                'slug' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('products', 'slug')->ignore($request->id), // Ignore the current record when updating
                ],
                'img1' => 'required|image|mimes:jpeg,jpg,png,gif,svg,webp|max:2048',
                'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'rprice' => 'numeric',
                'sprice' => 'required',
                'appprice' => 'nullable',
                'long_description' => 'required|string',
                'meta_title' => 'required|string',
                'meta_description' => 'required|string',
            ]);

            $seo = new SeoPage();

            $seo->title = $request->meta_title;
            $seo->slug = createSlug($request->slug);
            $seo->description = $request->meta_description;
            $seo->type = 'product';
            $seo->created_by = Auth::id();
            $seo->save();

            $pdate = date('Y-m-d');

            $imgUrl1 = null;
            if ($request->img1) {
                $img1 = $request->file('img1');
                $imgUrl1 = $this->save_image($img1, 1);
            }

            $product = new Product();

            $product->title = $request->name;
            $product->pcode = $request->pcode;
            $product->slug = createSlug($request->slug);
            $product->phone = $request->phone;
            $product->bkash = $request->bkash;
            $product->long_description = $request->long_description;
            $product->rprice = $request->rprice;
            $product->sprice = $request->sprice;
            $product->appprice = $request->appprice;
            $product->qty = $request->qty;
            $product->img1 = $imgUrl1;
            $product->video = $request->video;
            $product->product_video = $request->product_video;
            $product->pdate = $pdate;
            $product->status = $request->action;
            $product->sts = 1;
            $product->created_by = Auth::id();

            $product->save();

            $product_id = $product->id;

            if ($request->file('photos')) {
                foreach ($request->file('photos') as $file) {
                    $imagePath = $this->save_image($file, 0);
                    $productImage = new ProductImg();
                    $productImage->product_id = $product_id;
                    $productImage->image = $imagePath;
                    $productImage->created_by = Auth::id();
                    $productImage->save();
                }
            }

            $ctgs = $request->pr_ctg;
            $totalctg = count($ctgs);

            $variations = $request->variations;
            $total_options = $request->has('variations') ? count($variations) : 0;

            if ($request->has('hot')) {
                $hotdeal = new Hotdeal();
                $hotdeal->product_id = $product_id;
                $hotdeal->sts = 1;
                $hotdeal->save();
            }

            for ($i = 0; $i < $totalctg; $i++) {
                $product_ctg = new Products_categories();
                $product_ctg->product_id = $product_id;
                $product_ctg->category_id = $ctgs[$i];
                $product_ctg->save();
            }

            if ($total_options) {
                for ($i = 0; $i < $total_options; $i++) {
                    $product_options = new ProductVariation();
                    $product_options->product_id = $product_id;
                    $product_options->variation_id = $variations[$i];
                    $product_options->save();
                }
            }

            $colors = $request->input('color_name');
            $prices = $request->input('color_price');
            $quantities = $request->input('color_quantity');
            $photos = $request->file('color_photo');

            if (is_array($colors) && is_array($prices) && is_array($quantities) && is_array($photos)) {
                DB::beginTransaction();

                try {
                    foreach ($colors as $key => $color) {
                        $photo = $photos[$key];
                        $price = $prices[$key];
                        $quantity = $quantities[$key];

                        if ($photo && $price !== null && $quantity !== null) {
                            $this->processColor($product_id, $color, $photo, $price, $quantity);
                        }
                    }

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                }
            }
            $message = [
                'success' => 'Success!! New Product added successfully.',
            ];

            return response()->json($message);
        }
        $message = [
            'error' => 'Success!! New Product added successfully.',
        ];
        return back()->with($message);
    }

    private function processColor($product_id, $color, $photo, $price, $quantity)
    {
        $extension = $photo->getClientOriginalExtension();
        $filename = 'color_' . time() . '_' . uniqid() . '.' . $extension;
        $folder = 'public/image/color_photo/';
        $photo->move($folder, $filename);
        $photoName = pathinfo($filename, PATHINFO_BASENAME);

        try {
            // Insert into the database
            DB::table('product_color')->insert([
                'product_id' => $product_id,
                'color_name' => $color,
                'color_photo' => $photoName,
                'color_price' => $price,
                'color_quantity' => $quantity,
            ]);
        } catch (\Exception $e) {
            // Handle the exception (log or show an error message)
            // Don't throw the exception here unless you want to stop further execution
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function save_image($img, $thumbnail)
    {
        $image = $img;
        $image_name = 'item_' . rand(100, 999) . '_' . time() . '.' . $image->getClientOriginalExtension();
        $folder = 'public/image/product_image/';
        $new_img = Image::make($image->getRealPath());

        $new_img
            ->resize(800, 800, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save($folder . $image_name);
        if ($thumbnail) {
            $folder = 'public/image/product_image/thumbnail/';
            $new_img
                ->resize(200, 200, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save($folder . $image_name);
        }
        return $image_name;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::where('id', $id)->first();
        $hotdeal = Hotdeal::where('product_id', $id)->first();
        $categories = Category::whereNull('mctg')->get();
        $variations = Variation::all();

        $hot = null;

        if ($hotdeal) {
            $hot = 1;
        }

        $category = Products_categories::select('categories.id')
            ->join('categories', 'categories.id', 'products_categories.category_id')
            ->where('products_categories.product_id', $id)
            ->get();

        $ctgs = [];
        foreach ($category as $key => $ctg) {
            $ctgs[$key] = $ctg->id;
        }

        $variation = ProductVariation::where('product_id', $id)->get();

        $ops = [];
        foreach ($variation as $key => $option) {
            $ops[$key] = $option->variation_id;
        }
        //dd($ops);

        return view('back-end.editproduct', [
            'product' => $product,
            'hotdeal' => $hot,
            'ctgs' => $ctgs,
            'ops' => $ops,
            'variations' => $variations,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::check()) {
            request()->validate([
                'name' => 'required|min:3',
                'slug' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('products', 'slug')->ignore($id), // Ignore the current record when updating
                ],
                'img1' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg,webp|max:2048',
                'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'rprice' => 'numeric',
                'sprice' => 'required',
                'appprice' => 'nullable',
                'long_description' => 'required|string',
            ]);

            $folder = 'public/image/product_image/';
            $product = Product::find($id);

            $imgUrl1 = $product->img1;
            if ($request->file('img1')) {
                File::delete('public/image/product_image/thumbnail/' . $imgUrl1);
                $img1 = $request->file('img1');
                $imgUrl1 = $this->save_image($img1, 1);
            }

            $product->title = $request->name;
            $product->pcode = $request->pcode;
            $product->slug = $request->slug;
            $product->phone = $request->phone;
            $product->bkash = $request->bkash;
            $product->long_description = $request->long_description;
            $product->rprice = $request->rprice;
            $product->sprice = $request->sprice;
            $product->appprice = $request->appprice;
            $product->qty = $request->qty;
            $product->img1 = $imgUrl1;
            $product->video = $request->video;
            $product->product_video = $request->product_video;
            $product->updated_by = Auth::id();

            $product->save();
            $product_id = $product->id;

            if ($request->file('photos')) {
                foreach ($request->file('photos') as $file) {
                    ProductImg::where('product_id', $product_id)->delete();
                    $imagePath = $this->save_image($file, 0);
                    $productImage = new ProductImg();
                    $productImage->product_id = $product_id;
                    $productImage->image = $imagePath;
                    $productImage->updated_by = Auth::id();
                    $productImage->save();
                }
            }
            Products_categories::where('product_id', $id)->delete();
            ProductVariation::where('product_id', $id)->delete();
            Hotdeal::where('product_id', $id)->delete();

            $ctgs = $request->pr_ctg;
            $totalctg = count($ctgs);

            $variations = $request->variations;
            $total_options = $request->has('variations') ? count($variations) : 0;

            if ($request->has('hot')) {
                $hotdeal = new Hotdeal();
                $hotdeal->product_id = $product_id;
                $hotdeal->sts = 1;
                $hotdeal->save();
            }

            for ($i = 0; $i < $totalctg; $i++) {
                $product_ctg = new Products_categories();
                $product_ctg->product_id = $product_id;
                $product_ctg->category_id = $ctgs[$i];
                $product_ctg->save();
            }

            if ($total_options > 0) {
                for ($i = 0; $i < $total_options; $i++) {
                    $product_options = new ProductVariation();
                    $product_options->product_id = $product_id;
                    $product_options->variation_id = $variations[$i];
                    $product_options->save();
                }
            }

            $colors = $request->input('color_name');
            $prices = $request->input('color_price');
            $quantities = $request->input('color_quantity');
            $photos = $request->file('color_photo');

            if (is_array($colors) && is_array($prices) && is_array($quantities) && is_array($photos)) {
                DB::beginTransaction();

                try {
                    foreach ($colors as $key => $color) {
                        $photo = $photos[$key];
                        $price = $prices[$key];
                        $quantity = $quantities[$key];

                        if ($photo && $price !== null && $quantity !== null) {
                            $this->processColor($product_id, $color, $photo, $price, $quantity);
                        }
                    }

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                }
            }

            return back()->with('msg-success', 'Success!! Product info updated successfully.');
        }
        return back()->with('msg-error', 'Opps!! Something wrong, please try again.');
    }

    public function destroy_color($id)
    {
        $color = DB::table('product_color')
            ->where('id', $id)
            ->first();

        if ($color) {
            // Get the filename from the color_name column
            $filename = $color->color_photo;

            // Delete the record from the database
            DB::table('product_color')
                ->where('id', $id)
                ->delete();

            $color_img = 'image/color_photo/' . $filename;

            if (file_exists($color_img)) {
                unlink($color_img);

                return redirect()
                    ->back()
                    ->with('success', 'Color deleted successfully.');
            } else {
                return redirect()
                    ->back()
                    ->with('error', 'Color image not found.');
            }
        } else {
            return redirect()
                ->back()
                ->with('error', 'Color not found.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::check()) {
            $product = Product::find($id);
            $imgUrl1 = $product->img1;
            File::delete('public/image/product_image/thumbnail/' . $imgUrl1);
            Products_categories::where('product_id', $id)->delete();
            Hotdeal::where('product_id', $id)->delete();
            $product->delete();
            return back()->with('msg-success', 'Success!! Product info updated successfully.');
        }
        return back()->with('msg-error', 'Opps!! Something wrong, please try again.');
    }

    public function productGallary($product_id)
    {
        $data['product'] = Product::with('multiple_images')->findOrFail($product_id);
        $data['multiple_images'] = ProductImg::where('product_id', $product_id)->paginate();
        return view('back-end.product_gallary', $data);
    }

    public function productGallaryUpdate(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg,webp|max:2048',
        ]);

        if ($request->file('image')) {
            $imagePath = $this->save_image($request->file('image'), 0);
            $productImage = ProductImg::findOrFail($request->id);
            File::delete( URL::to("/image/product_image/$productImage->image"));
            $productImage->product_id = $request->product_id;
            $productImage->image = $imagePath;
            $productImage->updated_by = Auth::id();
            $productImage->save();
        }

        return response()->json([
            'success' => "Image uploaded"
        ]);
    }

    public function productGallaryDelete($image_id)
    {
        ProductImg::findOrFail($image_id)->delete();
        return redirect()->back();
    }

    public function productGallaryAdd(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg,webp|max:2048',
        ]);

        if ($request->file('image')) {
            $imagePath = $this->save_image($request->file('image'), 0);
            $productImage = new ProductImg();
            $productImage->product_id = $request->product_id;
            $productImage->image = $imagePath;
            $productImage->created_by = Auth::id();
            $productImage->save();
        }

        return response()->json([
            'success' => "Image uploaded"
        ]);
    }
}
