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
                trans('mconsole::news.table.heading') => $item->heading,
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
        return view('mconsole::news.form');
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
        $news->tags()->sync($request->input('tags'));
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
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(NewsRequest $request, $id)
    {
        $news = News::find($id);
        $news->tags()->sync($request->input('tags'));
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
}
