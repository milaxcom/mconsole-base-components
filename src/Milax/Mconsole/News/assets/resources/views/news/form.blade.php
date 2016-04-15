@extends('mconsole::app')

@section('content')

<div class="row">
	<div class="col-lg-7 col-md-6">
        @if (isset($item))
            {!! Form::model($item, ['method' => 'PUT', 'route' => ['mconsole.news.update', $item->id]]) !!}
        @else
            {!! Form::open(['method' => 'POST', 'url' => '/mconsole/news']) !!}
        @endif
        <div class="portlet light">
            @include('mconsole::partials.portlet-title', [
                'title' => trans('mconsole::news.form.main'),
                'fullscreen' => true,
            ])
            <div class="portlet-body form">
    			<div class="form-body">
    				@include('mconsole::forms.date', [
    					'label' => trans('mconsole::news.form.date'),
    					'name' => 'published',
    				])
    				@include('mconsole::forms.text', [
    					'label' => trans('mconsole::news.form.heading'),
    					'name' => 'heading',
    				])
    				@include('mconsole::forms.text', [
    					'label' => trans('mconsole::news.form.slug'),
    					'name' => 'slug',
    				])
    				@include('mconsole::forms.text', [
    					'label' => trans('mconsole::news.form.title'),
    					'name' => 'title',
    				])
    				
                    @if (app('API')->options->get('textareatype') == 'ckeditor')
                        @include('mconsole::forms.ckeditor', [
                            'label' => trans('mconsole::news.form.preview'),
                            'name' => 'preview',
                        ])
                        @include('mconsole::forms.ckeditor', [
                            'label' => trans('mconsole::news.form.text'),
                            'name' => 'text',
                        ])
                    @else
                        @include('mconsole::forms.textarea', [
                            'label' => trans('mconsole::news.form.preview'),
                            'name' => 'preview',
                            'size' => '50x2',
                        ])
                        @include('mconsole::forms.textarea', [
                            'label' => trans('mconsole::news.form.text'),
                            'name' => 'text',
                            'size' => '50x15',
                        ])
                    @endif
                    
    				@include('mconsole::forms.textarea', [
    					'label' => trans('mconsole::news.form.description'),
    					'name' => 'description',
    				])

    				@include('mconsole::forms.select', [
    					'label' => trans('mconsole::news.form.enabled.name'),
    					'name' => 'enabled',
    					'options' => [
    						'1' => trans('mconsole::news.form.enabled.true'),
    						'0' => trans('mconsole::news.form.enabled.false'),
    					],
    				])
    			</div>
                <div class="form-actions">
                    @include('mconsole::forms.submit')
                </div>
            </div>
        </div>
	</div>
    
    <div class="col-lg-5 col-md-6">
        <div class="portlet light">
			<div class="portlet-title">
				<div class="caption">
					<span class="caption-subject font-blue sbold uppercase">{{ trans('mconsole::forms.tags.label') }}</span>
				</div>
			</div>
			<div class="portlet-body form">
                @if (isset($item))
                    @include('mconsole::forms.tags', [
                        'tags' => $item->tags,
                    ])
                @else
                    @include('mconsole::forms.tags')
                @endif
			</div>
		</div>
    </div>
    
    {!! Form::close() !!}
    
</div>

@endsection