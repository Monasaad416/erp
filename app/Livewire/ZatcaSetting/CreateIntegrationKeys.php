<?php

namespace App\Livewire\ZatcaSetting;

use Alert;
use App\Models\Branch;
use App\Models\Setting;
use Livewire\Component;
use App\Models\ZatcaSetting;
use App\Services\Zatca\OnBoarding;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class CreateIntegrationKeys extends Component
{

    public $tax_num,$commercial_register,$branch,$branch_id,$name,$settings,$otp,$complianceCertificate,$complianceSecret,$complianceRequestID,$productionCertificate,$productionCertificateSecret,
    $productionCertificateRequestID,$privateKey,$publicKey,$csrKey,$configData ;

    public function mount ()
    {
        
        $authUser = Auth::user();
        $this->branch = Branch::where('id',$authUser->branch_id)->first();
        $this->branch_id = $this->branch->id;

        $this->settings = ZatcaSetting::firstOrCreate();
        //dd($this->settings);
        $this->otp = $this->settings->otp;
        $this->tax_num = $this->settings->tax_num;
        $this->commercial_register = $this->settings->commercial_register;
        $this->name = $this->settings->name;

        $this->complianceCertificate =$this->settings->complianceCertificate;
        $this->complianceSecret = $this->settings->complianceSecret;
        $this->complianceRequestID = $this->settings->complianceRequestID;
        $this->productionCertificate = $this->settings->productionCertificate;
        $this->productionCertificateSecret = $this->settings->productionCertificateSecret;
        $this->productionCertificateRequestID = $this->settings->productionCertificateRequestID;
        $this->privateKey = $this->settings->privateKey ;
        $this->publicKey = $this->settings->publicKey;
        $this->csrKey = $this->settings->csrKey;
        $this->configData = $this->settings->configData;
    }
    // public function generatePrivateKey()
    // {
    //     exec('openssl ecparam -name secp256k1 -genkey -noout -out Privatekey.pem');
    //     $privateKey = file_get_contents('Privatekey.pem');

    //     $this->settings->private_key = $privateKey;
    //     $this->settings->branch_id = Auth::user()->branch_id;
    //     $this->settings->save();

    //     Alert::success('Private key generated successfully.');
    //     return redirect()->route('zatca_settings.create');
    // }
    // public function generatePublicKey()
    // {
    //     exec('openssl ec -in Privatekey.pem -pubout -out Publickey.pem');
    //     $publicKey = file_get_contents('Publickey.pem');
    //     $this->settings->public_key = $publicKey;
    //     $this->settings->branch_id = Auth::user()->branch_id;
    //     $this->settings->save();

    //     Alert::success('Public key generated successfully.');
    //     return redirect()->route('zatca_settings.create');
    // }

    // public function generateCsr()
    // {
    //     exec('openssl req -new -sha256 -key Privatekey.pem -extensions v3_req -config D:\configuration.cnf -out taxpayer.csr');
    //     $csr = file_get_contents('taxpayer.csr');

    //     $this->settings->csr = $csr;
    //     $this->settings->branch_id = Auth::user()->branch_id;
    //     $this->settings->save();

    //     Alert::success('CSR generated successfully.');
    //     return redirect()->route('zatca_settings.create');
    // }

        public function rules() {
        return [
            'tax_num' => 'required|tax_num_length',
            'commercial_register' => 'required',
            'name' => 'nullable|string',
            'otp' => 'nullable|string',
        ];
    }
    public function messages()
    {
        return [

            'settings.tax_num.tax_num_length' => trans('validation.tax_num_length'),
            'settings.tax_num.required' => 'الرقم الضريبي مطلوب',
            'settings.commercial_register.required' => 'السجل التجاري  مطلوب',
            'settings.name.string' => 'إسم المتجر يجب ان يتكون من حروف وأرقام',
            'settings.address.string' => 'عنوان المتجر يجب ان يتكون من حروف وأرقام',
        ];

    }
    public function update()
    {
        $this->validate($this->rules(), $this->messages());

    //dd($this->settings);



        $this->settings->tax_num = $this->tax_num;
        $this->settings->commercial_register = $this->commercial_register;
        $this->settings->name = $this->name;
        $this->settings->otp = $this->otp;
        // $this->settings->branch_id = $this->branch_id;
        $this->settings->save();

        $this->resetValidation();

   
        //dd($this->settings);

        $response = (new OnBoarding())
        ->setZatcaEnv('developer-portal')
        ->setZatcaLang('en')
        ->setEmailAddress($this->branch->email)
        ->setCommonName($this->settings->name)
        ->setCountryCode('SA')
        ->setOrganizationUnitName($this->branch->name_ar)
        ->setOrganizationName($this->settings->name)
        ->setEgsSerialNumber('1-SDSA|2-FGDS|3-SDFG')
        ->setVatNumber($this->settings->tax_num)
        ->setInvoiceType('0100')
        ->setRegisteredAddress($this->branch->street_name_ar)
        ->setAuthOtp($this->settings->otp)
        ->setBusinessCategory('Healthcare')
        ->getAuthorization();




       //dd($response);
        $this->settings->complianceCertificate = $response['data']['complianceCertificate'];
        $this->settings->complianceSecret = $response['data']['complianceSecret'];
        $this->settings->complianceRequestID = $response['data']['complianceRequestID'];
        $this->settings->productionCertificate = $response['data']['productionCertificate'];
        $this->settings->productionCertificateSecret = $response['data']['productionCertificateSecret'];
        $this->settings->productionCertificateRequestID = $response['data']['productionCertificateRequestID'];
        $this->settings->privateKey = $response['data']['privateKey'];
        $this->settings->publicKey = $response['data']['publicKey'];
        $this->settings->csrKey = $response['data']['csrKey'];
        $this->settings->configData = $response['data']['configData'];
        $this->settings->save();


        Alert::success('تم تعديل إعدادات الربط مع هيأة الزكاة والدخل والضرائب بنجاح');
        return redirect()->route('zatca_settings.edit');

    }


    public function render()
    {
        return view('livewire.zatca-setting.create-integration-keys');
    }
}
