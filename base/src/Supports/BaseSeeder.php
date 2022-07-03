<?php

namespace BlackCMS\Base\Supports;

use BlackCMS\Media\Models\MediaFile;
use BlackCMS\Media\Models\MediaFolder;
use BlackCMS\Addon\Services\AddonService;
use Exception;
use File;
use Illuminate\Database\Seeder;
use Mimey\MimeTypes;
use MediaManagement;

class BaseSeeder extends Seeder
{
    /**
     * @param string $folder
     * @param null|string $basePath
     * @return array
     */
    public function uploadFiles(string $folder, $basePath = null): array
    {
        File::deleteDirectory(
            config("filesystems.disks.public.root") . "/" . $folder
        );
        MediaFile::where("url", "LIKE", $folder . "/%")->forceDelete();
        MediaFolder::where("name", $folder)->forceDelete();

        $mimeType = new MimeTypes();

        $files = [];

        $folderPath =
            ($basePath ?: database_path("seeders/files")) . "/" . $folder;

        foreach (File::allFiles($folderPath) as $file) {
            $type = $mimeType->getMimeType(File::extension($file));
            $files[] = MediaManagement::uploadFromPath(
                $file,
                0,
                $folder,
                $type
            );
        }

        return $files;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function activateAllAddons(): array
    {
        $addons = array_values(scan_folder(addon_path()));

        $addonService = app(AddonService::class);

        foreach ($addons as $addon) {
            $addonService->activate($addon);
        }

        return $addons;
    }
}
