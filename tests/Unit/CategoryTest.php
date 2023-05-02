<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryTest extends TestCase
{
    protected $category;

    public function setUp() : void
    {
        parent::setUp();

        $this->faker = Faker::create();
        $this->category = category::factory()->create();
    }

    public function tearDown() : void
    {
        parent::tearDown();
    }

    public function test_create()
    {
        // $category = category::factory()->create();
        $this->assertInstanceOf(category::class, $this->category);

        // Kiểm tra xem cơ sở dữ liệu đã được cập nhập hay chưa
        $this->assertDatabaseHas('categories', $this->category->toArray());
        $this->assertTrue(true);
    }

    public function test_destroy()
    {
        // kiểm tra xem dữ liệu đã được xóa trong cơ sở dữ liệu hay chưa
        $check = $this->category->latest('id')->first()->delete();
        // $this->assertDatabaseMissing('categories', $this->category->toArray());
        $this->assertTrue($check);
    }
    // vendor\bin\phpunit
}
