@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
           <div class="card">
            <div class="card-header">Subir video</div>
            <div class="card-body">
                <form action="{{route('video.save')}}" method="post" enctype="multipart/form-data" autocomplete="off">
                @csrf

                <div class="form-group row mb-3">
                    <label class="col-md-4 text-md-end col-form-label" for="video">Titulo</label>
                    <div class="col-md-6">
                        <input id="titulo" name="titulo" class="form-control @error('titulo') is-invalid @enderror" type="text" required/>

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
                        <textarea id="descripcion" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" type="text"></textarea>

                        @error('descripcion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-md-4 text-md-end col-form-label" for="video">Video</label>
                    <div class="col-md-6">
                        <input id="video" name="video" class="form-control @error('video') is-invalid @enderror" type="file" required accept="video/*"/>

                        @error('video')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-md-4 text-md-end col-form-label" for="miniatura">Miniatura</label>
                    <div class="col-md-6">
                        <input id="miniatura" name="miniatura" class="form-control @error('miniatura') is-invalid @enderror" type="file" required accept="image/*"/>

                        @if ($errors->has('miniatura'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('miniatura') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-md-4 text-md-end col-form-label" for="categoria_id">Categoria</label>
                    <div class="col-md-6">
                        <select id="categoria_id" name="categoria_id" class="form-control @error('categoria_id') is-invalid @enderror" required>
                            <option value="">Seleccionar categoría</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->tipo }}</option>
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
                        <input type="submit" class="btn btn-primary" value="Subir video">
                    </div>
                </div>

                </form>
            </div>
           </div>
        </div>
    </div>
</div>
@endsection