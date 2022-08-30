@if (isset($item))
    @if(Auth::user()->update_own && Auth::user()->id != $item->author_id) 
        <script>window.location = '/';</script>
    @else
        {!! Form::model($item, ['method' => 'PUT', 'url' => mconsole_url(sprintf('news/%s', $item->id))]) !!}
    @endif
@else
    {!! Form::open(['method' => 'POST', 'url' => mconsole_url('news')]) !!}
@endif

<div class="row">
	<div class="col-lg-7 col-md-6">
        <div class="portlet light">
            @include('mconsole::partials.portlet-title', [
                'back' => mconsole_url('news'),
                'title' => trans('mconsole::forms.tabs.main'),
                'fullscreen' => true,
            ])
            <div class="portlet-body form">
    			<div class="form-body">
                    <div class="form-group">
						<label>{{ trans('mconsole::news.form.slug') }}</label>
						<div class="input-group">
                            {!! Form::text('slug', !is_null(Form::getValueAttribute('slug')) ? null : (isset($item) ? $item->slug : null), ['class' => 'form-control']) !!}
							<span class="input-group-btn">
								<button class="btn blue slugify" type="button">
                                <i class="fa fa-refresh fa-fw"></i> {{ trans('mconsole::news.form.slugify') }}</button>
                            </span>
                            <span class="input-group-addon">
                            <span id="popover-slug" class="glyphicon glyphicon-question-sign" data-content="{{ trans('mconsole::news.help.slug.news') }}<br>{{ trans('mconsole::news.help.slug.local') }}<br>{{ trans('mconsole::news.help.slug.outside') }}<br>{{ trans('mconsole::news.help.slug.without') }}" data-toggle="popover"></span>
                            </span>
						</div>
					</div>
                    @include('mconsole::forms.date', [
    					'label' => trans('mconsole::news.form.published_at'),
    					'name' => 'published_at',
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
                                    <hr />
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
                                    <hr />
                                    <h3>{{ trans('mconsole::news.form.seo') }}</h3>
                                    @include('mconsole::forms.text', [
                    					'label' => trans('mconsole::news.form.title'),
                    					'name' => 'title[' . $language->key . ']',
                    				])
                                    @include('mconsole::forms.text', [
    									'label' => trans('mconsole::news.form.description'),
    									'name' => 'description[' . $language->key . ']',
    								])
									@include('mconsole::forms.text', [
    									'label' => trans('mconsole::news.form.keywords'),
    									'name' => 'keywords[' . $language->key . ']',
    								])
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @include('mconsole::forms.select', [
                        'label' => trans('mconsole::news.form.indexing'),
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
        @if (app('API')->options->getByKey('news_has_cover'))
            <div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-blue sbold uppercase">{{ trans('mconsole::news.form.cover') }}</span>
					</div>
				</div>
				<div class="portlet-body form">
                    @include('mconsole::forms.upload', [
                        'type' => MconsoleUploadType::Image,
                        'multiple' => false,
                        'group' => 'cover',
                        'preset' => 'news_cover',
                        'id' => isset($item) ? $item->id : null,
                        'model' => 'Milax\Mconsole\News\Models\News',
                    ])
				</div>
			</div>
        @endif
        
        @if (app('API')->options->getByKey('news_has_gallery'))
            <div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-blue sbold uppercase">{{ trans('mconsole::news.form.gallery') }}</span>
					</div>
				</div>
				<div class="portlet-body form">
                    @include('mconsole::forms.upload', [
                        'type' => MconsoleUploadType::Image,
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
                        'categories' => ['news'],
                    ])
                @else
                    @include('mconsole::forms.tags', [
                        'categories' => ['news'],
                    ])
                @endif
                @includeWhen(!isset($item), 'mconsole::forms.hidden', [
                    'name' => 'author_id',
                    'value' => Auth::user()->id,
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
                @include('mconsole::forms.select', [
                    'label' => trans('mconsole::news.form.pinned'),
                    'name' => 'pinned',
                    'value' => isset($item) ? $item->pinned : 0,
                    'type' => MconsoleFormSelectType::YesNo,
                ])
                @include('mconsole::forms.state', isset($item) ? $item : [])
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

        //$('[data-toggle="tooltip"]').tooltip();
        $('#popover-slug').popover({
            html : true,
            placement : 'bottom',
            trigger : 'hover',
        });

        $('[data-toggle="tooltip"]').tooltip();
	</script>
@endsection