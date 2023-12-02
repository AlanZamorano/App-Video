@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            {{-- mensajes --}}
            @include('includes.mensaje')
            
            <form action="canal.index" method="GET" id="buscador">
                <div class="row mb-3">
                    <div class="form-group col-10">
                <input type="text" id="search" name="search" class="form-control" placeholder="Buscar"/>
            </div>
            <div class="form-group col-2">
                <input type="submit" value="Buscar" class="btn btn-success">
            </div>
        </div>
            </form>
            @include('partials.top', ['topVideos' => $topVideos])
           
                {{-- Repetir 3 veces para la vista --}}

                <h1>Videos</h1>
                @foreach($videos->chunk(3) as $repetir)
                    <div class="card-group ">
                        {{-- Traer datos guardados en la DB --}}
                        @foreach($repetir as $video)
                            <div class="card">
                                {{-- Redirecciona a los detalles del video --}}
                                <a href="{{ route('video.detail', ['id' => $video->id]) }}">
                                    <div class="videoH">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <video class="object-fit-md-contain border rounded h" controls poster="{{ route('video.imagen', ['filename' => $video->miniatura]) }}">
                                                <source src="{{ route('video.video', ['filename' => $video->video]) }}" type="video/mp4"/>
                                                <source src="{{ route('video.video', ['filename' => $video->video]) }}" type="video/webm"/>
                                            </video>
                                            {{-- <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $video->video }}" allowfullscreen></iframe> --}}
                                        </div>
                                    </div>
                                </a>
                                <div class="card-body">
                                    <h5 class="titulo">
                                        <div class="foto-perfil">
                                            <img src="{{ route('canal.imagen', ['filename' => $video->canal->imagen]) }}" alt="Imagen de canal">
                                        </div>
                                        <div class="p">{{ $video->titulo }}</div>
                                    </h5>
                                    <p class="card-text">
                                        <div class="descripcion">
                                            <a href="{{route('canal.profile',['id' => $video->canal_id] )}}">
                                            {{ $video->canal->nombre }}
                                            </a>
                                            <br>
                                                {{$video->vistas}} vistas
                                        </div>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
                
                {{-- Paginas --}}
                <div class="d-flex justify-content-center">
                    {{ $videos->links('pagination::bootstrap-4') }}
                </div>
            
        </div>
    </div>
</div>
@endsection
