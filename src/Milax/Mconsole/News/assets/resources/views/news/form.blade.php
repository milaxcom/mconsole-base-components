@extends('mconsole::app')

@section('content')

@if (isset($item))
    {!! Form::model($item, ['method' => 'PUT', 'route' => ['mconsole.news.update', $item->id]]) !!}
@else
    {!! Form::open(['method' => 'POST', 'url' => '/mconsole/news']) !!}
@endif

<div class="row">
	<div class="col-lg-7 col-md-6">
        <div class="portlet light">
            @include('mconsole::partials.portlet-title', [
                'back' => '/mconsole/news',
                'title' => trans('mconsole::forms.tabs.main'),
                'fullscreen' => true,
            ])
            <div class="portlet-body form">
    			<div class="form-body">
                    @include('mconsole::forms.text', [
    					'label' => trans('mconsole::news.form.slug'),
    					'name' => 'slug',
    				])
                    @include('mconsole::forms.date', [
    					'label' => trans('mconsole::news.form.date'),
    					'name' => 'published',
    				])
                    
                    <div class="tabbable-line">
                        <ul class="nav nav-tabs">
                            @foreach ($languages as $key => $language)
                                <li @if ($key == 0) class="active" @endif>
                                    <a href="#lang_{{ $language->id }}" data-toggle="tab"> {{ $language->name }}  </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            @foreach ($languages as $key =>$language)
                                <div class="tab-pane fade @if ($key == 0) active @endif in" id="lang_{{ $language->id }}">
                    				@include('mconsole::forms.text', [
                    					'label' => trans('mconsole::news.form.heading'),
                    					'name' => 'heading[' . $language->key . ']',
                    				])
                    				@include('mconsole::forms.text', [
                    					'label' => trans('mconsole::news.form.title'),
                    					'name' => 'title[' . $language->key . ']',
                    				])
                                    <hr />
                                    @if (app('API')->options->get('textareatype') == 'ckeditor')
                                        @include('mconsole::forms.ckeditor', [
                                            'label' => trans('mconsole::news.form.preview'),
                                            'name' => 'preview[' . $language->key . ']',
                                        ])
                                        @include('mconsole::forms.ckeditor', [
                                            'label' => trans('mconsole::news.form.text'),
                                            'name' => 'text[' . $language->key . ']',
                                        ])
                                    @else
                                        @include('mconsole::forms.textarea', [
                                            'label' => trans('mconsole::news.form.preview'),
                                            'name' => 'preview[' . $language->key . ']',
                                            'size' => '50x2',
                                        ])
                                        @include('mconsole::forms.textarea', [
                                            'label' => trans('mconsole::news.form.text'),
                                            'name' => 'text[' . $language->key . ']',
                                            'size' => '50x15',
                                        ])
                                    @endif
                                    @include('mconsole::forms.textarea', [
                    					'label' => trans('mconsole::news.form.description'),
                    					'name' => 'description[' . $language->key . ']',
                                        'size' => '50x3',
                    				])
                                </div>
                            @endforeach
                        </div>
                    </div>
    			</div>
                <div class="form-actions">
                    @include('mconsole::forms.submit')
                </div>
            </div>
        </div>
	</div>
    
    <div class="col-lg-5 col-md-6">
        
        @if (app('API')->options->get('news_has_gallery'))
            <div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-blue sbold uppercase">{{ trans('mconsole::news.form.gallery') }}</span>
					</div>
				</div>
				<div class="portlet-body form">
                    @include('mconsole::forms.upload', [
                        'type' => MX_UPLOAD_TYPE_IMAGE,
                        'multiple' => true,
                        'group' => 'gallery',
                        'preset' => 'news',
                        'id' => isset($item) ? $item->id : null,
                        'model' => 'Milax\Mconsole\News\Models\News',
                    ])
				</div>
			</div>
        @endif
        
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
        
        <div class="portlet light">
			<div class="portlet-title">
				<div class="caption">
					<span class="caption-subject font-blue sbold uppercase">{{ trans('mconsole::forms.tabs.settings') }}</span>
				</div>
			</div>
			<div class="portlet-body form">
                @include('mconsole::forms.state')
                @include('mconsole::forms.select', [
                    'label' => trans('mconsole::news.form.indexing'),
                    'name' => 'indexing',
                    'type' => MX_SELECT_STATE,
                ])
			</div>
		</div>
    </div>
    
</div>

{!! Form::close() !!}

@endsection