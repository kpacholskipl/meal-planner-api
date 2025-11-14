<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class ImageService
{
    public function __construct(protected object $modelSource, protected string $disk = '')
    {
        $this->disk = $disk ?: config('filesystems.default');
    }

    public function create($file): Image
    {
        $id = Uuid::uuid4()->toString();
        $path = Storage::disk($this->disk)->putFile(
            sprintf('images/%s/%s', strtolower(class_basename($this->modelSource)), $id),
            $file
        );
        return Image::create([
            'id' => $id,
            'imageable_id' => $this->modelSource->id,
            'imageable_type' => get_class($this->modelSource),
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'url' => Storage::disk($this->disk)->url($path)
        ]);
    }

    public function createFromUrl(string $url): ?Image
    {
        try {
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                throw new \InvalidArgumentException('Invalid image URL provided');
            }

            $response = Http::timeout(15)
                ->withHeaders(['User-Agent' => 'MealPlanner/1.0'])
                ->get($url);

            if (!$response->successful()) {
                throw new \RuntimeException("Failed to download image from URL: {$url}");
            }

            $contentType = $response->header('Content-Type');
            if (!str_starts_with($contentType, 'image/')) {
                throw new \RuntimeException('The URL does not point to a valid image');
            }

            $tempFile = tempnam(sys_get_temp_dir(), 'img_');
            file_put_contents($tempFile, $response->body());

            $uploadedFile = new UploadedFile(
                $tempFile,
                basename($url),
                $contentType,
                null,
                true
            );

            return $this->create($uploadedFile);
        } catch (\Exception $e) {
            Log::error('Failed to create image from URL', [
                'url' => $url,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return null;
        }
    }
}
