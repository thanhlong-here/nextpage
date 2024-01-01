<?php

namespace App\Http\Controllers;

use App\Models\Unit\Content;
use App\Http\Requests\StoreContentRequest;
use App\Http\Requests\UpdateContentRequest;
use App\Models\Unit\Media;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Content $content)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Content $content)
    {
        $content->access();
        return  $content;
    }
    /**
     * Update the specified resource in storage.
     */
    public function addMedia(Request $request, Content $content)
    {
        foreach ($request->media as $file) {
            $media = Media::create(['file' => $file]);
            $srcs[] =$media->src;
            $ids[] = $media->id;
        }
        $content->medias()->sync($ids);

        return [
            'status' => true,
            'src' => $srcs ?? [],
        ];
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContentRequest $request, Content $content)
    {
        return [
            'status' => $content->update($request->input())
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Content $content)
    {
        //
    }
}
