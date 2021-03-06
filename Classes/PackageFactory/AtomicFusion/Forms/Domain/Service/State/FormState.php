<?php
namespace PackageFactory\AtomicFusion\Forms\Domain\Service\State;

/**
 * This file is part of the PackageFactory.AtomicFusion.Forms package
 *
 * (c) 2016 Wilhelm Behncke <wilhelm.behncke@googlemail.com>
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Utility\ObjectAccess;
use Neos\Utility\Arrays;
use Neos\Error\Messages\Result;

/**
 * The form state
 */
class FormState implements FormStateInterface
{
    /**
     * @var boolean
     */
    protected $initialCall = true;

    /**
     * @var array
     */
    protected $arguments = [];

    /**
     * @var array
     */
    protected $values = [];

    /**
     * @var Result
     */
    protected $validationResult;

    /**
     * @var string
     */
    protected $currentPage = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->validationResult = new Result();
    }

    /**
     * @inheritdoc
     */
    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * @inheritdoc
     */
    public function addArgument($name, $value)
    {
        $this->arguments[$name] = $value;
    }

    /**
     * @inheritdoc
     */
    public function mergeArguments(array $arguments)
    {
        $this->arguments = Arrays::arrayMergeRecursiveOverrule(
            $this->arguments,
            $arguments
        );
    }

    /**
     * @inheritdoc
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @inheritdoc
     */
    public function getArgument($path)
    {
        return ObjectAccess::getPropertyPath($this->arguments, $path);
    }

    /**
     * @inheritdoc
     */
    public function setValues(array $values)
    {
        $this->values = $values;
    }

    /**
     * @inheritdoc
     */
    public function addValue($name, $value)
    {
        $this->values[$name] = $value;
    }

    /**
     * @inheritdoc
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @inheritdoc
     */
    public function getValue($path)
    {
        return ObjectAccess::getPropertyPath($this->values, $path);
    }

    /**
     * @inheritdoc
     */
    public function setCurrentPage($pageIdentifier)
    {
        $this->currentPage = $pageIdentifier;
    }

    /**
     * @inheritdoc
     */
    public function getValidationResult()
    {
        return $this->validationResult;
    }

    /**
     * @inheritdoc
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * @inheritdoc
     */
    public function isCurrentPage($pageIdentifier)
    {
        return $this->currentPage === $pageIdentifier;
    }

    /**
     * @inheritdoc
     */
    public function isInitialCall()
    {
        return $this->initialCall;
    }

    /**
     * Indicate, that the form has already been called when this object gets
     * unserialized
     *
     * Re-Initialize state parts that weren't persisted
     *
     * @return void
     */
    public function __wakeup()
    {
        $this->initialCall = false;
        $this->validationResult = new Result();
    }

    /**
     * Invalidate state parts that should not be persisted between pages
     *
     * @return void
     */
    public function __sleep()
    {
        return ['arguments', 'values', 'currentPage'];
    }
}
