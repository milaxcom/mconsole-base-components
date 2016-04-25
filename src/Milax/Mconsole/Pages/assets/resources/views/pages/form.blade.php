@if (isset($item))
	{!! Form::model($item, ['method' => 'PUT', 'route' => ['mconsole.pages.update', $item->id], 'files' => true, 'id' => 'uploadable-form']) !!}
@else
	{!! Form::open(['method' => 'POST', 'url' => '/mconsole/pages', 'files' => true, 'id' => 'uploadable-form']) !!}
@endif
<div class="row">
	<div class="col-lg-7 col-md-6">
		<div class="portlet light">
            @include('mconsole::partials.portlet-title', [
                'back' => '/mconsole/pages',
                'title' => trans('mconsole::forms.tabs.main'),
                'fullscreen' => true,
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
                					@if (app('API')->options->get('textareatype') == 'ckeditor')
                                        @include('mconsole::forms.ckeditor', [
                                            'label' => trans('mconsole::pages.form.preview'),
                    						'name' => 'preview[' . $language->key . ']',
                                        ])
                                        @include('mconsole::forms.ckeditor', [
                                            'label' => trans('mconsole::pages.form.text'),
                    						'name' => 'text[' . $language->key . ']',
                                        ])
                                    @else
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
                                    @endif
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
                                    @include('mconsole::forms.select', [
                                        'label' => trans('mconsole::pages.form.indexing'),
                                        'name' => 'index',
                                        'type' => MX_SELECT_STATE,
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
                @include('mconsole::forms.upload', [
                    'type' => MX_UPLOAD_TYPE_IMAGE,
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
					<span class="caption-subject font-blue sbold uppercase">{{ trans('mconsole::forms.tabs.settings') }}</span>
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
                                'label' => trans('mconsole::pages.form.enabled'),
                                'name' => 'enabled',
                                'type' => MX_SELECT_YESNO,
                            ])
                            @include('mconsole::forms.select', [
								'label' => trans('mconsole::pages.form.hide_heading'),
								'name' => 'hide_heading',
                                'type' => MX_SELECT_YESNO,
							])
							@include('mconsole::forms.select', [
								'label' => trans('mconsole::pages.form.fullwidth'),
								'name' => 'fullwidth',
                                'type' => MX_SELECT_YESNO,
							])
						</div>
						<div class="tab-pane fade" id="tab_2">
                            @include('mconsole::forms.select', [
                                'label' => 'Прикрепить ссылки со страницы',
                                'name' => 'links_page_id',
                                'options' =>  isset($item) ? $links_page_id_options->except($item->id)->toArray() : $links_page_id_options->toArray(),
                            ])
                            @include('mconsole::forms.hidden', [
                                'name' => 'links',
                                'class' => 'links-editor',
                            ])
                            @trans([
                                'links-editor-title' => trans('mconsole::pages.form.links.title'),
                                'links-editor-url' => trans('mconsole::pages.form.links.url'),
                                'links-editor-enabled' => trans('mconsole::pages.form.links.enabled'),
                            ])
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

{!! Form::close() !!}