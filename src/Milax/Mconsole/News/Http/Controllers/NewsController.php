<?php

namespace Milax\Mconsole\News\Http\Controllers;

use App\Http\Controllers\Controller;
use Milax\Mconsole\News\Http\Requests\NewsRequest;
use Milax\Mconsole\News\Models\News;
use Milax\Mconsole\Contracts\ListRenderer;
use Milax\Mconsole\Contracts\FormRenderer;

class NewsController extends Controller
{
    use \HasRedirects;

    protected $redirectTo = '/mconsole/news';
    protected $model = 'Milax\Mconsole\News\Models\News';
    
    /**
     * Create new class instance
     */
    public function __construct(ListRenderer $list, FormRenderer $form)
    {
        $this->list = $list;
        $this->form = $form;
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
            ], true);
        
        return $this->list->setQuery(News::query())->setAddAction('news/create')->render(function ($item) {
            return [
                '#' => $item->id,
                trans('mconsole::news.table.published') => $item->published_at->format('m.d.Y'),
                trans('mconsole::news.table.updated') => $item->updated_at->format('m.d.Y'),
                trans('mconsole::news.table.slug') => $item->slug,
                trans('mconsole::news.table.heading') => collect($item->heading)->transform(function ($val, $key) {
                    if (strlen($val) > 0) {
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
        $news = News::create($request->all());
        
        $this->handleUploads($news);
        
        if (!is_null($tags = $request->input('tags'))) {
            $news->tags()->sync($tags);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        return $this->form->render('mconsole::news.form', [
            'item' => $news,
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
        $news = News::findOrFail($id);
        
        $this->handleUploads($news);
        
        if (!is_null($tags = $request->input('tags'))) {
            $news->tags()->sync($tags);
        } else {
            $news->tags()->detach();
        }
        
        $news->update($request->all());
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
        News::destroy($id);
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
