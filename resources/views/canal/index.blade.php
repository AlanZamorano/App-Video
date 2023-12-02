@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            
            <form action="canal.index" method="GET" id="buscador">
                @csrf
                <div class="row">
                    <div class="form-group col-10">
                <input type="text" id="search" name="search" class="form-control" placeholder="Buscar"/>
            </div>
            <div class="form-group col-2">
                <input type="submit" value="Buscar" class="btn btn-success">
            </div>
        </div>
            </form>
        
            @foreach($canales->chunk(2) as $repetir)
            <div class="card-group">
                {{-- traer datos guardados en la db --}}
                @foreach ($repetir as $canal)
                <div class="card mb-3">
                    <img src="{{ route('canal.imagen', ['filename' => $canal->imagen]) }}" alt="Imagen de canal">
                    <div class="card-body">
                      <h5 class="card-title">{{$canal->nombre}}</h5>
                      <p class="card-text">{{$canal->descripcion}}</p>
                      <p class="card-text"><small class="text-body-secondary">Creado {{\FormatTime::LongTimeFilter($canal->created_at)}}</small></p>
                    <a class="btn btn-success" href="{{route('canal.profile', ['id'=> $canal->id])}}">Ver perfil</a>
                   
                </div>
                  </div>
                  @endforeach
                </div>
               
                @endforeach
                
                @foreach($videos->chunk(2) as $repetir)
                <div class="card-group">
                    {{-- traer datos guardados en la db --}}
                    @foreach ($repetir as $video)
                    <div class="card mb-3">
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
                          <h5 class="card-title">{{$video->titulo}}</h5>
                          <p class="card-text"><small class="text-body-secondary">{{\FormatTime::LongTimeFilter($video->created_at)}}</small></p>                       
                    </div>
                      </div>
                      @endforeach
                    </div>
                   
                    @endforeach
            {{-- Paginas --}}
            <div class="d-flex justify-content-center">
                {{ $canales->links('pagination::bootstrap-4') }}
            </div>
        </div>
        </div>
</div>
@endsection
