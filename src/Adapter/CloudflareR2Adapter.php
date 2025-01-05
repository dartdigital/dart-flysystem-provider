<?php

namespace Dart\Library\Craft\StorageProvider\Adapter;

use Aws\S3\S3Client;
use craft\flysystem\base\FlysystemFs;
use Dart\Library\Craft\StorageProvider\Lib\CloudflareR2FlysystemAdapter;
use League\Flysystem\FilesystemAdapter;

class CloudflareR2Adapter extends FlysystemFs {

    private array $args;

//    private bool $cachePurged = false;

    public function __construct(
        public string $accountId,
        public string $accessKeyId,
        public string $secretAccessKey,
        public string $bucket,
        public ?bool $eu = false,
        public ?string $zoneId = null,
        public ?string $apiToken = null,
    ) {
        $this->args =  [
            'region' => 'us-east-1',
            'version' => 'latest',
            'endpoint' => "https://$accountId." . ($this->eu ? 'eu.' : '') . "r2.cloudflarestorage.com",
            'use_path_style_endpoint' => false,
            'credentials' => [
                'key' => $accessKeyId,
                'secret' => $secretAccessKey,
            ]
        ];

        parent::__construct();
    }

    protected function createAdapter(): FilesystemAdapter
    {
        return new CloudflareR2FlysystemAdapter(
            new S3Client($this->args),
            $this->bucket
        );
    }

    protected function invalidateCdnPath(string $path): bool
    {
        return false;
//        // fix for DigitalOcean RateLimit.
//        if ($this->cachePurged) {
//            return true;
//        }
//
//        // Read all files to be deleted.
//        // @todo Was ist mit den anderen Fällen, wie verschieben von Dateien etc.?
//        try {
//            $bodyParams = Craft::$app->request->getBodyParams();
//
//            $paths = [];
//            if ($bodyParams && isset($bodyParams['elementAction']) &&  $bodyParams['elementAction'] === 'craft\elements\actions\DeleteAssets') {
//                $assets = Asset::find()->id($bodyParams['elementIds'])->all();
//
//                foreach ($assets as $asset) {
//                    $paths[] = $asset->getPath();
//                }
//            }
//        } catch (\Exception $e) {
//            return false;
//        }
//
//
//        try {
//            $client = HttpClient::create();
//            $response = $client->request(
//                'DELETE',
//                "https://api.cloudflare.com/client/v4/zones/$this->zoneId/purge_cache",
//                [
//                    'headers' => [
//                        'Content-Type' => 'application/json',
//                        'Authorization' => 'Bearer ' . $this->apiToken,
//                    ],
//                    'json' => [
//                        'files' => count($paths) > 0 ? $paths : [$path],
//                    ]
//                ]
//            );
//
//            $statusCode = $response->getStatusCode();
//            $content = $response->getContent();
//        } catch(\Exception $e) {
//            Craft::warning('invalidateCdnPath error', 'filesystem');
//
//            return false;
//        }
//
//        $this->cachePurged = true;
//        return true;
    }
}