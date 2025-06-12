<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function store(Request $request, $requestId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);


        $comment = new Comment();

        //$request->title = $r->input('title');
        $comment->content = $request->input('content');

        $comment->user_id = Auth::user()->id;
        $comment->request_id = $requestId;
        $comment->save();
        // Comment::create([
        //     'request_id' => $requestId,
        //     'user_id' => Auth::user()->id, // Получаем ID текущего аутентифицированного пользователя
        //     'content' => $request->content,
        // ]);

        return back();
    }

    // public function show($requestId)
    // {
    //     $comments = Comment::where('request_id', $requestId)->get();
    //     return view('request_full', compact('comments'));
    // }

    

}
