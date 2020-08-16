<?php

namespace Infinitypaul\LaravelUptime;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Status extends Model
{
    protected $table;

    protected $fillable = ['status_code'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = Config::get('uptime.statuses_table');
    }

    public function isUp()
    {
        return substr((string) $this->status_code, 0, 1) === '2';
    }

    public function isDown()
    {
        return ! $this->isUp();
    }
}
