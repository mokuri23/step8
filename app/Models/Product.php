<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;



class Product extends Model
{

    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'company_id',
        'product_name',
        'price',
        'stock',
        'comment',
        'img_path',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // 一覧表示
    public function index()
    {
        $products = DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->select('products.*', 'companies.company_name')
            ->paginate(10);
        return $products;
    }

    // 登録
    public function store($data, $img_path)
    {
        $this->product_name = $data['product_name'];
        $this->company_id = $data['company_id'];
        $this->price = $data['price'];
        $this->stock = $data['stock'];
        $this->comment = $data['comment'];

        if ($img_path) {
            $original = $img_path->getClientOriginalName();
            $name = date('Ymd_His') . '_' . $original;
            $img_path->move('storage/image', $name);
            $this->img_path = $name;
        }

        $this->save();
    }

    // 詳細
    public function detail($id)
    {
        $products = DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->select('products.*', 'companies.company_name')
            ->where('products.id', $id)
            ->first();
        return $products;
    }


    // 更新
    public function updateData($id, $data, $img_path)
    {
        $products = Product::find($id);
        $products->product_name = $data['product_name'];
        $products->company_id = $data['company_id'];
        $products->price = $data['price'];
        $products->stock = $data['stock'];
        $products->comment = $data['comment'];

        if ($img_path) {
            $original = $img_path->getClientOriginalName();
            $name = date('Ymd_His') . '_' . $original;
            $img_path->move('storage/image', $name);
            $products->img_path = $name;
        }

        $products->save();
    }

    // 削除
    public function deleteProduct($id)
    {
        DB::table('products')->delete($id);
    }

    // 検索
    public function getProductSearch($searchProduct, $searchCompany, $min_price, $max_price, $min_stock, $max_stock)
    {
        $products = DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->select('products.*', 'companies.company_name');

        if ($searchProduct) {
            $products->where('product_name', 'like', '%' . $searchProduct . '%');
        }

        if ($searchCompany) {
            $products->where('companies.id', $searchCompany);
        }


        if ($min_price) {
            $products->where('products.price', '>=', $min_price);
        }

        if ($max_price) {
            $products->where('products.price', '<=', $max_price);
        }

        if ($min_stock) {
            $products->where('products.stock', '>=', $min_stock);
        }

        if ($max_stock) {
            $products->where('products.stock', '<=', $max_stock);
        }

        return $products->paginate(10);
    }
}
