@extends('layouts.app', ['title' => 'Dashboard', 'pageTitle' => '', 'pageSubtitle' => ''])

@section('content')
<div class="container-fluid py-2">
  <div class="row">
    <div class="ms-3">
      <h3 class="mb-0 h4 font-weight-bolder">Painel de Atendimento</h3>
      <p class="mb-4">Resumo de conversas, atendimentos e desempenho geral.</p>
    </div>

    <!-- Indicadores principais -->
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-2 ps-3">
          <div class="d-flex justify-content-between">
            <div>
              <p class="text-sm mb-0 text-capitalize">Conversas Hoje</p>
              <h4 class="mb-0">1.245</h4>
            </div>
            <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
              <i class="material-symbols-rounded opacity-10">chat</i>
            </div>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-2 ps-3">
          <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+12% </span>que ontem</p>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-2 ps-3">
          <div class="d-flex justify-content-between">
            <div>
              <p class="text-sm mb-0 text-capitalize">Atendimentos Concluídos</p>
              <h4 class="mb-0">980</h4>
            </div>
            <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
              <i class="material-symbols-rounded opacity-10">done_all</i>
            </div>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-2 ps-3">
          <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+8% </span>esta semana</p>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-2 ps-3">
          <div class="d-flex justify-content-between">
            <div>
              <p class="text-sm mb-0 text-capitalize">Tempo Médio de Resposta</p>
              <h4 class="mb-0">3m 45s</h4>
            </div>
            <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
              <i class="material-symbols-rounded opacity-10">timer</i>
            </div>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-2 ps-3">
          <p class="mb-0 text-sm"><span class="text-danger font-weight-bolder">-5% </span>que mês passado</p>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6">
      <div class="card">
        <div class="card-header p-2 ps-3">
          <div class="d-flex justify-content-between">
            <div>
              <p class="text-sm mb-0 text-capitalize">Novos Contatos</p>
              <h4 class="mb-0">325</h4>
            </div>
            <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
              <i class="material-symbols-rounded opacity-10">person_add</i>
            </div>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-2 ps-3">
          <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+15% </span>este mês</p>
        </div>
      </div>
    </div>
  </div>

  <!-- gráficos -->
  <div class="row">
    <div class="col-lg-4 col-md-6 mt-4 mb-4">
      <div class="card">
        <div class="card-body">
          <h6 class="mb-0">Conversas por Dia</h6>
          <p class="text-sm">Desempenho da última semana</p>
          <div class="chart"><canvas id="chart-bars" class="chart-canvas" height="170"></canvas></div>
          <hr class="dark horizontal">
          <div class="d-flex"><i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
            <p class="mb-0 text-sm"> atualizado há 1 dia </p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 mt-4 mb-4">
      <div class="card">
        <div class="card-body">
          <h6 class="mb-0">Atendimentos Diários</h6>
          <p class="text-sm">(<span class="font-weight-bolder">+15%</span>) em relação ao dia anterior.</p>
          <div class="chart"><canvas id="chart-line" class="chart-canvas" height="170"></canvas></div>
          <hr class="dark horizontal">
          <div class="d-flex"><i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
            <p class="mb-0 text-sm"> atualizado há 4 min </p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 mt-4 mb-3">
      <div class="card">
        <div class="card-body">
          <h6 class="mb-0">Tarefas Concluídas</h6>
          <p class="text-sm">Últimas ações realizadas</p>
          <div class="chart"><canvas id="chart-line-tasks" class="chart-canvas" height="170"></canvas></div>
          <hr class="dark horizontal">
          <div class="d-flex"><i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
            <p class="mb-0 text-sm"> atualizado agora </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- tabela de atendimentos -->
  <div class="row mb-4">
    <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
      <div class="card">
        <div class="card-header pb-0">
          <div class="row">
            <div class="col-lg-6 col-7">
              <h6>Atendimentos em Andamento</h6>
              <p class="text-sm mb-0"><i class="fa fa-check text-info"></i><span class="font-weight-bold ms-1">45 ativos</span> no momento</p>
            </div>
          </div>
        </div>

        <div class="card-body px-0 pb-2">
          <div class="table-responsive">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cliente</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Atendente</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Canal</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <div class="d-flex px-2 py-1">
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">João Silva</h6>
                      </div>
                    </div>
                  </td>
                  <td>Maria Souza</td>
                  <td class="align-middle text-center text-sm"><span class="text-xs font-weight-bold">WhatsApp</span></td>
                  <td class="align-middle text-center"><span class="badge bg-gradient-info">Em atendimento</span></td>
                </tr>
                <!-- Outras linhas de exemplo -->
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>

    <div class="col-lg-4 col-md-6">
      <div class="card h-100">
        <div class="card-header pb-0">
          <h6>Resumo de Atividades</h6>
          <p class="text-sm"><i class="fa fa-arrow-up text-success"></i><span class="font-weight-bold">24%</span> de crescimento</p>
        </div>
        <div class="card-body p-3">
          <div class="timeline timeline-one-side">
            <div class="timeline-block mb-3">
              <span class="timeline-step"><i class="material-symbols-rounded text-success">chat</i></span>
              <div class="timeline-content">
                <h6 class="text-dark text-sm font-weight-bold mb-0">Nova conversa iniciada</h6>
                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">há 5 min</p>
              </div>
            </div>
            <!-- Outros eventos -->
          </div>
        </div>
      </div>
    </div>
  </div>

  @includeWhen(View::exists('layouts.footer'), 'layouts.footer')
</div>
@endsection
@push('scripts')
<script>
  // Conversas por Dia
  new Chart(document.getElementById("chart-bars").getContext("2d"), {
    type: "bar",
    data: {
      labels: ["Seg", "Ter", "Qua", "Qui", "Sex", "Sáb", "Dom"], // Dias da semana em PT-BR
      datasets: [{
        label: "Conversas",
        tension: 0.4,
        borderWidth: 0,
        borderRadius: 4,
        borderSkipped: false,
        backgroundColor: "#43A047",
        data: [50, 45, 22, 28, 50, 60, 76],
        barThickness: 'flex'
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        }
      },
      interaction: {
        intersect: false,
        mode: 'index'
      }
    }
  });

  // Atendimentos Mensais
  new Chart(document.getElementById("chart-line").getContext("2d"), {
    type: "line",
    data: {
      labels: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"], // Meses em PT-BR
      datasets: [{
        label: "Atendimentos",
        tension: 0,
        borderWidth: 2,
        pointRadius: 3,
        pointBackgroundColor: "#43A047",
        pointBorderColor: "transparent",
        borderColor: "#43A047",
        backgroundColor: "transparent",
        fill: true,
        data: [120, 230, 130, 440, 250, 360, 270, 180, 90, 300, 310, 220]
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        }
      }
    }
  });

  // Chats Concluídos
  new Chart(document.getElementById("chart-line-tasks").getContext("2d"), {
    type: "line",
    data: {
      labels: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"], // Meses em PT-BR
      datasets: [{
        label: "Chats Finalizados",
        tension: 0,
        borderWidth: 2,
        pointRadius: 3,
        pointBackgroundColor: "#43A047",
        pointBorderColor: "transparent",
        borderColor: "#43A047",
        backgroundColor: "transparent",
        fill: true,
        data: [50, 40, 300, 220, 500, 250, 400, 230, 500, 450, 380, 600]
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        }
      }
    }
  });
</script>
@endpush
