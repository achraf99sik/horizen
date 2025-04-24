<?php

namespace App\Console\Commands;

use Illuminate\Http\File;
use FFMpeg\Format\Video\X264;
use Illuminate\Console\Command;
use Illuminate\Http\UploadedFile;
use Psr\Http\Message\StreamInterface;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use ProtoneMedia\LaravelFFMpeg\Exporters\HLSVideoFilters;

class ProcessVideo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle(): void
    {
        $lowBitrate = (new X264)->setKiloBitrate(250);
        $midBitrate = (new X264)->setKiloBitrate(500);
        $highBitrate = (new X264)->setKiloBitrate(1000);

        FFMpeg::fromDisk('uploads')
            ->open('video-one/raw/video.mp4')
            ->exportForHLS()
            ->withRotatingEncryptionKey(function (string $filename, StreamInterface|File|UploadedFile|string $contents)  {
                Storage::disk("uploads")->put("video-one/secrets/{$filename}/",$contents);
            })
            ->addFormat($lowBitrate, function (HLSVideoFilters $filters) {
                $filters->resize(480, 360);
            })
            ->addFormat($midBitrate, function (HLSVideoFilters $filters) {
                $filters->resize(1280, 720);
            })
            ->addFormat($highBitrate, function (HLSVideoFilters $filters) {
                $filters->resize(1920, 1080);
            })
            ->onProgress(function (string $progress){
                $this->info("Progress: {$progress}%");
            })
            ->toDisk("uploads")
            ->save('video-one/videos/index.m3u8');
    }
}
