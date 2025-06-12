<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Requests;
use App\Models\Equipment;
use App\Models\Equipment_type;
use App\Models\Problems;
use App\Models\Locations;
use App\Models\User;
use App\Models\Comment;
use App\Models\Simple_request;
use App\Notifications\EmailNotification;
use App\Events\BrowserNotifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function home() {
        return view('home');
    }

    public function request_type_choice() {
        return view('request_type_choice');
    }

    public function request_show_choice() {
        return view('request_show_choice');
    }

    public function simple_request() {
        $clients = User::where('role_id', 3)->get(); 
        return view('simple_request',  compact('clients'));
    }

    public function request() {
        //return view('request');
        $equipment = Equipment::all(); 

        $equipment_type = Equipment_type::all(); 

        $problem = Problems::all(); 

        $location = Locations::all(); 

        $executors = User::where('role_id', 4)->get();

        return view('request', compact('equipment', 'equipment_type', 'executors', 'problem', 'location')); 

    }

    public function request_send(Request $r) {

        $valid = $r->validate([
            //'title' => 'required',
            //'equipment_type' => 'required',
            'problem' => 'required',
            //'description' => 'required',
            //'deadline' => 'required',
            //'priority' => 'required',
            //'equipment_id' => 'required',
        ]);

        $request = new Requests();

        //$request->title = $r->input('title');
        $request->title = $r->input('problem');

        if ($r->input('description') == null) {
            $request->description = '-';
        } else {
            $request->description = $r->input('description');
        }

        $request->client = Auth::user()->name;
        //$request->client = $r->input('client'); 

        $request->deadline = $r->input('deadline');

        // if ($r->input('deadline') == '') {
        //     $request->deadline = '';
        // }
        
        $request->priority = $r->input('priority');
        // if ($request->priority === 'не выбрано') {
        //     // Логика для случая, когда ничего не выбрано
        // } else {
        //     // Логика для случая, когда выбрана опция
        // }


        if ($r->input('executor') == null) {
            $request->executor_id = null;
        } else {
            $request->executor_id = $r->input('executor');
        }
        //$request->executor = '-';

        $request->status = 'В ожидании исполнителя';
        $request->manager = '-';
        $request->equipment_id = $r->input('equipment_id');

        $request->save();

        $user = Auth::user(); 
        $user->notify(new EmailNotification('Вы сформировали заявку. Ожидайте, в скором времени её начнут выполнять', url('/request_show')));
        event(new BrowserNotifications('Это информационное уведомление.', 'info', 'Информация'));
        \Log::info('Событие BrowserNotifications вызвано');

        $executors = User::where('role_id', 4)->get();
        $managers = User::where('role_id', 2)->get();

        // Отправьте уведомление каждому из них
        foreach ($executors as $executor) {
            // Не отправляем уведомление текущему пользователю
            if ($executor->id !== $user->id) {
                $executor->notify(new EmailNotification('Появилась новая заявка', url('/request_show')));
            }
        }
        foreach ($managers as $manager) {
            // Не отправляем уведомление текущему пользователю
            if ($manager->id !== $user->id) {
                $manager->notify(new EmailNotification('Появилась новая заявка', url('/request_show')));
            }
        }

        return back();
    }

    public function simple_request_send(Request $r) {

        $valid = $r->validate([
            'title' => 'required',
            'deadline' => 'required',
        ]);

        $request = new Simple_request();

        $request->title = $r->input('title');

        $request->client_id = Auth::user()->id;

        $request->deadline = $r->input('deadline');

        $request->priority = $r->input('priority');

        if ($r->input('executor_id') == null) {
            $request->executor_id = null;
        } else {
            $request->executor_id = $r->input('executor_id');
        }

        $request->status = 'В ожидании исполнителя';

        $request->save();

        $user = Auth::user(); 
        $user->notify(new EmailNotification('Вы сформировали заявку. Ожидайте, в скором времени её начнут выполнять', url('/request_show')));

        $executors = User::where('role_id', 4)->get();

        foreach ($executors as $executor) {
            // Не отправляем уведомление текущему пользователю
            if ($executor->id !== $user->id) {
                $executor->notify(new EmailNotification('Появилась новая заявка на оказание помощи', url('/request_show')));
            }
        }

        return back();
    }

    public function request_show()
    {
        $user = Auth::user(); 

        $executors = User::where('role_id', 4)->get();

        if ($user->role_id == 3) {
            $requests = Requests::where('client', $user->name)->get();
        } elseif(($user->role_id == 4)) {
            $requests = Requests::where('executor_id', $user->id)->get();
        }
        else {
            //$requests = Requests::with('equipment')->get();
            $requests = Requests::with(['equipment'])->get();
            //$requests = Requests::all();
        }

        return view('request_show', compact('requests', 'executors'));
    }

    public function request_full($id)
    {
        $request = Requests::findOrFail($id); // Получаем заявку по ID
        $comments = Comment::where('request_id', $id)
                       ->orderBy('created_at', 'desc') // Сортируем по времени создания в обратном порядке
                       ->get(); // Получаем комментарии для этой заявки
        return view('request_full', compact('request', 'comments')); // Передаем данные в представление
    }


    public function simple_request_show()
    {
        $user = Auth::user(); 

        $executors = User::where('role_id', 4)->get();

        if ($user->role_id == 3) {
            $requests = Simple_request::where('client_id', $user->id)->get();
        } else {
            //$requests = Requests::with('equipment')->get();
            $requests = Simple_request::all();
            //$requests = Requests::all();
        }

        return view('simple_request_show', compact('requests', 'executors'));
    }

    public function simple_requests_accept($id)
    {
        $request = Simple_request::find($id);
        $request->executor_id = Auth::user()->id; 
        $request->status = 'в работе'; 
        $request->save();

        return redirect()->back()->with('success', 'Заявка принята и находится в работе.');
    }

    

    public function accept($id)
    {
        $request = Requests::find($id);
        $request->executor_id = Auth::user()->id; 
        $request->status = 'В работе'; 
        $request->save();
    
        
        // $client = User::find($request->client);

        // $client->notify(new EmailNotification('Исполнитель принял вашу заявку на выполнение', url('/request_show/' . $request->id)));
        

        return redirect()->back()->with('success', 'Заявка принята и находится в работе.');
    }
    
    public function complete($id)
    {
        $request = Requests::find($id);
        $request->status = 'Выполнено'; 
        $request->save();
    
        return redirect()->back()->with('success', 'Работа выполнена.');
    }

    public function simple_requests_complete($id)
    {
        $request = Simple_request::find($id);
        $request->status = 'Выполнено'; 
        $request->save();
    
        return redirect()->back()->with('success', 'Работа выполнена.');
    }

    public function markAsNotCompleted($id)
    {
        $request = Requests::find($id);
        $request->status = 'В работе'; 
        $request->save();

        return redirect()->back()->with('success', 'Работа помечена как не выполненная.');
    }

    public function decline($id)
    {
        $request = Requests::find($id);

        if ($request && $request->executor_id == Auth::user()->id) {
            //$request->executor_id = NULL; 
            $request->status = 'Не удаётся выполнить'; 
            $request->save();
            return redirect()->back();
        }

        return redirect()->back();
    }

    public function destroy($id)
    {
        $request = Requests::findOrFail($id); 

        if (Auth::user()->name == $request->client) {
            $request->delete();
            return redirect()->back()->with('success', 'Запись успешно удалена.');
        } else {
            return redirect()->back()->with('error', 'У вас нет прав для удаления этой записи.');
        }
    }

    public function simple_requests_destroy($id)
    {
        $request = Simple_request::findOrFail($id); 

        if (Auth::user()->id == $request->client_id) {
            $request->delete();
            return redirect()->back()->with('success', 'Запись успешно удалена.');
        } else {
            return redirect()->back()->with('error', 'У вас нет прав для удаления этой записи.');
        }
    }

    public function profile_show()
    {
        $user = Auth::user(); 
        return view('profile', compact('user')); 
    }

}
