<?php
/**
 * Created by PhpStorm.
 * User: Binge
 * Date: 2018-10-28
 * Time: 17:32
 */

namespace App\Repositories;


use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    public function insertUserInfo($data)
    {
        User::where(['openid' => $data['openid']])
            ->update([
                'name' => $data['nickname'],
                'email' => $data['openid'],
                'remember_token' => $data['remember_token'] ?? '',
                'created_at' => Carbon::now(),
                'oauth_type' => 'qq',
                'avatar' => $data['figureurl_qq_2']
            ]);
        $id = User::where(['openid' => $data['openid']])
            ->first(['id'])->id;

        if (isset($data['openid'])) {
            DB::table('qq_users')->updateOrInsert([
                'user_id' => $id,
            ], [
                'user_id' => $id,
                'nickname' => $data['nickname'],
                'gender' => $data['gender'],
                'province' => $data['province'],
                'city' => $data['city'],
                'year' => $data['year'],
                'is_yellow_vip' => $data['is_yellow_vip'],
                'vip' => $data['vip'],
                'yellow_vip_level' => $data['yellow_vip_level'],
                'level' => $data['level'],
                'is_yellow_year_vip' => $data['is_yellow_year_vip']
            ]);
        }

        return $id;
    }
}
