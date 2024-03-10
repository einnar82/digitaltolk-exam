<?php

namespace DTApi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as Request;

abstract class FormRequest extends Request
{
    public function authorize(): bool
    {
        return true;
    }

    abstract public function rules(): array;
}
