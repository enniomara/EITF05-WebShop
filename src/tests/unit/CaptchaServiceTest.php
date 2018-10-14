<?php

namespace Tests\Unit;

use App\Classes\CaptchaService;
use App\Classes\SessionManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CaptchaServiceTest extends TestCase
{
    /**
     * @var CaptchaService
     */
    private $captchaService;

    /**
     * @var SessionManager|MockObject
     */
    private $sessionManagerStub;

    protected function setUp()
    {
        parent::setUp();

        $this->sessionManagerStub = $this->getMockBuilder(SessionManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->captchaService = new CaptchaService($this->sessionManagerStub);
    }

    public function testIncreaseCaptchaAttempts()
    {
        $this->sessionManagerStub->expects($this->once())
            ->method('get')
            ->with('loginAttempts')
            ->willReturn(2);

        $this->sessionManagerStub->expects($this->once())
            ->method('put')
            ->with('loginAttempts', 3);

        $this->captchaService->increaseCaptchaAttempts();
    }

    public function testResetCaptchaAttempts()
    {
        $this->sessionManagerStub->expects($this->once())
            ->method('put')
            ->with('loginAttempts', 0);

        $this->captchaService->resetCaptchaAttempts();
    }

    public function testIsValidEmptyKey()
    {
        $this->assertFalse($this->captchaService->isValid(""));
    }

    public function testShouldShowReturnsTrue()
    {
        $this->sessionManagerStub->expects($this->once())
            ->method('get')
            ->with('loginAttempts')
            ->willReturn(2);

        $this->assertTrue($this->captchaService->shouldShow());
    }

    public function testShouldShowReturnsFalse()
    {
        $this->sessionManagerStub->expects($this->once())
            ->method('get')
            ->with('loginAttempts')
            ->willReturn(1);

        $this->assertFalse($this->captchaService->shouldShow());
    }
}
