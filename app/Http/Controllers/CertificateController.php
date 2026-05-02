<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\UserProgress;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function generate(Course $course)
    {
        if (!$course) {
            abort(404, 'Curso no encontrado');
        }

        $user = auth()->user();

        // Verify course is 100% complete
        $totalLessons = $course->lessons()->count();

        if ($totalLessons === 0) {
            return back()->with('error', 
                'Este curso no tiene lecciones todavía.');
        }

        $completedLessons = UserProgress::where('user_id', $user->id)
            ->whereIn('lesson_id', 
                $course->lessons()->pluck('id'))
            ->count();

        $percent = round(($completedLessons / $totalLessons) * 100);

        if ($percent < 100) {
            return back()->with('error', 
                'Debes completar el 100% del curso para obtener el certificado. '
                . 'Llevas un ' . $percent . '%.');
        }

        // Get completion date
        $completionDate = UserProgress::where('user_id', $user->id)
            ->whereIn('lesson_id', $course->lessons()->pluck('id'))
            ->orderBy('completed_at', 'desc')
            ->first()
            ->completed_at;

        $data = [
            'user'           => $user,
            'course'         => $course,
            'completionDate' => $completionDate,
            'totalLessons'   => $totalLessons,
            'totalXP'        => $course->lessons()->sum('xp_reward'),
        ];

        $pdf = Pdf::loadView('certificates.template', $data);
        
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOptions([
            'defaultFont' => 'DejaVu Sans',
            'isRemoteEnabled' => false,
            'logOutputFile' => storage_path('logs/dompdf.log.html'),
            'tempDir' => storage_path('app/public'),
        ]);

        $filename = 'certificado-'
            . \Str::slug($course->title) . '-'
            . \Str::slug($user->name) . '.pdf';

        return $pdf->download($filename);
    }
}
