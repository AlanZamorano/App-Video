@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <h1>Usuarios</h1>
                <table class="table table-dark border-danger">
                    <thead>

                        <tr class="align-middle">
                            <th scope="col">ID</th>
                            <th scope="col">Nombres</th>
                            <th scope="col">Apellido paterno</th>
                            <th scope="col">Apellido materno</th>
                            <th scope="col">Canal</th>
                            <th scope="col">Total de videos</th>
                            <th scope="col">Ver canal</th>
                            <th scope="col">Comentarios</th>
                            <th scope="col">Ver comentarios</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Acciones</th>
                        </tr>

                    </thead>
                    <tbody>

                        @foreach ($usuarios as $usuario)
                            <tr class="table-active align-middle">
                                <td scope="row">{{ $usuario->id }}</td>
                                <td>{{ $usuario->name }}</td>
                                <td>{{ $usuario->apellido_p }}</td>
                                <td>
                                    @if ($usuario->apellido_m)
                                    {{ $usuario->apellido_m }}
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>
                                    @if ($usuario->canal)
                                        {{ $usuario->canal->nombre }}
                                    @else
                                        -
                                    @endif

                                </td>

                                <td>
                                    @if ($usuario->canal && count($usuario->canal->videos) > 0)
                                        {{ count($usuario->canal->videos) }}
                                    @else
                                        -
                                    @endif

                                </td>
                                <td>
                                    @if ($usuario->canal)
                                    <a href="{{route('canal.profile',['id' => $usuario->canal->id] )}}">
                                        <i class="bi bi-eye-fill bg-success"></i>
                                    </a>
                                    @else
                                    <i class="bi bi-eye-slash-fill bg-danger"></i>
                                    @endif

                                </td>
                                <td>
                                    @if ($usuario->comentarios->count() > 0)
                                        {{ count($usuario->comentarios) }}
                                    @else
                                        -
                                    @endif

                                </td>

                                <td>
                                    @if ($usuario->comentarios->count() > 0)
                                        <i class="bi bi-eye-fill bg-success"></i>
                                    @else
                                    <i class="bi bi-eye-slash-fill bg-danger"></i>
                                    @endif

                                </td>
                                <td>
                                    @if ($usuario->estado_id == 1)
                                    <span class="badge rounded-pill text-bg-primary">{{ $usuario->estado->tipo }}</span>
                                    @elseif ($usuario->estado_id == 2)
                                    <span class="badge rounded-pill text-bg-secondary">{{ $usuario->estado->tipo }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if (Auth::user()->tipo_usuario_id === 1)
                                        <form method="POST" action="{{ route('admin.usuariosEstado', ['id' => $usuario->id]) }}">
                                            @csrf
                                            @if ($usuario->estado_id == 1)
                                            <button type="submit" class="btn btn-danger btn-sm " onclick="return confirm('¿Estás seguro de cambiar el estado?')">
                                                <i class="bi bi-x-circle-fill"></i>
                                            </button>
                                            @elseif ($usuario->estado_id == 2)
                                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('¿Estás seguro de cambiar el estado?')">
                                                <i class="bi bi-check-circle-fill"></i>
                                            </button>
                                            @endif



                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $usuarios->links('pagination::bootstrap-4') }}
                    <a href=""></a>
                    <a href=""></a>
                </div>
            </div>
        </div>
    </div>
@endsection
