<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\DailyReport;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\JsonResponse;
class AdminDashboardController extends Controller
{
    public function index(): JsonResponse { return response()->json(['stats'=>['users'=>User::count(),'groups'=>Group::count(),'reports_today'=>DailyReport::whereDate('report_date',today())->count(),'pending_reviews'=>DailyReport::where('review_status','pending')->count()],'recent_users'=>User::latest()->limit(6)->get(['id','name','email','status','created_at']),'recent_reports'=>DailyReport::with('user:id,name,email')->latest('report_date')->limit(6)->get()]); }
    public function users(): JsonResponse { return response()->json(User::select(['id','name','email','status','created_at'])->withCount('groups')->orderBy('name')->paginate(20)); }
    public function user(User $user): JsonResponse { $user->load('groups:id,name'); $user->activity_summary=DailyReport::where('user_id',$user->id)->selectRaw('COUNT(*) as reports, AVG(completed_activities * 100.0 / NULLIF(total_activities, 0)) as average_completion, AVG(rating) as average_rating')->first(); $user->recent_reports=$user->dailyReports()->latest('report_date')->limit(8)->get(); return response()->json($user->only(['id','name','email','status','created_at','groups','activity_summary','recent_reports'])); }
    public function groups(): JsonResponse { return response()->json(Group::with('members:id,name,email')->withCount('members')->orderBy('name')->paginate(20)); }
    public function group(Group $group): JsonResponse { return response()->json($group->load('members:id,name,email')->loadCount('members')); }
}
