<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\StoreSearchRequest;
use App\Models\ImageReview;
use App\Models\ReportedReview;
use App\Models\Review;
use App\Models\ReviewWelfare;
use App\Models\UserFavorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $review = Review::query()->orderBy('id', 'desc')->paginate(10);
        return view('user.index', compact('review'));
    }

    public function search(StoreSearchRequest $request)
    {
        $validated = $request->validated();
        $company_name = $validated['company_name'] ?? null;

        $review = Review::query()
            ->with(['ReportReview', 'ReviewWelfare'])
            ->when($company_name, function ($q) use ($company_name) {
                // ใช้ LIKE และใส่ % ปิดหน้า-หลัง เพื่อหาคำที่ประกอบด้วยคำนั้นๆ
                $q->where('company_name', 'LIKE', '%' . $company_name . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();
        //กลับหน้าหลัก
        return view('user.index', compact('review'));
    }

    public function filter(StoreSearchRequest $request)
    {
        $validated = $request->validated();
        $type = $validated['type'] ?? null;
        $submarjor = $validated['submajor'] ?? null;
        $province = $validated['province'] ?? null;
        $year = $validated['year'] ?? null;
        $score = $validated['score'] ?? null;
        $welfare = $validated['welfare'] ?? null;

        $review = Review::query()->with(['ReportReview', 'ReviewWelfare'])
            ->when($type, fn($q) => $q->where('type', $type))
            ->when($submarjor, fn($q) => $q->where('submajor', $submarjor))
            ->when($province, fn($q) => $q->where('province', $province))
            ->when($year, fn($q) => $q->where('created_at', $year))
            ->when($score, fn($q) => $q->where('score', $score))
            ->when($welfare, fn($q) => $q->whereHas('ReviewWelfare', function ($query) use ($welfare) {
                $query->where('welfare', $welfare);
            }))
            ->orderBy('id', 'desc')->paginate(10)->withQueryString();
        return view('user.index', compact('review'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {
        $validated = $request->validated();
        Review::create([
            'company_name' => $validated['company_name'],
            'comment' => $validated['comment'],
            'task' => $validated['task'],
            'province' => $validated['province'],
            'selection' => $validated['selection'],
            'score' => $validated['score'],
            'type' => $validated['type'],
            'user_id' => Auth::user()->id,
            'submajor' => $validated['submajor']
        ]);

        // (ข้อควรระวัง: ดูหมายเหตุเรื่อง last_review ด้านล่างด้วยนะครับ)
        $last_review = Review::query()->where('user_id', Auth::user()->id)->latest()->first();
        if ($request->hasFile('img')) {

            foreach ($request->file('img') as $key => $image) {
                $img_name = time() . '-' . $key . '.' . $image->extension();

                $image->move(public_path('image'), $img_name);

                ImageReview::create([
                    'review_id' => $last_review->id,
                    'img_name' => $img_name
                ]);
            }
        }

        if (!empty($validated['welfare'])) {
            foreach ($validated['welfare'] as $item) {
                if ($item != 'ไม่มี') {
                    ReviewWelfare::create([
                        'review_id' => $last_review->id,
                        'welfare' => $item
                    ]);
                }
            }
        }

        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $review = Review::find($id);
        $images = ImageReview::query()->where('review_id', $review->id)->get();
        return view('user.show', compact('review', 'images'));
    }

    public function myreview()
    {
        $user_id = Auth::user()->id;
        $review = Review::query()->where('user_id', $user_id)->orderBy('id', 'desc')->paginate(10);
        return view('user.myreview', compact('review'));
    }

    public function myfavor($id)
    {
        $user_id = Auth::user()->id;
        $favorite = UserFavorite::where('user_id', $user_id)
            ->where('review_id', $id)
            ->first();

        if ($favorite) {

            $favorite->delete();
            $message = 'Removed from favorites successfully';
        } else {
            UserFavorite::create([
                'user_id' => $user_id,
                'review_id' => $id,
            ]);
            $message = 'Added to favorites successfully';
        }
        return redirect()->back()->with('success', $message);
    }

    public function favorite_page()
    {
        $user_id = Auth::user()->id;
        $review = Review::query()->whereHas('UserFavorite', function ($q) use ($user_id) {
            $q->where('user_id', $user_id);
        })->paginate(10);

        return view('user.myfavor', compact('review'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $review = Review::query()->find($id);
        $img = ImageReview::query()->where('review_id', $id);
        $reviewWelfare = ReviewWelfare::where('review_id', $id)->pluck('welfare');

        // ถ้าว่าง ให้ใส่ ['ไม่มี'] ถ้าไม่ว่าง ให้แปลงเป็น array
        $reviewWelfare = $reviewWelfare->isEmpty() ? ['ไม่มี'] : $reviewWelfare->toArray();
        return view('user.edit', compact('review', 'id', 'img', 'reviewWelfare'));
    }

    public function report($id, StoreReportRequest $request)
    {
        if (ReportedReview::where('user_id', Auth::user()->id)->where('review_id', $id)->exists()) {
            return redirect()->back()->withErrors('review_id', 'You have been reported this review aleardy');
        }
        $validated = $request->validated();
        ReportedReview::create([
            'review_id' => $id,
            'user_id' => Auth::user()->id,
            'report_topic' => $validated['report_topic'],
            'report_content' => $validated['report_content']
        ]);

        $message = 'Report successful';
        return redirect()->back()->with('success', $message);
    }
    public function delete_report($id)
    {
        $report = ReportedReview::find($id);
        $report->delete();
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(StoreReviewRequest $request, $id)
    {
        $review = Review::find($id);
        $validated = $request->validated();

        $review->update([
            'company_name' => $validated['company_name'],
            'comment' => $validated['comment'],
            'task' => $validated['task'],
            'province' => $validated['province'],
            'selection' => $validated['selection'],
            'score' => $validated['score'],
            'type' => $validated['type'],
            'submajor' => $validated['submajor'],
        ]);

        if (!empty($validated['delete_images'])) {
            // ดึงข้อมูลรูปภาพที่ต้องการลบ เพื่อเอาชื่อไฟล์มาลบออกจาก Disk
            $imagesToDelete = ImageReview::whereIn('id', $validated['delete_images'])->get();

            foreach ($imagesToDelete as $delImage) {
                // ลบไฟล์จากโฟลเดอร์ public/image
                $filePath = public_path('image/' . $delImage->img_name);

                if (File::exists($filePath)) {
                    File::delete($filePath);
                }

                // ลบ Record ออกจาก Database
                $delImage->delete();
            }
        }
        if ($request->hasFile('img')) {
            foreach ($request->file('img') as $key => $image) {
                // ตั้งชื่อไฟล์ (เพิ่ม uniqid เพื่อป้องกันชื่อซ้ำหากอัปโหลดพร้อมกันหลายคน)
                $img_name = time() . '-' . $key . '-' . uniqid() . '.' . $image->extension();

                // ย้ายไฟล์ไปที่ public/image
                $image->move(public_path('image'), $img_name);

                // บันทึกลง Database
                ImageReview::create([
                    // ใช้ ID ของ Report ปัจจุบัน (ระวังเรื่องชื่อ FK ให้ตรงกับ DB จริงของคุณ)
                    'review_id' => $id,
                    'img_name' => $img_name
                ]);
            }
        }

        // 1. ล้างข้อมูลเก่าทิ้งเสมอ (Safe & Clean)
        ReviewWelfare::where('review_id', $id)->delete();

        // 2. วนลูปบันทึกใหม่ (ถ้ามีข้อมูลส่งมา)
        if (!empty($validated['welfare'])) {
            foreach ($validated['welfare'] as $item) {
                // กรองคำว่า 'ไม่มี' ไม่ให้บันทึกลง DB
                if ($item !== 'ไม่มี') {
                    ReviewWelfare::create([
                        'review_id' => $id,
                        'welfare' => $item
                    ]);
                }
            }
        }
        return redirect()->route('user.myreview');
    } 

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $review = Review::find($id);
        $review->delete();
    }
}
