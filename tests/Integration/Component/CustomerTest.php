<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Tests\Integration\Component;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Office\OfficeClient;
use SandwaveIo\Office365\Response\QueuedResponse;

final class CustomerTest extends TestCase
{
    /**
     * @test
     */
    public function create(): void {
        $ninaResponse = '<NinaResponse><IsSuccess>true</IsSuccess><ErrorCode>0</ErrorCode><ErrorMessage>Success</ErrorMessage></NinaResponse>';

        $mockHandler = new MockHandler(
            [new Response(200, [], $ninaResponse)]
        );
        $stack = HandlerStack::create($mockHandler);
        $officeClient = new OfficeClient("example.com", "test", "test", ['handler' => $stack]);

        $customerResponse = $officeClient->customer->create("testname" );

        $this->assertInstanceOf(QueuedResponse::class, $customerResponse);
        $this->assertTrue($customerResponse->isSuccess());
        $this->assertSame("Success", $customerResponse->getErrorMessage());
        $this->assertSame(0, $customerResponse->getErrorCode());
    }
}
