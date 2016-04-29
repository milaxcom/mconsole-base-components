<?php

namespace Milax\Mconsole\Pages\Http\Controllers;

use App\Http\Controllers\Controller;
use Milax\Mconsole\Pages\Http\Requests\PageRequest;
use Milax\Mconsole\Pages\Models\Page;
use Milax\Mconsole\Pages\Models\ContentLink;
use Milax\Mconsole\Contracts\ListRenderer;
use Milax\Mconsole\Contracts\FormRenderer;
use Milax\Mconsole\Contracts\Repository;

class PagesController extends Controller
{
    use \HasRedirects, \DoesNotHaveShow;

    protected $redirectTo = '/mconsole/pages';
    protected $model = 'Milax\Mconsole\Pages\Models\Page';
    
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
        $this->list->setText(trans('mconsole::pages.form.heading'), 'heading')
            ->setText(trans('mconsole::pages.form.text'), 'text')
            ->setSelect(trans('mconsole::settings.options.enabled'), 'enabled', [
                '1' => trans('mconsole::settings.options.on'),
                '0' => trans('mconsole::settings.options.off'),
            ], true);
        
        return $this->list->setQuery($this->repository->index())->setAddAction('pages/create')->render(function ($item) {
            return [
                '#' => $item->id,
                trans('mconsole::pages.table.updated') => $item->updated_at->format('m.d.Y'),
                trans('mconsole::pages.table.slug') => $item->slug,
                trans('mconsole::pages.table.heading') => collect($item->heading)->transform(function ($val, $key) {
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
        return $this->form->render('mconsole::pages.form', [
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
        $page = $this->repository->create($request->all());
        $this->handleUploads($page);
        app('API')->links->sync($page);
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
        return $this->form->render('mconsole::pages.form', [
            'item' => $this->repository->query()->with('links')->with('uploads')->find($id),
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
        $page = $this->repository->find($id);
        
        $this->handleUploads($page);
        app('API')->links->sync($page);
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
        $page = $this->repository->find($id);
        
        if ($page->system) {
            return redirect()->back()->withErrors(trans('mconsole::mconsole.errors.system'));
        }
        
        $page->delete();
    }
    
    /**
     * Handle uploads upload
     *
     * @param Milax\Mconsole\Pages\Models\Page $page [Page object]
     * @return void
     */
    protected function handleUploads($page)
    {
        // Images processing
        app('API')->uploads->handle(function ($uploads) use (&$page) {
            app('API')->uploads->attach([
                'group' => 'gallery',
                'uploads' => $uploads,
                'related' => $page,
            ]);
            app('API')->uploads->attach([
                'group' => 'cover',
                'uploads' => $uploads,
                'related' => $page,
                'unique' => true,
            ]);
        });
    }
}
