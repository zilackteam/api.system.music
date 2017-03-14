<?php

namespace App\Models;
use Carbon\Carbon;

/**
 * App\Models\UserVip
 *
 * @property integer $id
 * @property integer $singer_id
 * @property integer $user_id
 * @property boolean $status
 * @property string $active_date
 * @property integer $balance
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class UserVip extends VeoModel {

    protected $table = 'user_vips';

    protected $guarded = [];

    protected $hidden = [];

    const STATUS_NORMAL = 0;
    const STATUS_VIP = 1;

    const BALANCE_VIP = 10000; //VND

    const ACTIVE_PERIOD = 30; //Day


    public static function rules($key = 'create') {
        $common = [
        ];
        $rules = [
            'create' => array_merge($common, [
            ]),
            'update' => array_merge($common, [
            ])
        ];
        return array_get($rules, $key);
    }

    public function isVip() {
        $expiredAt = Carbon::createFromFormat('Y-m-d H:i:s', $this->active_date)->addDay(self::ACTIVE_PERIOD);
        $now = Carbon::now();
        if ($this->status != self::STATUS_VIP ||
            !$this->active_date ||
            $expiredAt->lt($now)
        ) {
            return false;
        }
        return true;
    }

    public function chargeVip() {
        if ($this->balance < self::BALANCE_VIP) {
            return false;
        }

        $this->status       = self::STATUS_VIP;
        $this->active_date  = Carbon::now();
        $this->balance      = $this->balance - self::BALANCE_VIP;
        return $this->save();
    }

}
