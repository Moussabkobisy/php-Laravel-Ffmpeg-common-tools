<?php
/**
 * Created by PhpStorm.
 * User: mouss
 * Date: 11/19/2019
 * Time: 6:50 PM
 */

namespace App\Http\Controllers\Classes;


use getID3;
use Illuminate\Support\Facades\Storage;

class Video
{
	public static function mregeVideoHorizontally($video1,$video2){
		//manage names and extentions
		$video1name=explode('.',$video1)[0];
		$video1ex=explode('.',$video1)[1];
		$video2name=explode('.',$video2)[0];
		$video2ex=explode('.',$video2)[1];

		//cropping videos to same height
		$command='ffmpeg -i storage/'.$video1.' -vf "scale=360:690:force_original_aspect_ratio=decrease,pad=360:690:(ow-iw)/2:(oh-ih)/2" storage/'.$video1name.'c.'.$video1ex;
		shell_exec($command);
		$command='ffmpeg -i storage/'.$video2.' -vf "scale=360:690:force_original_aspect_ratio=decrease,pad=360:690:(ow-iw)/2:(oh-ih)/2" storage/'.$video2name.'c.'.$video2ex;
		shell_exec($command);
		// start stacking
		$command='ffmpeg -i storage/'.$video1name.'c.'.$video1ex.' -i storage/'.$video2name.'c.'.$video2ex.' -filter_complex "[0]pad=iw+5:color=white[left];[left][1]hstack=inputs=2" storage/'.$video1name.'s.'.$video1ex;
		shell_exec($command);
		//deleting unnecessary files
		Storage::disk('public')->delete([$video1,$video2,$video1name.'c.'.$video1ex,$video2name.'c.'.$video2ex]);
//
		if (Storage::disk('public')->exists($video1name.'s.'.$video1ex)){
			return $video1name.'s.'.$video1ex;
		}
		else{
			return 0;
		}


	}
	public static function mregeVideoVertically($video1,$video2){

		//manage names and extentions
		$video1name=explode('.',$video1)[0];
		$video1ex=explode('.',$video1)[1];
		$video2name=explode('.',$video2)[0];
		$video2ex=explode('.',$video2)[1];

		//cropping videos to same width
		$command='ffmpeg -i storage/'.$video1.' -vf "scale=690:360:force_original_aspect_ratio=decrease,pad=690:360:(ow-iw)/2:(oh-ih)/2" storage/'.$video1name.'c.'.$video1ex;
		shell_exec($command);
		$command='ffmpeg -i storage/'.$video2.' -vf "scale=690:360:force_original_aspect_ratio=decrease,pad=690:360:(ow-iw)/2:(oh-ih)/2" storage/'.$video2name.'c.'.$video2ex;
		shell_exec($command);
		//start stacking
		$command='ffmpeg -i storage/'.$video1name.'c.'.$video1ex.' -i storage/'.$video2name.'c.'.$video2ex.' -filter_complex "vstack=inputs=2" storage/'.$video1name.'ss.'.$video1ex;
		shell_exec($command);
		//deleting unnecessary files
		Storage::disk('public')->delete([$video1,$video2,$video1name.'c.'.$video1ex,$video2name.'c.'.$video2ex]);
		//
		if (Storage::disk('public')->exists($video1name.'s.'.$video1ex)){
			return $video1name.'s.'.$video1ex;
		}
		else{
			return 0;
		}

	}
	public static function SeparateSoundLayer($video)
	{
		$output=array();
		//manage names and extentions
		$NameWithoutEx=explode('.',$video)[0];
		$Ex=explode('.',$video)[1];
		//generate audio file
		$command='ffmpeg -i storage/'.$video.' -vn storage/'.$NameWithoutEx.'.mp3';
		shell_exec($command);
		//generate video file
		$command='ffmpeg -i storage/'.$video.' -an storage/'.$NameWithoutEx.'video.'.$Ex;
		shell_exec($command);
		Storage::disk('public')->delete($video);
		//processing output
		$output['video']=$NameWithoutEx.'video.'.$Ex;
		$output['audio']=$NameWithoutEx.'.mp3';
		return $output;
	}
	public static function GetSize($video)
	{
		return Storage::disk('public')->size($video);
	}
	public static function GetDuration($video)
	{
		$getID3 = new getID3;
		$file = $getID3->analyze('storage/'.$video);
		$playtime_seconds = $file['playtime_seconds'];
		$duration = date('H:i:s', $playtime_seconds);

		return $duration;
	}

}