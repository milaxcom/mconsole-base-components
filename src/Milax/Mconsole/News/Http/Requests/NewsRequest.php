<?php

namespace Milax\Mconsole\News\Http\Requests;

use App\Http\Requests\Request;
use Milax\Mconsole\News\Models\News;

class NewsRequest extends Request
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
     * @return array
     */
    public function rules()
    {
        $new = News::find($this->news);
        
        switch ($this->method) {
            case 'PUT':
            case 'UPDATE':
                return [
                    'slug' => 'required|max:255|unique:news,slug,' . $new->id,
                    'heading' => 'required|max:255',
                ];
                break;
            
            default:
                return [
                    'slug' => 'required|max:255|unique:news',
                    'heading' => 'required|max:255',
                ];
        }
    }
}
