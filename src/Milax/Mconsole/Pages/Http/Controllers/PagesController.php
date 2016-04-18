<?php

namespace Milax\Mconsole\Pages\Http\Controllers;

use Milax;
use App\Http\Controllers\Controller;
use Milax\Mconsole\Pages\Http\Requests\PageRequest;
use Milax\Mconsole\Pages\Models\Page;
use Milax\Mconsole\Pages\Models\ContentLink;

class PagesController extends Controller
{
    use \HasQueryTraits, \HasRedirects, \HasPaginator;

    protected $redirectTo = '/mconsole/pages';
    protected $model = 'Milax\Mconsole\Pages\Models\Page';
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->setPerPage(20)->run('mconsole::pages.list', function ($item) {
            return [
                '#' => $item->id,
                trans('mconsole::pages.table.updated') => $item->updated_at->format('m.d.Y'),
                trans('mconsole::pages.table.slug') => $item->slug,
                trans('mconsole::pages.table.heading') => collect($item->heading)->transform(function ($val, $key) {
                    if (strlen($val) > 0) {
                        return sprintf('%s (%s)', $val, $key);
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
        return view('mconsole::pages.form', [
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
    public function store(PageRequest $request)
    {
        $page = Page::create($request->all());
        
        $this->handleImages($page);
        
        if (strlen($request->input('links')) > 0) {
            $links = collect(json_decode($request->input('links'), true));
            $page->links()->whereNotIn('id', $links->lists('id'))->delete();
            
            foreach ($links as $link) {
                if (strlen($link['id']) > 0) {
                    if ($dbLink = ContentLink::find((int) $link['id'])) {
                        $dbLink->update($link);
                    } else {
                        $page->links()->create($link);
                    }
                } else {
                    $page->links()->create($link);
                }
            }
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
        $page = Page::with('links')->with('uploads')->find($id);
        return view('mconsole::pages.form', [
            'item' => $page,
            'languages' => \Milax\Mconsole\Models\Language::all(),
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
    public function update(PageRequest $request, $id)
    {
        $page = Page::find($id);
        
        $this->handleImages($page);
        
        if (strlen($request->input('links')) > 0) {
            $links = collect(json_decode($request->input('links'), true));
            $page->links()->whereNotIn('id', $links->lists('id'))->delete();
            
            foreach ($links as $link) {
                if (strlen($link['id']) > 0) {
                    if ($dbLink = ContentLink::find((int) $link['id'])) {
                        $dbLink->update($link);
                    } else {
                        $page->links()->create($link);
                    }
                } else {
                    $page->links()->create($link);
                }
            }
        }
        
        $page->update($request->all());
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
        $page = Page::find($id);
        if ($page->system) {
            return redirect()->back()->withErrors(trans('mconsole::mconsole.errors.system'));
        }

        Page::destroy($id);
    }
    
    /**
     * Handle images upload
     *
     * @param Milax\Mconsole\Pages\Models\Page $page [Page object]
     * @return void
     */
    protected function handleImages($page)
    {
        // Images processing
        app('API')->uploads->handle(function ($images) use (&$page) {
            app('API')->uploads->attach([
                'group' => 'gallery',
                'images' => $images,
                'related' => $page,
            ]);
            app('API')->uploads->attach([
                'group' => 'cover',
                'images' => $images,
                'related' => $page,
                'unique' => true,
            ]);
        });
    }
}