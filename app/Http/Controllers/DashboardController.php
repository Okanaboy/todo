<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {
        if(Auth::user()->hasRole('superadmin'))
        {
            return view('admin.index');
        }
        elseif(Auth::user()->hasRole('user'))
        {
            return view('user.index');
        }
    }

    public function todos()
    {
        $this->middleware('role:superadmin');
        Carbon::setLocale('fr');
        $todos = Todo::latest()->paginate(15);
        return view('admin.todo.index', compact('todos'));
    }

    public function users()
    {
        $this->middleware('role:superadmin');
        Carbon::setLocale('fr');
        $users = User::latest()->paginate(15);
        return view('admin.user.index', compact('users'));
    }

    public function showTodo(Todo $todo)
    {
        Carbon::setLocale('fr');
        return view('admin.todo.show', compact('todo'));
    }

    public function todoEdit(Todo $todo)
    {
        if ($todo->status == 0) {
            $todo->update([
                'status' => '1'
            ]);
        }
        else
        {
            $todo->update([
                'status' => '0'
            ]);
        }

        return redirect()->back();
    }

    public function todoTrashed()
    {
        $todos = Todo::onlyTrashed()->latest()->paginate(15);

        return view('admin.todo.trashed', compact('todos'));
    }

    public function userTrashed()
    {
        $users = User::onlyTrashed()->latest()->paginate(15);

        return view('admin.user.trashed', compact('users'));
    }

    public function completed()
    {
        $todos = Todo::where('status', '1')->latest()->paginate(15);

        return view('admin.todo.completed', compact('todos'));
    }

    public function uncompleted()
    {
        $todos = Todo::where('status', '0')->latest()->paginate(15);

        return view('admin.todo.uncompleted', compact('todos'));
    }
}
