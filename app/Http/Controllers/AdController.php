<?php

namespace App\Http\Controllers;

use App\Ad;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use League\Flysystem\Exception;

class AdController extends Controller
{
    public function index()
    {
        try {
            if ($user = Auth::id()) {
                $ads = Ad::with('user')->orderBy('created_at', 'desc')->paginate(5);
                return view('ads_list', ['ads' => $ads]);
            }
            return redirect('/');
        } catch (Exception $ex) {
            Session::put('notification', 'Произошла неизвестная ошибка, попробуйте повторить действие');
            return redirect('/');
        }
    }
    public function create() {
        return view('create_form');
    }
    public function store(Request $request) {
        try {
            $this->validate($request, [
                'title' => 'required|max:255',
                'description' => 'required',
            ]);
            $user = Auth::user();
            $ad = Ad::create([
                'user_id'     => $user->id,
                'title'       => $request->title,
                'author_name' => $user->login,
                'description' => $request->description
            ]);
            Session::put('notification', 'Вы добавили новое объявление');
            return redirect('/ad/' . $ad->id);
        } catch (Exception $e) {
            Session::put('notification', 'Произошла неизвестная ошибка, попробуйте повторить действие');
            return redirect('/');
        }
    }

    public function show($id)
    {
        try {
            $ad = Ad::find($id);
            $user = User::find($ad->user_id);
            return view('single_ad', ['ad' => $ad, 'user' => $user]);
        } catch (Exception $e) {
            Session::put('notification', 'Произошла неизвестная ошибка, попробуйте повторить действие');
            return redirect('/');
        }

    }

    public function edit($id) {
        try {
            $ad = Ad::find($id);
            $user = Auth::user();
            if ($ad->user_id == $user->id) {
                return view('edit_form', ['ad' => $ad, 'user' => $user]);
            }
            Session::put('notification', 'У вас нет прав для редактирования этого объявления!!!');
            return redirect('/ad');
        } catch (Exception $e) {
            Session::put('notification', 'Произошла неизвестная ошибка, попробуйте повторить действие');
            return redirect('/');
        }
    }

    public function update(Request $request)
    {
        try {
            $this->validate($request, [
                'title' => 'required|max:255',
                'description' => 'required',
            ]);
            $ad = Ad::find($request->id);
            $user = Auth::user();
            if ($ad->user_id == $user->id) {
                $ad = Ad::find($ad->id);
                $ad->title = $request->title;
                $ad->description = $request->description;
                $ad->save();
                Session::put('notification', 'Ваше объявление было успешно отредактированно');
                return view('single_ad', ['ad' => $ad, 'user' => $user]);
            }
            Session::put('notification', 'У вас нет прав для редактирования этого объявления!!!');
            return redirect('/ad');
        } catch (Exception $e) {
            Session::put('notification', 'Произошла неизвестная ошибка, попробуйте повторить действие');
            return redirect('/');
        }
    }

    public function destroy($id)
    {
        try {
            $ad = Ad::find($id);
            $user = Auth::user();
            if ($ad->user_id == $user->id) {
                Ad::find($ad->id)->delete();
                Session::put('notification', 'Ваше объявление было успешно удалено');

                return redirect('/');
            }
            Session::put('notification', 'У вас нет прав для удаления этого объявления!!!');
            return redirect('/');
        } catch (Exception $e) {
            Session::put('notification', 'Произошла неизвестная ошибка, попробуйте повторить действие');
            return redirect('/');
        }
    }
}
