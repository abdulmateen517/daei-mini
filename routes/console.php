<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('activities:send-reminders')->everyMinute();
