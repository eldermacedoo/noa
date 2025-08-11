@extends('layouts.app', ['compact' => true])

@section('content')
<style>
  .chat-list{height:calc(100vh - 140px);overflow-y:auto}
  .chat-messages{height:calc(100vh - 210px);overflow-y:auto;background:#f7f7f7}
  .bubble{max-width:75%;padding:.6rem .8rem;border-radius:.75rem;font-size:.95rem}
  .in{background:#fff;border:1px solid #e9ecef}
  .out{background:#d1f0d4;border:1px solid #b9e4be;margin-left:auto}
  .contact-active{background:rgba(67,160,71,.08)}
</style>

<div class="row">
  {{-- Contatos --}}
  <div class="col-12 col-lg-4 col-xl-3">
    <div class="card h-100">
      <div class="card-header pb-0">
        <h6>Contatos</h6>
        <div class="input-group input-group-outline mt-3">
          <input id="busca" type="text" class="form-control" placeholder="Buscar contato...">
        </div>
      </div>
      <div class="card-body p-2">
        <ul class="list-group chat-list" id="listaContatos">
          @foreach($contatos as $c)
            <a href="{{ route('chat.index', $c['id']) }}"
               class="list-group-item border-0 d-flex align-items-center px-3 {{ $contatoAtivo === $c['id'] ? 'contact-active' : '' }}">
              <div class="avatar me-3">
                <img src="{{ asset('material/img/team-' . (($loop->index % 4) + 1) . '.jpg') }}" class="border-radius-lg" alt="avatar">
              </div>
              <div class="d-flex flex-column">
                <h6 class="mb-0 text-sm">{{ $c['nome'] }}</h6>
                <p class="text-xs text-secondary mb-0">{{ $c['id'] }}</p>
              </div>
            </a>
          @endforeach
        </ul>
      </div>
    </div>
  </div>

  {{-- Conversa --}}
  <div class="col-12 col-lg-8 col-xl-9 mt-4 mt-lg-0">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
          <img src="{{ asset('material/img/team-2.jpg') }}" class="avatar me-3 border-radius-lg" alt="user">
          <div>
            <h6 class="mb-0">{{ $contatoAtivo ?? 'Selecione um contato' }}</h6>
            <span class="text-xs text-success">online</span>
          </div>
        </div>
      </div>

      <div id="messages" class="card-body chat-messages d-flex flex-column gap-2">
        @forelse($mensagens as $m)
          <div class="d-flex {{ $m['direction'] === 'out' ? 'justify-content-end' : '' }}">
            <div class="bubble {{ $m['direction'] === 'out' ? 'out' : 'in' }}">
              <div>{{ $m['body'] }}</div>
              <div class="text-end text-xxs text-secondary mt-1">{{ $m['at'] }}</div>
            </div>
          </div>
        @empty
          <div class="text-center text-secondary mt-5">Nenhuma mensagem ainda…</div>
        @endforelse
      </div>

      <div class="card-footer">
        <form action="{{ route('chat.enviar') }}" method="POST" class="d-flex gap-2">
          @csrf
          <input type="hidden" name="contato" value="{{ $contatoAtivo }}">
          <div class="input-group input-group-outline flex-grow-1">
            <input name="body" class="form-control" placeholder="Escreva uma mensagem…" autocomplete="off">
          </div>
          <button class="btn bg-gradient-success">
            <span class="material-symbols-rounded">send</span>
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  // autoscroll
  const box=document.getElementById('messages'); if(box){ box.scrollTop=box.scrollHeight; }
  // filtro contatos
  const q=document.getElementById('busca'), list=document.getElementById('listaContatos');
  q?.addEventListener('input',()=>{ const t=q.value.toLowerCase();
    [...list.querySelectorAll('.list-group-item')].forEach(li=>li.style.display=li.textContent.toLowerCase().includes(t)?'':'none');
  });
</script>
@endpush
@endsection
