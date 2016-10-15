<?php
namespace PackageFactory\AtomicFusion\Forms\Domain\Model\Finishers;

/**
 * This file is part of the PackageFactory.AtomicFusion.Forms package
 *
 * (c) 2016 Wilhelm Behncke <wilhelm.behncke@googlemail.com>
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use TYPO3\Flow\Annotations as Flow;
use PackageFactory\AtomicFusion\Forms\Domain\Exception\FinisherRuntimeException;
use PackageFactory\AtomicFusion\Forms\Domain\Service\FinisherRuntime;

/**
 * Defines methods for finishers
 */
interface FinisherInterface
{
    /**
     * Execute this finisher
     *
     * @param FinisherRuntime $finisherRuntime
     * @return void
     * @throws FinisherRuntimeException when the execution fails
     */
    public function execute(FinisherRuntime $finisherRuntime);
}
