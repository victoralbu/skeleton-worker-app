<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BidFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'job_id' => ['exists:jobs,id', 'required'],
            'date' => ['date'],
            'money' => ['decimal:0,2'],
            'few_words' => ['string', 'max:500'],
            'status' => [Rule::in(['Won', 'In Progress', 'Lost'])],
        ];
    }
}
