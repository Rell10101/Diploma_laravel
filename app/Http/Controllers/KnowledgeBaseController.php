<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class KnowledgeBaseController extends Controller
{
    public function index()
    {
        $files = scandir(public_path('public/knowledge_base'));
        $files = array_diff($files, ['.', '..']); // Убираем . и ..
        return view('knowledge_base.index', compact('files'));
    }

    public function show($filename)
    {
        $path = public_path('public/knowledge_base/' . $filename);
        
        if (!file_exists($path)) {
            abort(404);
        }

        $content = file_get_contents($path);
        return view('knowledge_base.show', compact('content', 'filename'));
    }
}
