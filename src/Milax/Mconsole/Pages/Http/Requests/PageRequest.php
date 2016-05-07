<?php

namespace Milax\Mconsole\Pages\Http\Requests;

use App\Http\Requests\Request;
use Milax\Mconsole\Pages\Models\Page;

class PageRequest extends Request
{
    /**
     * Create new instance
     */
    public function __construct()
    {
        $this->repository = app('API')->repositories->pages;
    }
    
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
        switch ($this->method) {
            case 'PUT':
            case 'UPDATE':
                return [
                    'slug' => 'max:255|unique:pages,slug,' . $this->repository->find($this->pages)->id,
                    'heading' => 'required|max:255',
                ];
                break;
            
            default:
                return [
                    'slug' => 'max:255|unique:pages',
                    'heading' => 'required|max:255',
                ];
        }
    }
    
    /**
     * Modify request input
     * 
     * @return array
     */
    public function all()
    {
        $input = parent::all();
        
        if (strlen($input['slug']) == 0) {
            foreach (Request::input('heading') as $lang => $heading) {
                if (strlen($heading) > 0) {
                    break;
                }
            }
            $input['slug'] = str_slug($heading);
        } else {
            $input['slug'] = str_slug($input['slug']);
        }
        
        return $input;
    }
    
    /**
     * Set custom validator attribute names
     *
     * @return Validator
     */
    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();
        $validator->setAttributeNames(trans('mconsole::pages.form'));
        
        return $validator;
    }
}
