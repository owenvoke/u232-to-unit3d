<?php

namespace pxgamer\U232ToUnit3d\Functionality;

use Carbon\Carbon;
use stdClass;

class Mapping
{
    /**
     * @param  string  $type
     * @param  stdClass  $data
     * @return array
     */
    public static function map(string $type, stdClass $data): array
    {
        return self::{'map'.$type}($data);
    }

    /**
     * @param  stdClass  $data
     * @return array
     */
    public static function mapUser(stdClass $data): array
    {
        return [
            'username' => $data->username,
            'password' => $data->passhash ?? null,
            'passkey' => $data->torrent_pass ?? md5(uniqid().time().microtime()),
            'rsskey' => md5(uniqid().time().microtime().$data->passhash),
            'group_id' => 3, // Default Member Group
            'email' => $data->email ?? null,
            'uploaded' => $data->uploaded ?? 0,
            'downloaded' => $data->downloaded ?? 0,
            'seedbonus' => str_replace('-', '', $data->seedbonus) ?? 0,
            'image' => $data->avatar ?? null,
            'title' => $data->title ?? null,
            'about' => $data->about ?? null,
            'signature' => $data->signature ?? null,
            'active' => 1,
            'invites' => $data->invites ?? 0,
            'last_login' => Carbon::now(),
            'created_at' => date('Y/m/d H:i:s', $data->added),
            'updated_at' => Carbon::now(),
        ];
    }

    /**
     * @param  stdClass  $data
     * @return array
     */
    public static function mapTorrent(stdClass $data): array
    {
        return [
            'info_hash' => $data->info_hash,
            'name' => $data->name ?? null,
            'size' => $data->size ?? 0,
            'description' => $data->descr ?? null,
            'seeders' => $data->seeders ?? 0,
            'leechers' => $data->leechers ?? 0,
            'num_files' => $data->numfiles ?? 0,
            'created_at' => date('Y/m/d H:i:s', $data->added),
        ];
    }
}
