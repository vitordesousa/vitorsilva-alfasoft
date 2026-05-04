<?php

namespace Tests\Unit;

use App\Helpers\Strings;
use PHPUnit\Framework\TestCase;

class StringsTest extends TestCase
{
    public function test_only_numbers_removes_all_non_digit_characters(): void
    {
        $this->assertEquals('12345678900', Strings::onlyNumbers('123.456.789-00'));
        $this->assertEquals('1234567890', Strings::onlyNumbers('(12) 3456-7890'));
        $this->assertEquals('123', Strings::onlyNumbers('abc123def'));
    }

    public function test_only_numbers_returns_empty_string_for_null(): void
    {
        $this->assertEquals('', Strings::onlyNumbers(null));
    }

    public function test_only_numbers_returns_empty_string_for_no_digits(): void
    {
        $this->assertEquals('', Strings::onlyNumbers('abc-def'));
    }
}
