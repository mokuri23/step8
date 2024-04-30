<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\Company;
use App\Models\Sale;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;






class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // 商品一覧画面
    public function index()
    {
        $product_model = new Product();
        $company_model = new Company();
        $products = $product_model->index();
        $companies = $company_model->index();
        return view('index', ['products' => $products, 'companies' => $companies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  新規登録画面
    public function create()
    {
        $company_model = new Company();
        $companies = $company_model->index();
        return view('create', ['companies' => $companies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // 登録
    public function store(ProductRequest $request)
    {
        $data = $request->all();
        $img_path = $request->file('img_path');
        DB::beginTransaction();

        try {
            $product_model = new Product();
            $product_model->store($data, $img_path);
            DB::commit();
            return redirect()->route('index')->with('success', config('message.create_success'));
        } catch (\Exception $e) {
            return redirect()->route('index')->with('success', config('message.create_fail'));
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //  詳細画面
    public function show($id)
    {
        $product_model = new Product();
        $product = $product_model->detail($id);

        return view('show', ['product' => $product]);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // 編集画面
    public function edit($id)
    {
        $product_model = new Product();
        $company_model = new Company();
        $product = $product_model->detail($id);
        $companies = $company_model->index();

        return view('edit', ['product' => $product, 'companies' => $companies]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //  更新
    public function update(ProductRequest $request, $id)
    {
        $data = $request->all();
        $img_path = $request->file('img_path');
        DB::beginTransaction();

        try {
            $product_model = new Product();
            $product_model->updateData($id, $data, $img_path);
            DB::commit();
            return redirect()->route('index')->with('success', config('message.update_success'));
        } catch (\Exception $e) {
            return redirect()->route('index')->with('success', config('message.update_fail'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //  削除

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            Product::find($id)->sales()->delete();
            Product::find($id)->delete();
            DB::commit();
            return response()->json([
                'message' => '商品が削除されました。'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return response()->json([
                'message' => '商品の削除に失敗しました。'
            ]);
        }
    }

    // 検索
    public function search(Request $request)
    {
        $search_product = $request->input('keyword');
        $search_company = $request->input('company');
        $min_price = $request->input('min_price');
        $max_price = $request->input('max_price');
        $min_stock = $request->input('min_stock');
        $max_stock = $request->input('max_stock');
        DB::beginTransaction();

        try {
            $product_model = new Product();
            $company_model = new Company();
            $companies = $company_model->index();
            $products = $product_model->getProductSearch($search_product, $search_company, $min_price, $max_price, $min_stock, $max_stock);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }

        return response()->json($products);
    }

    // 購入
    public function cart($id)
    {
        $sale_model = new Sale();
        $product = $sale_model->detail($id);
        return view('cart', ['product' => $product]);
    }

    public function purchase(Request $request, $id)
    {
        $quantity = $request->input('quantity');
        DB::beginTransaction();

        try {
            $sale_model = new Sale();
            $message = $sale_model->purchase($quantity, $id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }

        return response()->json([
            'message' => $message
        ]);
    }
}
