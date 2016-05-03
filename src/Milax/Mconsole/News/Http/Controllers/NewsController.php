<?php

namespace Milax\Mconsole\News\Http\Controllers;

use App\Http\Controllers\Controller;
use Milax\Mconsole\News\Http\Requests\NewsRequest;
use Milax\Mconsole\News\Models\News;
use Milax\Mconsole\Contracts\ListRenderer;
use Milax\Mconsole\Contracts\FormRenderer;
use Milax\Mconsole\Contracts\Repository;

class NewsController extends Controller
{
    use \HasRedirects, \DoesNotHaveShow;

    protected $redirectTo = '/mconsole/news';
    protected $model = 'Milax\Mconsole\News\Models\News';
    
    /**
     * Create new class instance
     */
    public function __construct(ListRenderer $list, FormRenderer $form, Repository $repository)
    {
        $this->list = $list;
        $this->form = $form;
        $this->repository = $repository;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->list->setText(trans('mconsole::news.form.heading'), 'heading')
            ->setText(trans('mconsole::news.form.text'), 'text')
            ->setSelect(trans('mconsole::settings.options.enabled'), 'enabled', [
                '1' => trans('mconsole::settings.options.on'),
                '0' => trans('mconsole::settings.options.off'),
            ], true)
            ->setDateRange(trans('mconsole::news.form.published_at'), 'published_at');
        
        return $this->list->setQuery($this->repository->index())->setAddAction('news/create')->render(function ($item) {
            return [
                '#' => $item->id,
                trans('mconsole::news.table.published') => $item->published_at ? $item->published_at->format('m.d.Y') : null,
                trans('mconsole::news.table.updated') => $item->updated_at->format('m.d.Y'),
                trans('mconsole::news.table.slug') => $item->slug,
                trans('mconsole::news.table.heading') => collect($item->heading)->transform(function ($val, $key) {
                    if (strlen($val) > 0) {
                        return sprintf('<div class="label label-info">%s</div> %s', $key, $val);
                    }
                })->values()->implode('<br />'),
                trans('mconsole::tables.state.name') => view('mconsole::indicators.state', $item),
            ];
        });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->form->render('mconsole::news.form', [
            'languages' => \Milax\Mconsole\Models\Language::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(NewsRequest $request)
    {
        $news = $this->repository->create($request->all());
        
        $this->handleUploads($news);
        app('API')->tags->sync($news);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->form->render('mconsole::news.form', [
            'item' => $this->repository->find($id),
            'languages' => \Milax\Mconsole\Models\Language::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(NewsRequest $request, $id)
    {
        $news = $this->repository->find($id);
        
        $this->handleUploads($news);
        app('API')->tags->sync($news);
        
        $this->repository->update($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->destroy($id);
    }
    
    /**
     * Handle files upload
     *
     * @param Milax\Mconsole\News\Models\News $news [News object]
     * @return void
     */
    protected function handleUploads($news)
    {
        // Images processing
        app('API')->uploads->handle(function ($uploads) use (&$news) {
            app('API')->uploads->attach([
                'group' => 'gallery',
                'uploads' => $uploads,
                'related' => $news,
            ]);
            app('API')->uploads->attach([
                'group' => 'cover',
                'uploads' => $uploads,
                'related' => $news,
                'unique' => true,
            ]);
        });
    }
}
