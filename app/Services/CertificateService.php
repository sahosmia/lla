<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserCertificate;
use App\Models\UserEducation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class CertificateService {

    public $user;

    public function __construct($user) {
        $this->user = $user;
    }

    public function getUserCertificates(): Collection {
        return $this->user->certificates()->get();
    }

    public function getUserCertificate($certificateId) {
        return $this->user->certificates()->whereId($certificateId)->first();
    }

    public function setUserCertificate($certificate) {
        if ($certificate) {
            $certificate['issue_date'] = Carbon::parse($certificate['issue_date']);
            if (!empty($certificate['expiry_date'])){
                $certificate['expiry_date'] = Carbon::parse($certificate['expiry_date']);
            }
            $isUpdate            = !empty($certificate['id']);
            $updatedCertificate  = $this->user->certificates()->updateOrCreate(['id' => $certificate['id'] ?? null], $certificate);
            if (request()->is('api/*')) {
               return $updatedCertificate;
            } else{
                return $isUpdate ? 'updated' : 'created';
            }
        }
    }

    public function deleteCertificate($certificateId): bool {
        $certificate = $this->user->certificates()->whereId($certificateId)->first();

        if ($certificate) {
            $certificate->delete();
            return true;
        } else
            return false;
    }
}
