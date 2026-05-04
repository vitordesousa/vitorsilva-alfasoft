<?php

namespace App\Http\Requests\Contacts;

use App\Helpers\Strings;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    #[\Override] protected function prepareForValidation(): void
    {
        if ($this->input('contact')) {
            $this->merge([
                'contact' => Strings::onlyNumbers($this->input('contact')),
            ]);
        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'email_address' => ['required', 'email', 'string', 'max:150', Rule::unique('contacts', 'email_address')->ignore($this->route('contact'))->whereNull('deleted_at')],
            'contact' => ['required', 'numeric', 'digits:9', Rule::unique('contacts', 'contact')->ignore($this->route('contact'))->whereNull('deleted_at')],
        ];
    }
}
