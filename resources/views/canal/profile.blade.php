@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            
            <h1>Canal "{{$canal->nombre}}"</h1>
            {{-- repetir 3 veces para la vista --}}
            @foreach($videos->chunk(3) as $repetir)
            <div class="card-group ">  
                
                {{-- traer datos guardados en la db --}}
                @foreach($repetir as $video)

            <div class="card">
                {{-- redirecciona a los detalles del video --}}
            <a href="{{route('video.detail', ['id' => $video->id])}}">
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
                    <div class="p">{{$video->titulo}}</div>
                </h5>
                    
                  <p class="card-text">
                    <div class="descripcion">
                        {{$video->canal->nombre}}
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
</div>
@endsection
