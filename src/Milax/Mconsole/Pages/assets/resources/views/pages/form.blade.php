@if (isset($item))
	@if(Auth::user()->update_own && Auth::user()->id != $item->author_id) 
        <script>window.location = '/';</script>
    @else
		{!! Form::model($item, ['method' => 'PUT', 'url' => mconsole_url(sprintf('pages/%s', $item->id))]) !!}
	@endif
@else
	{!! Form::open(['method' => 'POST', 'url' => mconsole_url('pages')]) !!}
@endif

<div class="row">
	<div class="col-lg-7 col-md-6">
		<div class="portlet light">
            @include('mconsole::partials.portlet-title', [
                'back' => mconsole_url('pages'),
                'title' => trans('mconsole::forms.tabs.main'),
                'fullscreen' => true,
            ])
			<div class="portlet-body">
                <div class="form-body">
					<div class="form-group">
						<label>{{ trans('mconsole::pages.form.slug') }}</label>
						<div class="input-group">
							{!! Form::text('slug', !is_null(Form::getValueAttribute('slug')) ? null : (isset($item) ? $item->slug : null), ['class' => 'form-control']) !!}
							<span class="input-group-btn">
								<button class="btn blue slugify" type="button">
								<i class="fa fa-refresh fa-fw"></i> {{ trans('mconsole::pages.form.slugify') }}</button>
							</span>
						</div>
					</div>
					
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
									@include('mconsole::forms.text', [
    									'label' => trans('mconsole::pages.form.keywords'),
    									'name' => 'keywords[' . $language->key . ']',
    								])
    							</div>
                            @endforeach
						</div>
					</div>
                    
                    @include('mconsole::forms.select', [
                        'label' => trans('mconsole::pages.form.indexing'),
                        'name' => 'indexing',
                        'type' => MconsoleFormSelectType::OnOff,
                    ])
                    
                    {!! app('API')->forms->constructor->render() !!}
                    
                </div>
                <div class="form-actions">
                    @include('mconsole::forms.submit')
                </div>
			</div>
		</div>
	</div>
	<div class="col-lg-5 col-md-6">

        <div class="portlet light">
			@include('mconsole::partials.portlet-title', [
                'title' => trans('mconsole::pages.form.gallery'),
            ])
			<div class="portlet-body">
                @include('mconsole::forms.upload', [
                    'type' => MconsoleUploadType::Image,
                    'multiple' => true,
                    'group' => 'gallery',
                    'preset' => 'pages',
                    'id' => isset($item) ? $item->id : null,
                    'model' => 'Milax\Mconsole\Pages\Models\Page',
                ])
			</div>
		</div>
        
		<div class="portlet light">
			@include('mconsole::partials.portlet-title', [
				'title' => trans('mconsole::forms.tabs.settings'),
			])
			<div class="portlet-body">
				<div class="tabbable-line">
					<ul class="nav nav-tabs nav-justified">
						<li role="presentation" class="active">
							<a href="#tab_1" data-toggle="tab"> {{ trans('mconsole::pages.form.options') }}  </a>
						</li>
						<li role="presentation">
							<a href="#tab_2" data-toggle="tab"> {{ trans('mconsole::forms.links.label') }} <span class="badge badge-default">{{ (isset($item) && $item->allLinks->count() > 0) ? $item->allLinks->count() : null }}</span> </a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane fade active in" id="tab_1">
                            @include('mconsole::forms.select', [
                                'label' => trans('mconsole::pages.form.enabled'),
                                'name' => 'enabled',
                                'type' => MconsoleFormSelectType::YesNo,
                            ])
                            @include('mconsole::forms.select', [
								'label' => trans('mconsole::pages.form.hide_heading'),
								'name' => 'hide_heading',
                                'type' => MconsoleFormSelectType::YesNo,
							])
							@include('mconsole::forms.select', [
								'label' => trans('mconsole::pages.form.fullwidth'),
								'name' => 'fullwidth',
                                'type' => MconsoleFormSelectType::YesNo,
							])
							@includeWhen(!isset($item), 'mconsole::forms.hidden', [
								'name' => 'author_id',
                                'value' => Auth::user()->id,
							])
						</div>
						<div class="tab-pane fade" id="tab_2">
                            @include('mconsole::forms.links', [
                                'item' => isset($item) ? $item : null,
                                'attribute' => 'slug',
                                'model' => 'Milax\Mconsole\Pages\Models\Page',
                            ])
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

{!! Form::close() !!}

@section('page.scripts')
    <script src="/massets/js/slugify.js" type="text/javascript"></script>
	<script type="text/javascript">
		var slug = $('input[name="slug"]');
		$('.slugify').click(function () {
			slug.prop('disabled', true);
			slugify($('input[name*="heading"]'), function (text) {
				slug.val(text);
				slug.prop('disabled', false);
			});
		});
	</script>
@endsection