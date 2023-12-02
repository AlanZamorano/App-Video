@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1>Videos que te gustan</h1>
            {{-- repetir 3 veces para la vista --}}
            @foreach($likes->chunk(3) as $repetir)
            <div class="card-group ">  
                
                {{-- traer datos guardados en la db --}}
                @foreach($repetir as $like)

            <div class="card">
                {{-- redirecciona a los detalles del video --}}
            <a href="{{route('video.detail', ['id' => $like->video_id])}}">
                <div class="videoH">
                    <div class="embed-responsive embed-responsive-16by9">
                        <video class="object-fit-md-contain border rounded h" controls poster="{{ route('video.imagen', ['filename' => $like->video->miniatura]) }}">
                            <source src="{{ route('video.video', ['filename' => $like->video->video]) }}" type="video/mp4"/>
                            <source src="{{ route('video.video', ['filename' => $like->video->video]) }}" type="video/webm"/>
                        </video>
                        {{-- <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $video->video }}" allowfullscreen></iframe> --}}
                    </div>
                </div>
            </a>

                <div class="card-body">
                  <h5 class="titulo">
                    <div class="foto-perfil">
                        <img src="{{ route('canal.imagen', ['filename' => $like->video->canal->imagen]) }}" alt="Imagen de canal">
                    </div>
                    <div class="p">{{$like->video->titulo}}</div>
                </h5>
                    
                  <p class="card-text">
                    <div class="descripcion">
                        {{$like->video->canal->nombre}}
                    </div>
                  </p>
                </div>
              </div>
              @endforeach
            </div>
        
            @endforeach
            {{-- Paginas --}}
            <div class="d-flex justify-content-center">
                {{ $likes->links('pagination::bootstrap-4') }}
            </div>
        </div>
        </div>
</div>
</div>
@endsection
