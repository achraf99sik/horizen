<?php

namespace App\Jobs;

use Illuminate\Http\File;
use FFMpeg\Format\Video\X264;
use Illuminate\Http\UploadedFile;
use Psr\Http\Message\StreamInterface;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Exporters\HLSVideoFilters;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class ProcessVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $folder;
    protected string $file;

    /**
     * Create a new job instance.
     */
    public function __construct(string $folder, string $file)
    {
        $this->folder = $folder;
        $this->file = $file;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        set_time_limit(0);

        $folder = $this->folder; // Not argument() anymore, it's from constructor
        $file = $this->file;

        $lowBitrate = (new X264)->setKiloBitrate(250);
        $midBitrate = (new X264)->setKiloBitrate(500);
        $highBitrate = (new X264)->setKiloBitrate(1000);

        FFMpeg::fromDisk('uploads')
            ->open("{$folder}/raw/{$file}")
            ->exportForHLS()
            ->withRotatingEncryptionKey(function (string $filename, StreamInterface|File|UploadedFile|string $contents) use ($folder) {
                Storage::disk("uploads")->put("{$folder}/secrets/{$filename}", $contents);
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
            ->onProgress(function (string $progress) use ($folder) {
                logger()->info("Encoding {$folder}: {$progress}% done");
            })
            ->toDisk('uploads')
            ->save("{$folder}/videos/index.m3u8");
    }
}
