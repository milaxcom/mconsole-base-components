<?php

namespace Milax\Mconsole\News\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Milax\Mconsole\News\Models\News;
use Milax\Mconsole\News\Contracts\Repositories\NewsRepository;
use Illuminate\Validation\Rule;

class NewsRequest extends FormRequest
{
    /**
     * Create new instance
     */
    public function __construct(NewsRepository $repository)
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
        $slugRule = Rule::unique('news')->whereNot('slug', NULL);

        switch ($this->method()) {
            case 'PUT':
            case 'UPDATE':
                return [
                    'slug' => [
                        'max:255',
                        $slugRule->whereNot('id', $this->repository->find($this->news)->id),
                    ],
                    'heading' => 'required|max:255',
                ];
                break;
            
            default:
                return [
                    'slug' => [
                        'max:255',
                        $slugRule,
                    ],
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
        $validator->setAttributeNames(trans('mconsole::news.form'));
        
        return $validator;
    }
}
