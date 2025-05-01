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
}
