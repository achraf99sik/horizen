<?php

namespace App\Services;

use Illuminate\Http\UploadedFile as BaseUploadedFile;

class FileUploadService extends BaseUploadedFile
{
    public function store($path = '', $options = [])
    {
        if ($path == 'raw') {
            $this->storeAs(trim($this->hashName(), ".mp4") . '/' . $path, $this->hashName(), $this->parseOptions($options));
            return trim($this->hashName(), ".mp4");
        }
        return $this->storeAs($path, $this->hashName(), $this->parseOptions($options));
    }
}
