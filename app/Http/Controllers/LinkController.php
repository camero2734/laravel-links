<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      // This ideally would have pagination
      $links = Link::orderBy("created_at", "desc")->where("user_id", auth()->user()->id);

      return Inertia::render("Links/Index", [
        "links" => $links->get(["link_id", "url", "title", "created_at", "updated_at"])
      ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return Inertia::render("Links/Create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      // TODO: Validate request
      $link = new Link($request->all());
      $link["user_id"] = auth()->user()->id;
      $link->save();

      return Redirect::route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(Link $link)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Link $link)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Link $link)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link)
    {
        //
    }
}
