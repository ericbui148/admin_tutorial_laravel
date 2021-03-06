<?php

namespace ThaoHR\Tests\Feature\Api\Activity;

use Carbon\Carbon;
use Tests\Feature\ApiTestCase;
use ThaoHR\User;
use ThaoHR\Activity;
use ThaoHR\Repositories\Activity\ActivityRepository;

class StatsTest extends ApiTestCase
{
    /** @test */
    public function non_admin_users_cannot_get_user_stats()
    {
        $user = factory(User::class)->create();

        Carbon::setTestNow(Carbon::now()->subWeek());
        factory(Activity::class)->times(5)->create(['user_id' => $user->id]);

        Carbon::setTestNow(null);
        factory(Activity::class)->times(5)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'api')->getJson("/api/stats/activity");

        $expected = app(ActivityRepository::class)->userActivityForPeriod(
            $user->id,
            Carbon::now()->subWeek(2),
            Carbon::now()
        )->toArray();

        $response->assertOk()
            ->assertJson($expected);
    }
}
