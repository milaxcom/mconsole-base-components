@extends('mconsole::app')

@section('content')

<div class="row">
	<div class="col-sm-6">
		@if (isset($item))
			{!! Form::model($item, ['method' => 'PUT', 'route' => ['mconsole.news.update', $item->id]]) !!}
		@else
			{!! Form::open(['method' => 'POST', 'url' => '/mconsole/news']) !!}
		@endif
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
				
				@include('mconsole::forms.textarea', [
					'label' => trans('mconsole::news.form.preview'),
					'name' => 'preview',
				])
				@include('mconsole::forms.textarea', [
					'label' => trans('mconsole::news.form.text'),
					'name' => 'text',
				])
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
		{!! Form::close() !!}
	</div>
</div>

@endsection