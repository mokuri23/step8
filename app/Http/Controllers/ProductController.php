<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\Company;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;




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
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }

        return redirect()->route('index')->with('success', config('message.create_success'));
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
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }

        return redirect()->route('index')->with('success', config('message.update_success'));
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
            $model = new Product();
            $product = $model->deleteProduct($id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }

        return redirect()->route('index')->with('success', config('message.delete_success'));
    }

    // 検索
    public function search(Request $request)
    {
        $search_product = $request->input('keyword');
        $search_company = $request->input('company');
        DB::beginTransaction();

        try {
            $product_model = new Product();
            $company_model = new Company();
            $companies = $company_model->index();
            $products = $product_model->getProductSearch($search_product, $search_company);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }

        return view('index', ['products' => $products, 'companies' => $companies]);
    }
}
