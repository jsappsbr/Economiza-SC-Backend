<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name("home");

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
});

Route::get('/delete-account', function () {
    return view('delete-account');
});

Route::post('/delete-account', function (Request $request) {
    $request->validate([
        'password' => 'required',
        'email' => 'required|email',
    ]);

    try {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->withErrors([
                'email' => 'O e-mail ou a senha estão incorretos',
            ]);
        }

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors([
                'password' => 'O e-mail ou a senha estão incorretos',
            ]);
        }

        $user->delete();

        return redirect()->route('home')->with('success', 'Sua conta foi deletada com sucesso');
    } catch (\Exception $e) {
        return redirect()->back()->with([
            'error' => 'Não foi possível deletar sua conta, tente novamente mais tarde.',
        ]);
    }
});