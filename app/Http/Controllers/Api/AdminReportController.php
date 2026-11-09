<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\DailyReport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class AdminReportController extends Controller
{
    public function index(Request $request): JsonResponse { $f=$request->validate(['user_id'=>['sometimes','integer','exists:users,id'],'date'=>['sometimes','date_format:Y-m-d'],'status'=>['sometimes',Rule::in(['pending','reviewed'])]]); return response()->json(DailyReport::with('user:id,name,email')->when(isset($f['user_id']),fn($q)=>$q->where('user_id',$f['user_id']))->when(isset($f['date']),fn($q)=>$q->whereDate('report_date',$f['date']))->when(isset($f['status']),fn($q)=>$q->where('review_status',$f['status']))->latest('report_date')->paginate(20)); }
    public function show(DailyReport $report): JsonResponse { return response()->json(['data'=>$report->load('user:id,name,email','feedback')]); }
    public function feedback(Request $request, DailyReport $report): JsonResponse { $data=$request->validate(['comment'=>['required','string','max:5000'],'suggestions'=>['nullable','string','max:5000']]); $entry=$report->feedback()->create(['admin_id'=>$request->user()->id,...$data]); $report->update(['review_status'=>'reviewed']); return response()->json(['data'=>$entry->load('admin:id,name')],201); }
    public function status(Request $request, DailyReport $report): JsonResponse { $data=$request->validate(['status'=>['required',Rule::in(['pending','reviewed'])]]); $report->update(['review_status'=>$data['status']]); return response()->json(['data'=>$report->fresh()]); }
}
