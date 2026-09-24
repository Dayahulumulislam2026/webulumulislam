<?php

namespace App\Http\Controllers;

use App\Models\AdmissionSetting;
use App\Models\Institution;
use App\Models\SiteSetting;
use Illuminate\View\View;

class AdmissionController extends Controller
{
    public function index(): View
    {
        $smp = Institution::where('type', 'smp')->first();
        $sma = Institution::where('type', 'sma')->first();

        $smpAdmission = $smp ? AdmissionSetting::where('institution_id', $smp->id)->first() : null;
        $smaAdmission = $sma ? AdmissionSetting::where('institution_id', $sma->id)->first() : null;

        $smpTemplate = $smpAdmission?->whatsapp_template ?: SiteSetting::get('whatsapp_template_smp', 'Assalamualaikum. Nama: [Nama], Asal: [Asal]. Saya ingin bertanya mengenai pendaftaran SMP Ulumul Islam.');
        $smaTemplate = $smaAdmission?->whatsapp_template ?: SiteSetting::get('whatsapp_template_sma', 'Assalamualaikum. Nama: [Nama], Asal: [Asal]. Saya ingin bertanya mengenai pendaftaran SMA Ulumul Islam.');

        $smpWaLink = generate_whatsapp_link($smp?->whatsapp, $smpTemplate);
        $smaWaLink = generate_whatsapp_link($sma?->whatsapp, $smaTemplate);

        return view('admission', compact(
            'smp',
            'sma',
            'smpAdmission',
            'smaAdmission',
            'smpWaLink',
            'smaWaLink'
        ));
    }
}
