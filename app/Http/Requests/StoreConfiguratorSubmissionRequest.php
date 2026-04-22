<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreConfiguratorSubmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $createAccount = (bool) $this->input('order.create_account', false);

        return [
            // Submission
            'submission.is_custom' => ['required', 'boolean'],
            'submission.system_id' => ['required', 'integer', 'exists:systems,id'],
            'submission.schema_id' => ['required', 'integer', 'exists:schemas,id'],
            'submission.dimension_id' => ['required', 'integer', 'exists:dimensions,id'],
            'submission.handle_id' => ['nullable', 'integer', 'exists:handles,id'],
            'submission.color_id' => ['nullable', 'integer', 'exists:colors,id'],
            'submission.base_price' => ['required', 'numeric', 'min:0'],
            'submission.handle_price' => ['required', 'numeric', 'min:0'],
            'submission.accessories_total' => ['required', 'numeric', 'min:0'],
            'submission.total_price' => ['required', 'numeric', 'min:0'],
            'submission.observations' => ['nullable', 'string', 'max:2000'],

            // Accessories
            'selected_accesory_ids' => ['nullable', 'array'],
            'selected_accesory_ids.*' => ['integer', 'exists:accesories,id'],

            // Customer / order
            'order.company_name' => ['nullable', 'string', 'max:255'],
            'order.first_name' => ['required', 'string', 'max:255'],
            'order.last_name' => ['required', 'string', 'max:255'],
            'order.email' => ['required', 'email', 'max:255'],
            'order.phone' => ['required', 'string', 'max:50'],
            'order.address' => ['required', 'string', 'max:500'],
            'order.observations' => ['nullable', 'string', 'max:2000'],
            'order.create_account' => ['boolean'],
            'order.password' => $createAccount
                ? ['required', 'string', Password::default(), 'confirmed']
                : ['nullable'],
            'order.password_confirmation' => $createAccount
                ? ['required', 'string']
                : ['nullable'],
        ];
    }

    /**
     * Map validated data into the shape expected by SubmitConfiguratorSelectionService.
     *
     * @return array<string, mixed>
     */
    public function toServicePayload(): array
    {
        $validated = $this->validated();

        return [
            'order' => $validated['order'] ?? [],
            'submission' => $validated['submission'] ?? [],
            'selected_accesory_ids' => $validated['selected_accesory_ids'] ?? [],
        ];
    }
}
