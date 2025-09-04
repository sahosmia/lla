<?php

namespace App\Livewire\Forms\Tutor\Certificate;

use App\Http\Requests\Tutor\Certificate\CertificateStoreRequest;
use App\Traits\PrepareForValidation;
use Livewire\WithFileUploads;
use Livewire\Form;

class UserCertificateForm extends Form
{
    use WithFileUploads;
    use PrepareForValidation;
    public $old_image;
    public $image;
    public $title;
    public $institute_name;
    public $description;
    public $issue_date;
    public $expiry_date;
    public $id;
    public $isBase64 = false;

    private ?CertificateStoreRequest $request = null;

    public function boot() {
        $this->request = new CertificateStoreRequest();
    }
    public function rules(){
        return $this->request->rules();
    }

    public function setCertificate($certificate = []){

        if(!empty($certificate['id'])){
            $this->id               = $certificate['id'] ?? '';
        }
        $this->image                = $certificate['image'] ?? '';
        $this->title                = $certificate['title'] ?? '';
        $this->institute_name       = $certificate['institute_name'] ?? '';
        $this->issue_date           = $certificate['issue_date'] ?? '';
        $this->expiry_date          = $certificate['expiry_date'] ?? '';
        $this->description          = $certificate['description'] ?? '';
    }

    public function validateCertificate(){
        $this->beforeValidation(['image']);
        $this->validate();

        if (!empty($this->image) && $this->image instanceof \Illuminate\Http\UploadedFile) {
            $imageName             = $this->image->getClientOriginalName();
            $certificatesImage     = $this->image->storeAs('certificates', $imageName, getStorageDisk());
        } else {
            $certificatesImage = $this->image;
        }

        $certificate = [
            'id'                    => $this->id,
            'image'                 => $certificatesImage,
            'title'                 => $this->title,
            'institute_name'        => $this->institute_name,
            'issue_date'            => $this->issue_date,
            'expiry_date'           => $this->expiry_date,
            'description'           => $this->description,
        ];
        return $certificate;
    }
}
