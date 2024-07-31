<?php

namespace App\Http\Requests;

use App\Models\Book;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookRequest extends FormRequest
{
    public $validator;

    public function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
    }
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
        $bookId = $this->route()->parameter('book');
        $book = Book::find($bookId);

        if ($this->isMethod('POST')) {
            return [
                'code'        => 'required|unique:m_books,code',
                'title'       => 'required',
                'm_author_id' => 'required|exists:m_authors,id',
                'stock'       => 'required|numeric',
            ];
        } else {

            $request = $this->request->all();

            return [
                'code'        => ['required', $request['code'] != @$book->code ? Rule::unique('m_books')->ignore(@$book->id) : ''],
                'title'       => 'required',
                'm_author_id' => 'nullable|exists:m_authors,id',
                'stock'       => 'required|numeric',
            ];
        }
    }

    public function attributes() : array
    {
        return [
            'm_author_id' => 'Author',
        ];
    }
}
