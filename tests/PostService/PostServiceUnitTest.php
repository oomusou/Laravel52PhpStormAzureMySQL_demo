<?php

declare(strict_types = 1);

use App\Post;
use App\Repositories\PostRepository;
use App\Services\PostService;
use Illuminate\Database\Eloquent\Collection;
use Mockery\Mock;

class PostServiceUnitTest extends TestCase
{
    /** @test */
    public function 回傳全部3筆文章()
    {
        /** arrange */
        $posts = factory(Post::class, 3)->make();
        /** @var Mock $mock */
        $mock = Mockery::mock(PostRepository::class);
        App::instance(PostRepository::class, $mock);
        $mock->shouldReceive('getAllPosts')
            ->once()
            ->withAnyArgs()
            ->andReturn($posts);

        /** @var PostService $target */
        $target = App::make(PostService::class);

        /** act */
        $actual = $target->showAllPosts()
            ->pick(['title', 'description', 'content'])
            ->all();

        /** assert */
        $expected = [
            ['title1', 'description1', 'content1'],
            ['title2', 'description2', 'content2'],
            ['title3', 'description3', 'content3'],
        ];
        $this->assertEquals($expected, $actual);
    }

    /** @test */
    public function 當id為1時應回傳title1()
    {
        /** arrange */
        /** @var Mock $mock */
        $mock = Mockery::mock(PostRepository::class);
        App::instance(PostRepository::class, $mock);
        $mock->shouldReceive('getTitle')
            ->once()
            ->withAnyArgs()
            ->andReturn('title1');

        /** @var PostService $target */
        $target = App::make(PostService::class);

        /** act */
        $id = 1;
        $default = 'title1';
        $actual = $target->showTitle($id, $default);

        /** assert */
        $expected = 'title1';
        $this->assertEquals($expected, $actual);
    }

    /** @test */
    public function 當id為4時應回傳no_title()
    {
        /** arrange */
        /** @var Mock $mock */
        $mock = Mockery::mock(PostRepository::class);
        App::instance(PostRepository::class, $mock);
        $mock->shouldReceive('getTitle')
            ->once()
            ->withAnyArgs()
            ->andReturn('no title');

        /** @var PostService $target */
        $target = App::make(PostService::class);

        /** act */
        $id = 4;
        $default = 'no title';
        $actual = $target->showTitle($id, $default);

        /** assert */
        $expected = 'no title';
        $this->assertEquals($expected, $actual);
    }

    /** @test */
    public function 由Array回傳3筆titles()
    {
        /** arrange */
        $posts = factory(Post::class, 3)->make();
        /** @var Mock $mock */
        $mock = Mockery::mock(PostRepository::class);
        App::instance(PostRepository::class, $mock);
        $mock->shouldReceive('getAllPosts')
            ->once()
            ->withAnyArgs()
            ->andReturn($posts);

        /** @var PostService $target */
        $target = App::make(PostService::class);

        /** act */
        $actual = $target->showTitlesOfAllPostsByArray();

        /** assert */
        $expected = [
            'title1',
            'title2',
            'title3'
        ];
        $this->assertEquals($expected, $actual);
    }

    /** @test */
    public function 由Collection回傳全部3筆titles()
    {
        /** arrange */
        $posts = factory(Post::class, 3)->make();
        /** @var Mock $mock */
        $mock = Mockery::mock(PostRepository::class);
        App::instance(PostRepository::class, $mock);
        $mock->shouldReceive('getAllPosts')
            ->once()
            ->withAnyArgs()
            ->andReturn($posts);

        /** @var PostService $target */
        $target = App::make(PostService::class);

        /** act */
        $actual = $target->showTitlesOfAllPostsByCollection();

        /** assert */
        $expected = new Collection([
            'title1',
            'title2',
            'title3'
        ]);
        $this->assertEquals($expected, $actual);
    }
}
