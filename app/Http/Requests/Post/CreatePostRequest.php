<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'module' => 'required|in:post,review',
            'status' => 'required_if:module,post,event',
            'title' => 'required',
            'image' => 'required',
            'cover' => 'required',
            'references' => 'required',
            'tags' => 'required',
            'content' => 'required_if:module,post',
            'sinopse' => 'required_if:module,review',
            'year_of_release' => 'required_if:module,review',
            'review.content' => 'required_if:module,review',
        ];
    }
}
