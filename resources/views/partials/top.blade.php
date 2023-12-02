@if(isset($topVideos))
<h1>Top 5 videos más vistos</h1>
  <div id="carouselExampleFade" class="carousel slide carousel-fade mb-5">
    <div class="carousel-inner">
        @foreach($topVideos as $index => $top)
            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                <video class="d-block w-100" controls poster="{{ route('video.imagen', ['filename' => $top->miniatura]) }}">
                    <source src="{{ route('video.video', ['filename' => $top->video]) }}" type="video/mp4"/>
                    <source src="{{ route('video.video', ['filename' => $top->video]) }}" type="video/webm"/>
                </video>
                <a href="{{ route('video.detail', ['id' => $top->id]) }}">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>{{$top->titulo}}</h5>
                        <p>{{$top->canal->nombre}}</p>
                        <p>{{ $top->vistas }} vistas</p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
  </div>
@endif
