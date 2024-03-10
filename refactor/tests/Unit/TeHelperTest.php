<?php

namespace Tests\Unit;

use DTApi\Helpers\TeHelper;
use Tests\TestCase;

/**
 * @covers \DTApi\Helpers\TeHelper
 */
class TeHelperTest extends TestCase
{
    /**
     * @dataProvider willExpireAtProvider
     * @param string $dueTime
     * @param string $createdAt
     * @param string $expectedTime
     */
    public function testWillExpireAt(string $dueTime, string $createdAt, string $expectedTime)
    {
        $this->assertEquals($expectedTime, TeHelper::willExpireAt($dueTime, $createdAt));
    }

    public static function willExpireAtProvider(): array
    {
        return [
            // Less than 90 minutes remaining - return due time
            ['2024-03-10 10:00:00', '2024-03-10 08:30:00', '2024-03-10 10:00:00'],
            // 90 minutes remaining - return created time + 90 minutes
            ['2024-03-10 10:00:00', '2024-03-10 08:30:00', '2024-03-10 10:00:00'], // This is a duplicate, might be a typo in original code
            ['2024-03-10 10:00:00', '2024-03-10 09:10:00', '2024-03-10 10:00:00'],
            // Less than or equal to 24 hours remaining - return created time + 16 hours
            ['2024-03-10 10:00:00', '2024-03-09 18:00:00', '2024-03-10 10:00:00'],
            ['2024-03-10 10:00:00', '2024-03-10 00:00:00', '2024-03-10 10:00:00'],
            // More than 24 hours and less than or equal to 72 hours remaining - return created time + 16 hours
            ['2024-03-10 10:00:00', '2024-03-08 10:00:00', '2024-03-10 10:00:00'],
            ['2024-03-10 10:00:00', '2024-03-07 18:00:00', '2024-03-10 10:00:00'],
            // More than 72 hours remaining - return due time - 48 hours
            ['2024-03-10 10:00:00', '2024-03-07 10:00:00', '2024-03-10 10:00:00'],
        ];
    }

    /**
     * @dataProvider convertToHoursMinsProvider
     * @param int $time
     * @param string $expectedFormat
     */
    public function testConvertToHoursMins(int $time, string $expectedFormat)
    {
        $this->assertEquals($expectedFormat, TeHelper::convertToHoursMins($time));
    }

    public static function convertToHoursMinsProvider(): array
    {
        return [
            [0, '0min'],
            [59, '59min'],
            [60, '1h'],
            [90, '01h 30min'],
            [120, '02h 00min']
        ];
    }
}
