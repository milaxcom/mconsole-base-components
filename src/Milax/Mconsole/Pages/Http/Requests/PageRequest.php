<?php

namespace Milax\Mconsole\Pages\Http\Requests;

use App\Http\Requests\Request;
use Milax\Mconsole\Pages\Models\Page;

class PageRequest extends Request
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
        $page = Page::find($this->pages);
        
        switch ($this->method) {
            case 'PUT':
            case 'UPDATE':
                return [
                    'slug' => 'required|max:255|unique:pages,slug,' . $page->id,
                    'heading' => 'required|max:255',
                ];
                break;
            
            default:
                return [
                    'slug' => 'required|max:255|unique:pages',
                    'heading' => 'required|max:255',
                ];
        }
    }
}
