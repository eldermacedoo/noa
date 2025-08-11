<?php

namespace App\Http\Controllers;

use App\Models\Mensagem;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(?string $numero = null)
    {
        $contatos = Mensagem::query()
            ->select('numero')
            ->distinct()
            ->orderBy('numero')
            ->pluck('numero');

        $mensagens = collect();
        if ($numero) {
            $mensagens = Mensagem::where('numero', $numero)
                ->orderBy('created_at')
                ->get();
        }

        return view('chat.index', [
            'contatos' => $contatos,
            'mensagens' => $mensagens,
            'numeroAtivo' => $numero
        ]);
    }

    public function enviar(Request $request)
    {
        $request->validate([
            'numero' => 'required',
            'body'   => 'required|string|max:5000',
        ]);

        // Aqui você pode chamar sua integração (Meta Cloud API, Baileys, Twilio…)
        Mensagem::create([
            'numero'    => $request->numero,
            'body'      => $request->body,
            'direction' => 'out',
        ]);

        return back();
    }
}
