<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ChatController extends Controller
{
    // mock rápido só pra ver a UI (troque por DB depois)
    private function contatosFake(): Collection {
        return collect([
            ['id' => '5511999990001', 'nome' => 'João Silva'],
            ['id' => '5511888880002', 'nome' => 'Maria Souza'],
            ['id' => '5511777770003', 'nome' => 'Cliente XPTO'],
        ]);
    }

    private function mensagensFake(string $contato): Collection {
        return collect([
            ['direction' => 'in',  'body' => 'Olá, preciso de ajuda',          'at' => now()->subMinutes(30)->format('H:i')],
            ['direction' => 'out', 'body' => 'Claro! Me diga o problema 🙂',   'at' => now()->subMinutes(28)->format('H:i')],
            ['direction' => 'in',  'body' => 'Quero status do pedido #1234',   'at' => now()->subMinutes(27)->format('H:i')],
            ['direction' => 'out', 'body' => 'Acabei de verificar, saiu hoje', 'at' => now()->subMinutes(25)->format('H:i')],
        ]);
    }

    public function index(?string $contato = null)
    {
        $contatos = $this->contatosFake();
        $ativo = $contato ?? optional($contatos->first())['id'];
        $mensagens = $ativo ? $this->mensagensFake($ativo) : collect();

        return view('chat.index', [
            'pageTitle'   => 'Chat',
            'pageSubtitle'=> 'Converse com seus clientes',
            'contatos'    => $contatos,
            'contatoAtivo'=> $ativo,
            'mensagens'   => $mensagens,
        ]);
    }

    public function enviar(Request $request)
    {
        $request->validate([
            'contato' => 'required|string',
            'body'    => 'required|string|max:5000',
        ]);

        // aqui você salvaria no banco e/ou enviaria via API (WhatsApp/Twilio/Meta, etc.)
        // Mensagem::create([...]);

        return back()->with('ok', 'Mensagem enviada!');
    }
}
