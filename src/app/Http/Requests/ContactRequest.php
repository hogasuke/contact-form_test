<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['nullable'],
            'last_name' => ['nullable'],
            'gender' => ['required'],
            'email' => ['required', 'email', 'max:255'],
            'tel1' => ['nullable'],
            'tel2' => ['nullable'],
            'tel3' => ['nullable'],
            'address' => ['required'],
            'category_id' => ['required'],
            'detail' => ['required', 'max:120'],
        ];
    }

    public function messages()
    {
        return [
            'gender.required' => '性別を選択してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'address.required' => '住所を入力してください',
            'category_id.required' => 'お問い合わせの種類を選択してください',
            'detail.required' => 'お問い合わせ内容を入力してください',
            'detail.max' => 'お問い合わせ内容は120文字以内で入力してください',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            # 名前のバリデーション設定
            $last_name = $this->input('last_name');
            $first_name = $this->input('first_name');

            if (empty($last_name) && empty($first_name)) {
                $validator->errors()->add('last_name', 'お名前を入力してください');
            }
            elseif (empty($last_name)) {
                $validator->errors()->add('last_name', '姓を入力してください');
            }
            elseif (empty($first_name)) {
                $validator->errors()->add('first_name', '名を入力してください');
            }

            # 電話番号のバリデーション設定
            $tel1 = $this->input('tel1');
            $tel2 = $this->input('tel2');
            $tel3 = $this->input('tel3');

            if (empty($tel1) || empty($tel2) || empty($tel3)) {
                $validator->errors()->add('tel1', '電話番号を入力してください');
            }

            if (!preg_match('/^[0-9A-Za-z]+$/', $tel1 . $tel2 . $tel3)) {
                $validator->errors()->add('tel1', '電話番号は半角英数字で入力してください');
            }

            if (strlen($tel1) >5 || strlen($tel2) >5 || strlen($tel3) >5) {
                $validator->errors()->add('tel1', '電話番号は5桁まで数字で入力してください');
            }

        });
    }
}