<?php
namespace PackageFactory\AtomicFusion\Forms\Tests\Unit\Fusion\Fields;

use TYPO3\Flow\Tests\UnitTestCase;
use TYPO3\TypoScript\Core\Runtime as FusionRuntime;
use PackageFactory\AtomicFusion\Forms\Domain\Model\Definition\FieldDefinitionInterface;
use PackageFactory\AtomicFusion\Forms\Domain\Model\Definition\ProcessorDefinitionInterface;
use PackageFactory\AtomicFusion\Forms\Domain\Model\Definition\ValidatorDefinitionInterface;
use PackageFactory\AtomicFusion\Forms\Domain\Model\Definition\FormDefinitionInterface;
use PackageFactory\AtomicFusion\Forms\Domain\Model\Definition\Factory\FieldDefinitionFactoryInterface;
use PackageFactory\AtomicFusion\Forms\Fusion\Fields\FieldImplementation;

class FieldImplementationTest extends UnitTestCase
{
    /**
     * @test
     */
    public function evaluatesToAFormDefinitionFactory()
    {
        $fusionRuntime = $this->createMock(FusionRuntime::class);
        $fieldImplementation = new FieldImplementation($fusionRuntime, '', '');

        $this->assertTrue($fieldImplementation->evaluate() instanceof FieldDefinitionFactoryInterface);
    }

    /**
     * @test
     */
    public function createsFieldDefinitions()
    {
        $fusionRuntime = $this->createMock(FusionRuntime::class);
        $fieldImplementation = new FieldImplementation($fusionRuntime, '', '');
        $formDefinition = $this->createMock(FormDefinitionInterface::class);
        $processorDefinition = $this->createMock(ProcessorDefinitionInterface::class);
        $validatorDefinition = $this->createMock(ValidatorDefinitionInterface::class);
        $validatorDefinition->method('getName')->willReturn('Validator');

        $fusionRuntime->expects($this->exactly(6))
            ->method('evaluate')
            ->withConsecutive(
                ['/label', $fieldImplementation],
                ['/name', $fieldImplementation],
                ['/type', $fieldImplementation],
                ['/page', $fieldImplementation],
                ['/processor', $fieldImplementation],
                ['/validators', $fieldImplementation]
            )
            ->will($this->onConsecutiveCalls(
                'SomeLabel',
                'SomeName',
                'SomeType',
                'SomePage',
                $processorDefinition,
                [$validatorDefinition]
            ));

        $fieldDefinition = $fieldImplementation->createFieldDefinition($formDefinition);

        $this->assertTrue($fieldDefinition instanceof FieldDefinitionInterface);
        $this->assertEquals('SomeLabel', $fieldDefinition->getLabel());
        $this->assertEquals('SomeName', $fieldDefinition->getName());
        $this->assertEquals('SomeType', $fieldDefinition->getType());
        $this->assertEquals('SomePage', $fieldDefinition->getPage());
        $this->assertSame($processorDefinition, $fieldDefinition->getProcessorDefinition());
        $this->assertEquals(1, count($fieldDefinition->getValidatorDefinitions()));
        $this->assertSame($validatorDefinition, $fieldDefinition->getValidatorDefinitions()['Validator']);
    }
}