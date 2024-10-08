<?php

namespace Milax\Mconsole\Pages\Http\Controllers;

use Milax\Mconsole\Http\Controllers\ModuleController as Controller;
use Milax\Mconsole\Pages\Http\Requests\PageRequest;
use Milax\Mconsole\Pages\Models\Page;
use Milax\Mconsole\Pages\Models\ContentLink;
use Milax\Mconsole\Contracts\ListRenderer;
use Milax\Mconsole\Contracts\FormRenderer;
use Milax\Mconsole\Pages\Contracts\Repositories\PagesRepository;

class PagesController extends Controller
{
    use \HasRedirects, \DoesNotHaveShow, \UseLayout;

    protected $model = 'Milax\Mconsole\Pages\Models\Page';

    protected $form, $list, $module, $repository, $redirectTo;
    
    /**
     * Create new class instance
     */
    public function __construct(ListRenderer $list, FormRenderer $form, PagesRepository $repository)
    {
        parent::__construct();
        
        $this->setCaption(trans('mconsole::pages.menu'));
        $this->list = $list;
        $this->form = $form;
        $this->repository = $repository;
        $this->redirectTo = mconsole_url('pages');
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

        $user = \Auth::user();
        $query = $this->repository->index();

        if ($user->update_own)
            $query = $query->where('author_id', $user->id);
        
        return $this->list->setQuery($query)->setAddAction('pages/create')->render(function ($item) {
            return [
                trans('mconsole::tables.state') => view('mconsole::indicators.state', $item),
                trans('mconsole::tables.id') => $item->id,
                trans('mconsole::pages.table.updated') => $item->updated_at->format('m.d.Y'),
                trans('mconsole::pages.table.slug') => $item->slug,
                trans('mconsole::pages.table.heading') => collect($item->heading)->transform(function ($val, $key) {
                    if (!is_null($val) && strlen($val) > 0) {
                        return sprintf('<div class="label label-info">%s</div> %s', $key, $val);
                    }
                })->values()->reject(function ($lang) {
                    return is_null($lang);
                })->implode('<br />'),
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
        return $this->form->render('mconsole::pages.form');
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
        #$test = $this->repository->query()->with(['links', 'uploads'])->findOrFail($id);
        #$links = $test->uploads;
        #dd($test, $links);
        return $this->form->render('mconsole::pages.form', [
            'item' => $this->repository->query()->with('links')->with('uploads')->findOrFail($id),
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

        #$this->repository->update($id, $request->except('links'));
        $page->update($request->all());
        
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
        $page = $this->repository->find($id);
        
        if ($page->system) {
            return redirect()->back()->withErrors(trans('mconsole::mconsole.errors.system'));
        }
        
        $page->delete();
        
        $this->redirect();
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
