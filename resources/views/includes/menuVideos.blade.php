<nav class="navbar bg-body-tertiary">
    <form class="container-fluid justify-content-center">
    <a href="{{route('canal.profileA', ['id' => $canal->id])}}">
      <button class="btn btn-outline-success me-2" type="button">Aceptados</button>
    </a>
    <a href="{{route('canal.profileP', ['id' => $canal->id])}}">
      <button class="btn btn-outline-warning me-2" type="button">Pendientes</button>
    </a>
    <a href="{{route('canal.profileI', ['id' => $canal->id])}}">
      <button class="btn btn-outline-danger me-2" type="button">Rechazados</button>
    </a>
    </form>
  </nav>