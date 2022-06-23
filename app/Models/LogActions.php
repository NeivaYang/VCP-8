<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActions extends Model
{
    use HasFactory;
    protected $table = 'log_actions';
    protected $fillable = ['farm_id', 'user_id', 'uri', 'method', 'item_id', 'action', 'module', 'request_data', 'client_host', 'client_ip', 'client_device_type', 'client_device', 'client_browser', 'client_platform', 'client_version', 'client_agent'];
}