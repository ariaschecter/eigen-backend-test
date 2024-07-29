<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules() : array
    {
        $book = $this->route()->parameter('book');

        return [
            'code'                 => ['required', Rule::unique('m_books', 'code')->withoutTrashed()->ignore(@$book->id)],
            'title'                => 'required',
            'author'               => 'required',
            'stock'                => 'required|numeric',
            'admin_email_personal' => ['nullable', 'email', 'max:128',],
        ];
    }
}
