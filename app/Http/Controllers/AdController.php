<?php

namespace App\Http\Controllers;

use App\Ad;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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
        } catch (\Exception $ex) {
            Session::flash('notification', 'Произошла неизвестная ошибка, попробуйте повторить действие');
            return redirect('/');
        }
    }
    public function create() {
        return view('create_form');
    }
    public function store(Request $request) {

        $v = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required',
        ]);
        if ($v->fails())
        {
            Session::flash('notification', 'Вы ввели невалидные данные');
            return redirect()->back();
        }
        $user = Auth::user();
        $ad = Ad::create([
            'user_id'     => $user->id,
            'title'       => $request->title,
            'author_name' => $user->login,
            'description' => $request->description
        ]);
        Session::flash('notification', 'Вы добавили новое объявление');
        return redirect('/ad/' . $ad->id);
    }

    public function show($id)
    {
        $ad = Ad::findOrFail($id);
        $user = User::findOrFail($ad->user_id);
        return view('single_ad', ['ad' => $ad, 'user' => $user]);
    }

    public function edit($id) {
        $ad = Ad::findOrFail($id);
        $user = Auth::user();
        if ($ad->user_id == $user->id) {
            return view('edit_form', ['ad' => $ad, 'user' => $user]);
        }
        Session::flash('notification', 'У вас нет прав для редактирования этого объявления!!!');
        return redirect('/ad');
    }

    public function update(Request $request, $id)
    {
        $v = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required',
        ]);
        if ($v->fails())
        {
            Session::flash('notification', 'Вы ввели невалидные данные');
            return redirect()->back();
        }
        $ad = Ad::findOrFail($id);
        $user = Auth::user();
        if ($ad->user_id == $user->id) {
            $ad->title = $request->title;
            $ad->description = $request->description;
            $ad->save();
            Session::flash('notification', 'Ваше объявление было успешно отредактированно');
            return view('single_ad', ['ad' => $ad, 'user' => $user]);
        }
        Session::flash('notification', 'У вас нет прав для редактирования этого объявления!!!');
        return redirect('/ad');
    }

    public function destroy($id)
    {
        $ad = Ad::findOrFail($id);
        $user = Auth::user();
        if ($ad->user_id == $user->id) {
            Ad::findOrFail($ad->id)->delete();
            Session::flash('notification', 'Ваше объявление было успешно удалено');
            return redirect('/');
        }
        Session::flash('notification', 'У вас нет прав для удаления этого объявления!!!');
        return redirect('/');
    }
}
