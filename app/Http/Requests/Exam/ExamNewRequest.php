<?php

namespace App\Http\Requests\Exam;

use Illuminate\Foundation\Http\FormRequest;

class ExamNewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $ruleName = 'required|unique:exams,name|min:4|max:255';
        if ($this->route()->id) $ruleName = 'required|min:4|max:255|unique:exams,name,' . $this->route()->id . ',id';
        $rule = [
            'name' => $ruleName,
            'description' => 'required',
        ];
        return $rule;
    }

    public function messages()
    {
        return [
            'name.required' => trans('validate.required'),
            'name.unique' => trans('validate.unique'),
            'name.min' => trans('validate.min'),
//            'description.min' => trans('validate.min'),
            'name.max' => trans('validate.max'),
            'description.required' => trans('validate.required'),
            'campus_exam.required' => trans('validate.required'),

//            'time_exam.numeric' => trans('validate.numeric'),
//            'time_exam.max' => trans('validate.max'),
//            'time_exam.min' => trans('validate.min'),
//            'time_exam.required' => trans('validate.required'),
        ];
    }
}
