<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;

class HomeController extends Controller
{
    public function index()
    {
        $videos = Video::orderBy('id', 'desc')->where('estado_id', 1)->paginate(9);
        
        if ($videos->currentPage() === 1) {
            $topVideos = $this->getTopVideos();
        } else {
            $topVideos = null; 
        }
        return view('home', [
            'videos' => $videos,
            'topVideos' => $topVideos
        ]);
    }

    private function getTopVideos()
{
    return Video::orderBy('vistas', 'desc')->where('estado_id', 1)
        ->take(5)
        
        ->get();
}

}
