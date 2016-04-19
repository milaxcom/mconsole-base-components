<?php

namespace Milax\Mconsole\News\Http\Controllers;

use App\Http\Controllers\Controller;
use Milax\Mconsole\News\Http\Requests\NewsRequest;
use Milax\Mconsole\News\Models\News;

class NewsController extends Controller
{
    use \HasQueryTraits, \HasRedirects, \HasPaginator;

    protected $redirectTo = '/mconsole/news';
    protected $model = 'Milax\Mconsole\News\Models\News';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->setPerPage(20)->run('mconsole::news.list', function ($item) {
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
        return view('mconsole::news.form', [
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
        
        $this->handleImages($news);
        
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
    public function edit($id)
    {
        return view('mconsole::news.form', [
            'item' => News::find($id),
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
        $news = News::find($id);
        
        $this->handleImages($news);
        
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
     * Handle images upload
     *
     * @param Milax\Mconsole\News\Models\News $news [News object]
     * @return void
     */
    protected function handleImages($news)
    {
        // Images processing
        app('API')->uploads->handle(function ($images) use (&$news) {
            app('API')->uploads->attach([
                'group' => 'gallery',
                'images' => $images,
                'related' => $news,
            ]);
        });
    }
}
