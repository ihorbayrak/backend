<?php

namespace App\Modules\V1\Post\Requests;

use App\Models\Post;
use App\Modules\V1\Base\Requests\BaseRequest;
use Illuminate\Validation\Rules\File;

class CreatePostRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'body' => ['required_without:image', 'string', 'max:'.Post::MAX_CHAR],
            'image' => ['required_without:body', 'mimes:jpg,jpeg,png,gif', File::image()->max(10 * 1024)]
        ];
    }
}
