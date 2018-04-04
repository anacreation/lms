<?php

namespace Anacreation\Lms\Requests;

use Anacreation\Lms\Enums\LessonCompletionType;
use Anacreation\Lms\Models\Lesson;
use Anacreation\Lms\Models\Test;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLessonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $completionTypes = LessonCompletionType::GetCompletionTypes();

        return [
            'title'               => 'required',
            'summary'             => 'required',
            'content'             => 'nullable',
            'content-type'        => 'required',
            'is_featured'         => 'required|boolean',
            'is_visible'          => 'required|boolean',
            'is_active'           => 'required|boolean',
            'completion_criteria' => 'required|in:' . implode(',',
                    array_values($completionTypes)),
            'test_id'             => "required_if:completion_criteria,0|in:" . implode(",",
                    Test::pluck('id')->toArray()),
            'max_attempts'        => "required_if:completion_criteria,0|numeric|min:0|nullable",
            'seconds'             => "numeric|min:1|required_if:completion_criteria,1",
            'prerequisites.*'     => 'required|in:0,' . implode(",",
                    Lesson::pluck('id')->toArray()),
            "coverPic"            => "image",
            'tags'                => 'nullable',
        ];
    }

    public function messages(): array {
        return [
            "max_attempts.required_if" => 'Max attempt field is request if completion criteria select to Test'
        ];
    }
}
