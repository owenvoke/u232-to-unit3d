<?php

namespace pxgamer\U232ToUnit3d\Tests\Functionality;

use Carbon\Carbon;
use Orchestra\Testbench\TestCase;
use pxgamer\U232ToUnit3d\Functionality\Mapping;

class MappingTest extends TestCase
{
    private const TEST_DATE_STRING = '2017/10/15 06:06:06';
    private const TEST_STRING = 'SpaghettiTest';
    private const TEST_HASH = 'f87b9feb33b6744f0bd1cb53b6fc1f23';

    /** @test */
    public function itCanMapAUserInstance(): void
    {
        $data = new \stdClass();
        $data->username = self::TEST_STRING;
        $data->passhash = null;
        $data->torrent_pass = null;
        $data->class = 1;
        $data->email = null;
        $data->uploaded = 0;
        $data->downloaded = 0;
        $data->title = null;
        $data->avatar = null;
        $data->added = self::TEST_DATE_STRING;

        $result = Mapping::map('User', $data);

        $this->assertIsArray($result);
        $this->assertEquals(self::TEST_STRING, $result['username']);
        $this->assertNull($result['password']);
        $this->assertEquals(0, $result['uploaded']);
        $this->assertEquals(0, $result['downloaded']);
        $this->assertInstanceOf(Carbon::class, $result['created_at']);
    }

    /** @test */
    public function itCanMapATorrentInstance(): void
    {
        $data = new \stdClass();
        $data->info_hash = self::TEST_HASH;
        $data->name = self::TEST_STRING;
        $data->size = 0;
        $data->descr = null;
        $data->seeders = 0;
        $data->leechers = 0;
        $data->numfiles = 0;
        $data->added = self::TEST_DATE_STRING;

        $result = Mapping::map('Torrent', $data);

        $this->assertIsArray($result);
        $this->assertEquals(self::TEST_HASH, $result['info_hash']);
        $this->assertEquals(0, $result['size']);
        $this->assertInstanceOf(Carbon::class, $result['created_at']);
    }
}
