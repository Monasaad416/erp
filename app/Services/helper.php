<?php

use Carbon\Carbon;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Setting;
use App\Models\ZatcaSetting;
use App\Models\ZatcaDocument;
use App\Models\CustomerInvoice;
use App\Models\CustomerReturnItem;
use App\Models\CustomerInvoiceItem;
use App\Services\Zatca\Invoice\PIH;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerDebitNoteItem;
use App\Services\Zatca\Invoice\Delivery;
use App\Services\Zatca\Invoice\Supplier;
use App\Services\Zatca\Invoice\TaxesTotal;
use App\Services\Zatca\Invoice\InvoiceLine;
use App\Services\Zatca\Invoice\PaymentType;
use App\Services\Zatca\Invoice\TaxSubtotal;
use App\Services\Zatca\Invoice\ReturnReason;
use App\Services\Zatca\Invoice\AllowanceCharge;
use App\Services\Zatca\Invoice\LineTaxCategory;
use App\Services\Zatca\Invoice\BillingReference;
use App\Services\Zatca\Invoice\InvoiceGenerator;
use App\Services\Zatca\Invoice\LegalMonetaryTotal;
use App\Services\Zatca\Invoice\Client as ZatcaClient;
use App\Services\Zatca\Invoice\AdditionalDocumentReference;


