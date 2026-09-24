<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmissionSetting;
use App\Models\AuditLog;
use App\Models\Institution;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdmissionController extends Controller
{
    public function index(Request $request): View
    {
        $tab = $request->query('tab', 'smp');
        $institutions = Institution::whereIn('type', ['smp', 'sma'])->get()->keyBy('type');
        $currentInstitution = $institutions->get($tab) ?? $institutions->first();

        $admission = $currentInstitution ? AdmissionSetting::where('institution_id', $currentInstitution->id)->first() : null;

        return view('admin.admission.index', compact('institutions', 'currentInstitution', 'admission', 'tab'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'institution_id' => ['required', 'exists:institutions,id'],
            'is_open' => ['nullable', 'boolean'],
            'requirements' => ['nullable', 'string'],
            'required_documents' => ['nullable', 'string'],
            'schedule_information' => ['nullable', 'string'],
            'additional_information' => ['nullable', 'string'],
            'whatsapp_template' => ['nullable', 'string'],
            'steps' => ['nullable', 'array'],
        ]);

        $steps = [];
        if ($request->has('steps') && is_array($request->steps)) {
            foreach ($request->steps as $step) {
                if (!empty(trim($step['title'] ?? ''))) {
                    $steps[] = [
                        'title' => trim($step['title']),
                        'description' => trim($step['description'] ?? ''),
                        'icon' => trim($step['icon'] ?? 'document'),
                    ];
                }
            }
        }

        $admission = AdmissionSetting::updateOrCreate(
            ['institution_id' => $request->institution_id],
            [
                'is_open' => $request->boolean('is_open'),
                'requirements' => $request->requirements,
                'required_documents' => $request->required_documents,
                'schedule_information' => $request->schedule_information,
                'additional_information' => $request->additional_information,
                'whatsapp_template' => $request->whatsapp_template,
                'steps' => $steps,
            ]
        );

        $institution = Institution::find($request->institution_id);
        $statusText = $admission->is_open ? 'DIBUKA' : 'DITUTUP';

        AuditLog::log('update', 'admission_setting', $admission->id, "Memperbarui setelan pendaftaran {$institution?->name} (Status: {$statusText}).");

        return back()->with('success', "Pengaturan pendaftaran {$institution?->name} berhasil diperbarui (Status: {$statusText}).");
    }
}
