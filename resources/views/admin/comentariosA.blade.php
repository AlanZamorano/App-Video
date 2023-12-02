@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            @include('includes.menuC')
            <h1>Comentarios aceptado</h1>
            @include('includes.mensaje')
            <div class="list-group">
                @include('includes.mensaje')
                @foreach ($comentarios as $comentario)
                    <a href="{{route('video.detailA', ['id' => $comentario->video->id])}}" class="list-group-item list-group-item-action mb-3">
                        <div class="d-flex w-100 justify-content-between coment">
                        <h5 class="mb-1">{{$comentario->video->titulo}}</h5>
                        <small class="text-muted">{{\FormatTime::LongTimeFilter($comentario->created_at)}}</small>
                        </div>
                        <p class="mb-1">{{$comentario->user->name.' '.$comentario->user->apellido_p.' '.$comentario->user->apellido_m}}</p>
                        <small class="text-muted">{!! nl2br(e($comentario->descripcion)) !!}</small>
                    </a>

                    @if (Auth::check() && Auth::user()->tipo_usuario_id === 1)
                <a href="{{route('comentario.eliminado', ['id' => $comentario->id])}}">
                    <button class="btn btn-danger me-2" type="button">Eliminar</button>
                    </a>
                    @endif
                @endforeach
                

              </div>

        </div>
    </div>
</div>

  @endsection