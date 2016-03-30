<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RecommendationInteractionsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->jane = factory(App\User::class)->create();
        $this->john = factory(App\User::class)->create();
        $this->blog = factory(App\Blog::class)->create();
    }

    public function test_that_jane_can_recommend_a_blog_to_john()
    {
        $recommendation = $this->jane->recommend($this->blog, $this->john);
        $this->assertModelExists($recommendation);
        $this->assertModelEquals(
            ['by_id' => $this->john->id, 'to_id' => $this->john->id, 'blog_id' => $this->blog->id],
            $recommendation
        );
    }

    public function test_that_john_can_accept_a_recommendation()
    {
        $recommendation = factory(\App\Recommendation::class)->make([
            'by_id' => $this->jane->id,
            'to_id' => $this->john->id,
            'blog_id' => $this->blog->id,
        ]);
        $recommendation->save();

        $this->assertFalse($recommendation->accepted);
        $recommendation->accept();

        $this->assertTrue($recommendation->accepted);
        $this->assertNotNull($recommendation->subscription);
        $this->assertTrue($recommendation->subscription->exists);
        $this->assertEquals($recommendation->subscription->user->id, $this->john->id);
        $this->assertEquals($recommendation->subscription->blog->id, $this->blog->id);
    }
}
