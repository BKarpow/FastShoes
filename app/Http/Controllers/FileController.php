<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use App\Http\Resources\FileResource;

class FileController extends Controller
{
    /**
     * Upload file in storage
     */
    public function upload(Request $request)
    {
        $dirNameSave = 'files/'.$request->user()->id;
        $file = $request->file('file');
        $name = $file->getClientOriginalName();
        $ext = $file->extension();
        $path = $file->store('public/'.$dirNameSave);
        $path = str_replace('public/', '', $path);
        //Create item in database
        $file = new File();
        $file->name = $name;
        $file->uri = "/storage/{$path}";
        $file->path = storage_path("app/public/{$path}");
        $file->type = $ext;
        $file->save();
        return response($file->jsonSerialize(), 200);
    }

    /**
     * Delete from file
     * 
     */
    public function delete($fileId)
    {
        $file = File::findOrFail((int)$fileId);
        unlink($file->path);
        $file->delete();
        return response(null, 200);
    }

    /**
     * Getting item file from uri
     * 
     */
    public function getItemFileFromUri(Request $request)
    {
        $request->validate([
            'uri' => 'required|exists:files,uri',
        ]);

        $file = File::where([
            ['uri', '=', $request->uri],
        ])->first();
        if (!$file) {
            return response()->json(['message'=>'File not found!'], 404);
        }
        return new FileResource($file);
    }
}
