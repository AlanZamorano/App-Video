@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
           <div class="card">
            <div class="card-header">Editar video</div>
            <div class="card-body">
                <div class="videoH mb-3 px-5">
                    <div class="embed-responsive embed-responsive-16by9">
                        <video class="object-fit-md-contain border rounded h" controls poster="{{ route('video.imagen', ['filename' => $video->miniatura]) }}">
                            <source src="{{ route('video.video', ['filename' => $video->video]) }}" type="video/mp4"/>
                            <source src="{{ route('video.video', ['filename' => $video->video]) }}" type="video/webm"/>
                        </video>
                        {{-- <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $video->video }}" allowfullscreen></iframe> --}}
                    </div>
                </div>
                <form action="{{route('video.update')}}" method="post" enctype="multipart/form-data" autocomplete="off">
                @csrf
                    <input type="hidden" name="id" value="{{$video->id}}">
                <div class="form-group row mb-3">
                    <label class="col-md-4 text-md-end col-form-label" for="titulo">Titulo</label>
                    <div class="col-md-6">
                        <input id="titulo" name="titulo" value="{{ $video->titulo }}" class="form-control @error('titulo') is-invalid @enderror" type="text" required/>

                        @error('titulo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-md-4 text-md-end col-form-label" for="descripcion">Descripción</label>
                    <div class="col-md-6">
                        <textarea id="descripcion" value="{{$video->descripcion}}" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" type="text"></textarea>

                        @error('descripcion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-md-4 text-md-end col-form-label" for="categoria_id">Categoria</label>
                    <div class="col-md-6">
                        <select id="categoria_id" name="categoria_id" class="form-control @error('categoria_id') is-invalid @enderror" required>
                            
                            @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ $categoria->id == $video->categoria_id ? 'selected' : '' }}>{{ $categoria->tipo }}</option>
                            @endforeach
                        </select>

                        @error('categoria_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <input type="submit" class="btn btn-primary" value="Actualizar video">
                    </div>
                </div>

                </form>
            </div>
           </div>
        </div>
    </div>
</div>
@endsection