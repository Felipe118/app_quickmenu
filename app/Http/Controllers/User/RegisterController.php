<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Interfaces\User\RegisterServiceInterface;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __construct(
        public RegisterServiceInterface $registerService,
    ){}

    /**
     * Store a newly created resource in storage.
     *  
     * @param  \Illuminate\Http\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function register(UserRequest $request)
    {
        try{
            $this->registerService->register($request->all());
            return response()->json([
                'message' => 'Usuário registrado com sucesso',
            ], 201);
        }catch(\RuntimeException $e){
            return response()->json([
                'message' => $e->getMessage(),
                'error' =>  $e->getPrevious() ? $e->getPrevious()->getMessage() : null,
            ], 500);
        }
        
    }
}