if(!function_exists('send_to_zatca')){
    function send_to_zatca($invoice){
        try {
            //dd($invoice->id);
            $document = ZatcaDocument::create(['invoice_id' => $invoice->id]);

           //dd($document);
            $document_type = '';
            $invoice_type = '';
            if($invoice->type == 'sales'){
                $invoice_type = '388';
            } elseif($invoice->type == 'debit_note'){
                $invoice_type = '383';
            } elseif($invoice->type == 'credit_note'){
                $invoice_type = '381';
            }
            //dd($invoice);
            $stock_type = ($invoice->type == 'sales' || $invoice->type == 'debit_note' ) ? 'out_qty' : 'in_qty';

            $zatcaSettings = ZatcaSetting::first();
            //dd($zatcaSettings);
            $authUser = Auth::user();
            $branch_id = $authUser->branch_id;
            $branch = Branch::where('id',$branch_id)->first();
            //dd($invoice_type);




            // if(!empty($invoice->invoiceable->tax_number)){

            //     $client = (new ZatcaClient())
            //     ->setVatNumber($invoice->invoiceable->tax_number)
            //     ->setStreetName(@$invoice->invoiceable->national_address->street_name)
            //     ->setBuildingNumber($invoice->invoiceable->national_address->building_number)
            //     ->setPlotIdentification(@@$invoice->invoiceable->national_address->sub_number)
            //     ->setSubDivisionName(@$invoice->invoiceable->national_address->region->name)
            //     ->setCityName(@$invoice->invoiceable->national_address->city->name)
            //     ->setPostalNumber(@$invoice->invoiceable->national_address->postal_code)
            //     ->setCountryName('SA')
            //     ->setClientName($invoice->invoiceable->name);
            //     $document_type = '0100000';
            // }else{
                //dd($document);
                $clientName = $invoice->customer ? $invoice->customer : '---';
                $client = (new ZatcaClient())
                ->setCountryName('SA')
                ->setClientName('عميل');
                $document_type = '0200000';
            // }




            //dd($branch);
            //pharmacy info
            $supplier = (new Supplier())
            ->setCrn($zatcaSettings->commercial_register)
            ->setStreetName($branch->street_name_ar)
            ->setBuildingNumber($branch->building_number)
            ->setPlotIdentification($branch->plot_identification)
            ->setSubDivisionName($branch->region_ar)
            ->setCityName($branch->city_ar)
            ->setPostalNumber($branch->postal_code)
            ->setCountryName('SA')
            ->setVatNumber($zatcaSettings->tax_num)
            ->setVatName($zatcaSettings->name ." " . $branch->name_ar);

            //dd($supplier);


            $delivery = (new Delivery())
            ->setDeliveryDateTime(Carbon::parse($invoice->created_at)->format('Y-m-d'));
            // dd($delivery);



            if($invoice->payment_method == 'cash') {
                $paymentMethod = 10;

            } elseif($invoice->payment_method == 'visa') {
                $paymentMethod = 30;
            }


            $paymentType = (new PaymentType())
            ->setPaymentType($paymentMethod);
            //   dd($paymentType);

            if($invoice->type =='credit_note') {
                $returnReason = (new ReturnReason())
                ->setReturnReason('KSA-10');
            }elseif($invoice->type =='debit_note') {

                $returnReason = (new ReturnReason())
                ->setReturnReason('KSA-10');
            }
            $previous_hash = (new PIH())
            ->setPIH($document->pih);


            if($invoice->type =='debit_note' || $invoice->type == 'credit_note') {
                $billingReference = (new BillingReference())
                ->setBillingReference($invoice->customer_invoice_id); // note this used when type credit or debit this value of parent invoice id
            }
            $additionalDocumentReference = (new AdditionalDocumentReference())
            ->setInvoiceID($document->icv);


           //dd($invoice->tax_value);

            if($invoice->type == 'sales') {
                $extensionAmount = $invoice->total_after_discount - $invoice->tax_value;
                $taxExclusiveAmount = $invoice->total_after_discount - $invoice->tax_value;
                $taxInclusiveAmount = $invoice->total_after_discount;
                $allowanceTotalAmount = $invoice->total_before_discount - $invoice->total_after_discount;
                $totalTaxes = $invoice->tax_value;
            } else {
                $extensionAmount = $invoice->total_without_tax;
                $taxExclusiveAmount = $invoice->total_without_tax;
                $taxInclusiveAmount = $invoice->total_with_tax;
                $allowanceTotalAmount = 0;
                $totalTaxes = $invoice->tax;
            }

            $legalMonetaryTotal = (new LegalMonetaryTotal())
            ->setTotalCurrency('SAR')
            ->setLineExtensionAmount($extensionAmount) // اجمالي المبلغ بدون ضريبة
            ->setTaxExclusiveAmount($taxExclusiveAmount) // اجمالي المبلغ بدون ضريبة
            ->setTaxInclusiveAmount($taxInclusiveAmount) //اجمالي المبلغ شامل الضريبة قبل الخصم
            ->setAllowanceTotalAmount($allowanceTotalAmount) //نسبة الخصم
            ->setPrepaidAmount(0)// المدفوع مقدما
            ->setPayableAmount($taxInclusiveAmount); //اجمالي المبلغ المدفوع شامل الضريبة


            //dd($legalMonetaryTotal);


            $taxesTotal = (new TaxesTotal())
            ->setTaxCurrencyCode('SAR')
            ->setTaxTotal($totalTaxes);

            //dd($taxesTotal);



            // dd(CustomerInvoiceItem::where('customer_invoice_id',$invoice->id)->get());

            if($invoice->type == 'sales') {
                $items = CustomerInvoiceItem::where('customer_invoice_id', $invoice->id)->get();
                //dd($items);
            } if($invoice->type == 'credit_note') {
                $items = CustomerReturnItem::where('customer_return_id', $invoice->id)->get();

            } if($invoice->type == 'debit_note') {
                $items = CustomerDebitNoteItem::where('customer_debit_note_id', $invoice->id)->get();
            }


            if ($items->count() > 0) {
                foreach($items as $item ){
        
                    $product = Product::where('id',$item->product_id)->first();
                    //dd($product);
                    if($product && $product->taxes == 1 ) { 
                        $taxSubtotal[] = (new TaxSubtotal())
                        ->setTaxCurrencyCode('SAR')
                        ->setTaxableAmount($item->total_without_tax)
                        ->setTaxAmount($item->tax)
                        ->setTaxCategory('S')
                        ->setTaxPercentage(15)
                        ->getElement();

                        $allowanceCharge[] = (new AllowanceCharge())
                        ->setAllowanceChargeCurrency('SAR')
                        ->setAllowanceChargeIndex('2')
                        ->setAllowanceChargeAmount(0)
                        ->setAllowanceChargeTaxCategory('S')
                        ->setAllowanceChargeTaxPercentage(15)
                        ->getElement();

                        $lineTaxCategory1 = (new LineTaxCategory())
                        ->setTaxCategory('S')
                        ->setTaxPercentage(15)
                        ->getElement();

                        $invoiceLines[] = (new InvoiceLine())
                        ->setLineID($item->id)
                        ->setLineName($item->product_name_ar)
                        ->setLineCurrency('SAR')
                        ->setLinePrice($item->sale_price)
                        ->setLineQuantity($invoice->type == 'credit_note' ? $item->return_qty : $item->qty)
                        ->setLineSubTotal($item->total_without_tax)
                        ->setLineTaxTotal($item->tax)
                        ->setLineNetTotal($item->total_with_tax)
                        ->setLineTaxCategories($lineTaxCategory1)
                        ->setLineDiscountReason('reason')
                        ->setLineDiscountAmount(0)
                        ->getElement();
                        
                    } elseif($product && $product->taxes == null ) {
                        $taxSubtotal[] = (new TaxSubtotal())
                        ->setTaxCurrencyCode('SAR')
                    ->setTaxableAmount($item->total_without_tax)
                        ->setTaxAmount($item->tax)
                        ->setTaxCategory('Z')
                        ->setTaxPercentage(0)
                        ->setTaxExemptionReasonCode('VATEX-SA-35')
                        ->setTaxExemptionReason('Medicines and medical equipment')
                        ->getElement();

                        $allowanceCharge[] = (new AllowanceCharge())
                        ->setAllowanceChargeCurrency('SAR')
                        ->setAllowanceChargeIndex('1')
                        ->setAllowanceChargeAmount(0)
                        ->setAllowanceChargeTaxCategory('Z')
                        ->setAllowanceChargeTaxPercentage(0)
                        ->getElement();

                        $lineTaxCategory2 = (new LineTaxCategory())
                        ->setTaxCategory('Z')
                        ->setTaxPercentage(0)
                        ->getElement();

                        $invoiceLines[] = (new InvoiceLine())
                        ->setLineID($item->id)
                        ->setLineName($item->product_name_ar)
                        ->setLineCurrency('SAR')
                        ->setLinePrice($item->sale_price)
                        ->setLineQuantity($invoice->type == 'credit_note' ? $item->return_qty : $item->qty)
                        ->setLineSubTotal($item->total_without_tax)
                        ->setLineTaxTotal($item->tax)
                        ->setLineNetTotal($item->total_with_tax)
                        ->setLineTaxCategories($lineTaxCategory2)
                        ->setLineDiscountReason('reason')
                        ->setLineDiscountAmount(0)
                        ->getElement();
                    }
                }
            }    
                //dd($invoiceLines);



            //dd($taxSubtotal);

            // $itemTaxCategory = (new LineTaxCategory())
            // ->setTaxCategory($productTaxCategory)
            // ->setTaxPercentage($productTaxPercentage)
            // ->getElement();


            //dd($invoiceLines);



            if($invoice->type == 'sales') {
                $invoiceNumber = $invoice->customer_inv_num;
            } if($invoice->type == 'credit_note' || $invoice->type == 'debit_note') {
                $invoiceNumber = CustomerInvoice::where('id',$invoice->customer_invoice_id)->first()->customer_inv_num;
            }
            $response = (new InvoiceGenerator())
            ->setZatcaEnv('developer-portal')
            ->setZatcaLang(app()->getLocale())
            ->setInvoiceNumber($invoiceNumber)
            ->setInvoiceUuid($document->uuid) // this value from step 6
            ->setInvoiceIssueDate(Carbon::parse($invoice->created_at)->format('Y-m-d'))
            ->setInvoiceIssueTime(Carbon::parse($invoice->created_at)->format('H:i:s'))
            ->setInvoiceType($document_type,$invoice_type)
            ->setInvoiceCurrencyCode('SAR')
            ->setInvoiceTaxCurrencyCode('SAR');



            //dd($response);

            if($invoice->type == 'credit_note' || $invoice->type == 'debit_note'){
                $response = $response->setInvoiceBillingReference($billingReference);  //use this when document type is credit or debit
            }

            $response = $response->setInvoiceAdditionalDocumentReference($additionalDocumentReference)
            ->setInvoicePIH($previous_hash)
            ->setInvoiceSupplier($supplier)
            ->setInvoiceClient($client)
            ->setInvoiceDelivery($delivery)
            ->setInvoicePaymentType($paymentType);

            //dd($response);

            if($invoice->type == 'credit_note' || $invoice->type == 'debit_note' ){
                $response = $response->setInvoiceReturnReason($returnReason); //use this when document type is credit or debit
            }




            $response = $response->setInvoiceLegalMonetaryTotal($legalMonetaryTotal)
            ->setInvoiceTaxesTotal($taxesTotal)
            ->setInvoiceTaxSubTotal(...$taxSubtotal)
            ->setInvoiceAllowanceCharges(...$allowanceCharge)
            ->setInvoiceLines(...$invoiceLines)
            ->setCertificateEncoded(!$zatcaSettings->is_production ? $zatcaSettings->complianceCertificate : $zatcaSettings->productionCertificate)
            ->setPrivateKeyEncoded($zatcaSettings->privateKey)
            ->setCertificateSecret(!$zatcaSettings->is_production ? $zatcaSettings->complianceSecret : $zatcaSettings->productionCertificateSecret)
            ->sendDocument(!$zatcaSettings->is_production ? false : true);

            //dd($response);



            if($response['success']){
                $document->update([
                    'hash' => $response['hash'],
                    'xml' => $response['xml'],
                    'signing_time' => Carbon::parse($response['signing_time']),
                ]);
            } else {
            //dd($response['success']);
            }

            $document->update([
                'sent_to_zatca' => $response['success'],
                'sent_to_zatca_status' => $response['response']->validationResults->status,
                'response' => json_encode($response,JSON_UNESCAPED_UNICODE),
            ]);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }

    }
}
// {"success":true,"response":{"validationResults":{"infoMessages":[{"type":"INFO","code":"XSD_ZATCA_VALID","category":"XSD validation","message":"Complied with UBL 2.1 standards in line with ZATCA specifications","status":"PASS"}],"warningMessages":[{"type":"WARNING","code":"BR-KSA-69","category":"KSA","message":
//     "يجب أن يشتمل التوزيع التفصيلي لضريبة 
//     القيمة المضافة (BG-23) حيث يكون رمز فئة
//      ضريبة القيمة المضافة (BT-118) 'خاضع لنسبة
//       الصفر' على الرمز المخصص لسبب الإعفاء من ضريبة القيمة المضافة (BT-121) والنص المخصص لسبب الإعفاء من ضريبة القيمة المضافة (BT-120).","status":"WARNING"}],"errorMessages":[],"status":"WARNING"},"reportingStatus":"REPORTED","clearanceStatus"

