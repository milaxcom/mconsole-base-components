<?php

namespace Milax\Mconsole\Pages\Http\Controllers;

use Milax;
use App\Http\Controllers\Controller;
use Milax\Mconsole\Pages\Http\Requests\PageRequest;
use Milax\Mconsole\Pages\Models\Page;
use Milax\Mconsole\Contracts\Localizator;
use Paginatable;
use Redirectable;
use HasQueryTraits;

class PagesController extends Controller
{
    use HasQueryTraits, Redirectable, Paginatable;

    protected $redirectTo = '/mconsole/pages';
    protected $model = 'Milax\Mconsole\Pages\Models\Page';
    
    public function __construct(Localizator $localizator)
    {
        $this->localizator = $localizator;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->setPerPage(20)->run('mconsole::pages.list', function ($item) {
            return [
                trans('mconsole::pages.table.id') => $item->id,
                trans('mconsole::pages.table.updated') => $item->updated_at->format('m.d.Y'),
                trans('mconsole::pages.table.slug') => $item->slug,
                trans('mconsole::pages.table.heading') => json_encode($item->heading),
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
        return view('mconsole::pages.form');
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
        if (strlen($request->input('links')) > 0) {
            $links = collect(json_decode($request->input('links'), true));
            $page->links()->whereNotIn('id', $links->lists('id'))->delete();
            
            foreach ($links as $link) {
                if (strlen($link['id']) > 0) {
                    if ($dbLink = Milax\Mconsole\Models\ContentLink::find((int) $link['id'])) {
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
        $page = Page::with('links')->find($id);
        return view('mconsole::pages.form', [
            'item' => $page,
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
        
        if (strlen($request->input('links')) > 0) {
            $links = collect(json_decode($request->input('links'), true));
            $page->links()->whereNotIn('id', $links->lists('id'))->delete();
            
            foreach ($links as $link) {
                if (strlen($link['id']) > 0) {
                    if ($dbLink = Milax\Mconsole\Models\ContentLink::find((int) $link['id'])) {
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
}
