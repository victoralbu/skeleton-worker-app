<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobFormRequest extends FormRequest
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

    public function rules()
    {
        return [
            'title'       => ['string', 'max:255', 'required'],
            'description' => ['string', 'max:255', 'required'],
            'level'       => ['string', 'max:255', Rule::in(['Easy', 'Medium', 'Hard']), 'required'],
            'budget'      => ['decimal:0,2'],
            'address'     => ['string', 'max:255', 'required'],
            'city'        => ['string', 'max:255', 'required'],
            'urgency'     => ['string', 'max:255', Rule::in(['Very Urgent', 'Urgent', 'Not Urgent']), 'required'],
            'group_id'    => ['string', 'max:255', 'exists:groups,id'],
            'status'      => ['string', 'max:255', Rule::in(['Done', 'In Progress', 'Bidding'])],
        ];
    }
}
