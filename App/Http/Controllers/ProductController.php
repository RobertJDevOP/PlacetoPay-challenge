<?php

namespace App\Http\Controllers;

use App\Http\Request\Products\IndexRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use App\ViewModels\Products\IndexViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(IndexViewModel $viewModel): View
    {
        //Aplicar patron repositorio y decorador para el cache.
        $products=Product::select('id','product_name','url_product_img','price','category_id','created_at',
            'updated_at','enabled_at','list_price')->with('category')
            ->paginate(5);
        $viewModel->collection($products);

        return view('products.index', $viewModel->toArray());
    }

    public function categories(ProductCategory $candy)
    {
        $data = $candy->all();
        return view('products.create')->with('candies', $data);
    }

    public function statusProduct(int $id,Request $request): RedirectResponse
    {
        $statusProduct = $request->input('validation');
        $product = Product::where('id', $id)->firstOrFail();

        ('enabled'===$statusProduct) ?
            $product->markAsDisabled()
            :
            $product->markAsEnabled();

        return redirect('/products')->with('success',Lang::get('messages.productStatus'));
    }

    public function create(IndexRequest $request)
    {

        $image = $request->file('url_product_img');
        $fileName = time().'.'.$image->getClientOriginalExtension();

        $image->storeAs('public/images',$fileName);

        $product = Product::create([
            'product_name' => $request->input('product_name'),
            'category_id' =>$request->input('category_id'),
            'list_price' => $request->input('list_price'),
            'price' =>$request->input('price'),
            'url_product_img' => $fileName
        ]);

        $product->markAsEnabled();

        return back()
            ->with('success','Image has successfully uploaded.')
            ->with('fileName',$fileName);
    }
}
