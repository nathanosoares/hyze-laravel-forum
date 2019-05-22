<?php

namespace App\Http\Requests\Forums;

use App\Models\Forums\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!$this->thread && !$this->post) {
            return false;
        }

        if ($this->post) {
            $this->thread = $this->post->thread;
        }

        return $this->user()->can('create', [Post::class, $this->thread, $this->post]);
    }

    /**
     * Configure the validator instance.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator()
    {
        $validator = Validator::make([
            'body' => strip_tags($this->body)
        ], [
            'body' => 'required|min:2'
        ]);


        $validator->after(function ($validator) {
            if ($this->post) {
                if ((!is_null($this->post->parent) || $this->thread->main_post->id === $this->post->id)) {
                    $validator->errors()->add('body', 'Unprocessable Entity');
                }
            }
        });

        return $validator;
    }
}
