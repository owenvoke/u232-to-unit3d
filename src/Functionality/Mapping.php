<?php

namespace pxgamer\U232ToUnit3d\Functionality;

use Carbon\Carbon;

/**
 * Class Mapping.
 */
class Mapping
{
    /**
     * @param string $type
     * @param \stdClass $data
     * @return array
     */
    public static function map(string $type, \stdClass $data): array
    {
        return self::{'map'.$type}($data);
    }

    /**
     * @param \stdClass $data
     * @return array
     */
    public static function mapUser(\stdClass $data): array
    {
        return [
            'username'   => $data->username,
            'password'   => $data->passhash ?? null,
            'passkey'    => $data->torrent_pass ?? null,
            'group_id'   => $data->class ?? 1,
            'email'      => $data->email ?? null,
            'uploaded'   => $data->uploaded ?? 0,
            'downloaded' => $data->downloaded ?? 0,
            'title'      => $data->title ?? null,
            'image'      => $data->avatar ?? null,
            'created_at' => Carbon::createFromTimestamp(strtotime($data->added)),
        ];
    }

    /**
     * @param \stdClass $data
     * @return array
     */
    public static function mapTorrent(\stdClass $data): array
    {
        return [
            'info_hash'   => $data->info_hash,
            'name'        => $data->name ?? null,
            'size'        => $data->size ?? 0,
            'description' => $data->descr ?? null,
            'seeders'     => $data->seeders ?? 0,
            'leechers'    => $data->leechers ?? 0,
            'num_files'   => $data->numfiles ?? 0,
            'created_at'  => Carbon::createFromTimestamp(strtotime($data->added)),
        ];
    }
}
