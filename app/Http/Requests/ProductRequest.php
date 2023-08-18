<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'product_name' => 'required | max:20',
            'company_id' => 'required',
            'stock' => 'required | integer | min:0',
            'price' => 'required | integer | min:0',
            'comment' => 'max:1000',
        ];
    }

    public function attributes()
    {
        return [
            'product_name' => '商品名',
            'company_id' => 'メーカー名',
            'stock' => '在庫数',
            'price' => '価格',
            'comment' => 'コメント',

        ];
    }

    public function messages()
    {
        return [
            'product_name.required' => ':attributeは必須項目です。',
            'company_id.required' => ':attributeは必須項目です。',
            'stock.required' => ':attributeは必須項目です。',
            'price.required' => ':attributeは必須項目です。',
        ];
    }
}
