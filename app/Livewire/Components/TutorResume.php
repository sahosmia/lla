<?php

namespace App\Livewire\Components;

use App\Services\CertificateService;
use App\Services\EducationService;
use App\Services\ExperienceService;
use Livewire\Component;
use Illuminate\Http\Request;

class TutorResume extends Component
{

    protected $educationService;
    protected $experiencesService;
    protected $certificateService;

    public $employmentTypes = [
        'full_time'     => 'Full Time',
        'part_time'     => 'Part Time',
        'self_employed' => 'Self Employed',
        'contract'      => 'Contract',
    ];

    public function placeholder()
    {
        return view('skeletons.tutor-resume');
    }

    public function mount($user)
    {
        $this->educationService      = new EducationService($user);
        $this->experiencesService    = new ExperienceService($user);
        $this->certificateService   = new CertificateService($user);
    }
    public function render()
    {
        $educations   = $this->educationService->getUserEducations();
        $experiences  = $this->experiencesService->getUserExperiences();
        $certificates   = $this->certificateService->getUserCertificates();
        return view('livewire.components.tutor-resume',compact('educations','experiences','certificates'));
    }

}
