<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class ProductAvatarManager
{
    /**
     * Save image for provided product.
     *
     * @param UploadedFile $image
     * @return string
     */
    public function uploadImage(UploadedFile $image): string
    {
        $link = Storage::url($image->storePubliclyAs('public', $image->getClientOriginalName()));
        return $link;
    }

    /**
     * Save image for provided product (CLI).
     *
     * @param string $products
     * @return string|null
     */
    public function uploadImageCLI(string $path) : string
    {
        $db_path = '/'.basename(trim($path));
        $public_path = 'public'.$db_path;

        try {
            Storage::put($public_path, File::get(trim($path)));
            return ("/storage/".$db_path);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }

        return null;
    }

    /**
     * Remove the specified product image from storage.
     *
     * @param string $image
     * @return bool
     */
    public function deleteImageProduct(string $image): bool
    {
        list($part1, $part2) = explode('/storage/', $image);
        return Storage::delete("/public/".$part2);
    }
}
