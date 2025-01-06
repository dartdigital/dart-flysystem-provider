<?php

namespace Dart\Library\Craft\FlysystemProvider\Adapter;

use Craft;
use Aws\S3\S3Client;
use craft\flysystem\base\FlysystemFs;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\FilesystemAdapter;

class DigitalOceanS3Adapter extends FlysystemFs {

    private array $args;

    private bool $cachePurged = false;

    public function __construct(
        public string $accessKeyId,
        public string $secretAccessKey,
        public string $region,
        public string $bucket,
        public ?string $apiToken = null,
        public ?string $cdnEndpointId = null,
    ) {
        $this->args =  [
            'version' => 'latest',
            'region' => $region,
            'endpoint' => "https://$region.digitaloceanspaces.com",
            'credentials' => [
                'key'    => $accessKeyId,
                'secret' => $secretAccessKey,
            ],
        ];

        parent::__construct();
    }

    protected function createAdapter(): FilesystemAdapter
    {
        return new AwsS3V3Adapter(
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
//                "https://api.digitalocean.com/v2/cdn/endpoints/$this->cdnEndpointId/cache",
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
