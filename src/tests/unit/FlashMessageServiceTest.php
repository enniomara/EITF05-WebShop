<?php

namespace Tests\Unit;

use App\Classes\FlashMessageService;
use App\Classes\Models\FlashMessage;
use App\Classes\SessionManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class FlashMessageServiceTest extends TestCase
{
    /**
     * @var FlashMessageService
     */
    private $flashMessageService;
    /**
     * @var SessionManager|MockObject
     */
    private $sessionManager;

    protected function setUp()
    {
        parent::setUp();

        $this->sessionManager = $this->getMockBuilder(SessionManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->flashMessageService = new FlashMessageService($this->sessionManager);
    }

    public function testAdd()
    {
        $this->sessionManager->expects($this->once())
            ->method('get')
            ->willReturn([1 => ['message1']]);

        $this->sessionManager->expects($this->once())
            ->method('put')
            ->with('flashMessages', [
                1 => ['message1', 'message2']
            ]);

        $this->flashMessageService->add('message2', 1);
    }

    public function testClear()
    {
        $this->sessionManager->expects($this->once())
            ->method('get')
            ->willReturn([1 => ['message1'], 2 => ['message']]);

        $this->sessionManager->expects($this->once())
            ->method('put')
            ->with('flashMessages', [
                1 => [],
                2 => ['message']
            ]);
        $this->flashMessageService->clear(1);
    }

    public function testHasMessagesWithType()
    {
        $this->sessionManager->expects($this->exactly(2))
            ->method('get')
            ->willReturnOnConsecutiveCalls([
                [
                    1 => ['message1'],
                    2 => ['message']
                ],
                [
                    1 => ['message1'],
                    2 => []
                ]
            ]);

        $this->assertTrue($this->flashMessageService->hasMessages(1));

        $this->assertFalse($this->flashMessageService->hasMessages(2));
    }

    /**
     * Call hasMessages with a null type parameter
     */
    public function testHasMessagesAll()
    {
        $this->sessionManager->expects($this->exactly(2))
            ->method('get')
            ->willReturnOnConsecutiveCalls([
                [
                    1 => ['message1'],
                    2 => ['message']
                ],
                [
                    1 => [],
                    2 => []
                ]
            ]);

        $this->assertTrue($this->flashMessageService->hasMessages());
        $this->assertFalse($this->flashMessageService->hasMessages());
    }

    public function testGetMessage()
    {
        // Only mock the clear method
        $flashMessageService = $this->getMockBuilder(FlashMessageService::class)
            ->setMethods(['clear'])
            ->setConstructorArgs([$this->sessionManager])
            ->getMock();

        $flashMessageService->expects($this->once())
            ->method('clear')
            ->willReturn(null);

        $this->sessionManager->expects($this->once())
            ->method('get')
            ->willReturn([
                1 => ['message1', 'message2'],
                2 => ['amotherMessage']
            ]);

        $expectedResponse = [
            new FlashMessage('message1', 1),
            new FlashMessage('message2', 1)
        ];
        $this->assertEquals($expectedResponse, $flashMessageService->getMessage(1));
    }
}
