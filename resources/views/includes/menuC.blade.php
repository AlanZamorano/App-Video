<nav class="navbar bg-body-tertiary">
    <form class="container-fluid justify-content-center">
    <a href="{{route('admin.comentarios')}}">
        <button class="btn btn-outline-warning me-2" type="button">Pendientes</button>
    </a>

    <a href="{{route('admin.comentariosA')}}">
      <button class="btn btn-outline-success me-2" type="button">Aceptados</button>
    </a>
    
    </form>
  </nav>