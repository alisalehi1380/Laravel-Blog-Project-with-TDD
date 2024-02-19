<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\Repositories\Eloquent\UserRepository;
use App\Http\Controllers\User\Requests\AddCommentRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    private $userRepository;
    
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    public function addComment(AddCommentRequest $request, Post $post)
    {
        try {
            $post->comments()->create([
                'user_id' => Auth::id(),
                'text'    => $request->text
            ]);
            return redirect()->back()->with('comment-succ', 'comment addedd successfully');
        } catch (\Exception $e) {
            Log::error($e);
            dd($e);
        }
    }
    
    public function index()
    {
        $data = $this->userRepository->all();
        return response()->json($data);
    }
}
