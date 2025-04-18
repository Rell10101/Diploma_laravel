<?php

namespace App\Http\Controllers;

use App\Models\Contact;
//use App\Contact;
use App\Models\Requests;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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
        $user = Auth::user(); // Получаем текущего аутентифицированного пользователя
        // Получите все записи из таблицы requests
        //$requests = Requests::all();

        if ($user->role_id == 3) {
            // Если роль клиента, фильтруем записи по имени
            $requests = Requests::where('client', $user->name)->get();
        } else {
            // Если не клиент, получаем все записи или обрабатываем по-другому
            $requests = Requests::all();
        }

        // Передайте данные в представление
        return view('request_show', compact('requests'));
    }

    public function accept($id)
    {
        $request = Requests::find($id);
        $request->executor = Auth::user()->name; // Назначаем исполнителя
        $request->status = 'in_progress'; // Обновляем статус на "в работе"
        $request->save();
    
        return redirect()->back()->with('success', 'Заявка принята и находится в работе.');
    }
    

    public function complete($id)
    {
        $request = Requests::find($id);
        $request->status = 'completed'; // Обновляем статус на выполнено
        $request->save();
    
        return redirect()->back()->with('success', 'Работа выполнена.');
    }
    public function markAsNotCompleted($id)
    {
    $request = Requests::find($id);
    $request->status = 'in_progress'; // Возвращаем статус к "в работе"
    $request->save();

    return redirect()->back()->with('success', 'Работа помечена как не выполненная.');
    }



    public function decline($id)
    {
        $request = Requests::find($id);
        if ($request && $request->executor == Auth::user()->name) {
            $request->executor = 'none'; // Убираем исполнителя
            $request->status = 'Ожидает исполнителя'; // Обновляем статус, если необходимо
            $request->save();
            return redirect()->back()->with('success', 'Вы отказались от выполнения заявки.');
        }

        return redirect()->back()->with('error', 'Не удалось отказаться от заявки.');
    }

    public function destroy($id)
    {
        $record = Requests::findOrFail($id); 

        // Проверяем, имеет ли пользователь право удалить запись
        if (Auth::user()->name == $record->client) {
            $record->delete();
            return redirect()->back()->with('success', 'Запись успешно удалена.');
        } else {
            return redirect()->back()->with('error', 'У вас нет прав для удаления этой записи.');
        }
    }


    public function users_show()
    {
        //$users = User::all();
        //return view('users_show', compact('users'));

        
        $currentUserName = Auth::user()->name;
        $users = User::where('name', '!=', $currentUserName)->get();
        return view('users_show', compact('users'));
    }

    public function updateRole(Request $request, $id)
    {
        

        // Найдите пользователя по ID и обновите его роль
        $user = User::findOrFail($id);
        $user->role_id = $request->role_id;
        $user->save();

        // Перенаправление с сообщением об успехе
        return redirect()->route('users.users_show')->with('success', 'Роль пользователя обновлена!');
    }

    public function profile_show()
    {
        $user = Auth::user(); // Получаем текущего аутентифицированного пользователя
        return view('profile', compact('user')); // Передаем пользователя в представление
    }


    public function chat()
    {
        return view('chat');
    }

    public function chat_accept(Request $request)
    {
        // это нужно передать ollama
        //$r->input('message');

        $response = Http::post('http://localhost:11434/api/generate', [
            'model' => 'deepseek-r1:1.5b',  // Название модели
            'prompt' => $request->input('message'),  // Ваш запрос
            'language' => 'ru',
            'stream' => false,     // Отключить потоковый ответ
            'options' => [
                'temperature' => 0.2,
                'num_predict' => 1000
            ]
        ]);

        $message = $response->json()['response']; // Получаем сообщение от бота
        $message = str_replace('<think>', '', $message); // Убираем <think>
        $message = str_replace('</think>', '', $message); // Убираем </think>
            
        if ($response->successful()) {
            //return $response->json()['response'];
            //printf($response->json()['response']);
            return view('chat', ['data' => $message]);
        }

        //return response()->json(['error' => 'Ошибка запроса'], 500);
        //printf(response()->json(['error' => 'Ошибка запроса'], 500));
        return view('chat', ['data' => response()->json(['error' => 'Ошибка запроса'], 500)]);
    }
}
