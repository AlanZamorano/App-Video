@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
           <div class="card">
            <div class="card-header">Crear canal</div>
            <div class="card-body">
                <form action="{{route('canal.save')}}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <label class="col-md-4 text-md-end col-form-label" for="nombre">Nombre</label>
                    <div class="col-md-6">
                        <input id="nombre" name="nombre" class="form-control" type="text" required/>

                        @error('nombre')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 text-md-end col-form-label" for="descripcion">Descripción</label>
                    <div class="col-md-6">
                        <textarea id="descripcion" name="descripcion" class="form-control" type="text"></textarea>

                        @error('descripcion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 text-md-end col-form-label" for="imagen">Foto de perfil</label>
                    <div class="col-md-6">
                        <input id="imagen" name="imagen" class="form-control" type="file"/>

                        @error('imagen')
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