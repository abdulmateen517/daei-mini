<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class DailyReportFeedback extends Model
{
    protected $fillable = ['daily_report_id', 'admin_id', 'comment', 'suggestions'];
    public function admin() { return $this->belongsTo(User::class, 'admin_id'); }
    public function report() { return $this->belongsTo(DailyReport::class); }
}
