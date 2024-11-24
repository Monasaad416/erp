<?php
namespace App\Livewire\SupplierInvoices;

use Alert;
use Exception;
use Carbon\Carbon;
use App\Models\Bank;
use App\Models\Unit;
use App\Models\Account;
use App\Models\Product;
use App\Models\Setting;
use Livewire\Component;
use App\Models\Supplier;
use App\Models\TAccount;
use App\Models\Treasury;
use Dotenv\Parser\Entry;
use App\Models\Inventory;
use App\Models\ProductCode;
use App\Models\ShortComing;
use App\Models\JournalEntry;
use App\Events\NewInvoiceEvent;
use App\Models\SupplierInvoice;
use Illuminate\Support\Facades\DB;
use App\Events\NewSuppInvoiceEvent;
use App\Models\SupplierInvoiceItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Livewire\SupplierInvoices\DisplayInvoices;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AddInvoice222 extends Component
{
    public $products=[] ,$banks=[],$validationMessages,$rows=[],$suppliers,$units,$product, $product_id,$product_name_ar,$product_name_en, $product_code, $unit,
    $discount_percentage=0,$discount_value=0,$taxes ,$sale_price,$purchase_price,$batch_num,$qty='',
    $invoice_discount_percentage=0,$invoice_discount_value=0,$price,$code_type,$invoice_products=[]
    ,$wholesale_inc_vat,$payment_type,$status,$supp_inv_num,$supp_inv_date_time,$is_approved,$is_pending=0,$notes,$supplier_id,
     $finalItemPrice=0,$settings,$bank_id,$check_num,$totalPrices,$totalTaxes,$totalPricesTaxes,$invoice,
     $showModal = false,$modalFilled = false,$profit_percentage,$transportation_fees;



    public function mount()
    {
        $settings = Setting::find(1);
        //dd($settings->vat);
        $this->supp_inv_num = getNextInvoiceNumber();
        $this->supp_inv_date_time = now()->format('Y-m-d\TH:i');
        for($i=0; $i < 20; $i++){
            $this->addRow($i);
        }

        $this->dispatch('newRowAdded');
        $this->dispatch('load');

    }

    public function rules()
    {
        $rules = [
            // 'payment_type' => 'required',
            'notes' => 'nullable|string',
            'is_pending' => 'required',
            'supplier_id' => 'required',
            'transportation_fees' => 'nullable|numeric',

        ];

        foreach ($this->rows as $index => $row) {

            if($row['product_code'] != "") {
                $rules['rows.' . $index . '.product_code'] = [
                    'required',
                    'string',
                    'max:100',
                    'exists:product_codes,code',
                ];
                $rules['rows.' . $index . '.qty'] = 'required|numeric';
                $rules['rows.' . $index . '.purchase_price'] = [
                    'required_if:rows.' . $index . '.wholesale_inc_vat,null',
                    'gt:0',
                    'lt:rows.' . $index . '.sale_price',
                ];
                $rules['rows.' . $index . '.wholesale_inc_vat'] = 'required_if:rows.*.purchase_price,null|required_with:qty';
                $rules['rows.' . $index . '.discount_value'] = 'nullable|numeric';
                $rules['rows.' . $index . '.discount_percentage'] = 'nullable|numeric';
                $rules['rows.' . $index . '.batch_num'] = 'nullable|string';
      
            }
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'payment_type.required' => trans('validation.payment_type_required'),
            'supplier_id.required' => trans('validation.supplier_id_required'),
            'supp_inv_date_time.required' => trans('validation.supp_inv_date_time_required'),
            'payment_type.in' => trans('validation.payment_type_in'),
            'status.required' => trans('validation.status_required'),
            'rows.*.product_code.required' => trans('validation.product_code_required'),
            'rows.*.product_code.string' => trans('validation.product_code_string'),
            'rows.*.product_code.max' => trans('validation.product_code_max'),
            'rows.*.product_code.exists' => trans('validation.product_code_exists'),
            'rows.*.purchase_price.required_if' => trans('validation.purchase_price_required_if'),
            'rows.*.wholesale_inc_vat.required_if' => trans('validation.wholesale_inc_vat_required_if'),
            'rows.*.wholesale_inc_vat.numeric' => trans('validation.wholesale_inc_vat_numeric'),
            'rows.*.purchase_price.min' => trans('validation.purchase_price_min'),
            'rows.*.purchase_price.gt' => 'سعر الشراء يجب أن يكون اكبر من 0',
            'rows.*.purchase_price.lt' => 'سعر الشراء يجب أن يكون اقل من سعر البيع',
            'rows.*.discount_percentage.numeric' => trans('validation.discount_percentage_numeric'),
            'rows.*.discount_value.numeric' => trans('validation.discount_value_numeric'),
            'rows.*.qty.required' => trans('validation.qty_required'),
            'rows.*.qty.numeric' => trans('validation.qty_numeric'),
        ];
    }

    public function clearInputs ()
    {
        $this->product_code = "";
        $this->qty = "";
        $this->product_name_ar = "";
        $this->product_id = "";
        $this->product_name_en = "";
        $this->purchase_price = "";
        $this->wholesale_inc_vat = "";
        $this->discount_value = "";
        $this->discount_percentage = "";
    }


    public function adjustCode($index)
    {
        $codeExclude01 = substr($this->rows[$index]['product_code'], 2);
        //dd($codeExclude01);
        $finalCode = substr($codeExclude01, 0, 14);
        $this->rows[$index]['product_code'] = $finalCode;
        //dd($this->rows[$index]['product_code']);
        $this->fetchByCode($index);
    }

    public function fetchByName($index, $selectedProductId)
    {
        // Fetch data and update properties
        //dd('dd');
        $product = Product::where('id', $selectedProductId)->first();
        //dd($product);

        $this->rows[$index]['product_id'] = $product ? $product->id : trans('admin.not_found');
        $this->rows[$index]['unit'] = $product ? $product->unit->name : null;
        $this->rows[$index]['sale_price'] = $product ?  $product->sale_price : 0 ;
        $this->rows[$index]['product_name_ar'] = $product ? $product->name_ar : null;
        // $this->rows[$index]['qty'] =  1;
        $this->rows[$index]['product_code'] = $product ? ProductCode::where('product_id', $selectedProductId)->latest()->first()->code : null ;

    }

    public function fetchByCode($index)
    {
        //dd($this->rows, $this->rows[$index]['product_name_ar']);
        // $codeExclude01 = substr($this->rows[$index]['product_code'], 2);
        // $finalCode = substr($codeExclude01, 0, 14);

        // $this->rows[$index]['product_code'] = $finalCode;

        //dd($this->rows[$index]['product_code']);

        $this->validate([
            'rows.' . $index . '.product_code' => 'required|string|max:100|exists:product_codes,code',
        ]);

        // Retrieve the product name based on the product code
        $productCode = ProductCode::where('code', $this->rows[$index]['product_code'])->first();

        $product = Product::where('id', $productCode->product_id)->first();
        //dd($product);
        $this->rows[$index]['product_name_ar'] =  $product->name_ar;
        $this->rows[$index]['product_name_en'] =  $product->name_en ;
        $this->rows[$index]['product_id'] =  $product->id ;
        $this->rows[$index]['unit'] =  $product->unit->name ;
        // $this->rows[$index]['qty'] =  1;
        $this->rows[$index]['sale_price'] = $product->discount_price > 0  ? $product->discount_price : $product->sale_price ;

    }

    public function calculateUnitPrice($index)
    {
        if ($this->rows[$index]['qty'] !== null && $this->rows[$index]['qty'] > 0) {
            $wholesalePriceWithVat = (float) $this->rows[$index]['wholesale_inc_vat'];
            $wholesalePriceWithoutVat = $wholesalePriceWithVat / 1.15;

            $qty = (float) $this->rows[$index]['qty'];

            $unitPrice = $wholesalePriceWithoutVat / $qty;
            $formattedUnitPrice = number_format($unitPrice, 2);

            $this->rows[$index]['purchase_price'] = $formattedUnitPrice;
        }
        elseif($this->rows[$index]['qty'] == 0){
            $this->dispatch(
            'alert',
                text: 'فضلا ادخل الكمية اولا ثم اعد كتابة اجمالي السعر شامل الضريبة',
                icon: 'error',
                confirmButtonText: trans('admin.done')

            );
        }

         $this->getTotals();
    }

    public function profitPercentage($index){
        $salePrice = (float)$this->rows[$index]['sale_price'];
        $purchasePrice = (float)$this->rows[$index]['purchase_price'];
        if($purchasePrice) {
            $this->rows[$index]['profit_percentage'] = round(( $salePrice  - $purchasePrice ) / $purchasePrice * 100 ,2) ;
        }
    }

    public function getTaxes($index)
    {
        $product = Product::where('id', $this->rows[$index]['product_id'])->first();
        //dd($product);

        if($product) {
            //dd((float)$this->rows[$index]['purchase_price'] );
            $this->rows[$index]['taxes'] = $product->taxes == 1 ? round((float)$this->rows[$index]['purchase_price'] * 0.15 ,2)  : 0;
            $this->rows[$index]['unit_total'] = round( (float)$this->rows[$index]['taxes']  + (float)$this->rows[$index]['purchase_price'] ,2 );
        }


        $this->getTotals();
        $this->profitPercentage($index);
        $this->rows[$index+1]['batch_num'];
    }
    public function getTotals()
    {
        $this->totalPrices = 0;
        $this->totalTaxes = 0;


        foreach($this->rows as $row) {
            //dd($row['qty']);
            if ($row['qty'] !== '' && $row['purchase_price'] !== '') {
                $product = Product::where('id', $row['product_id'])->first();
               // dd($product);
                if($product) {
                    if($product->taxes == 1){
                        $this->totalTaxes +=  sprintf("%.2f", $row['purchase_price'] *  sprintf("%.2f",$row['qty'] * 0.15 )) ;
                    } else {
                            $this->totalTaxes += 0;
                    }
                    $this->totalPrices += sprintf("%.2f", $row['purchase_price'] *  $row['qty']);
                    $this->totalPricesTaxes = sprintf("%.2f",$this->totalPrices + $this->totalTaxes);
                }
            }
        }
    }
    public function focusNextRowInput( $index)
    {
        if ($index === count($this->rows) - 1) {

            $this->addRow();
            $this->dispatch('newRowAdded');
        }

        $nextIndex = $index + 1;
        $nextInputId = "input-" . $nextIndex;

        $this->dispatch('focus-input', ['inputId' => $nextInputId]);
    }
    public function addRow()
    {

        $this->rows[] = [
            'product_code' => '',
            'qty' => '',
            'product_name_ar' => '',
            // 'product_name_en' => '',
            'product_id' => '',
            'unit' => '',
            'purchase_price' => '',
            'sale_price' => '',
            'wholesale_inc_vat' => '',
            'batch_num' => '',
            'taxes' => '',
            'unit_total' => '',
            'profit_percentage' => '',

        ];
         $this->dispatch('initialize-select2', ['index' => count($this->rows) - 1]);

        //     $this->dispatch('refreshJS');

    }

    public function removeItem($index)
    {
        unset($this->rows[$index -1]);
    }


    public function BankInfo()
    {
        if($this->payment_type == 'by_check') {
            $this->banks = Bank::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
            // $this->dispatch('newRowAdded');
        }
    }
public function saveModal()
{
    // Perform any necessary validation for the modal form
    $this->validate([
        'bank_id' => 'required',
        'check_num' => 'required',
    ]);

    // Set the flag to indicate that the modal has been filled
    $this->modalFilled = true;

    // Hide the modal after saving its data
    $this->showModal = false;
}

    public function installmentsPayment()
    {
        $this->create();

        $this->invoice->payment_type = "by_installments";
        $this->invoice->save();
        event(new NewSuppInvoiceEvent($this->invoice,$this->invoice->payment_type));
        DB::commit();
        Alert::success('تم إضافة فاتورة مورد أجلة جديدة بنجاح');
        return redirect()->route('suppliers.invoices');
    }
    public function cashPayment()
    {

        $this->create();
        $this->invoice->payment_type = "cash";
        $this->invoice->save();
        event(new NewSuppInvoiceEvent($this->invoice,$this->invoice->payment_type));
        DB::commit();
        Alert::success('تم إضافة فاتورة مورد جديدة بنجاح -الدفع كاش من الخزينة');
        return redirect()->route('suppliers.invoices');

    }
    public function bankPayment()
    {


        $this->showModal = true;
        $this->dispatch('bankPaymentModalToggle');

    }

    public function saveBankPayment()
    {

        //dd("ll");
        $this->create();
        $this->invoice->bank_id = $this->bank_id;
        $this->invoice->check_num = $this->check_num;
        $this->invoice->save();
        event(new NewSuppInvoiceEvent($this->invoice, $this->invoice->payment_type));

        DB::commit();

        $this->showModal = false;
        $this->dispatch('bankPaymentModalToggle');

        Alert::success('تم إضافة فاتورة مورد جديدة بنجاح-الدفع بشيك');
        return redirect()->route('suppliers.invoices');

    }


    public function pendInvoice()
    {
        $this->create();
        DB::commit();

        $this->invoice->is_pending = 1;
        $this->invoice->save();



        Alert::error('  تم تعليق الفاتوره');
        return redirect()->route('suppliers.invoices');

    }
    public function create() {
        $this->validate($this->rules() ,$this->messages());

        //dd($this->all());
        // try{

            DB::beginTransaction();

            $this->invoice = new SupplierInvoice();
            $this->invoice->supp_inv_num = getNextInvoiceNumber();
            $this->invoice->serial_num= getNextSerial();
            $this->invoice->supp_inv_date_time=Carbon::parse($this->supp_inv_date_time)->format('Y-m-d H:i:s');
            $this->invoice->supplier_id =$this->supplier_id;
            $this->invoice->is_approved =false;
            $this->invoice->is_pending= $this->is_pending;
            $this->invoice->transportation_fees= $this->transportation_fees ?$this->transportation_fees : 0;
            $this->invoice->created_by= Auth::user()->id;
            $this->invoice->payment_type=$this->payment_type;
            $this->invoice->discount_percentage= $this->discount_percentage ? $this->discount_percentage : 0;
            $this->invoice->supp_balance_before_invoice = Supplier::where('id',$this->supplier_id)->first()->current_balance;
            $this->invoice->branch_id = Auth::user()->branch_id;
            $this->invoice->bank_id = $this->bank_id ?? null;
            $this->invoice->check_num = $this->check_num ?? null;
            $this->invoice->save();

            //dd($this->invoice);



            $invTotal = 0;
            $taxTotal = 0;
            foreach ($this->rows as $index => $row) {
                if($row['product_code'] !== "" || $row['product_code'] !== null)  {
                    //dd($row['unit_total'] * $row['qty']);
                    $product = Product::where('id', $row['product_id'] )->first();


                    if($product) {
                        $productTax = $product->taxes == 1 ? 1 :0;

                        $price = 0;
                        if($row['wholesale_inc_vat'] > 0) {
                            $price = ($row['wholesale_inc_vat'] / 1.15) / $row['qty'];
                        }
                        $invoiceItem = new SupplierInvoiceItem();
                        $invoiceItem->product_id = $row['product_id'];
                        $invoiceItem->product_name_ar = $row['product_name_ar'];
                        $invoiceItem->product_name_en = $row['product_name_en'] ?? null;
                        $invoiceItem->product_code = $row['product_code'];
                        $invoiceItem->unit = $row['unit'];
                        $invoiceItem->supplier_invoice_id = $this->invoice->id;
                        $invoiceItem->qty = $row['qty'];
                        $invoiceItem->purchase_price = $row['purchase_price'] ? $row['purchase_price'] : $price;
                        $invoiceItem->sale_price = $row['sale_price'] ;
                        $invoiceItem->wholesale_inc_vat = $row['wholesale_inc_vat'] ? $row['wholesale_inc_vat'] : 0 ;
                        $invoiceItem->tax_value = $row['purchase_price'] * $row['qty'] * 0.15 * $productTax;//////////////////////////////////////////check
                        $invoiceItem->total =  $row['wholesale_inc_vat'] > 0 ?  $row['wholesale_inc_vat'] : $row['unit_total'] * $row['qty'];

                        $invTotal += $invoiceItem->total;
                        $taxTotal += $invoiceItem->tax_value;
                        // $invoiceItem->save();


                        //dd($invoiceItem);


                            //increase inventory amount

                            $inventory  = Inventory::where('product_id',$row['product_id'])->where('branch_id',1)->latest()->first();
                                // dd( $row['product_id']);
                            $inv = new Inventory();
                            $inv->inventory_balance = $inventory ? $inventory->inventory_balance + $row['qty'] :  $row['qty'];
                            $inv->initial_balance = $inventory ? $inventory->initial_balance : 0 ;
                            $inv->in_qty = $row['qty'];
                            $inv->out_qty = 0;
                            $inv->current_financial_year = date("Y");
                            $inv->is_active = 1;
                            $inv->branch_id = 1;
                            $inv->store_id = 1;
                            $inv->product_id = $product->id;
                            $inv->updated_by = Auth::user()->id;
                            $inv->notes ='توريد كمية جديدة للمخزن الرئيسي';
                            $inv->latest_purchase_price =  $invoiceItem->purchase_price;
                            $inv->latest_sale_price = $inventory->latest_sale_price;
                            $inv->inventorable_id = $this->invoice->id;
                            $inv->inventorable_type = 'App\Models\SupplierInvoice';
                            $inv->save();

                            $invoiceItem->inventory_balance  = $inv->inventory_balance;
                            $invoiceItem->save();



                            $shortcomings = ShortComing::where('product_id',$row['product_id'])->where('branch_id',1)->get();
                            if($shortcomings) {
                                foreach($shortcomings as $shortcoming) {
                                    if($invoiceItem->qty > $product->alert_main_branch){
                                        $shortcoming->delete();
                                    }
                                }
                            }
                        }
                }
            }


            $this->invoice->tax_value += $taxTotal;
            $this->invoice->total_before_discount += $invTotal;
            $this->invoice->total_after_discount = $invTotal *(1- $this->discount_percentage / 100);
            $this->invoice->discount_value = $invTotal * $this->discount_percentage / 100;
            $this->invoice->tax_after_discount = $this->invoice->tax_value * $this->discount_percentage / 100;
            $this->invoice->supp_balance_after_invoice = $invTotal * (1- $this->discount_percentage / 100) *(1- $this->discount_percentage / 100) + $this->invoice->supp_balance_before_invoice;

            $invoiceItem->inventory_balance  = $inv->inventory_balance;
            $invoiceItem->save();
            $this->invoice->save();

            $supplier_id = $this->supplier_id;


            $this->clearInputs();

            $this->reset(['product_code','qty','product_name_ar','product_name_en','purchase_price','wholesale_inc_vat','discount_value','discount_percentage']);





            //Handle financial aids after adding new invoice
            // event(new NewInvoiceEvent($invoice,$supplier_id));



        // Alert::success(trans('admin.supplier_invoice_created_successfully'));
        // return redirect()->route('suppliers.invoices');




    //  } catch (Exception $e) {
    //         DB::rollback();
    //         return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
    //     }
    }



    public function render()
    {
        return view('livewire.supplier-invoices.add-invoice222');
    }
}
