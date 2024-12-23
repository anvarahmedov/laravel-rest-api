<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Invoice;

class BulkStoreInvoiceRequest extends FormRequest
{
    // protected array $data;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user != null && $user->tokenCan('create');
    }

    /**
     * Get the validation rules that apply to the request.
     *

     */
    public function rules(): array
    {
        return [
            '*.customer_id' => ['required', 'integer'],
            '*.amount' => ['required', 'numeric'],
            '*.status' => ['required', Rule::in('B', 'P', 'V', 'b', 'p', 'v')],
            '*.billed_date' => ['required', 'date_format:Y-m-d H:i:s'],
            '*.paid_date' => ['  ', 'nullable'],
        ];
    }
    protected function prepareForValidation()
    {
        $data = [];

       foreach($this->toArray() as $obj) {
            // dd($obj);
            $obj['customer_id'] = $obj['customerId'] ?? null;
            $obj['billed_date'] = $obj['billedDate'] ?? null;
            $obj['paid_date'] = $obj['paidDate'] ?? null;
            //   array_merge($data, $obj);
        }

        $this->merge($data);
    }
}
