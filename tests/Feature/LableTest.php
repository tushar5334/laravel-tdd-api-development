<?php

namespace Tests\Feature;

use App\Models\Lable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LableTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->user = $this->authUser();
    }
    public function test_user_can_create_new_lable()
    {
        $lable = Lable::factory()->raw();
        $this->postJson(route('lable.store'), ['title' => $lable['title'], 'color' => $lable['color']])->assertCreated();
        $this->assertDatabaseHas('lables', ['title' => $lable['title'], 'color' => $lable['color']]);
    }

    public function test_user_can_delete_lable()
    {
        $lable = $this->createLable();
        $this->deleteJson(route('lable.destroy', $lable->id))->assertNoContent();
        $this->assertDatabaseMissing('lables', ['title' => $lable->title]);
    }

    public function test_user_can_update_lable()
    {
        $lable = $this->createLable();
        $this->patchJson(route('lable.update', $lable->id), ['title' => $lable->title, 'color' => 'update-color'])->assertOk();
        $this->assertDatabaseHas('lables', ['color' => 'update-color']);
    }

    public function test_fetch_all_label_for_a_user()
    {
        $lable = $this->createLable(['user_id' => $this->user->id]);
        $this->createLable();
        $response = $this->getJson(route('lable.index'))->assertOk()->json('data');
        $this->assertEquals($response[0]['title'], $lable->title);
    }
}
