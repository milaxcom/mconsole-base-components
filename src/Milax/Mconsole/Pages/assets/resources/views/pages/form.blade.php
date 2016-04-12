@extends('mconsole::app')

@section('content')
	
	@if (isset($item))
		{!! Form::model($item, ['method' => 'PUT', 'route' => ['mconsole.pages.update', $item->id], 'files' => true, 'id' => 'uploadable-form']) !!}
	@else
		{!! Form::open(['method' => 'POST', 'url' => '/mconsole/pages', 'files' => true, 'id' => 'uploadable-form']) !!}
	@endif
	<div class="row">
		<div class="col-lg-7 col-md-6">
			<div class="portlet light">
                @include('mconsole::partials.portlet-title', [
                    'title' => trans('mconsole::pages.form.main'),
                ])
				<div class="portlet-body form">
                    <div class="form-body">
                        @include('mconsole::forms.text', [
                            'label' => trans('mconsole::pages.form.slug'),
                            'name' => 'slug',
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
                    						'label' => trans('mconsole::pages.form.heading'),
                    						'name' => 'heading[' . $language->key . ']',
                    					])
                                        <hr />
                                        <h3>{{ trans('mconsole::pages.form.content') }}</h3>
                    					@include('mconsole::forms.textarea', [
                    						'label' => trans('mconsole::pages.form.preview'),
                    						'name' => 'preview[' . $language->key . ']',
                                            'size' => '50x2',
                    					])
                    					@include('mconsole::forms.textarea', [
                    						'label' => trans('mconsole::pages.form.text'),
                    						'name' => 'text[' . $language->key . ']',
                                            'size' => '50x15',
                    					])
                                        <hr />
                                        <h3>{{ trans('mconsole::pages.form.seo') }}</h3>
                                        @include('mconsole::forms.text', [
        									'label' => trans('mconsole::pages.form.title'),
        									'name' => 'title[' . $language->key . ']',
        								])
        								@include('mconsole::forms.text', [
        									'label' => trans('mconsole::pages.form.description'),
        									'name' => 'description[' . $language->key . ']',
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
            
            <div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-blue sbold uppercase">{{ trans('mconsole::pages.form.gallery') }}</span>
					</div>
				</div>
				<div class="portlet-body form">
                    @include('mconsole::partials.upload', [
                        'multiple' => true,
                        'group' => 'gallery',
                        'preset' => 'pages',
                        'id' => isset($item) ? $item->id : null,
                        'model' => 'Milax\Mconsole\Pages\Models\Page',
                    ])
				</div>
			</div>
            
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-blue sbold uppercase">{{ trans('mconsole::pages.form.additional') }}</span>
					</div>
				</div>
				<div class="portlet-body form">
					
					<div class="tabbable-line">
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#tab_1" data-toggle="tab"> {{ trans('mconsole::pages.form.options') }}  </a>
							</li>
							<li>
								<a href="#tab_2" data-toggle="tab"> {{ trans('mconsole::pages.form.links.label') }} </a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane fade active in" id="tab_1">
                                @include('mconsole::forms.select', [
                                    'label' => trans('mconsole::pages.form.enabled.name'),
                                    'name' => 'enabled',
                                    'options' => [
                                        '1' => trans('mconsole::pages.form.enabled.true'),
                                        '0' => trans('mconsole::pages.form.enabled.false'),
                                    ],
                                ])
                                @include('mconsole::forms.select', [
									'label' => trans('mconsole::pages.form.hide_heading.name'),
									'name' => 'hide_heading',
									'options' => [
                                        '0' => trans('mconsole::pages.form.hide_heading.false'),
										'1' => trans('mconsole::pages.form.hide_heading.true'),
									],
								])
								@include('mconsole::forms.select', [
									'label' => trans('mconsole::pages.form.fullwidth.name'),
									'name' => 'fullwidth',
									'options' => [
										'0' => trans('mconsole::pages.form.fullwidth.false'),
										'1' => trans('mconsole::pages.form.fullwidth.true'),
									],
								])
							</div>
							<div class="tab-pane fade" id="tab_2">
                                @include('mconsole::forms.hidden', [
                                    'name' => 'links',
                                    'class' => 'links-editor',
                                    'hidden' => [
                                        'title' => trans('mconsole::pages.form.links.title'),
                                        'url' => trans('mconsole::pages.form.links.url'),
                                        'enabled' => trans('mconsole::pages.form.links.enabled'),
                                    ],
                                ])
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	{!! Form::close() !!}
	
@endsection