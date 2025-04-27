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
    protected $signature = 'video:process {folder} {file}';

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
        set_time_limit(0);
        $folder = $this->argument('folder');
        $file = $this->argument('file');

        $lowBitrate = (new X264)->setKiloBitrate(250);
        $midBitrate = (new X264)->setKiloBitrate(500);
        $highBitrate = (new X264)->setKiloBitrate(1000);

        FFMpeg::fromDisk('uploads')
            ->open("{$folder}/raw/{$file}")
            ->exportForHLS()
            ->withRotatingEncryptionKey(function (string $filename, StreamInterface|File|UploadedFile|string $contents) use ($folder)  {
                Storage::disk("uploads")->put("{$folder}/secrets/{$filename}/",$contents);
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
                return $this->info("Progress: {$progress}%");
            })
            ->toDisk("uploads")
            ->save("{$folder}/videos/index.m3u8");
    }
}
