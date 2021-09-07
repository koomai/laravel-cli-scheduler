<?php

namespace Koomai\CliScheduler;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledTask extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'environments' => 'array',
        'without_overlapping' => 'boolean',
        'on_one_server' => 'boolean',
        'run_in_background' => 'boolean',
        'even_in_maintenance_mode' => 'boolean',
        'append_output' => 'boolean',
    ];

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('scheduler.table');
    }

    /**
     * @param $value
     */
    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = ucfirst(strtolower($value));
    }
}
