<?php

namespace App\Services\ImageUpload;

use App\DTO\DTO;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

interface ImageUploader
{
    public function uploadFiles(array $files, DTO $dto);
    public function uploadFile(UploadedFile $file, DTO $dto);
}
