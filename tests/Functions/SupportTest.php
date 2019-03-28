<?php
namespace MathPHP\Tests\Functions;

use MathPHP\Functions\Support;
use MathPHP\Exception;

class SupportTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider dataProviderForCheckLimitsLowerLimit
     */
    public function testCheckLimitsLowerLimit(array $limits, array $params)
    {
        $this->assertTrue(Support::checkLimits($limits, $params));
    }

    public function dataProviderForCheckLimitsLowerLimit()
    {
        return [
            [
                ['x' => '[0,∞]'],
                ['x' => 0],
            ],
            [
                ['x' => '[0,∞]'],
                ['x' => 0.1],
            ],
            [
                ['x' => '[0,∞]'],
                ['x' => 1],
            ],
            [
                ['x' => '[0,∞]'],
                ['x' => 4934],
            ],
            [
                ['x' => '(0,∞]'],
                ['x' => 0.1],
            ],
            [
                ['x' => '(0,∞]'],
                ['x' => 1],
            ],
            [
                ['x' => '(0,∞]'],
                ['x' => 4934],
            ],
            [
                ['x' => '[-50,∞]'],
                ['x' => -50],
            ],
            [
                ['x' => '(-50,∞]'],
                ['x' => -49],
            ],
            [
                ['x' => '[-∞,10]'],
                ['x' => -89379837],
            ],
            [
                ['x' => '(-∞,10]'],
                ['x' => -95893223452],
            ],
            [
                ['x' => '[0,∞]', 'y' => '[0,∞]'],
                ['x' => 0, 'y' => 5],
            ],
            [
                ['x' => '[0,∞]', 'y' => '[0,∞]', 'z' => '[0,1]'],
                ['x' => 0, 'y' => 5],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForCheckLimitsLowerLimitException
     */
    public function testCheckLimitsLowerLimitException(array $limits, array $params)
    {
        $this->expectException(Exception\OutOfBoundsException::class);
        Support::checkLimits($limits, $params);
    }

    public function dataProviderForCheckLimitsLowerLimitException()
    {
        return [
            [
                ['x' => '[0,∞]'],
                ['x' => -1],
            ],
            [
                ['x' => '[0,∞]'],
                ['x' => -4],
            ],
            [
                ['x' => '[5,∞]'],
                ['x' => 4],
            ],
            [
                ['x' => '(0,∞]'],
                ['x' => -1],
            ],
            [
                ['x' => '(0,∞]'],
                ['x' => -4],
            ],
            [
                ['x' => '(5,∞]'],
                ['x' => 4],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForCheckLimitsUpperLimit
     */
    public function testCheckLimitsUpperLimit(array $limits, array $params)
    {
        $this->assertTrue(Support::checkLimits($limits, $params));
    }

    public function dataProviderForCheckLimitsUpperLimit()
    {
        return [
            [
                ['x' => '[0,5]'],
                ['x' => 0],
            ],
            [
                ['x' => '[0,5]'],
                ['x' => 3],
            ],
            [
                ['x' => '[0,5]'],
                ['x' => 5],
            ],
            [
                ['x' => '[0,5)'],
                ['x' => 0],
            ],
            [
                ['x' => '[0,5)'],
                ['x' => 3],
            ],
            [
                ['x' => '[0,5)'],
                ['x' => 4.999],
            ],
            [
                ['x' => '[0,∞]'],
                ['x' => 9489859893],
            ],
            [
                ['x' => '[0,∞)'],
                ['x' => 9489859893],
            ],
            [
                ['x' => '[0,5]', 'y' => '[0,5]'],
                ['x' => 0],
            ],
            [
                ['x' => '[0,5]', 'y' => '[0,5]'],
                ['x' => 0, 'y' => 3],
            ],
            [
                ['x' => '[0,5]', 'y' => '[0,5]', 'z' => '[0,5]'],
                ['x' => 0, 'y' => 3],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForCheckLimitsUpperLimitException
     */
    public function testCheckLimitsUpperLimitException(array $limits, array $params)
    {
        $this->expectException(Exception\OutOfBoundsException::class);
        Support::checkLimits($limits, $params);
    }

    public function dataProviderForCheckLimitsUpperLimitException()
    {
        return [
            [
                ['x' => '[0,5]'],
                ['x' => 5.001],
            ],
            [
                ['x' => '[0,5]'],
                ['x' => 6],
            ],
            [
                ['x' => '[0,5]'],
                ['x' => 98349389],
            ],
            [
                ['x' => '[0,5)'],
                ['x' => 5],
            ],
            [
                ['x' => '[0,5)'],
                ['x' => 5.1],
            ],
            [
                ['x' => '[0,5)'],
                ['x' => 857385738],
            ],
        ];
    }

    public function testCheckLimitsLowerLimitEndpointException()
    {
        $this->expectException(Exception\BadDataException::class);

        $limits = ['x' => '{0,1)'];
        $params = ['x' => 0.5];
        Support::checkLimits($limits, $params);
    }

    public function testCheckLimitsUpperLimitEndpointException()
    {
        $this->expectException(Exception\BadDataException::class);

        $limits = ['x' => '(0,1}'];
        $params = ['x' => 0.5];
        Support::checkLimits($limits, $params);
    }

    /**
     * @dataProvider dataProviderForCheckLimitsUndefinedParameterException
     */
    public function testCheckLimitsUndefinedParameterException(array $limits, array $params)
    {
        $this->expectException(Exception\BadParameterException::class);
        Support::checkLimits($limits, $params);
    }

    public function dataProviderForCheckLimitsUndefinedParameterException()
    {
        return [
            [
                ['x' => '[0,1]'],
                ['y' => 0.5],
            ],
            [
                ['x' => '[0,1]', 'a' => '[0,10]'],
                ['y' => 0.5],
            ],
            [
                ['x' => '[0,1]', 'a' => '[0,10]'],
                ['x' => 0.5, 'b' => 4],
            ],
            [
                ['x' => '[0,1]', 'a' => '[0,10]'],
                ['x' => 0.5, 'a' => 4, 'z' => 9],
            ],
        ];
    }

    /**
     * @testCase     isZero returns true for infinitesimal quantities less than the defined epsilon
     * @dataProvider dataProviderForZero
     *
     * @param  float $x
     */
    public function testIsZeroTrue(float $x)
    {
        $this->assertTrue(Support::isZero($x));
    }

    /**
     * @testCase     isZero returns false for infinitesimal quantities greater than the defined epsilon
     * @dataProvider dataProviderForNotZero
     *
     * @param  float $x
     */
    public function testIsZeroFalse(float $x)
    {
        $this->assertFalse(Support::isZero($x));
    }

    /**
     * @testCase     isNotZero returns true for infinitesimal quantities greater than the defined epsilon
     * @dataProvider dataProviderForNotZero
     *
     * @param  float $x
     */
    public function testIsNotZeroTrue(float $x)
    {
        $this->assertTrue(Support::isNotZero($x));
    }

    /**
     * @testCase     isNotZero returns false for infinitesimal quantities less than the defined epsilon
     * @dataProvider dataProviderForZero
     *
     * @param  float $x
     */
    public function testIsNotZeroFalse(float $x)
    {
        $this->assertFalse(Support::isNotZero($x));
    }

    public function dataProviderForZero(): array
    {
        return [
            [0],
            [0.0],
            [0.00],
            [0.000000000000000000000000000000],
            [0.000000000000001],
            [0.0000000000000001],
            [0.00000000000000001],
            [0.000000000000000001],
            [0.0000000000000000001],
            [0.00000000000000000001],
            [0.000000000000000000001],
            [0.0000000000000000000001],
            [0.00000000000000000000001],
            [0.000000000000000000000001],
            [-0],
            [-0.0],
            [-0.00],
            [-0.000000000000000000000000000000],
            [-0.000000000000001],
            [-0.0000000000000001],
            [-0.00000000000000001],
            [-0.000000000000000001],
            [-0.0000000000000000001],
            [-0.00000000000000000001],
            [-0.000000000000000000001],
            [-0.0000000000000000000001],
            [-0.00000000000000000000001],
            [-0.000000000000000000000001],
        ];
    }

    public function dataProviderForNotZero(): array
    {
        return [
            [1],
            [1.0],
            [1.00],
            [1.000000000000000000000000000000],
            [0.000000000002],
            [0.00000000001],
            [0.0000000001],
            [0.000000001],
            [0.00000001],
            [0.0000001],
            [-1],
            [-1.0],
            [-1.00],
            [-1.000000000000000000000000000000],
            [-0.000000000002],
            [-0.00000000001],
            [-0.0000000001],
            [-0.000000001],
            [-0.00000001],
            [-0.0000001],
        ];
    }

    /**
     * @test         isEqual returns true for equal values
     * @dataProvider dataProviderForEqualValues
     * @param        int|float $x
     * @param        int|float $y
     */
    public function testIsEqual($x, $y)
    {
        $this->assertTrue(Support::isEqual($x, $y));
    }

    /**
     * @test         isEqual returns false for unequal values
     * @dataProvider dataProviderForUnequalValues
     * @param        int|float $x
     * @param        int|float $y
     */
    public function testIsEqualWhenNotEqual($x, $y)
    {
        $this->assertFalse(Support::isEqual($x, $y));
    }

    /**
     * @test         isMptEqual returns true for unequal values
     * @dataProvider dataProviderForUnequalValues
     * @param        int|float $x
     * @param        int|float $y
     */
    public function testIsNotEqual($x, $y)
    {
        $this->assertTrue(Support::isNotEqual($x, $y));
    }

    /**
     * @test         isMptEqual returns false for equal values
     * @dataProvider dataProviderForEqualValues
     * @param        int|float $x
     * @param        int|float $y
     */
    public function testIsNotEqualWhenEqual($x, $y)
    {
        $this->assertFalse(Support::isNotEqual($x, $y));
    }


    /**
     * @return array
     */
    public function dataProviderForEqualValues(): array
    {
        return [
            [0, 0],
            [1, 1],
            [2, 2],
            [489837, 489837],
            [-1, -1],
            [-2, -2],
            [-489837, -489837],
            [1.1, 1.1],
            [4.86, 4.86],
            [4.4948739874, 4.4948739874],
            [-1.1, -1.1],
            [-4.86, -4.86],
            [-4.4948739874, -4.4948739874],
            [0.01, 0.01],
            [0.001, 0.001],
            [0.0001, 0.0001],
            [0.00001, 0.00001],
            [0.000001, 0.000001],
            [0.0000001, 0.0000001],
            [0.00000001, 0.00000001],
            [0.000000001, 0.000000001],
            [0.0000000001, 0.0000000001],
            [0.00000000001, 0.00000000001],
            [0.000000000001, 0.000000000001],
            [-0.01, -0.01],
            [-0.001, -0.001],
            [-0.0001, -0.0001],
            [-0.00001, -0.00001],
            [-0.000001, -0.000001],
            [-0.0000001, -0.0000001],
            [-0.00000001, -0.00000001],
            [-0.000000001, -0.000000001],
            [-0.0000000001, -0.0000000001],
            [-0.00000000001, -0.00000000001],
            [-0.000000000001, -0.000000000001],
        ];
    }

    /**
     * @return array
     */
    public function dataProviderForUnequalValues(): array
    {
        return [
            [0, 1],
            [1, 2],
            [2, 3],
            [489838, 489837],
            [-1, -2],
            [-2, -3],
            [-489838, -489837],
            [1.1, 1.2],
            [4.86, 4.87],
            [4.4948739876, 4.4948739874],
            [-1.1, -1.2],
            [-4.86, -4.87],
            [-4.4948739873, -4.4948739874],
            [0.01, 0.02],
            [0.001, 0.002],
            [0.0001, 0.0002],
            [0.00001, 0.00002],
            [0.000001, 0.000002],
            [0.0000001, 0.0000002],
            [0.00000001, 0.00000002],
            [0.000000001, 0.000000002],
            [0.0000000001, 0.0000000002],
            [0.00000000001, 0.00000000002],
            [0.000000000001, 0.000000000002],
            [-0.01, -0.02],
            [-0.001, -0.002],
            [-0.0001, -0.0002],
            [-0.00001, -0.00002],
            [-0.000001, -0.000002],
            [-0.0000001, -0.0000002],
            [-0.00000001, -0.00000002],
            [-0.000000001, -0.000000002],
            [-0.0000000001, -0.0000000002],
            [-0.00000000001, -0.00000000002],
            [-0.000000000001, -0.000000000002],
        ];
    }
}
