<?php

namespace App\Services;

use Illuminate\Http\UploadedFile as BaseUploadedFile;

class FileUploadService extends BaseUploadedFile
{
    /**
     * Summary of store
     * @param mixed $path
     * @param mixed $options
     * @return mixed{file: string, folder: string|bool|string}
     */
    public function store($path = '',$options = []): array|bool|string
    {
        if ($path == 'raw') {
            $data = ['folder' => trim($this->hashName(), '.'.pathinfo($this->hashName())['extension']), 'file' => $this->hashName()];
            $this->storeAs($data['folder'] . '/' . $path, $this->hashName(), $this->parseOptions($options));
            return $data;
        }
        return $this->storeAs($path, $this->hashName(), $this->parseOptions($options));
    }
}
