<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserAddressRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			'province'      => 'required',
            'city'          => 'required',
            'district'      => 'required',
            'address'       => 'required',
            'zip'           => 'required',
            'contact_name'  => 'required',
            'contact_iphone' => 'required',   
        ];
    }

    public function attributes()
    {
        return [
            'province'      => '省',
            'city'          => '城市',
            'district'      => '地区',
            'address'       => '详细地址',
            'zip'           => '邮编',
            'contact_name'  => '姓名',
            'contact_iphone' => '电话', 
        ];
    }
}
