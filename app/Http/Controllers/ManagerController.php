<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ManagerController extends Controller
{
    public function check($id)
    {
        $record = Requests::findOrFail($id); 
        if (Auth::user()->role_id == 2 && $record->status == 'выполнено') {
            $record->status = 'проверка'; 
            $record->save(); 
            return redirect()->back()->with('success', 'Статус успешно изменен на "проверка".');
        } else {
            return redirect()->back()->with('error', 'У вас нет прав для изменения статуса этой записи.');
        }
    }

    public function markAsChecked($id)
    {
        $record = Requests::findOrFail($id); 
        if (Auth::user()->role_id == 2 && $record->status == 'проверка') {
            $record->status = 'проверено';
            $record->save(); 
            return redirect()->back()->with('success', 'Статус успешно изменен на "проверено".');
        } else {
            return redirect()->back()->with('error', 'У вас нет прав для изменения статуса этой записи.');
        }
    }

    public function updateExecutor(Request $request, $id)
    {
    // Валидация входящих данных
    $request->validate([
        'executor_id' => 'required|exists:users,id', // Убедитесь, что выбранный исполнитель существует
    ]);

    // Найдите заявку по ID
    $requestToUpdate = Requests::findOrFail($id);
    
    // Обновите ID исполнителя
    $requestToUpdate->executor_id = $request->executor_id;
    
    $requestToUpdate->status = 'В работе';

    //$requestToUpdate->deadline = $request->deadline;

    // Сохраните изменения
    $requestToUpdate->save();

    // Перенаправьте пользователя обратно на страницу с сообщением об успешном обновлении
    return redirect()->route('requests.request_show')->with('success', 'Исполнитель успешно изменен.');
    }

    
    public function requests_updateDeadline(Request $request, $id) {
        // Валидация входящих данных
        // $request->validate([
        //     'deadline' => 'required|exists:users,id', // Убедитесь, что выбранный исполнитель существует
        // ]);

        // Найдите заявку по ID
        $requestToUpdate = Requests::findOrFail($id);
    
        // Обновите ID исполнителя
        $requestToUpdate->deadline = $request->deadline;

        $requestToUpdate->save();

        return redirect()->route('requests.request_show');
    }

     public function requests_updatePriority(Request $request, $id) {
        $requestToUpdate = Requests::findOrFail($id);
    
        // Обновите ID исполнителя
        $requestToUpdate->priority = $request->priority;

        $requestToUpdate->save();

        return redirect()->route('requests.request_show');
     }

}
