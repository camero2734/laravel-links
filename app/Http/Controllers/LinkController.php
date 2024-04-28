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

    return $links->get();
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $params = $request->validate([
      'title' => 'required|string',
      'url' => 'required|url',
    ]);

    $link = new Link($params);
    $link["user_id"] = auth()->user()->id;
    $link->save();

    return $link;
  }

  /**
   * Redirect to the specified resource.
   */
  public function show($link_id)
  {
    $link = Link::where("link_id", $link_id)->first();
    return Redirect::to($link->url);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update($link_id, Request $request)
  {
    // Ensure the link exists and belongs to the user
    $link = Link::where("link_id", $link_id)->where("user_id", auth()->user()->id)->first();

    if (!$link) abort(404, "Link not found.");

    $params = $request->validate([
      "title" => "required|string",
      "url" => "required|url",
    ]);

    $link->update($params);

    return $link;
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($link_id)
  {
    // Ensure the link exists and belongs to the user
    $link = Link::where("link_id", $link_id)->where("user_id", auth()->user()->id)->first();

    if (!$link) abort(404, "Link not found.");

    $link->delete();
    return $link;
  }
}
