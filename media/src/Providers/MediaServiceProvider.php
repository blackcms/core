<?php

namespace BlackCMS\Media\Providers;

use Aws\S3\S3Client;
use BlackCMS\Base\Traits\LoadAndPublishDataTrait;
use BlackCMS\Media\Chunks\Storage\ChunkStorage;
use BlackCMS\Media\Commands\ClearChunksCommand;
use BlackCMS\Media\Commands\DeleteThumbnailCommand;
use BlackCMS\Media\Commands\GenerateThumbnailCommand;
use BlackCMS\Media\Commands\InsertWatermarkCommand;
use BlackCMS\Media\Facades\MediaManagementFacade;
use BlackCMS\Media\Models\MediaFile;
use BlackCMS\Media\Models\MediaFolder;
use BlackCMS\Media\Models\MediaSetting;
use BlackCMS\Media\Repositories\Caches\MediaFileCacheDecorator;
use BlackCMS\Media\Repositories\Caches\MediaFolderCacheDecorator;
use BlackCMS\Media\Repositories\Caches\MediaSettingCacheDecorator;
use BlackCMS\Media\Repositories\Eloquent\MediaFileRepository;
use BlackCMS\Media\Repositories\Eloquent\MediaFolderRepository;
use BlackCMS\Media\Repositories\Eloquent\MediaSettingRepository;
use BlackCMS\Media\Repositories\Interfaces\MediaFileInterface;
use BlackCMS\Media\Repositories\Interfaces\MediaFolderInterface;
use BlackCMS\Media\Repositories\Interfaces\MediaSettingInterface;
use BlackCMS\Media\Storage\BunnyCDN\BunnyCDNAdapter;
use BlackCMS\Media\Storage\BunnyCDN\BunnyCDNStorage;
use BlackCMS\Setting\Supports\SettingStore;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;
use MediaManagement;

/**
 * @since 02/07/2016 09:50 AM
 */
class MediaServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(MediaFileInterface::class, function () {
            return new MediaFileCacheDecorator(
                new MediaFileRepository(new MediaFile()),
                MEDIA_GROUP_CACHE_KEY
            );
        });

        $this->app->bind(MediaFolderInterface::class, function () {
            return new MediaFolderCacheDecorator(
                new MediaFolderRepository(new MediaFolder()),
                MEDIA_GROUP_CACHE_KEY
            );
        });

        $this->app->bind(MediaSettingInterface::class, function () {
            return new MediaSettingCacheDecorator(
                new MediaSettingRepository(new MediaSetting()),
                MEDIA_GROUP_CACHE_KEY
            );
        });

        AliasLoader::getInstance()->alias(
            "MediaManagement",
            MediaManagementFacade::class
        );
    }

    public function boot()
    {
        $this->setNamespace("core/media")
            ->loadHelpers()
            ->loadAndPublishConfigurations(["permissions", "media"])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadRoutes()
            ->publishAssets();

        Storage::extend("wasabi", function ($app, $config) {
            $client = new S3Client([
                "endpoint" =>
                    "https://" .
                    $config["bucket"] .
                    ".s3." .
                    $config["region"] .
                    ".wasabisys.com/",
                "bucket_endpoint" => true,
                "credentials" => [
                    "key" => $config["key"],
                    "secret" => $config["secret"],
                ],
                "region" => $config["region"],
                "version" => "latest",
            ]);

            $adapter = new AwsS3Adapter(
                $client,
                $config["bucket"],
                $config["root"]
            );

            return new Filesystem($adapter);
        });

        Storage::extend("bunnycdn", function ($app, $config) {
            $adapter = new BunnyCDNAdapter(
                new BunnyCDNStorage(
                    $config["zone"],
                    $config["key"],
                    $config["region"]
                )
            );

            return new Filesystem($adapter);
        });

        $config = $this->app->make("config");
        $setting = $this->app->make(SettingStore::class);

        $config->set([
            "filesystems.default" => $setting->get("media_driver", "public"),
            "filesystems.disks.s3" => [
                "driver" => "s3",
                "visibility" => "public",
                "key" => $setting->get(
                    "media_aws_access_key_id",
                    $config->get("filesystems.disks.s3.key")
                ),
                "secret" => $setting->get(
                    "media_aws_secret_key",
                    $config->get("filesystems.disks.s3.secret")
                ),
                "region" => $setting->get(
                    "media_aws_default_region",
                    $config->get("filesystems.disks.s3.region")
                ),
                "bucket" => $setting->get(
                    "media_aws_bucket",
                    $config->get("filesystems.disks.s3.bucket")
                ),
                "url" => $setting->get(
                    "media_aws_url",
                    $config->get("filesystems.disks.s3.url")
                ),
                "endpoint" =>
                    $setting->get(
                        "media_aws_endpoint",
                        $config->get("filesystems.disks.s3.endpoint")
                    ) ?:
                    null,
                "use_path_style_endpoint" => $config->get(
                    "filesystems.disks.s3.use_path_style_endpoint"
                ),
            ],
            "filesystems.disks.do_spaces" => [
                "driver" => "s3",
                "visibility" => "public",
                "key" => $setting->get("media_do_spaces_access_key_id"),
                "secret" => $setting->get("media_do_spaces_secret_key"),
                "region" => $setting->get("media_do_spaces_default_region"),
                "bucket" => $setting->get("media_do_spaces_bucket"),
                "endpoint" => $setting->get("media_do_spaces_endpoint"),
            ],
            "filesystems.disks.wasabi" => [
                "driver" => "wasabi",
                "visibility" => "public",
                "key" => $setting->get("media_wasabi_access_key_id"),
                "secret" => $setting->get("media_wasabi_secret_key"),
                "region" => $setting->get("media_wasabi_default_region"),
                "bucket" => $setting->get("media_wasabi_bucket"),
                "root" => $setting->get("media_wasabi_root", "/"),
            ],
            "filesystems.disks.bunnycdn" => [
                "driver" => "bunnycdn",
                "hostname" => $setting->get("media_bunnycdn_hostname"),
                "zone" => $setting->get("media_bunnycdn_zone"),
                "key" => $setting->get("media_bunnycdn_key"),
                "region" => $setting->get("media_bunnycdn_region"),
            ],
            "core.media.media.chunk.enabled" => (bool) $setting->get(
                "media_chunk_enabled",
                $config->get("core.media.media.chunk.enabled")
            ),
            "core.media.media.chunk.chunk_size" => (int) $setting->get(
                "media_chunk_size",
                $config->get("core.media.media.chunk.chunk_size")
            ),
            "core.media.media.chunk.max_file_size" => (int) $setting->get(
                "media_max_file_size",
                $config->get("core.media.media.chunk.max_file_size")
            ),
        ]);

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->registerItem([
                "id" => "cms-core-media",
                "priority" => 440,
                "parent_id" => null,
                "name" => "core/media::media.menu_name",
                "icon" => "las la-image la-2x",
                "url" => route("media.index"),
                "permissions" => ["media.index"],
            ]);
        });

        $this->commands([
            GenerateThumbnailCommand::class,
            DeleteThumbnailCommand::class,
            ClearChunksCommand::class,
            InsertWatermarkCommand::class,
        ]);

        $this->app->booted(function () {
            if (MediaManagement::getConfig("chunk.clear.schedule.enabled")) {
                $schedule = $this->app->make(Schedule::class);

                $schedule
                    ->command("cms:media:chunks:clear")
                    ->cron(
                        MediaManagement::getConfig("chunk.clear.schedule.cron")
                    );
            }
        });

        $this->app->singleton(ChunkStorage::class, function () {
            return new ChunkStorage();
        });
    }
}
