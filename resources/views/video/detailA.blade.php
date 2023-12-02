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
                    @if(Auth::user())
                        <div class="reacciones">
                            <div class="like">

                                {{-- comprobar si el usuario le dio like a la imagen --}}
                                <?php $user_like = false; ?>
                                @foreach($video->likes as $like)
                                    @if($like->user->id == Auth::user()->id)
                                        <?php $user_like = true; ?>
                                    @endif
                                @endforeach

                                @if($user_like)
                                <i class="bi bi-hand-thumbs-up-fill click-b like-button" data-id="{{$video->id}}"></i>
                                @else
                                <i class="bi bi-hand-thumbs-up like-button" data-id="{{$video->id}}"></i>
                                
                                @endif
                                {{ count($video->likes) }}
                            </div>
                            <div class="dislike">

                                <?php $user_dislike = false; ?>
                                @foreach($video->dislikes as $dislike)
                                    @if($dislike->user->id == Auth::user()->id)
                                        <?php $user_dislike = true; ?>
                                    @endif
                                @endforeach

                                @if($user_dislike)
                                <i class="bi bi-hand-thumbs-down-fill click dislike-button" data-id="{{$video->id}}"></i>
                                @else
                                <i class="bi bi-hand-thumbs-down dislike-button" data-id="{{$video->id}}"></i>
                                
                                @endif
                                {{ count($video->dislikes) }}
                            </div>
                        </div>
                        @endif
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
                
                @if(auth()->check())
                @include('includes.mensaje')
                <div class="create-comment">
                <div class="foto-perfil">
                    @include('includes.avatar')
                </div>
                <form action="{{route('comentario.save')}}" method="post">
                <div class="group">  
                    @csrf    
                    <input type="hidden" name="video_id" value="{{($video->id)}}">
                    <textarea name="descripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror"  rows="5" cols="10" placeholder="Escribe un comentario..." required></textarea>
                    
                    @error('descripcion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    
                    <button type="submit" class="btn btn-success i">
                        <i class="bi bi-send"></i>
                    </button>   
                  </div>
                </form>
                </div>
                @endif

                @foreach($video->comentarios as $comentario)
                <div class="mostrar-comentario">
                    <div class="head">
                    <div class="foto-perfil">
                        @if($comentario->user->imagen)
                        <img src="{{route('user.imagen',['filename'=>$comentario->user->imagen])}}" alt="Imagen de usuario">
                        @endif
                    </div>
                    <div class="head-body">
                    <div class="headbody">
                    <div class="p">{{$comentario->user->name . ' ' . $comentario->user->apellido_p . ' ' . $comentario->user->apellido_m}}</div>
                    <span>{{\FormatTime::LongTimeFilter($comentario->created_at)}}</span>
                    </div>
                    <div class="descripcion">
                        {!! nl2br(e($comentario->descripcion)) !!}
                        @if(Auth::check() && Auth::user()->tipo_usuario_id === 1)
                        <a class="btn btn-sm  btn-danger" href="{{route('comentario.deleteA', ['id' => $comentario->id])}}">
                            <i class="bi bi-trash3"></i>
                        </a>
                        @endif
                    </div>
                </div>
                </div>
                    
                </div>
                @endforeach
                </div>
              </div>
            </div>
        </div>
</div>
</div>

@endsection
