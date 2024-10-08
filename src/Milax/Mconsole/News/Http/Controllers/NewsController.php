<?php

namespace Milax\Mconsole\News\Http\Controllers;

use Milax\Mconsole\Http\Controllers\ModuleController as Controller;
use Milax\Mconsole\News\Http\Requests\NewsRequest;
use Milax\Mconsole\News\Models\News;
use Milax\Mconsole\Contracts\ListRenderer;
use Milax\Mconsole\Contracts\FormRenderer;
use Milax\Mconsole\News\Contracts\Repositories\NewsRepository;

class NewsController extends Controller
{
    use \HasRedirects, \DoesNotHaveShow, \UseLayout;

    protected $model = 'Milax\Mconsole\News\Models\News';

    protected $list, $form, $repository, $redirectTo, $module;
    
    /**
     * Create new class instance
     */
    public function __construct(ListRenderer $list, FormRenderer $form, NewsRepository $repository)
    {
        parent::__construct();
        
        $this->setCaption(trans('mconsole::news.menu'));
        $this->redirectTo = mconsole_url('news');
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

        $user = \Auth::user();
        $dateFormat = $user->lang == 'en' ? 'Y-m-d' : 'd-m-Y';

        $query = $this->repository->index()->orderBy('pinned', 'desc')->orderBy('published_at', 'desc');

        if ($user->update_own)
            $query = $query->where('author_id', $user->id);
        
        return $this->list->setQuery($query)->setAddAction('news/create')->render(function ($item) use ($dateFormat) {
            return [
                trans('mconsole::tables.state') => view('mconsole::indicators.state', $item),
                trans('mconsole::tables.id') => $item->id,
                trans('mconsole::news.table.published') => $item->published_at ? $item->published_at->format($dateFormat) : null,
                trans('mconsole::news.table.updated') => $item->updated_at->format($dateFormat),
                trans('mconsole::news.table.slug') => $item->slug,
                trans('mconsole::news.table.heading') => collect($item->heading)->transform(function ($val, $key) {
                    if (!is_null($val) && strlen($val) > 0) {
                        return sprintf('<div class="label label-info">%s</div> %s', $key, $val);
                    }
                })->values()->implode('<br />'),
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
        return $this->form->render('mconsole::news.form');
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

        $this->redirect();
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
        
        $this->redirect();
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
        
        $this->redirect();
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
