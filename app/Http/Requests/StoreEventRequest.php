<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize()
    {
        // يجب أن يكون المستخدم مسجل دخوله لإنشاء فعالية
        return auth()->check();
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date|after:today', // يجب أن يكون التاريخ في المستقبل
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // تحقق من أن الملف صورة
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'حقل اسم الفعالية مطلوب.',
            'date.after' => 'يجب أن يكون تاريخ الفعالية في المستقبل.',
            'image.image' => 'الملف المرفوع يجب أن يكون صورة.',
        ];
    }
}