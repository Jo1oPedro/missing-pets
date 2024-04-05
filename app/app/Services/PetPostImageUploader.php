<?php

namespace App\Services;

use App\DTO\DTO;
use App\Models\PetPost;
use App\Models\PetPostImage;
use App\Services\ImageUpload\ImageUploader;
use http\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class PetPostImageUploader implements ImageUploader
{
    public function uploadFiles(array $files, DTO $dto)
    {
        foreach($files as $file) {
            $this->uploadFile($file, $dto);
        }
    }

    public function uploadFile(UploadedFile $file, DTO $dto)
    {
        if(!$file->isValid()) {
            throw new InvalidArgumentException($file->getClientOriginalName() . " é invalido", 422);
        }
        $extension = $file->extension();
        $imageName = md5($file->getClientOriginalName() . strtotime("now")) . ".{$extension}";
        $file->move(public_path("img/pet_images"), $imageName);
        PetPostImage::create(["pet_post_id" => $dto->getId(), "image_path" => "img/pet_images/{$imageName}"]);
    }
}
