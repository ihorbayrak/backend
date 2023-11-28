<?php

namespace App\Modules\V1\Comment\Requests;

use App\Modules\V1\Base\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class CreateCommentRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'parent_id' => ['sometimes', 'nullable', 'integer', Rule::exists('comments', 'id')],
            'body' => ['required_without:image', 'string'],
            'image' => ['required_without:body', 'mimes:jpg,jpeg,png,gif', File::image()->max(10 * 1024)]
        ];
    }
}
