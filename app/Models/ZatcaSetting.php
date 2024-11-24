<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZatcaSetting extends Model
{
    use HasFactory;
    protected $fillable =['tax_num','commercial_register','branch_id','name','otp','complianceCertificate','complianceSecret','complianceRequestID','productionCertificate','productionCertificateSecret',
    'productionCertificateRequestID','privateKey','publicKey','csrKey','configData'];
}
