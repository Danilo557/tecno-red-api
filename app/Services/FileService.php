<?php

namespace App\Services;

use App\Http\Resources\FileResource;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function all()
    {
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => FileResource::collection(File::included()
                ->filter()
                ->sort()
                ->getOrPaginate()),
        ], 200);
    }


    public function show($id)
    {
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => FileResource::make(File::included()->findOrFail($id)),
        ], 200);
    }


    public function store(Request $request)
    {
        if ($request->file('file')) {
            $extension = $request->file->getClientOriginalExtension();
            $url = time() . '.' . $extension;
            $url = $request->file('file')->storeAs('posts', $url, 'public');
            $request["type"] = File::IMAGE;
            if (strtolower($extension) == 'pdf') {
                $request["type"] = File::FILE;
            }
            $request["url"] = $url;
        }

        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => FileResource::make(File::create($request->all()))
        ], 200);
    }

    public function update(Request $request, File $file)
    {
        $file->update($request->all());
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => FileResource::make($file),
        ], 200);
    }

    public function destroy(File $file)
    {
        Storage::delete('public/' . $file->url);

        $file->delete();
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => FileResource::make($file),
        ], 200);
    }
}
