<?php

namespace Milax\Mconsole\Pages\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Milax\Mconsole\Pages\Models\Page;
use Milax\Mconsole\Pages\Contracts\Repositories\PagesRepository;

class PageRequest extends FormRequest
{
    /**
     * Create new instance
     */
    public function __construct(PagesRepository $repository)
    {
        $this->repository = $repository;
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
        switch ($this->method()) {
            case 'PUT':
            case 'UPDATE':
                return [
                    'slug' => 'max:255|unique:pages,slug,' . $this->repository->find($this->page)->id,
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
