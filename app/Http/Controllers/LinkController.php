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

    return $links->get(["link_id", "url", "title", "created_at", "updated_at"]);
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

    return Redirect::route('dashboard');
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
  public function destroy($id)
  {
    $link = Link::where("link_id", $id)->where("user_id", auth()->user()->id)->first();

    if ($link) {
      $link->delete();
    }

    return $link;
  }
}
