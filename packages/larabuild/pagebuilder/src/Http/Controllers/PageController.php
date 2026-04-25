<?php

namespace Larabuild\Pagebuilder\Http\Controllers;

use Larabuild\Pagebuilder\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Larabuild\Pagebuilder\Facades\PageSettings;

class PageController extends Controller {
    /**
     * Display a listing of the pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $edit = false;
        $pages = Page::when($request->input('search'), fn ($q) => $q->where('name', 'like',  '%' . $request->input('search') . '%'))->orderBy('id', $request->input('sort') ?? 'asc')->paginate($request->input('per_page') ?? 10);


        $pagesList = view('pagebuilder::components.pages-list', compact('pages'))->render();

        $per_page_opt = perPageOpt();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'html' => $pagesList]);
        }

        return view('pagebuilder::pages', compact('pagesList', 'per_page_opt', 'edit'));
    }


    /**
     * Show the form for creating/edit a page.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $edit = false;

        $page = [];

        $pages = Page::paginate(10);
        $per_page_opt = perPageOpt();
        if ($request->ajax()) {
            return response()->json(['success' => true, 'html' => view('pagebuilder::components.update-page', compact('edit', 'page'))->render()]);
        }
    }

    /**
     * Store a newly created page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if (isDemoSite())
            return response()->json(['success' => 'demo']);
        return PageSettings::storePage($request);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the page.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id) {
        $edit = true;

        $page = Page::findOrFail($id);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'status' => $page->status, 'html' => view('pagebuilder::components.update-page', compact('edit', 'page'))->render()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        if (isDemoSite())
            return response()->json(['success' => 'demo']);
        Page::find($id)->delete();
        Cache::forget('pagebuilder__pageData_' . $id);
        return response()->json(['success' => true]);
    }
}
