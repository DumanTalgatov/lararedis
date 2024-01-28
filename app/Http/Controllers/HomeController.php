<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $records = Post::all();
        return view('home', compact('records'));
    }

    public function addPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => "required|string",
            "text" => "required|string|max:200"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "error" => $validator->errors()
            ]);
        }

        Post::create([
            "title" => $request->input("title"),
            "text" => $request->input("text"),
            "user_id" => Auth::id(),
        ]);

        $userController = new UserController();

        // Вызываем метод updateRanking из UserController
        $userController->updateRanking(Auth::id());

        return redirect('/home');
    }
}
