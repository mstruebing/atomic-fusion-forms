<?php
namespace PackageFactory\AtomicFusion\Forms\Tests\Unit\Domain\Service\State\Factory;

use TYPO3\Flow\Tests\UnitTestCase;
use TYPO3\Flow\Http\Response;
use PackageFactory\AtomicFusion\Forms\Domain\Service\State\FinisherStateInterface;
use PackageFactory\AtomicFusion\Forms\Domain\Service\State\Factory\FinisherStateFactory;

class FinisherStateFactoryTest extends UnitTestCase
{
    /**
     * @test
     */
    public function createsFinisherStates()
    {
        $finisherStateFactory = new FinisherStateFactory();
        $response = $this->createMock(Response::class);

        $finisherState = $finisherStateFactory->createFinisherState($response);

        $this->assertTrue($finisherState instanceof FinisherStateInterface);
    }
}
