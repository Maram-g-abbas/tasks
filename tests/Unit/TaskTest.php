<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Task;
class TaskTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $task = Task::factory()->make();

         $this->assertInstanceOf(Task::class, $task);
        $this->assertTrue(true);
    }

}
