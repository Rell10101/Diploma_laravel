<?php

namespace App\Http\Controllers;

use App\Models\Contact;
//use App\Contact;
use App\Models\Requests;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function home() {
        return view('home');
    }

    public function about() {
        return view('about');
    }

    public function review() {
        $reviews = new Contact();
        return view('review', ['reviews' => $reviews->all()]);
    }

    public function review_check(Request $request) {
        $valid = $request->validate([
            'email' => 'required|min:4|max:100',
            'subject' => 'required|min:4|max:100',
            'message' => 'required|min:15|max:500',
        ]);

        $review = new Contact();
        $review->email = $request->input('email');
        $review->subject = $request->input('subject');
        $review->message = $request->input('message');

        $review->save();

        return redirect()->route('review');
    }

    public function request() {
        return view('request');
    }

    public function request_send(Request $r) {
        //redirect()->route('send_request');
        $valid = $r->validate([
            'title' => 'required|min:4|max:100',
            'description' => 'required|min:15|max:500',
            'deadline' => 'required',
            'priority' => 'required',
            'equipment_id' => 'required',
        ]);

        $request = new Requests();
        $request->title = $r->input('title');
        $request->description = $r->input('description');
        $request->client = $r->input('client'); //'client_default';
        $request->deadline = $r->input('deadline');
        $request->priority = $r->input('priority');
        $request->executor = 'none';
        $request->status = 'undone';
        $request->manager = 'none';
        $request->equipment_id = $r->input('equipment_id');

        $request->save();

        return back();
    }

    // public function request_show() {
    //     return view('request_show');
    // }

    public function request_show()
    {
        // Получите все записи из таблицы requests
        $requests = Requests::all();

        // Передайте данные в представление
        return view('request_show', compact('requests'));
    }
}
