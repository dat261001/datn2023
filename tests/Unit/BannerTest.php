<?php

namespace Tests\Unit;

use Tests\TestCase;
// use PHPUnit\Framework\TestCase;
use App\Models\banner;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class BannerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    // protected $banner;

    public function setUp() : void
    {
        parent::setUp();

        $this->faker = Faker::create();
        $this->banner = banner::factory()->create();
    }

    public function tearDown() : void
    {
        parent::tearDown();
    }

    public function test_create()
    {
        $banner = banner::factory()->create();
        $this->assertInstanceOf(banner::class, $this->banner);

        // Kiểm tra xem cơ sở dữ liệu đã được cập nhập hay chưa
        $this->assertDatabaseHas('banners', $this->banner->toArray());
        $this->assertTrue(true);
    }

    public function test_destroy()
    {
        // kiểm tra xem dữ liệu đã được xóa trong cơ sở dữ liệu hay chưa
        $check = $this->banner->latest('id')->first()->delete();
        // $this->assertDatabaseMissing('banners', $this->banner->toArray());
        $this->assertTrue($check);
    }
}
