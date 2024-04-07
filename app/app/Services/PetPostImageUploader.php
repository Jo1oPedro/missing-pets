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
        $imageName = $file->store("public/pet_images");
        PetPostImage::create(["pet_post_id" => $dto->getId(), "image_path" => $imageName]);
    }
}
