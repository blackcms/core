<?php

namespace BlackCMS\Media\Http\Controllers;

use BlackCMS\Media\Chunks\Exceptions\UploadMissingFileException;
use BlackCMS\Media\Chunks\Handler\DropZoneUploadHandler;
use BlackCMS\Media\Chunks\Receiver\FileReceiver;
use BlackCMS\Media\Repositories\Interfaces\MediaFileInterface;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use MediaManagement;
use Storage;
use Validator;

/**
 * @since 19/08/2015 07:50 AM
 */
class MediaFileController extends Controller
{
    /**
     * @var MediaFileInterface
     */
    protected $fileRepository;

    /**
     * @param MediaFileInterface $fileRepository
     */
    public function __construct(MediaFileInterface $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function postUpload(Request $request)
    {
        if (!MediaManagement::isChunkUploadEnabled()) {
            $result = MediaManagement::handleUpload(
                Arr::first($request->file("file")),
                $request->input("folder_id", 0)
            );

            return $this->handleUploadResponse($result);
        }

        try {
            // Create the file receiver
            $receiver = new FileReceiver(
                "file",
                $request,
                DropZoneUploadHandler::class
            );
            // Check if the upload is success, throw exception or return response you need
            if ($receiver->isUploaded() === false) {
                throw new UploadMissingFileException();
            }
            // Receive the file
            $save = $receiver->receive();
            // Check if the upload has finished (in chunk mode it will send smaller files)
            if ($save->isFinished()) {
                $result = MediaManagement::handleUpload(
                    $save->getFile(),
                    $request->input("folder_id", 0)
                );

                return $this->handleUploadResponse($result);
            }
            // We are in chunk mode, lets send the current progress
            $handler = $save->handler();

            return response()->json([
                "done" => $handler->getPercentageDone(),
                "status" => true,
            ]);
        } catch (Exception $exception) {
            return MediaManagement::responseError($exception->getMessage());
        }
    }

    /**
     * @param array $result
     * @return JsonResponse
     */
    protected function handleUploadResponse(array $result)
    {
        if (!$result["error"]) {
            return MediaManagement::responseSuccess([
                "id" => $result["data"]->id,
                "src" => MediaManagement::url($result["data"]->url),
            ]);
        }

        return MediaManagement::responseError($result["message"]);
    }

    /**
     * @param Request $request
     * @return ResponseFactory|JsonResponse|Response
     */
    public function postUploadFromEditor(Request $request)
    {
        return MediaManagement::uploadFromEditor($request);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function postDownloadUrl(Request $request)
    {
        $validator = Validator::make($request->input(), [
            "url" => "required",
        ]);

        if ($validator->fails()) {
            return MediaManagement::responseError(
                $validator->messages()->first()
            );
        }

        $result = MediaManagement::uploadFromUrl(
            $request->input("url"),
            $request->input("folderId")
        );

        if (!$result["error"]) {
            return MediaManagement::responseSuccess([
                "id" => $result["data"]->id,
                "src" => Storage::url($result["data"]->url),
                "url" => $result["data"]->url,
                "message" => trans(
                    "core/media::media.javascript.message.success_header"
                ),
            ]);
        }

        return MediaManagement::responseError($result["message"]);
    }
}
