<?php

namespace Tests\Feature;

use App\Models\Resume;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PublishTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $publish;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $resume = $this->user->resumes()->create; {
            Resume::factory()->make()->toArray();
        };
        $theme = new Theme(['theme' => 'classy']);
        $theme->save();
        $this->publish = $this->user->publishes()->create([
            'resume_id' => $resume_id,
            'theme_id' => $theme_id,
            'visibility' => 'private',
        ]);
        $this->publish->update([
            'url' => route('publishes.show'), $this->publish->id
        ]);
    }

    public function testCannotSeePrivatePublishIfNotLoggenIn(){
        $response = $this->get(route('publishes.show', $this->publish->id));
        $response->assertStatus(302);
    }

    public function testCannotSeePrivatePublishIfDoesntBeelongToUser(){
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('publishes.show', $this->publish->id));
        $response->assertForbidden();
    }

    public function testCanAccessPublicPublish(){
        $this->user()->publishes()->where('id', $this->publish->id)->first()->update([
            'visibility' => 'public',
        ]);
        $response = $this->get(route('publishes.show', $this->publish->id));
        $response->assertOk();
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('publishes.show', $this->publish->id));
    }
}
