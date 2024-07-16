<?php

namespace Tests\Unit;

use Exception;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;
use App\Traits\HandlesImages;
use App\Contracts\StorageServiceInterface;

class HandlesImagesTest extends TestCase
{
    /** @var HandlesImages */
    protected $handlesImagesTrait;

    /** @var StorageServiceInterface|MockObject */
    protected $storageServiceMock;

    protected string $testingImage;

    protected string $testingImageName;

    /**
     * @throws Exception|\PHPUnit\Framework\MockObject\Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->testingImage = 'https://ei.phncdn.com/pics/pornstars/000/000/002/(m=lciuhScOb_c)(mh=5Lb6oqzf58Pdh9Wc)thumb_22561.jpg';

        $this->testingImageName = '(m=lciuhScOb_c)(mh=5Lb6oqzf58Pdh9Wc)thumb_22561.jpg';

        $this->storageServiceMock = $this->createMock(StorageServiceInterface::class);

        $this->handlesImagesTrait = new class {
            use HandlesImages;

            public function setStorageService(StorageServiceInterface $storageService): void
            {
                $this->storageService = $storageService;
            }

            public function callDownloadImage($folderName, $thumbnail)
            {
                return $this->downloadImage($folderName, $thumbnail);
            }
        };

        $this->handlesImagesTrait->setStorageService($this->storageServiceMock);
    }

    /** @test */
    public function it_downloads_image_if_not_exists()
    {
        $folderName = 'pornstar';
        $thumbnail = (object) [
            'type' => 'type1',
            'pornstar_id' => 1,
            'urls' => [$this->testingImage],
            'height' => 100,
            'width' => 100,
        ];

        $this->storageServiceMock
            ->expects($this->once())
            ->method('exists')
            ->with("public/$folderName/{$thumbnail->type}/{$thumbnail->pornstar_id}/{$this->testingImageName}")
            ->willReturn(false);

        Http::fake([
            'https://ei.phncdn.com/*' => Http::response('fake image content', 200),
        ]);

        $httpBody = Http::get($this->testingImage)->body();

        $this->storageServiceMock
            ->expects($this->once())
            ->method('get')
            ->with($this->testingImage)
            ->willReturn($httpBody);

        $this->storageServiceMock
            ->expects($this->once())
            ->method('put')
            ->with("public/$folderName/{$thumbnail->type}/{$thumbnail->pornstar_id}/{$this->testingImageName}", $httpBody);

        $this->storageServiceMock
            ->expects($this->once())
            ->method('url')
            ->with("public/$folderName/{$thumbnail->type}/{$thumbnail->pornstar_id}/{$this->testingImageName}")
            ->willReturn(config('app.url')."/storage/public/$folderName/{$thumbnail->type}/{$thumbnail->pornstar_id}/{$this->testingImageName}");

        $result = $this->handlesImagesTrait->callDownloadImage($folderName, $thumbnail);

        $expectedUrl = config('app.url')."/storage/public/pornstar/type1/1/{$this->testingImageName}";
        $this->assertArrayHasKey('url', $result);
        $this->assertEquals($expectedUrl, $result['url']);
        $this->assertEquals(100, $result['height']);
        $this->assertEquals(100, $result['width']);
        $this->assertEquals('type1', $result['type']);
    }
}
