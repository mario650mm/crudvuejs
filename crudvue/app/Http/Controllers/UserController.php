<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index($success = null, $message = null)
    {
        switch ($success) {
            case "create":
                return redirect('/users/list')->with('success', $message);
                break;
            case "update":
                return redirect('/users/list')->with('warning', $message);
                break;
        }
        return view("users.index");
    }

    public function getUsers(Request $request)
    {
        $page = $request->currentPage;
        $results = User::where('name', 'like', "%$request->name%")
            ->orderBy('updated_at', 'DESC')->latest()->paginate(10);
        foreach ($results as $result) {
            $result->cityName = $result->city != null ? $result->city->name : "";
            $result->stateName = $result->state != null ? $result->state->name : "";
            $result->countryName = $result->country != null ? $result->country->name : "";
        }
        $response = [
            'pagination' => [
                'total' => $results->total(),
                'per_page' => $results->perPage(),
                'current_page' => $page != null ? $page : 1,
                'last_page' => $results->lastPage(),
                'from' => $results->firstItem(),
                'to' => $results->lastItem()
            ],
            'data' => $results
        ];
        return response()->json(["model" => $response]);
    }

    public function create()
    {
        $catalogos = User::loadCatalogos();
        return view("users.create", ["countrys" => $catalogos->get('countrys')]);
    }

    public function store(Request $request)
    {
        \DB::beginTransaction();
        $this->validateUser($request, "store");
        $user = new User();
        $this->register($user, $request);
        \DB::commit();
        return response()->json(["result" => "ok", "message" =>
            trans('messages.general_user_message_p1') . ' ' . $user->name . ' ' . trans('messages.created_general_message')]);
    }

    public function edit($id)
    {
        $user = User::find($id);
        $catalogos = User::loadCatalogos();
        return view("users.edit", ["user" => $user, "countrys" => $catalogos->get('countrys')]);
    }

    public function update(Request $request, $id)
    {
        \DB::beginTransaction();
        $this->validateUser($request, "update");
        $user = User::find($id);
        $this->register($user, $request);
        \DB::commit();
        return response()->json(["result" => "ok", "message" =>
            trans('messages.general_user_message_p1') . ' ' . $user->name . ' ' . trans('messages.updated_general_message')]);
    }

    private function validateUser($request, $method)
    {
        $reglas = null;
        $mensajes = null;
        $rules = [
            "name" => "required",
            "email" => "required",
            "countrys" => "required",
            "states" => "required"
        ];
        $messages = [];
        if ($method == "store") {
            $reglas = [
                "password" => "required|confirmed|min:6",
                "password_confirmation" => "required|min:6",
            ];
            $mensajes = [];
        } else {
            $reglas = [
                "password" => "nullable|confirmed|min:6",
                "password_confirmation" => "nullable|min:6",
            ];
            $mensajes = [];
        }
        $reglas = array_merge($rules, $reglas);
        $mensajes = array_merge($messages, $mensajes);
        $this->validate($request, $reglas, $mensajes);
    }

    private function register($user, $request)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password != null & $request->password_confirmation != null) {
            $user->password = bcrypt($request->password);
        }
        $user->country_id = $request->countrys;
        $user->state_id = $request->states;
        $user->city_id = $request->citys != null ? $request->citys : null;
        $user->save();
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if ($user != null) {
            $user->delete();
            return redirect('/users/list')->with('warning', trans('messages.general_user_message_p1') .
                ' ' . $user->name . ' ' . trans('messages.deleted_general_message'));
        } else {
            return redirect('/users/list')->with('warning', trans('messages.general_user_message_p1') .
                ' ' . trans('messages.exists_general_message'));
        }
    }


}
