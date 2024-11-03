<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\Services;

use App\Http\Payloads\V1\CreateService;
use Illuminate\Foundation\Http\FormRequest;

final class WriteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['string', 'required', 'min:2', 'max:255'],
            'url' => ['string', 'url', 'min:11', 'max:255'],
        ];
    }

    public function payload(): CreateService
    {
        return new CreateService(
            name: $this->string('name')->toString(),
            url: $this->string('name')->toString(),
            user: $this->user()->id
        );
    }
}
