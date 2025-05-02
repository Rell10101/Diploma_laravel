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

    public function create()
    {
        return view('knowledge_base.upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:txt|max:2048', // Ограничение на тип и размер файла
        ]);

        $file = $request->file('file');
        $filename = $file->getClientOriginalName(); // Получаем оригинальное имя файла
        $file->move(public_path('public/knowledge_base'), $filename); // Перемещаем файл в папку

        return redirect()->route('knowledge_base.upload.form')->with('success', 'Файл успешно загружен!');
    }
}
