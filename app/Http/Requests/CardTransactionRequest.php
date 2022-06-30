<?php

namespace App\Http\Requests;

use App\Constants\TransactionConstants;
use Illuminate\Foundation\Http\FormRequest;

class CardTransactionRequest extends FormRequest
{
    const PERSIAN_TO_EN = [
        '۰' => '0', '۱' => '1', '۲' => '2',
        '۳' => '3', '۴' => '4', '۵' => '5',
        '۶' => '6', '۷' => '7', '۸' => '8',
        '۹' => '9', '٠' => '0', '١' => '1',
        '٢' => '2', '٣' => '3', '٤' => '4',
        '٥' => '5', '٦' => '6', '٧' => '7',
        '٨' => '8', '٩' => '9'
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    private function convertNumberWhenIsNotEnNumbersBeforeValidations(string $field)
    {
        return strtr($this->request->get($field), self::PERSIAN_TO_EN);
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        request()->merge([
            'to' => $this->convertNumberWhenIsNotEnNumbersBeforeValidations('to'),
            'from' => $this->convertNumberWhenIsNotEnNumbersBeforeValidations('from')
        ]);

        return [
            'from' => 'required|string|validate_credit_card_number|exists:credit_cards,credit_card_number',
            'to' => 'required|string|validate_credit_card_number|exists:credit_cards,credit_card_number',
            'amount' => [
                'required',
                'integer',
                'min:' . TransactionConstants::MIN_CARD_TRANSACTION,
                'max:' . TransactionConstants::MAX_CARD_TRANSACTION
            ],
        ];
    }
}
