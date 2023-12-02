@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card-group">   
            <div class="card mb-3">
                <div class="videobgc">
                <div class="embed-responsive embed-responsive-16by9">
                    <video class="object-fit-md-contain border rounded" autoplay controls poster="{{ route('video.imagen', ['filename' => $video->miniatura]) }}">
                        <source src="{{ route('video.video', ['filename' => $video->video]) }}" type="video/mp4"/>
                        <source src="{{ route('video.video', ['filename' => $video->video]) }}" type="video/webm"/>
                    </video>
                    {{-- <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $video->video }}" allowfullscreen></iframe> --}}
                </div>
            </div>
                <div class="card-body">
                    <h3 class="card-title">{{$video->titulo}}</h3>
                  <h5 class="card-title">
                    <div>
                        <a href="{{route('canal.profile',['id' => $video->canal->users_id] )}}">
                    <div  class="foto-perfil">
                        
                        <img src="{{ route('canal.imagen', ['filename' => $video->canal->imagen]) }}" alt="Imagen de canal">
                    
                    </div>
                </a>
                    <a href="{{route('canal.profile',['id' => $video->canal->users_id] )}}">
                    <div class="p">{{$video->canal->nombre}}</div>
                </a>
                </div>
                <div>

                        <div class="reacciones">
                            <div class="like">

                                <i class="bi bi-hand-thumbs-up like-button"></i>
                                
                            </div>
                            <div class="dislike">

                                <i class="bi bi-hand-thumbs-down dislike-button"></i>

                            </div>
                        </div>
                     
                    </div>
                    </h5>
                  <div class="card-text">
                    <div class="descripcion">
                        {{\FormatTime::LongTimeFilter($video->created_at)}} - {{$video->vistas}} vistas
                        <br>
                        {!! nl2br(e($video->descripcion)) !!}
                    </div>
                  </div>
                  <h4>
                    Comentarios ({{count($video->comentarios)}})
                </h4>
                



                </div>
                    
                </div>
               
                </div>
              </div>
            </div>
        </div>
</div>
</div>

@endsection
