<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Classes\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Input\Input;

ini_set('max_execution_time', 300);

class VideoController extends Controller
{
	public function stack()
	{
		$stackName = "";
		//validating video types and sizes
		$data = request()->validate([
			'video1' => 'mimetypes:video/mp4,application/x-mpegURL,video/3gpp,video/x-msvideo,video/x-ms-wmv,video/avi|required|max:40000',
			'video2' => 'mimetypes:video/mp4,application/x-mpegURL,video/3gpp,video/x-msvideo,video/x-ms-wmv,video/avi|required|max:40000',
			'orientation'=>'required'
		]);
		//upload videos to project folder
		$videoPath1 = request('video1')->store('uploads', 'public');
		$videoPath2 = request('video2')->store('uploads', 'public');
		// determine stacking orientation
		request('orientation') == 'h'?
			$stackName = Video::mregeVideoHorizontally($videoPath1, $videoPath2):
			$stackName = Video::mregeVideoVertically($videoPath1, $videoPath2);
		//return stacked video to view
		return view('stack', compact('stackName'));


	}

	public function extract()
	{
		//validating video types and sizes
		$data = request()->validate([
			'video' => 'mimetypes:video/mp4,application/x-mpegURL,video/3gpp,video/x-msvideo,video/x-ms-wmv,video/avi|required|max:40000'
		]);
		//upload videos to project folder
		$videoPath = request('video')->store('uploads', 'public');
		//call separating function
		$VideoAudio=Video::SeparateSoundLayer($videoPath);
		//return audio and video to view
		return view('extract', [
			'video'=>$VideoAudio['video'],
			'audio'=>$VideoAudio['audio']
		]);
	}

	public function test()
	{
	}
}
