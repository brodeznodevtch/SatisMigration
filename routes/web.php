<?php

use App\Http\Controllers\AccountingEntrieController;
use App\Http\Controllers\AccountingPeriodController;
use App\Http\Controllers\ApportionmentController;
use App\Http\Controllers\AssistanceEmployeeController;
use App\Http\Controllers\BackUpController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\BankCheckbookController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\BinnacleController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\BankTransactionController;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\BonusCalculationController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\BusinessLocationController;
use App\Http\Controllers\BusinessTypeController;
use App\Http\Controllers\CRMContactModeController;
use App\Http\Controllers\CRMContactReasonController;
use App\Http\Controllers\InternationalPurchaseController;
use App\Http\Controllers\Optics\DiagnosticController;
use App\Http\Controllers\Optics\ExternalLabController;
use App\Http\Controllers\Optics\FlowReasonController;
use App\Http\Controllers\Optics\GraduationCardController;
use App\Http\Controllers\Optics\InflowOutflowController;
use App\Http\Controllers\Optics\LabOrderController;
use App\Http\Controllers\Optics\MaterialTypeController;
use App\Http\Controllers\Optics\PatientController;
use App\Http\Controllers\Optics\StatusLabOrderController;
use App\Http\Controllers\ReasonController;
use App\Http\Controllers\CashDetailController;
use App\Http\Controllers\CashRegisterController;
use App\Http\Controllers\CashierClosureController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\ClaimTypeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CostCenterController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CreditDocumentsController;
use App\Http\Controllers\CreditRequestController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerGroupController;
use App\Http\Controllers\CustomerPortfolioController;
use App\Http\Controllers\CustomerVehicleController;
use App\Http\Controllers\DocumentCorrelativeController;
use App\Http\Controllers\DocumentTypeController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\FiscalYearController;
use App\Http\Controllers\FixedAssetController;
use App\Http\Controllers\FixedAssetTypeController;
use App\Http\Controllers\FollowCustomerController;
use App\Http\Controllers\FollowOportunitiesController;
use App\Http\Controllers\GroupTaxController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImplementationController;
use App\Http\Controllers\ImportExpenseController;
use App\Http\Controllers\ImportOpeningStockController;
use App\Http\Controllers\ImportProductsController;
use App\Http\Controllers\InvoiceLayoutController;
use App\Http\Controllers\InstitutionLawController;
use App\Http\Controllers\InvoiceSchemeController;
use App\Http\Controllers\KardexController;
use App\Http\Controllers\LabelsController;
use App\Http\Controllers\LawDiscountController;
use App\Http\Controllers\LocationSettingsController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ManageCreditRequestController;
use App\Http\Controllers\ManageEmployeesController;
use App\Http\Controllers\ManagePositionsController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OpeningStockController;
use App\Http\Controllers\OportunityController;
use App\Http\Controllers\Optics;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentCommitmentController;
use App\Http\Controllers\PaymentTermController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PayrollReportController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PhysicalInventoryController;
use App\Http\Controllers\PhysicalInventoryLineController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseReturnController;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReporterController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Restaurant;
use App\Http\Controllers\RetentionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RrhhAbsenceInabilityController;
use App\Http\Controllers\RrhhContractController;
use App\Http\Controllers\RrhhDataController;
use App\Http\Controllers\RrhhDocumentsController;
use App\Http\Controllers\RrhhEconomicDependenceController;
use App\Http\Controllers\RrhhImportEmployeesController;
use App\Http\Controllers\RrhhIncomeDiscountController;
use App\Http\Controllers\RrhhPersonnelActionController;
use App\Http\Controllers\RrhhSalarialConstanceController;
use App\Http\Controllers\RrhhSettingController;
use App\Http\Controllers\RrhhStudyController;
use App\Http\Controllers\RrhhTypeContractController;
use App\Http\Controllers\RrhhTypeIncomeDiscountController;
use App\Http\Controllers\RrhhTypePersonnelActionController;
use App\Http\Controllers\RrhhTypeWageController;
use App\Http\Controllers\SalesCommissionAgentController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\SellPosController;
use App\Http\Controllers\SellReturnController;
use App\Http\Controllers\SellingPriceGroupController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\StatusClaimController;
use App\Http\Controllers\StockAdjustmentController;
use App\Http\Controllers\StockTransferController;
use App\Http\Controllers\SupportDocumentsController;
use App\Http\Controllers\TaxGroupController;
use App\Http\Controllers\TaxRateController;
use App\Http\Controllers\TransactionPaymentController;
use App\Http\Controllers\TypeBankTransactionController;
use App\Http\Controllers\TypeEntrieController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UnitGroupController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VariationTemplateController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ZoneController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

include_once 'install_r.php';

Route::middleware('IsInstalled')->group(function () {

    Route::get('/', [HomeController::class, 'welcome']);

    Auth::routes();
    Route::post('/new-login', [\App\Http\Controllers\Auth\LoginController::class, 'postLogin'])->name('new_login');
    Route::get('/business/register', [BusinessController::class, 'getRegister'])->name('business.getRegister');
    Route::post('/business/register', [BusinessController::class, 'postRegister'])->name('business.postRegister');
    Route::post('/business/register/check-username', [BusinessController::class, 'postCheckUsername'])->name('business.postCheckUsername');
});

Route::middleware(['IsInstalled', 'auth', 'SetSessionData', 'language', 'timezone'])->group(function () {
    Route::get('/start', [UserController::class, 'getFirstSession']);
    Route::post('/user/first-session', [UserController::class, 'updatePasswordFirst']);
});

Route::post('credits/show-report', [CreditRequestController::class, 'showReport']);
Route::resource('credits', CreditRequestController::class);

Route::get('business_types/get-data', [BusinessTypeController::class, 'getBusinessTypeData']);
Route::get('payment_terms/get-data', [PaymentTermController::class, 'getPaymentTermData']);
Route::get('/documents/default', [DocumentTypeController::class, 'verifyDefault']);

Route::get('/documents/default', [DocumentTypeController::class, 'verifyDefault']);
//only create customer
Route::get('/customers/verified_document/{type}/{value}', [CustomerController::class, 'verifiedIfExistsDocument']);
//only edit customer
Route::get('/customers/verified_documentID/{type}/{value}/{edit}', [CustomerController::class, 'verifiedIfExistsDocumentID']);

//ruta para anular una terminal
Route::post('/terminal/anull/{id}', [PosController::class, 'cancel']);
//ruta para activar una terminal
Route::post('/terminal/activate/{id}', [PosController::class, 'activate']);

Route::get('/sell/update/{id}', [SellController::class, 'editInvoiceTrans']);

//ver el cliente y su saldo
Route::get('/customer-balances/{id}', [CustomerController::class, 'showBalances']);
//Ver las facturas por cliente xD
Route::get('/customer-balances/getData/{id}', [CustomerController::class, 'getInvoicePerCustomer']);

/** Accounts receivable and report */
Route::get('/accounts-receivable', [CustomerController::class, 'accountsReceivable']);
Route::post('/accounts-receivable-report', [CustomerController::class, 'accountsReceivableReport']);

Route::get('/customers/get_only_customers', [CustomerController::class, 'getClients']);
Route::get('/products/get_only_products', [ProductController::class, 'getProductsSelect']);

//Routes for authenticated users only
Route::middleware(['PasswordChanged', 'IsInstalled', 'auth', 'SetSessionData', 'language', 'timezone'])->group(function () {
    // Route::get('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

    //rutas para busineestypes y paymentTerm
    Route::resource('business_types', BusinessTypeController::class);
    Route::resource('payment_terms', PaymentTermController::class);

    Route::resource('quote/reason', ReasonController::class);

    //Sirve para modificar la anulacion de ventas
    Route::put('/business/update_annull_sale', [BusinessController::class, 'updateAnullSaleExpiry']);

    //Ruta para saldos por cliente xD getBalancesCustomersData
    Route::get('/balances_customer', [CustomerController::class, 'indexBalancesCustomer']);
    Route::get('/balances_customer/get-data', [CustomerController::class, 'getBalancesCustomersData']);

    // Ganancias
    Route::get('/home/get-profits', [HomeController::class, 'getProfitsDetails']);

    //List trending products
    Route::get('/home/get-trending-products', [HomeController::class, 'getListTrendingProducts']);

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/home/get-purchase-details', [HomeController::class, 'getPurchaseDetails']);
    Route::post('/home/get-sell-details', [HomeController::class, 'getSellDetails']);
    Route::get('/home/product-stock-alert', [HomeController::class, 'getProductStockAlert']);
    Route::get('/home/purchase-payment-dues', [HomeController::class, 'getPurchasePaymentDues']);
    Route::get('/home/sales-payment-dues', [HomeController::class, 'getSalesPaymentDues']);
    Route::get('/home/get-stock-expiry-products', [HomeController::class, 'getStockExpiryProducts']);
    Route::get('/home/get-total-stock', [HomeController::class, 'getTotalStock']);
    Route::post('/home/choose-month', [HomeController::class, 'chooseMonth']);
    Route::get('/home/get-weekly-sales', [HomeController::class, 'getWeekSales']);

    //Slider options
    Route::get('/carrousel', [SliderController::class, 'index']);
    Route::get('/carrousel/index', [SliderController::class, 'getSliderIndex']);
    Route::get('/image/upload', [SliderController::class, 'create']);
    Route::post('/image/store', [SliderController::class, 'store']);
    Route::get('/image/{id}/edit', [SliderController::class, 'edit']);
    Route::patch('/image/{id}/update', [SliderController::class, 'update']);
    Route::patch('/image/{id}/status', [SliderController::class, 'setImageStatus']);
    Route::get('/image/{id}/show', [SliderController::class, 'show']);
    Route::get('/image/{id}/download', [SliderController::class, 'downloadSlide']);
    Route::delete('/image/{id}/delete', [SliderController::class, 'destroy']);
    // Peak sales hours chart routes
    Route::get('/home/peak-sales-hours-month-chart', [HomeController::class, 'getPeakSalesHoursByMonthChart'])->name("getPeakSalesHoursByMonthChart");
    Route::get('/home/peak-sales-hours-chart', [HomeController::class, 'getPeakSalesHoursChart'])->name("getPeakSalesHoursChart");

    Route::get('/business/change-modal', [BusinessController::class, 'getChangeBusiness'])->name('business.getChangeBusiness');
    Route::patch('/business/change', [BusinessController::class, 'changeBusiness'])->name('business.changeBusiness');
    Route::get('/business/settings', [BusinessController::class, 'getBusinessSettings'])->name('business.getBusinessSettings');
    Route::get('business-accounting', [BusinessController::class, 'getAccountingSettings'])->name('business.getAccountingSettings');
    Route::post('/business/update', [BusinessController::class, 'postBusinessSettings'])->name('business.postBusinessSettings');
    Route::post('/business/update-accounting', [BusinessController::class, 'postAccountingSettings']);
    Route::post('/user/update', [UserController::class, 'updateProfile'])->name('user.updateProfile');
    Route::get('/user/profile', [UserController::class, 'getProfile'])->name('user.getProfile');
    Route::post('/user/update-password', [UserController::class, 'updatePassword'])->name('user.updatePassword');

    Route::resource('brands', BrandController::class);

    //DocumentType
    Route::resource('documents', DocumentTypeController::class);

/*    Route::resource('payment-account', 'PaymentAccountController');*/

    Route::resource('tax-rates', TaxRateController::class);
    Route::post('/tax_groups/get_tax_groups', [TaxGroupController::class, 'getTaxGroups']);
    Route::post('/tax_groups/get_tax_percent', [TaxGroupController::class, 'getTaxPercent']);
    Route::resource('tax_groups', TaxGroupController::class);

    Route::get('/unitgroups/getUnitGroupsData', [UnitGroupController::class, 'getUnitGroupsData']);
    Route::get('/unitgroups/groupHasLines/{id}', [UnitGroupController::class, 'groupHasLines']);
    Route::resource('unitgroups', UnitGroupController::class);
    Route::get('units/getUnits', [UnitController::class, 'getUnits']);
    Route::resource('units', UnitController::class);

    Route::get('/contacts/import', [ContactController::class, 'getImportContacts'])->name('contacts.import');
    Route::post('/contacts/import', [ContactController::class, 'postImportContacts']);
    Route::post('/contacts/check-contact-id', [ContactController::class, 'checkContactId']);
    Route::get('/contacts/customers', [ContactController::class, 'getCustomers']);
    Route::get('/contacts/suppliers', [ContactController::class, 'getSuppliers']);
    Route::get('/contacts/showSupplier/{id}', [ContactController::class, 'showSupplier']);
    Route::get('/contacts/get_tests', [ContactController::class, 'getTests']);
    Route::resource('contacts', ContactController::class);

    /** Payment Commitment */
    Route::get('/purchases/get-debt-purchases', [PurchaseController::class, 'getDebtPurchases']);
    Route::get('/payment-commitments/add-payment-commitment-row', [PaymentCommitmentController::class, 'addPaymentCommitmentRow']);
    Route::get('/payment-commitments/annul-payment-commitment/{id}', [PaymentCommitmentController::class, 'annul']);
    Route::get('/payment-commitments/print/{id}', [PaymentCommitmentController::class, 'print']);
    Route::resource('payment-commitments', PaymentCommitmentController::class);

    Route::get('categories/getCategoriesData', [CategoryController::class, 'getCategoriesData']);
    Route::post('categories/updateCatalogueId', [CategoryController::class, 'updateCatalogueId']);
    Route::resource('categories', CategoryController::class);

    Route::resource('variation-templates', VariationTemplateController::class);

    Route::get('/products/view-product-group-price/{id}', [ProductController::class, 'viewGroupPrice']);
    Route::get('/products/add-selling-prices/{id}', [ProductController::class, 'addSellingPrices']);
    Route::post('/products/save-selling-prices', [ProductController::class, 'saveSellingPrices']);
    Route::post('/products/mass-delete', [ProductController::class, 'massDestroy']);
    Route::get('/products/list', [ProductController::class, 'getProducts']);
    Route::get('/products/list_stock_transfer', [ProductController::class, 'getProductsTransferStock']);
    Route::get('/products/list_for_quotes', [ProductController::class, 'getProductsToQuote']);
    Route::get('/products/list-no-variation', [ProductController::class, 'getProductsWithoutVariations']);

    Route::post('/products/get_sub_categories', [ProductController::class, 'getSubCategories']);
    Route::post('/products/product_form_part', [ProductController::class, 'getProductVariationFormPart']);
    Route::post('/products/get_product_variation_row', [ProductController::class, 'getProductVariationRow']);
    Route::post('/products/get_variation_template', [ProductController::class, 'getVariationTemplate']);
    Route::get('/products/get_variation_value_row', [ProductController::class, 'getVariationValueRow']);
    Route::post('/products/check_product_sku', [ProductController::class, 'checkProductSku']);
    Route::get('/products/quick_add', [ProductController::class, 'quickAdd']);
    Route::post('/products/save_quick_product', [ProductController::class, 'saveQuickProduct']);

    Route::get('/products/view/{id}', [ProductController::class, 'view']);
    Route::get('/products/viewSupplier/{id}', [ProductController::class, 'viewSupplier']);
    Route::post('/products/addSupplier/{id}', [ProductController::class, 'addSupplier']);
    Route::get('/products/deleteSupplier/{id}/{supplierId}', [ProductController::class, 'deleteSupplier']);
    Route::get('/products/viewKit/{id}', [ProductController::class, 'viewKit']);
    Route::get('/products/productHasSuppliers/{id}', [ProductController::class, 'productHasSuppliers']);
    Route::get('/products/kitHasProduct/{id}', [ProductController::class, 'kitHasProduct']);
    Route::get('/products/getProductsData', [ProductController::class, 'getProductsData']);
    Route::get('/products/createProduct', [ProductController::class, 'createProduct']);
    Route::get('/products/getUnitPlan/{id}', [ProductController::class, 'getUnitplan']);
    Route::get('/products/getUnitsFromGroup/{id}', [ProductController::class, 'getUnitsFromGroup']);
    Route::get('/products/showProduct/{id}', [ProductController::class, 'showProduct']);
    Route::get('/products/showStock/{variation_id}/{location_id}', [ProductController::class, 'showStock']);
    Route::get('/products/getMeasureFromKitLines/{id}', [ProductController::class, 'getMeasureFromKitLines']);
    Route::get('/products/getKardex', [ReporterController::class, 'getKardex']);
    Route::post('/products/getKardexReport', [ReporterController::class, 'getKardexReport']);
    //Route::get('/products/runData', 'ReporterController@runData');

    // Product accounts by locations
    Route::get('/products/get-product-accounts/{product_id}', [ProductController::class, 'getProductAccountsLocation']);
    Route::post('/products/post-product-accounts/{product_id}', [ProductController::class, 'postProductAccountsLocation']);

    Route::get('products/get-services', [ProductController::class, 'getServices']);

    Route::get('/products/recalculate-product-cost/{variation_id}', [ProductController::class, 'recalculateProductCost']);
    Route::get('/products/get-recalculate-cost', [ProductController::class, 'getRecalculateCost']);
    Route::post('/products/get-recalculate-cost', [ProductController::class, 'postRecalculateCost']);

    Route::resource('products', ProductController::class);
    Route::get('/products/create', [ProductController::class, 'create'])->name('product.create');

    Route::get('/purchases/get_products', [PurchaseController::class, 'getProducts']);
    Route::get('/purchases/get_suppliers', [PurchaseController::class, 'getSuppliers']);
    Route::get('/purchases/debts-to-pay-report', [PurchaseController::class, 'debtsToPay']);
    Route::post('/purchases/debts-to-pay-report', [PurchaseController::class, 'debtsToPayReport']);
    Route::get('/purchases/suggested-purchase-report', [PurchaseController::class, 'suggestedPurchase']);
    Route::post('/purchases/suggested-purchase-report', [PurchaseController::class, 'suggestedPurchaseReport']);
    Route::get('/expenses/get_suppliers', [ExpenseController::class, 'getSuppliers']);
    Route::get('/expenses/get_categories', [ExpenseController::class, 'getCategories']);
    Route::get('/expenses/accounting-by-range/{start_date}/{end_date}', [ExpenseController::class, 'accountingByRange']);
    Route::get('/expenses/{id}/print', [ExpenseController::class, 'printExpense']);
    Route::post('/purchases/get_purchase_entry_row', [PurchaseController::class, 'getPurchaseEntryRow']);
    Route::post('/purchases/check_ref_number', [PurchaseController::class, 'checkRefNumber']);
    Route::get('/purchases/print/{id}/{type}', [PurchaseController::class, 'printInvoice']);
    Route::post('/purchases/close-book', [PurchaseController::class, 'closePurchaseBook']);
    Route::post('/purchases/is-closed', [PurchaseController::class, 'isClosed']);
    Route::get('/purchases/update-imports', [PurchaseController::class, 'updateImports']);

    Route::resource('purchases', PurchaseController::class);

    // Fixed assets and fixed asset types
    Route::resource('fixed-assets', FixedAssetController::class);
    Route::resource('fixed-asset-types', FixedAssetTypeController::class);

    Route::get('/sells/duplicate/{id}', [SellController::class, 'duplicateSell']);
    Route::get('/sells/drafts', [SellController::class, 'getDrafts']);
    Route::get('/sells/quotations', [SellController::class, 'getQuotations']);
    Route::get('/sells/draft-dt', [SellController::class, 'getDraftDatables']);

    // Update payment balance
    Route::get('/sells/update-payment-balance', [SellController::class, 'updatePaymentBalance']);

    /** Get parent correlative form final customer */
    Route::get('/sells/get-parent-correlative', [SellController::class, 'getParentCorrelative']);
    Route::get('/sells/get-trans-due-by-customer/{customer_id}', [SellController::class, 'getTransDueByCustomer']);
    Route::resource('sells', SellController::class);

    Route::get('/sells/pos/get_product_row/{variation_id}/{location_id}', [SellPosController::class, 'getProductRow']);
    Route::post('/sells/pos/get_payment_row', [SellPosController::class, 'getPaymentRow']);
    Route::get('/sells/pos/get-recent-transactions', [SellPosController::class, 'getRecentTransactions']);
    Route::get('/sells/{transaction_id}/print', [SellPosController::class, 'printInvoice'])->name('sell.printInvoice');
    Route::get('/sells/{transaction_id}/print-ccf', [SellPosController::class, 'printCCF'])->name('sell.print-ccf');
    Route::get('/sells/pos/get-product-suggestion', [SellPosController::class, 'getProductSuggestion']);
    Route::post('/pos/getCorrelatives', [SellPosController::class, 'getCorrelatives']);
    Route::get('/pos/annul/{v}', [SellPosController::class, 'annul']);
    Route::post('/pos/check-customer-patient-name', [SellPosController::class, 'checkCustomerPatientName']);
    Route::get('/sell-pos/update-fiscal-document-data', [SellPosController::class, 'updateFiscalDocumentData']);
    Route::post('/pos/check-pos-number', [SellPosController::class, 'checkPosNumber']);
    Route::get('/sell-pos/update-unit-cost-to-sell-lines/{tsl_initial?}/{tsl_final?}', [SellPosController::class, 'updateUnitCostToSellLines']);
    Route::get('/sell-pos/update-sale-price-to-sell-lines/{tsl_initial?}/{tsl_final?}', [SellPosController::class, 'updateSalePriceToSellLines']);
    Route::get('/sell-pos/update-sale-price-to-purchase-lines/{pl_initial?}/{pl_final?}', [SellPosController::class, 'updateSalePriceToPurchaseLines']);
    Route::resource('pos', SellPosController::class);
    Route::resource('terminal', PosController::class);

    Route::get('roles/verifyRoleName/{name}', [RoleController::class, 'verifyRoleName']);
    Route::get('roles/verifyDelete/{id}', [RoleController::class, 'verifyDelete']);
    Route::get('roles/getRolesData', [RoleController::class, 'getRolesData']);
    Route::get('roles/getPermissionsByRoles', [RoleController::class, 'getPermissionsByRoles']);
    Route::resource('roles', RoleController::class);
    Route::get('modules/getModulesData', [ModuleController::class, 'getModulesData']);
    Route::get('modules/getModules', [ModuleController::class, 'getModules']);
    Route::resource('modules', ModuleController::class);

    Route::get('permissions/getPermissionsData', [PermissionController::class, 'getPermissionsData']);
    Route::resource('permissions', PermissionController::class);
    Route::get('users/getUsersData', [ManageUserController::class, 'getUsersData']);
    Route::post('users/changePassword', [ManageUserController::class, 'changePassword']);
    Route::resource('users', ManageUserController::class);

    // //Rutas Employees
    Route::get('employees/getEmployeesData', [ManageEmployeesController::class, 'getEmployeesData']);
    Route::get('/employees/verify-if-exists-agent-code', [ManageEmployeesController::class, 'verifiedIfExistsAgentCode']);
    Route::resource('employees', ManageEmployeesController::class);

    // Rutas Positions
    Route::get('positions/getPositionsData', [ManagePositionsController::class, 'getPositionsData']);
    Route::resource('positions', ManagePositionsController::class);

    // Rutas Contact Mode
    Route::get('crm-contactmode/getContactModeData', [CRMContactModeController::class, 'getContactModeData']);
    Route::resource('crm-contactmode', CRMContactModeController::class);

    // Rutas Contact Reason
    Route::get('crm-contactreason/getContactReasonData', [CRMContactReasonController::class, 'getContactReasonData']);
    Route::resource('crm-contactreason', CRMContactReasonController::class);

    //Rutas Oportunities
    Route::get('oportunities/getOportunityData', [OportunityController::class, 'getOportunityData']);
    Route::resource('oportunities', OportunityController::class);
    Route::get('follow-oportunities/getFollowsByOportunity/{id}', [FollowOportunitiesController::class, 'getFollowsByOportunity']);
    Route::get('follow-oportunities/getProductsByFollowOportunity/{id}', [FollowOportunitiesController::class, 'getProductsByFollowOportunity']);
    Route::get('oportunities/convert-to-customer/{id}', [OportunityController::class, 'createCustomer']);
    Route::post('oportunities/convert-to-customer', [OportunityController::class, 'storeCustomer']);

    Route::resource('follow-oportunities', FollowOportunitiesController::class)->except('create');
    Route::get('/follow-oportunities/create/{id}', [FollowOportunitiesController::class, 'create']);
    Route::get('/follow-oportunities/showOportunities', [FollowOportunitiesController::class, 'showOportunities']);

    /** Quotes */
    Route::get('quotes/get_quotes', [QuoteController::class, 'getQuotes']);
    Route::get('quotes/addProduct/{variation_id}/{warehouse_id}/{selling_price_group_id?}', [QuoteController::class, 'addProduct']);
    Route::get('quotes/addProductNotStock/{variation_id}', [QuoteController::class, 'addProductNotStock']);
    Route::get('quotes/getQuotesData', [QuoteController::class, 'getQuotesData']);
    Route::get('quotes/getLinesByQuote/{id}', [QuoteController::class, 'getLinesByQuote']);
    Route::get('quotes/viewQuote/{id}', [QuoteController::class, 'viewQuote']);
    Route::get('quotes/excel/{id}', [QuoteController::class, 'viewExcel']);
    Route::resource('quotes', QuoteController::class);

    /** Orders */
    Route::post('orders/get_quote_lines', [OrderController::class, 'getQuoteLines']);
    Route::get('orders/get_product_row/{quote_id}/{variation_id}/{location_id}/{row_count}', [OrderController::class, 'getProductRow']);
    Route::get('orders/orders_planner', [OrderController::class, 'orderPlanner']);
    Route::post('orders/orders_planner_report', [OrderController::class, 'orderPlannerReport']);
    Route::get('orders/change_order_status/{id}/{employee_id?}', [OrderController::class, 'changeOrderStatus']);
    Route::post('orders/refresh-orders-list', [OrderController::class, 'refreshOrdersList']);
    Route::get('orders/get_in_charge_people', [OrderController::class, 'getInChargePeople']);
    Route::get('orders/get_orders', [OrderController::class, 'getOrders']);
    Route::resource('orders', OrderController::class);

    //Rutas Document Correlatives
    Route::get('correlatives/getCorrelativesData', [DocumentCorrelativeController::class, 'getCorrelativesData']);
    Route::resource('correlatives', DocumentCorrelativeController::class);

    Route::resource('group-taxes', GroupTaxController::class);

    Route::get('/barcodes/set_default/{id}', [BarcodeController::class, 'setDefault']);
    Route::resource('barcodes', BarcodeController::class);

    //Invoice schemes..
    Route::get('/invoice-schemes/set_default/{id}', [InvoiceSchemeController::class, 'setDefault']);
    Route::post('/invoice-schemes/UpdateDiscoount', [InvoiceSchemeController::class, 'UpdateDiscoount']);
    Route::resource('invoice-schemes', InvoiceSchemeController::class);

    //Print Labels
    Route::get('/labels/show', [LabelsController::class, 'show']);
    Route::get('/labels/add-product-row', [LabelsController::class, 'addProductRow']);
    Route::post('/labels/preview', [LabelsController::class, 'preview']);
    Route::get('/labels/show/barcode-setting/{has_logo?}', [LabelsController::class, 'getBarcodeSetting']);

    //Reports...
    Route::get('/reports/service-staff-report', [ReportController::class, 'getServiceStaffReport']);
    Route::get('/reports/table-report', [ReportController::class, 'getTableReport']);
    Route::get('/reports/profit-loss', [ReportController::class, 'getProfitLoss']);
    Route::get('/reports/get-opening-stock', [ReportController::class, 'getOpeningStock']);
    Route::get('/reports/purchase-sell', [ReportController::class, 'getPurchaseSell']);
    Route::get('/reports/customer-supplier', [ReportController::class, 'getCustomerSuppliers']);
    Route::get('/reports/stock-report', [ReportController::class, 'getStockReport']);
    Route::get('/reports/stock-details', [ReportController::class, 'getStockDetails']);
    Route::get('/reports/tax-report', [ReportController::class, 'getTaxReport']);
    Route::get('/reports/trending-products', [ReportController::class, 'getTrendingProducts']);
    Route::get('/reports/expense-report', [ReportController::class, 'getExpenseReport']);
    Route::get('/reports/stock-adjustment-report', [ReportController::class, 'getStockAdjustmentReport']);
    Route::get('/reports/register-report', [ReportController::class, 'getRegisterReport']);
    Route::get('/reports/sales-representative-report', [ReportController::class, 'getSalesRepresentativeReport']);
    Route::get('/reports/sales-representative-total-expense', [ReportController::class, 'getSalesRepresentativeTotalExpense']);
    Route::get('/reports/sales-representative-total-sell', [ReportController::class, 'getSalesRepresentativeTotalSell']);
    Route::get('/reports/sales-representative-total-commission', [ReportController::class, 'getSalesRepresentativeTotalCommission']);
    Route::get('/reports/stock-expiry', [ReportController::class, 'getStockExpiryReport']);
    Route::get('/reports/stock-expiry-edit-modal/{purchase_line_id}', [ReportController::class, 'getStockExpiryReportEditModal']);
    Route::post('/reports/stock-expiry-update', [ReportController::class, 'updateStockExpiryReport'])->name('updateStockExpiryReport');
    Route::get('/reports/customer-group', [ReportController::class, 'getCustomerGroup']);
    Route::get('/reports/product-purchase-report', [ReportController::class, 'getproductPurchaseReport']);
    Route::get('/reports/product-sell-report', [ReportController::class, 'getproductSellReport']);
    Route::get('/reports/product-sell-grouped-report', [ReportController::class, 'getproductSellGroupedReport']);
    Route::get('/reports/lot-report', [ReportController::class, 'getLotReport']);
    Route::get('/reports/purchase-payment-report', [ReportController::class, 'purchasePaymentReport']);
    Route::get('/reports/sell-payment-report', [ReportController::class, 'sellPaymentReport']);
    Route::get('/reports/cash_register_report', [ReporterController::class, 'getCashRegisterReport']);
    Route::get('/reports/new_cash_register_report', [ReporterController::class, 'getNewCashRegisterReport']);
    Route::get('/reports/audit-tape-report/{cashier_closure_id}', [ReporterController::class, 'getAuditTapeReport']);

    //Business Location Settings...
    Route::prefix('business-location/{location_id}')->name('location.')->group(function () {
        Route::get('settings', [LocationSettingsController::class, 'index'])->name('settings');
        Route::post('settings', [LocationSettingsController::class, 'updateSettings'])->name('settings_update');
    });

    //Business Locations...
    Route::post('business-location/check-location-id', [BusinessLocationController::class, 'checkLocationId']);
    Route::get('business-location/accounting-accounts/{location_id}', [BusinessLocationController::class, 'getAccountingAccountByLocation']);
    Route::post('business-location/accounting-accounts', [BusinessLocationController::class, 'postAccountingAccountByLocation']);
    Route::resource('business-location', BusinessLocationController::class);

    //Invoice layouts..
    Route::resource('invoice-layouts', InvoiceLayoutController::class);

    //Expense Categories...
    Route::resource('expense-categories', ExpenseCategoryController::class);

    //Expenses...
    Route::get('/expenses/get_add_expenses/{bank_transaction_id?}', [ExpenseController::class, 'getAddExpenses']);
    Route::post('/expenses/post_add_expenses', [ExpenseController::class, 'postAddExpenses']);
    Route::get('/expenses/get_add_expense', [ExpenseController::class, 'getAddExpense']);
    Route::get('/expenses/get-purchases-expenses', [ExpenseController::class, 'getPurchasesExpenses']);
    Route::get('/expenses/get_expense_details/{expense_id}', [ExpenseController::class, 'getExpenseDetails']);
    Route::resource('expenses', ExpenseController::class);

    //Transaction payments...
    Route::get('/payments/show-child-payments/{payment_id}', [TransactionPaymentController::class, 'showChildPayments']);
    Route::get('/payments/view-payment/{payment_id}/{entity_type?}', [TransactionPaymentController::class, 'viewPayment']);
    Route::get('/payments/add_payment/{transaction_id}', [TransactionPaymentController::class, 'addPayment']);
    Route::get('/payments/pay-contact-due/{contact_id}', [TransactionPaymentController::class, 'getPayContactDue']);
    Route::post('/payments/pay-contact-due', [TransactionPaymentController::class, 'postPayContactDue']);
    Route::get('payments/multi-payments', [TransactionPaymentController::class, 'multiPayments']);
    Route::post('payments/multi-payments', [TransactionPaymentController::class, 'storeMultiPayments']);
    Route::resource('payments', TransactionPaymentController::class);
    Route::delete('/payments/{id}/{entity_type?}', [TransactionPaymentController::class, 'destroy']);
    Route::get('/payments/{id}/edit/{entity_type?}', [TransactionPaymentController::class, 'edit']);

    //Printers...
    Route::resource('printers', PrinterController::class);

    Route::get('/stock-adjustments/remove-expired-stock/{purchase_line_id}', [StockAdjustmentController::class, 'removeExpiredStock']);
    Route::post('/stock-adjustments/get_product_row', [StockAdjustmentController::class, 'getProductRow']);
    Route::resource('stock-adjustments', StockAdjustmentController::class);

    Route::get('/cash-register/register-details', [CashRegisterController::class, 'getRegisterDetails']);
    Route::get('/cash-register/close-register', [CashRegisterController::class, 'getCloseRegister']);
    Route::post('/cash-register/close-register', [CashRegisterController::class, 'postCloseRegister']);
    Route::resource('cash-register', CashRegisterController::class);

    Route::resource('cash-detail', CashDetailController::class);

    // Cashier closure
    Route::get('/cashier-closure/generate-accounting-entry/{cashier_closure_id}', [CashierClosureController::class, 'createSaleAccountingEntry']);
    Route::get('/cashier-closure/get-cashier-closure/{cashier_closure_id?}', [CashierClosureController::class, 'getCashierClosure']);
    Route::post('/cashier-closure/post-cashier-closure', [CashierClosureController::class, 'postCashierClosure']);
    Route::get('/cashier-closure/get-daily-z-cut-report/{location_id}/{cashier_id?}/{cashier_closure_id?}', [CashierClosureController::class, 'dailyZCutReport']);
    Route::get('/cashier-closure/get-opening-cash-register/{cashier_closure_id}', [CashierClosureController::class, 'openingCashRegister']);
    Route::get('/cashier-closure/show-daily-z-cut/{id}', [CashierClosureController::class, 'showDailyZCut']);
    Route::get('/reports/daily-z-cut-report', [ReportController::class, 'getDailyZCutReport']);
    Route::get('/reports/recalc-cashier-closure/{id}/{location_id}', [CashierClosureController::class, 'recalcCashierClosure']);
    Route::resource('cashier-closure', CashierClosureController::class);

    //Import products
    Route::get('/import-products', [ImportProductsController::class, 'index']);
    Route::post('/import-products/check-file', [ImportProductsController::class, 'checkFile']);
    Route::post('/import-products/store', [ImportProductsController::class, 'store']);
    Route::post('/import-products/import', [ImportProductsController::class, 'import']);
    Route::get('/edit-products', [ImportProductsController::class, 'edit']);
    Route::post('/edit-products/check-file', [ImportProductsController::class, 'checkEditFile']);
    Route::post('/edit-products/import', [ImportProductsController::class, 'update']);

    //Sales Commission Agent
    Route::resource('sales-commission-agents', SalesCommissionAgentController::class);

    //Stock Transfer
    Route::get('stock-transfers/print/{id}', [StockTransferController::class, 'printInvoice']);
    Route::post('/stock-transfers/get_product_row_transfer', [StockTransferController::class, 'getProductRowTransfer']);
    Route::post('stock-transfers/receive/{id}', [StockTransferController::class, 'receive']);
    Route::get('stock-transfers/send', [StockTransferController::class, 'send']);
    Route::post('stock-transfers/count/{id}', [StockTransferController::class, 'count']);
    Route::resource('stock-transfers', StockTransferController::class);

    Route::get('/opening-stock/add/{product_id}', [OpeningStockController::class, 'add']);
    Route::post('/opening-stock/save', [OpeningStockController::class, 'save']);

    //Customer Groups
    Route::resource('customer-group', CustomerGroupController::class);

    //Import opening stock
    Route::get('/import-opening-stock', [ImportOpeningStockController::class, 'index']);
    Route::post('/import-opening-stock/store', [ImportOpeningStockController::class, 'store']);

    //Sell return
    Route::resource('sell-return', SellReturnController::class);
    Route::get('sell-return/get-product-row', [SellReturnController::class, 'getProductRow']);
    Route::get('/sell-return/print/{id}', [SellReturnController::class, 'printInvoice']);
    Route::get('/sell-return/add/{id}', [SellReturnController::class, 'add']);

    //Backup
    Route::get('backup/download/{file_name}', [BackUpController::class, 'download']);
    Route::get('backup/delete/{file_name}', [BackUpController::class, 'delete']);
    Route::resource('backup', BackUpController::class)->only('index', 'create', 'store');

    Route::resource('selling-price-group', SellingPriceGroupController::class);

    Route::resource('notification-templates', \App\Http\Controllers\NotificationTemplateController::class)->only(['index', 'store']);
    Route::get('notification/get-template/{transaction_id}/{template_for}', [NotificationController::class, 'getTemplate']);
    Route::post('notification/send', [NotificationController::class, 'send']);

    Route::get('/purchase-return/add/{id}', [PurchaseReturnController::class, 'add']);
    Route::get('/purchase-return/purchase_return_discount/{id}', [PurchaseReturnController::class, 'getPurchaseReturnDiscount']);
    Route::post('/purchase-return/purchase_return_discount/{id}', [PurchaseReturnController::class, 'postPurchaseReturnDiscount']);
    Route::resource('/purchase-return', PurchaseReturnController::class);

    //Restaurant module
    Route::prefix('mod')->group(function () {

        Route::resource('tables', Restaurant\TableController::class);
        Route::resource('modifiers', Restaurant\ModifierSetsController::class);

        //Map modifier to products
        Route::get('/product-modifiers/{id}/edit', [Restaurant\ProductModifierSetController::class, 'edit']);
        Route::post('/product-modifiers/{id}/update', [Restaurant\ProductModifierSetController::class, 'update']);
        Route::get('/product-modifiers/product-row/{product_id}', [Restaurant\ProductModifierSetController::class, 'product_row']);

        Route::get('/add-selected-modifiers', [Restaurant\ProductModifierSetController::class, 'add_selected_modifiers']);

        Route::get('/kitchen', [Restaurant\KitchenController::class, 'index']);
        Route::get('/kitchen/mark-as-cooked/{id}', [Restaurant\KitchenController::class, 'markAsCooked']);
        Route::post('/refresh-orders-list', [Restaurant\KitchenController::class, 'refreshOrdersList']);

        Route::get('/orders', [Restaurant\OrderController::class, 'index']);
        Route::get('/orders/mark-as-served/{id}', [Restaurant\OrderController::class, 'markAsServed']);
        Route::get('/data/get-pos-details', [Restaurant\DataController::class, 'getPosDetails']);
    });

    Route::get('bookings/get-todays-bookings', [Restaurant\BookingController::class, 'getTodaysBookings']);
    Route::resource('bookings', Restaurant\BookingController::class);

    //Accounting Routes
    Route::get('catalogue/verifyDeleteAccount/{id}', [CatalogueController::class, 'verifyDeleteAccount']);
    Route::get('catalogue/getAccounts', [CatalogueController::class, 'getAccounts']);
    Route::post('catalogue/get_accounts_for_select2', [CatalogueController::class, 'getAccountsForSelect2']);
    Route::get('catalogue/getAccountsParents/{account}', [CatalogueController::class, 'getAccountsParents']);
    Route::get('catalogue/verifyCode/{account}/{newCode}', [CatalogueController::class, 'verifyCode']);
    Route::get('catalogue/verifyClasif/{code}', [CatalogueController::class, 'verifyClasif']);
    Route::get('catalogue/getTree', [CatalogueController::class, 'getTree']);
    Route::get('catalogue/getInfoAccount/{id}/{date}', [CatalogueController::class, 'getInfoAccount']);
    Route::get('catalogue/getCatalogueData/{id}', [CatalogueController::class, 'getCatalogueData']);
    Route::post('catalogue/importCatalogue', [CatalogueController::class, 'importCatalogue']);
    Route::resource('catalogue', CatalogueController::class)->except(['create']);

    Route::get('entries/search/{code}', [AccountingEntrieController::class, 'search']);
    Route::get('entries/search-period', [AccountingEntrieController::class, 'searchPeriod']);
    Route::get('entries/clone-entrie/{id}', [AccountingEntrieController::class, 'cloneEntrie']);
    Route::get('entries/create-period', [AccountingEntrieController::class, 'createPeriod']);
    Route::get('entries/get-periods', [AccountingEntrieController::class, 'getPeriods']);
    Route::get('entries/getEntries/{type}/{location}/{period}', [AccountingEntrieController::class, 'getEntries']);
    Route::get('entries/getDetails/{id}', [AccountingEntrieController::class, 'getDetails']);
    Route::get('entries/getTotalEntrie/{id}', [AccountingEntrieController::class, 'getTotalEntrie']);
    Route::get('entries/getEntrieDetails/{id}', [AccountingEntrieController::class, 'getEntrieDetails']);
    Route::get('entries/getEntrieDetailsDebe/{id}', [AccountingEntrieController::class, 'getEntrieDetailsDebe']);
    Route::get('entries/getEntrieDetailsHaber/{id}', [AccountingEntrieController::class, 'getEntrieDetailsHaber']);
    Route::post('entries/editEntrie', [AccountingEntrieController::class, 'editEntrie']);
    Route::post('entries/allentries', [ReporterController::class, 'allEntries'])->name("entries.allentries");
    Route::get('entries/singleEntrie/{id}/{type}', [ReporterController::class, 'singleEntrie']);
    Route::get('entries/searchBankTransaction/{id}', [AccountingEntrieController::class, 'searchBankTransaction']);
    Route::get('entries/getNumberEntrie/{date}', [AccountingEntrieController::class, 'getNumberEntrie']);
    Route::get('entries/getCorrelativeEntrie/{date}', [AccountingEntrieController::class, 'getCorrelativeEntrie']);
    Route::get('entries/changeStatus/{id}/{number}', [AccountingEntrieController::class, 'changeStatus']);
    Route::get('entries/getResultCreditorAccounts/{date}', [AccountingEntrieController::class, 'getResultCreditorAccounts']);
    Route::get('entries/getResultDebtorAccounts/{date}', [AccountingEntrieController::class, 'getResultDebtorAccounts']);
    Route::get('entries/getProfitAndLossAccount', [AccountingEntrieController::class, 'getProfitAndLossAccount']);

    Route::get('entries/getApertureDebitAccounts/{date}', [AccountingEntrieController::class, 'getApertureDebitAccounts']);
    Route::get('entries/getApertureCreditAccounts/{date}', [AccountingEntrieController::class, 'getApertureCreditAccounts']);

    Route::get('/entries/assign-short-name', [AccountingEntrieController::class, 'assignShortName']);
    Route::get('entries/setNumeration/{mode}/{period}', [AccountingEntrieController::class, 'setNumeration']);
    Route::resource('entries', AccountingEntrieController::class)->except(['create']);

    Route::get('auxiliars/getLedger/{id}', [ReporterController::class, 'getLedger']);
    Route::get('auxiliars/getAuxiliarDetail/{id}/{from}/{to}', [ReporterController::class, 'getAuxiliarDetail']);
    Route::post('auxiliars/getAllAuxiliarReport', [ReporterController::class, 'getAllAuxiliarReport']);
    Route::get('auxiliars/getAuxiliarDetails', [ReporterController::class, 'getAuxiliarDetails']);

    Route::get('auxiliars/getAuxiliarRange/{start}/{end}', [ReporterController::class, 'getAuxiliarRange']);
    Route::get('auxiliars', [ReporterController::class, 'auxiliars']);

    Route::get('ledgers/getHigherDetails/{id}/{from}/{to}', [ReporterController::class, 'getHigherDetails']);
    Route::get('ledgers/getHigherAccounts', [ReporterController::class, 'getHigherAccounts']);
    Route::post('ledgers/getHigherReport', [ReporterController::class, 'getHigherReport']);
    Route::get('ledgers/getLedgerRange/{start}/{end}', [ReporterController::class, 'getLedgerRange']);
    Route::get('ledgers', [ReporterController::class, 'getHighers']);
    Route::get('/journal-book', [ReporterController::class, 'getGralJournalBook']);
    Route::post('/post-journal-book', [ReporterController::class, 'postGralJournalBook']);

    Route::post('balances/getBalances', [ReporterController::class, 'getBalanceReport']);
    Route::post('balances/getBalanceComprobation', [ReporterController::class, 'getBalanceComprobation']);
    Route::get('balances/getSignatures/{id}', [ReporterController::class, 'getSignatures']);
    Route::post('balances/setSignatures', [ReporterController::class, 'setSignatures']);
    Route::get('balances', [ReporterController::class, 'getBalances']);
    Route::post('iva_books/getIvaBooksReport', [ReporterController::class, 'getIvaBooksReport']);
    Route::get('iva_books', [ReporterController::class, 'getIvaBooks']);

    Route::post('result/getResultStatus', [ReporterController::class, 'getResultStatus']);

    Route::get('banks/getBanksData', [BankController::class, 'getBanksData']);
    Route::get('banks/getBanks', [BankController::class, 'getBanks']);
    Route::get('/banks/get-bank-accounts/{bank_id}', [BankController::class, 'getBankAccounts']);
    Route::get('banks/getCheckNumber/{id}', [BankController::class, 'getCheckNumber']);
    Route::resource('banks', BankController::class);

    Route::get('bank-accounts/getBankAccountsData', [BankAccountController::class, 'getBankAccountsData']);
    Route::get('bank-accounts/getBankAccounts', [BankAccountController::class, 'getBankAccounts']);
    Route::get('bank-accounts/getBankAccountsById/{id}', [BankAccountController::class, 'getBankAccountsById']);
    Route::resource('bank-accounts', BankAccountController::class);

    Route::get('bank-transactions/getBankTransactionsData/{period}/{type}/{bank}', [BankTransactionController::class, 'getBankTransactionsData']);
    Route::get('bank-transactions/getConfiguration', [BankTransactionController::class, 'getConfiguration']);
    Route::get('bank-transactions/getDateValidation/{type}/{checkbook}/{date}', [BankTransactionController::class, 'getDateValidation']);
    Route::get('bank-transactions/getDateByPeriod/{id}', [BankTransactionController::class, 'getDateByPeriod']);
    Route::get('bank-transactions/validateDate/{id}/{dat}', [BankTransactionController::class, 'validateDate']);
    Route::get('bank-transactions/cancelCheck/{id}', [BankTransactionController::class, 'cancelCheck']);
    Route::post('bank-transactions/getBankTransactions', [ReporterController::class, 'getBankTransactions']);
    Route::get('bank-transactions/printCheck/{id}/{print}', [BankTransactionController::class, 'printCheck']);
    Route::get('bank-transactions/printTransfer/{id}', [BankTransactionController::class, 'printTransferFormat']);

    Route::resource('bank-transactions', BankTransactionController::class);

    Route::get('fiscal-years/getFiscalYearsData', [FiscalYearController::class, 'getFiscalYearsData']);
    Route::get('fiscal-years/getYears', [FiscalYearController::class, 'getYears']);
    Route::resource('fiscal-years', FiscalYearController::class);

    Route::get('accounting-periods/getPeriodsData', [AccountingPeriodController::class, 'getPeriodsData']);
    Route::get('accounting-periods/getPeriodStatus/{id}', [AccountingPeriodController::class, 'getPeriodStatus']);
    Route::resource('accounting-periods', AccountingPeriodController::class);

    Route::get('type-entries/getTypesData', [TypeEntrieController::class, 'getTypesData']);
    Route::get('type-entries/getTypes', [TypeEntrieController::class, 'getTypes']);
    Route::resource('type-entries', TypeEntrieController::class);

    Route::get('type-bank-transactions/getTypeBankTransactionsData', [TypeBankTransactionController::class, 'getTypeBankTransactionsData']);
    Route::get('type-bank-transactions/getTypeBankTransactions', [TypeBankTransactionController::class, 'getTypeBankTransactions']);
    Route::get('type-bank-transactions/get_if_enable_checkbook/{bank_transaction_id}', [TypeBankTransactionController::class, 'getIfEnableCheckbook']);
    Route::resource('type-bank-transactions', TypeBankTransactionController::class);

    Route::get('bank-checkbooks/getBankCheckbooksData', [BankCheckbookController::class, 'getBankCheckbooksData']);
    Route::get('bank-checkbooks/getBankCheckbooks/{id}', [BankCheckbookController::class, 'getBankCheckbooks']);
    Route::get('bank-checkbooks/validateNumber/{id}/{number}', [BankCheckbookController::class, 'validateNumber']);
    Route::get('bank-checkbooks/validateRange/{id}/{number}', [BankCheckbookController::class, 'validateRange']);
    Route::resource('bank-checkbooks', BankCheckbookController::class);

    //RRHH Routes
    //Routes settings
    Route::get('rrhh-setting', [RrhhSettingController::class, 'index']);
    Route::post('rrhh-setting', [RrhhSettingController::class, 'store']);

    //Routes Employees
    Route::resource('rrhh-employees', EmployeesController::class);
    Route::get('rrhh-employees-getEmployees', [EmployeesController::class, 'getEmployees']);
    Route::get('rrhh-employees-getPhoto/{id}', [EmployeesController::class, 'getPhoto']);
    Route::get('rrhh-employees-downloadCv/{id}', [EmployeesController::class, 'downloadCv']);
    Route::post('rrhh-employees/uploadPhoto', [EmployeesController::class, 'uploadPhoto']);
    Route::get('/rrhh-employees/verified_document/{type}/{value}/{id?}', [EmployeesController::class, 'verifiedIfExistsDocument']);

    //Routes import employees
    Route::get('/rrhh-import-employees', [RrhhImportEmployeesController::class, 'create']);
    Route::post('/rrhh-import-employees/check-file', [RrhhImportEmployeesController::class, 'checkFile'])->name('rrhh-import-employees.checkFile');
    Route::post('/rrhh-import-employees/import', [RrhhImportEmployeesController::class, 'import'])->name('rrhh-import-employees.import');
    Route::get('/rrhh-edit-employees', [RrhhImportEmployeesController::class, 'edit']);
    Route::post('/rrhh-edit-employees/check-file', [RrhhImportEmployeesController::class, 'checkEditFile']);
    Route::post('/rrhh-edit-employees/import', [RrhhImportEmployeesController::class, 'update']);

    //Routes assistances by employees
    Route::resource('rrhh-assistances', AssistanceEmployeeController::class);
    Route::get('rrhh-assistances-getAssistances', [AssistanceEmployeeController::class, 'getAssistances']);
    Route::post('/rrhh-assistances-report', [AssistanceEmployeeController::class, 'postAssistancesReport']);
    Route::get('rrhh-assistances-show/{id}', [AssistanceEmployeeController::class, 'show']);
    Route::get('rrhh-assistances-viewImage/{id}', [AssistanceEmployeeController::class, 'viewImage']);

    //Routes documents by employees
    Route::get('rrhh-documents-getByEmployee/{id}', [RrhhDocumentsController::class, 'getByEmployee']);
    Route::get('rrhh-documents-createDocument/{id}', [RrhhDocumentsController::class, 'createDocument']);
    Route::get('rrhh-documents-files/{id}/{employee_id}', [RrhhDocumentsController::class, 'files']);
    Route::get('rrhh-documents-viewFile/{id}', [RrhhDocumentsController::class, 'viewFile']);
    Route::post('rrhh-documents-updateDocument', [RrhhDocumentsController::class, 'updateDocument']);
    Route::resource('rrhh-documents', RrhhDocumentsController::class)->except(['create', 'show', 'update']);

    //Routes contract by employees
    Route::get('rrhh-contracts-getByEmployee/{id}', [RrhhContractController::class, 'getByEmployee']);
    Route::get('rrhh-contracts-create/{id}', [RrhhContractController::class, 'create']);
    Route::get('rrhh-contracts-generate/{id}', [RrhhContractController::class, 'generate']);
    Route::post('rrhh-contracts-update', [RrhhContractController::class, 'updateContract']);
    Route::post('rrhh-contracts-finish/{id}', [RrhhContractController::class, 'finishContract']);
    Route::get('rrhh-contracts-show/{id}/{employee_id}', [RrhhContractController::class, 'show']);
    Route::get('rrhh-contracts-createDocument/{id}/{employee_id}', [RrhhContractController::class, 'createDocument']);
    Route::post('rrhh-contracts-storeDocument', [RrhhContractController::class, 'storeDocument']);
    Route::resource('rrhh-contracts', RrhhContractController::class)->only(['store', 'show']);
    Route::get('rrhh-contracts-masive', [RrhhContractController::class, 'createMassive']);
    Route::post('rrhh-contracts-masive-1', [RrhhContractController::class, 'storeMassive']);

    //Routes economic dependencies by employees
    Route::resource('rrhh-economic-dependence', RrhhEconomicDependenceController::class)->except(['index', 'create', 'show', 'update']);
    Route::get('rrhh-economic-dependence-getByEmployee/{id}', [RrhhEconomicDependenceController::class, 'getByEmployee']);
    Route::get('rrhh-economic-dependence-create/{id}', [RrhhEconomicDependenceController::class, 'createEconomicDependence']);
    Route::post('rrhh-economic-dependence-update', [RrhhEconomicDependenceController::class, 'updateEconomicDependence']);

    //Routes studies by employees
    Route::resource('rrhh-study', RrhhStudyController::class)->except(['index', 'create', 'show', 'update']);
    Route::get('rrhh-study-getByEmployee/{id}', [RrhhStudyController::class, 'getByEmployee']);
    Route::get('rrhh-study-create/{id}', [RrhhStudyController::class, 'createStudy']);
    Route::post('rrhh-study-update', [RrhhStudyController::class, 'updateStudy']);

    //Routes personnel action by employees
    Route::resource('rrhh-personnel-action', RrhhPersonnelActionController::class)->except(['create', 'show', 'update']);
    Route::get('rrhh-personnel-action-getByEmployee/{id}', [RrhhPersonnelActionController::class, 'getByEmployee']);
    Route::get('rrhh-personnel-action-create/{id}', [RrhhPersonnelActionController::class, 'createPersonnelAction']);
    Route::get('rrhh-personnel-action-masive', [RrhhPersonnelActionController::class, 'createMasive']);
    Route::post('rrhh-personnel-action-masive', [RrhhPersonnelActionController::class, 'storeMasive']);
    Route::get('rrhh-personnel-action-view/{id}', [RrhhPersonnelActionController::class, 'viewPersonnelAction']);
    Route::post('rrhh-personnel-action-update', [RrhhPersonnelActionController::class, 'updatePersonnelAction']);
    Route::get('rrhh-personnel-action', [RrhhPersonnelActionController::class, 'index']);
    Route::get('rrhh-personnel-action-getByAuthorizer', [RrhhPersonnelActionController::class, 'getByAuthorizer']);
    Route::post('rrhh-personnel-action/{id}/confirmAuthorization', [RrhhPersonnelActionController::class, 'confirmAuthorization']);
    Route::get('/rrhh-personnel-action/{id}/authorization-report', [RrhhPersonnelActionController::class, 'authorizationReport'])->name('rrhh-personnel-action.authorizationReport');
    Route::get('rrhh-personnel-action-createDocument/{id}', [RrhhPersonnelActionController::class, 'createDocument']);
    Route::post('rrhh-personnel-action-storeDocument', [RrhhPersonnelActionController::class, 'storeDocument']);
    Route::get('rrhh-personnel-action-files/{id}', [RrhhPersonnelActionController::class, 'files']);
    Route::get('rrhh-personnel-action-viewFile/{id}', [RrhhPersonnelActionController::class, 'viewFile']);

    //Routes absence inability by employees
    Route::resource('rrhh-absence-inability', RrhhAbsenceInabilityController::class)->except(['index', 'create', 'show', 'update']);
    Route::get('rrhh-absence-inability-getByEmployee/{id}', [RrhhAbsenceInabilityController::class, 'getByEmployee']);
    Route::get('rrhh-absence-inability-create/{id}', [RrhhAbsenceInabilityController::class, 'createAbsenceInability']);
    Route::post('rrhh-absence-inability-update', [RrhhAbsenceInabilityController::class, 'updateAbsenceInability']);

    //Routes income and discount by employees
    Route::resource('rrhh-income-discount', RrhhIncomeDiscountController::class)->except(['index', 'create', 'update']);
    Route::get('rrhh-income-discount-getByEmployee/{id}', [RrhhIncomeDiscountController::class, 'getByEmployee']);
    Route::get('rrhh-income-discount-create/{id}', [RrhhIncomeDiscountController::class, 'createIncomeDiscount']);
    Route::post('rrhh-income-discount-update', [RrhhIncomeDiscountController::class, 'updateIncomeDiscount']);

    //Routes catalogos RRHH
    Route::resource('rrhh-catalogues', \App\Http\Controllers\RrhhHeaderController::class);
    Route::resource('rrhh-catalogues-data', RrhhDataController::class);
    Route::get('rrhh/getCataloguesData/{id}', [RrhhDataController::class, 'getCatalogueData']);
    Route::get('rrhh/create-item/{id}', [RrhhDataController::class, 'createItem']);
    Route::get('rrhh/edit-item/{id}', [RrhhDataController::class, 'editItem']);

    Route::resource('rrhh-type-wages', RrhhTypeWageController::class);
    Route::get('rrhh/getTypeWagesData', [RrhhTypeWageController::class, 'getTypeWagesData']);

    Route::resource('rrhh-types-income-discounts', RrhhTypeIncomeDiscountController::class);
    Route::get('rrhh/getTypeIncomeDiscountData', [RrhhTypeIncomeDiscountController::class, 'getTypeIncomeDiscountData']);

    Route::resource('rrhh-type-personnel-action', RrhhTypePersonnelActionController::class);
    Route::get('rrhh/getTypePersonnelActionData', [RrhhTypePersonnelActionController::class, 'getTypePersonnelActionData']);
    Route::post('rrhh-type-personnel-action/{id}', [RrhhTypePersonnelActionController::class, 'update']);

    Route::resource('/rrhh-catalogues/type-contract', RrhhTypeContractController::class);
    Route::get('/rrhh/getTypes', [RrhhTypeContractController::class, 'getTypes']);

    Route::resource('/rrhh-catalogues/salarial-constance', RrhhSalarialConstanceController::class);
    Route::get('/rrhh/getSalarialConstances', [RrhhSalarialConstanceController::class, 'getSalarialConstances']);
    //Route::get('/salarial-constance', 'RrhhSalarialConstanceController@salarialConstances');
    Route::get('/salarial-constance/{id}/download', [RrhhSalarialConstanceController::class, 'download']);

    // Route Module Payroll
    //Routes Payroll
    Route::resource('payroll', PayrollController::class);
    Route::get('payroll-getPaymentPeriod/{id}', [PayrollController::class, 'getPaymentPeriod']);
    Route::get('payroll-getPayrollType/{id}', [PayrollController::class, 'getPayrollType']);
    Route::get('payroll-getPayrolls', [PayrollController::class, 'getPayrolls']);
    Route::post('payroll/{id}/approve', [PayrollController::class, 'approve']);
    Route::post('payroll/{id}/pay', [PayrollController::class, 'pay']);
    Route::post('payroll/{id}/paymentSlips', [PayrollController::class, 'paymentSlips']);
    Route::get('/payroll/{id}/generatePaymentSlips', [PayrollController::class, 'generatePaymentSlips']);
    Route::post('payroll/{id}/paymentFiles', [PayrollController::class, 'paymentFiles']);
    Route::get('/payroll/{id}/generatePaymentFiles', [PayrollController::class, 'generatePaymentFiles']);
    Route::post('payroll/{id}/recalculate', [PayrollController::class, 'recalculate']);
    Route::get('payroll-getPayrollDetail/{id}', [PayrollController::class, 'getPayrollDetail']);
    Route::get('payroll/{id}/exportPayroll', [PayrollController::class, 'exportPayroll']);

    //Report
    Route::get('payroll-annual-summary', [PayrollReportController::class, 'annualSummary']);
    Route::post('/payroll-annual-summary/export', [PayrollReportController::class, 'generateAnnualSummary']);

    //Route catalogues
    Route::resource('institution-law', InstitutionLawController::class);
    Route::put('institution-law/{id}/edit', [InstitutionLawController::class, 'update']);
    Route::get('institution-law-getInstitutionLaws', [InstitutionLawController::class, 'getInstitutionLaws']);

    Route::resource('law-discount', LawDiscountController::class);
    Route::put('law-discount/{id}/edit', [InstitutionLawController::class, 'update']);
    Route::get('law-discount-getLawDiscounts', [LawDiscountController::class, 'getLawDiscounts']);

    Route::resource('bonus-calculation', BonusCalculationController::class);
    Route::put('bonus-calculation/{id}/edit', [InstitutionLawController::class, 'update']);
    Route::get('bonus-calculation-getBonusCalculations', [BonusCalculationController::class, 'getBonusCalculations']);

    /** Route implementations */
    Route::get('implementations', [ImplementationController::class, 'index']);
    Route::post('implementations', [ImplementationController::class, 'store']);

    /** Cost Centers */
    Route::get('cost_centers/get_main_accounts/{cost_center_id}', [CostCenterController::class, 'getMainAccounts']);
    Route::post('cost_centers/post_main_accounts/{cost_center_id}', [CostCenterController::class, 'postMainAccounts']);
    Route::get('cost_centers/get_operation_accounts/{cost_center_id}', [CostCenterController::class, 'getOperationAccounts']);
    Route::post('cost_centers/post_operation_accounts/{cost_center_id}', [CostCenterController::class, 'postOperationAccounts']);
    Route::resource('cost_centers', CostCenterController::class);

    Route::get('geography/getCountriesData', [CountryController::class, 'getCountriesData']);
    Route::get('geography/getCountries', [CountryController::class, 'getCountries']);
    Route::post('geography/update/{id}', [CountryController::class, 'updateCountry']);
    Route::resource('geography', CountryController::class);

    Route::get('zones/getZonesData', [ZoneController::class, 'getZonesData']);
    Route::get('zones/getZones', [ZoneController::class, 'getZones']);
    Route::resource('zones', ZoneController::class);

    Route::get('states/getStatesData', [StateController::class, 'getStatesData']);
    Route::get('states/getStates', [StateController::class, 'getStates']);
    Route::get('states/getStatesByCountry/{id}', [StateController::class, 'getStatesByCountry']);
    Route::resource('states', StateController::class);

    Route::get('cities/getCitiesData', [CityController::class, 'getCitiesData']);
    Route::get('cities/changeStatus/{id}', [CityController::class, 'changeStatus']);
    Route::get('cities/getCitiesByState/{id}', [CityController::class, 'getCitiesByState']);
    Route::get('cities/getCitiesByStateSelect2/{id?}', [CityController::class, 'getCitiesByStateSelect2']);
    Route::resource('cities', CityController::class);

    Route::resource('crm', \App\Http\Controllers\CRMController::class);

    Route::get('portfolios/getPortfoliosData', [CustomerPortfolioController::class, 'getPortfoliosData']);
    Route::resource('portfolios', CustomerPortfolioController::class);

    Route::resource('cashiers', \App\Http\Controllers\CashierController::class);

    Route::get('claims/getClaimTypesData', [ClaimTypeController::class, 'getClaimTypesData']);
    Route::get('claims/getClaimTypes', [ClaimTypeController::class, 'getClaimTypes']);
    Route::get('claims/getClaimsData', [ClaimController::class, 'getClaimsData']);
    Route::get('claims/getClaimCorrelative', [ClaimController::class, 'getClaimCorrelative']);
    Route::get('claims/getNexState/{state_id}/{claim_id}', [ClaimController::class, 'getNexState']);
    Route::get('claims/getUsersByClaimType/{id}', [ClaimController::class, 'getUsersByClaimType']);
    Route::resource('claims', ClaimController::class);
    Route::get('claim-types/getClaimTypeCorrelative', [ClaimTypeController::class, 'getClaimTypeCorrelative']);
    Route::get('claim-types/getUserById/{id}', [ClaimTypeController::class, 'getUserById']);
    Route::get('claim-types/getUsersByClaimType/{id}', [ClaimTypeController::class, 'getUsersByClaimType']);
    Route::get('claim-types/getSuggestedClosingDate/{date}/{days}', [ClaimTypeController::class, 'getSuggestedClosingDate']);

    Route::resource('claim-types', ClaimTypeController::class);

    Route::get('sdocs/getSDocsData', [SupportDocumentsController::class, 'getSDocsData']);
    Route::resource('sdocs', SupportDocumentsController::class);

    Route::get('manage-credit-requests/getCreditsData', [ManageCreditRequestController::class, 'getCreditsData']);
    Route::post('manage-credit-requests/edit', [ManageCreditRequestController::class, 'editCredit']);

    Route::get('manage-credit-requests/view/{id}', [ManageCreditRequestController::class, 'viewCredit']);
    Route::resource('manage-credit-requests', ManageCreditRequestController::class);

    // Customers
    Route::get('/customers-import', [CustomerController::class, 'getImportCustomers'])->name('customers.import');
    Route::post('/customers-import', [CustomerController::class, 'postImportCustomers']);
    Route::get('customers/get_customers', [CustomerController::class, 'getCustomers']);
    Route::get('customers/getCustomersData', [CustomerController::class, 'getCustomersData']);
    Route::get('customers/get_add_customer/{customer_name?}', [CustomerController::class, 'getAddCustomer']);
    Route::get('customers/get_contacts/{id}', [CustomerController::class, 'getContacts']);
    Route::post('/customers/store_contacts/{id}', [CustomerController::class, 'addContact']);
    Route::post('/customers/export', [CustomerController::class, 'export']);
    Route::resource('customers', CustomerController::class);
    Route::get('customers/edit/{id}', [CustomerController::class, 'edit']);
    Route::post('customers/update/{id}', [CustomerController::class, 'update']);

    Route::get('follow-customers/getFollowsByCustomer/{id}', [FollowCustomerController::class, 'getFollowsByCustomer']);
    Route::get('follow-customers/getProductsByFollowCustomer/{id}', [FollowCustomerController::class, 'getProductsByFollowCustomer']);
    Route::resource('follow-customers', FollowCustomerController::class);

    //Status Claims Routes
    Route::get('status-claims/getStatusClaimsData', [StatusClaimController::class, 'getStatusClaimsData']);
    Route::get('status-claims/getStatusClaimCorrelative', [StatusClaimController::class, 'getStatusClaimCorrelative']);
    Route::get('status-claims/getStatusClaims', [StatusClaimController::class, 'getStatusClaims']);
    Route::resource('status-claims', StatusClaimController::class);

    // Sale Price Scales Routes
    Route::resource('sale_price_scale', \App\Http\Controllers\SalePriceScaleController::class);
    Route::get('/get_sale_price_scale/{id}', [ProductController::class, 'getSalePriceScale']);
    Route::post('/store_sale_price_scale', [ProductController::class, 'storeSalePriceScale']);
    Route::delete('/destroy_sale_price_scale/{id}', [ProductController::class, 'destroySalePriceScale']);
    Route::post('/edit_sale_price_scale/{id}', [ProductController::class, 'editSalePriceScale']);

    // Warehouses Routes
    Route::get('/warehouses/get_warehouses/{id}', [WarehouseController::class, 'getWarehouseByLocation']);
    Route::get('/warehouses/get-location/{warehouse_id}', [WarehouseController::class, 'getLocation']);
    Route::get('/warehouses/create-permissions', [WarehouseController::class, 'createPermissions']);
    Route::resource('warehouses', WarehouseController::class);

    //Credit Documents
    Route::get('credit-documents/getCDocsData', [CreditDocumentsController::class, 'getCDocsData']);
    Route::get('credit-documents/getTransactionByInvoice/{invoice}/{doctype}', [CreditDocumentsController::class, 'getTransactionByInvoice']);
    Route::get('credit-documents/reception/{id}', [CreditDocumentsController::class, 'reception']);
    Route::get('credit-documents/custodian/{id}', [CreditDocumentsController::class, 'custodian']);
    Route::post('credit-documents/saveReception/{id}', [CreditDocumentsController::class, 'saveReception']);
    Route::post('credit-documents/saveCustodian/{id}', [CreditDocumentsController::class, 'saveCustodian']);
    Route::resource('credit-documents', CreditDocumentsController::class);

    Route::post('print_pos', [ReporterController::class, 'printPOS']);
    Route::get('print_test', [ReportController::class, 'printTest']);

    // Movement Types Routes
    Route::resource('movement-types', MovementTypeController::class);

    // Payment terms
    Route::get('/payment-terms/get-payment-terms', [PaymentTermController::class, 'getPaymentTerms']);
    Route::resource('/payment-terms', PaymentTermController::class);

    // Sales book to final consumer
    Route::get('book-final-consumer', [ReporterController::class, 'viewBookFinalConsumer']);
    Route::post('book-final-consumer/get-report', [ReporterController::class, 'getBookFinalConsumer']);

    // Sales book to taxpayer
    Route::get('book-taxpayer', [ReporterController::class, 'viewBookTaxpayer']);
    Route::post('book-taxpayer/get-report', [ReporterController::class, 'getBookTaxpayer']);

    // Sales purchases book
    Route::get('purchases-book', [ReporterController::class, 'viewPurchasesBook']);
    Route::post('purchases-book/get-report', [ReporterController::class, 'getPurchasesBook']);

    // Purchases import routes
    Route::get('/purchases-import', [PurchaseController::class, 'getImportPurchases'])->name('purchases.import');
    Route::post('/purchases-import', [PurchaseController::class, 'postImportPurchases']);
    Route::post('/purchases-import/process-purchase', [PurchaseController::class, 'importPurchases']);

    // Sales and adjustments report routes
    Route::get('/reports/sales-n-adjustments-report', [ReportController::class, 'getSalesAndAdjustmentsReport']);
    Route::post('/reports/sales-n-adjustments-report', [ReportController::class, 'postSalesAndAdjustmentsReport']);

    // Correlative validation route
    Route::get('/pos/validateCorrelative/{location}/{document}/{correlative}/{transaction_id?}', [SellPosController::class, 'validateCorrelative']);

    // Generate accounting entry
    Route::get('/generate-accounting-entry-by-transaction/{transaction_id}', [SellPosController::class, 'createTransAccountingEntry']);

    // Cost of sale detail report routes
    Route::get('/product-reports/warehouse-closure-report', [ReportController::class, 'getCostOfSaleDetailReport']);
    Route::post('/product-reports/warehouse-closure-report', [ReportController::class, 'postCostOfSaleDetailReport']);

    // Kardex Routes
    Route::get('/kardex/get-recalculate-cost', [KardexController::class, 'getRecalculateCost']);
    Route::get('/kardex/recalculate-kardex-cost/{variation_id}', [KardexController::class, 'recalculateProductCost']);
    Route::get('/kardex/check-cost-balance', [KardexController::class, 'checkCostBalance']);
    Route::resource('kardex', KardexController::class);
    Route::get('/kardex/refresh-balance/{warehouse_id}/{variation_id}', [KardexController::class, 'refreshBalance']);
    Route::get('register-kardex', [KardexController::class, 'getRegisterKardex']);
    Route::post('post-register-kardex', [KardexController::class, 'postRegisterKardex']);
    Route::get('/kardex/products/list', [KardexController::class, 'getProducts']);
    Route::post('/kardex/report', [KardexController::class, 'generateReport']);
    Route::get('/kardex/print_invoice/{transaction_id}/{kardex_id}', [KardexController::class, 'printInvoicePurchase']);
    Route::get('/kardex/update_cost/{variation_id}', [KardexController::class, 'updateCost']);
    Route::get('/refresh-all-balances', [KardexController::class, 'refreshAllBalances']);
    Route::post('/kardex/generate-product-kardex', [KardexController::class, 'generateProductKardex']);
    Route::get('/kardex/fix-repeated-transfer/{transfer_id}/{warehouse_id}/{param_variation_id?}', [KardexController::class, 'fixRepeatedTransfer']);
    Route::get('/kardexs/compare-stock-kardex', [KardexController::class, 'compareStockAndKardex']);
    Route::get('/kardexs/compare-stock-kardex-strict', [KardexController::class, 'compareStockAndKardexStrict']);
    Route::get('/kardexs/compare-and-generate-product-kardex/{warehouse_id?}/{variation_initial?}/{variation_final?}', [KardexController::class, 'compareAndGenerateProductKardex']);
    Route::get('/kardexs/compare-and-refresh-balance/{warehouse_id?}/{variation_initial?}/{variation_final?}', [KardexController::class, 'compareAndRefreshBalance']);
    Route::get('/kardexs/fix-variation-location-detail/{warehouse_id?}/{variation_initial?}/{variation_final?}', [KardexController::class, 'fixVariationLocationDetail']);
    Route::get('/kardexs/fix-stock-adjustments/{variation_id}/{location_id}/{warehouse_id}', [KardexController::class, 'fixStockAdjustments']);
    Route::get('/kardexs/fix-kit-products/{warehouse_id?}', [KardexController::class, 'fixKitProducts']);
    Route::get('/kardexs/compare-sell-and-purchase-lines/{warehouse_id}', [KardexController::class, 'compareSellAndPurchaseLines']);
    Route::get('/kardexs/fix-purchase-lines/{sell_transfer_id}/{no_massive?}', [KardexController::class, 'fixPurchaseLines']);

    // Stock report routes
    Route::get('/product-reports/show-stock-report', [ReportController::class, 'showStockReport']);
    Route::post('/reports/stock-report', [ReportController::class, 'postStockReport']);
    Route::get('/reports/get_suppliers', [ReportController::class, 'getSuppliers']);

    /** Daily inventory report */
    Route::get('/product-reports/input-output-report', [ReportController::class, 'getInputOutputReport']);
    Route::post('/product-reports/input-output-report', [ReportController::class, 'postInputOutputReport']);

    /** List price report */
    Route::get('/product-reports/list-price-report', [ReportController::class, 'getListPriceReport']);
    Route::post('/product-reports/list-price-report', [ReportController::class, 'postListPriceReport']);

    /** Dispatched products report */
    Route::get('/reports/dispatched-products-count', [ReportController::class, 'getDispatchedProductsCount']);
    Route::get('/reports/dispatched-products-report', [ReportController::class, 'getDispatchedProducts']);
    Route::post('/reports/dispatched-products-report', [ReportController::class, 'postDispatchedProducts'])->name("sales.postDispatchedProducts");

    /** Connect report for Disproci */
    Route::get('/reports/connect-report', [ReportController::class, 'getConnectReport']);
    Route::post('/reports/connect-report', [ReportController::class, 'postConnectReport'])->name("sales.postConnectReport");

    /** Sale cost by product report */
    Route::get('/reports/sale-cost-product-report', [ReportController::class, 'saleCostProductReport']);
    Route::post('/reports/sale-cost-product-report', [ReportController::class, 'getSaleCostProductReport'])->name("sales.getSaleCostProductReport");

    /** Price List report for Nuves/AGL */
    Route::get('/reports/price-lists-report', [ReportController::class, 'getPriceListsReport']);
    Route::post('/reports/post-price-lists-report', [ReportController::class, 'postPriceListsReport'])->name("postPriceListsReport");

    Route::get('/debs-pay', [PurchaseController::class, 'showDebsToPay']);

    Route::post('/tax_groups/get_tax_groups', [TaxGroupController::class, 'getTaxGroups']);
    Route::post('/tax_groups/get_taxes', [TaxGroupController::class, 'getTaxes']);

    // Routes to create permissions
    Route::get('permissions-no-exist', [PermissionController::class, 'getPermissionsNoExist']);
    Route::get('permissions-no-exist/register', [PermissionController::class, 'getRegisterPermissions']);

    // Stock adjustment report routes
    Route::get('stock-adjustments/print/{id}', [StockAdjustmentController::class, 'printInvoice']);
    Route::get('stock-adjustments/create/{ref_count}/{type}/get-reference', [StockAdjustmentController::class, 'getReference']);

    //Report remission nte
    Route::get('/reports/remission_note/{id}', [StockTransferController::class, 'getRemissionNote'])->name('remission_note');
    //Edit payment method
    Route::get('/sell/payment_method/{id}', [TransactionPaymentController::class, 'editPaymentMethod']);

    // Physical inventory routes
    Route::resource('physical-inventory', PhysicalInventoryController::class);
    Route::get('/physical-inventory/change-status/{id}/{status}', [PhysicalInventoryController::class, 'changeStatus']);
    Route::get('/physical-inventory/finalize/{id}', [PhysicalInventoryController::class, 'finalize']);
    Route::get('/physical-inventory/products/list', [PhysicalInventoryController::class, 'getProducts']);
    Route::get('/physical-inventory/mapping/{id}', [PhysicalInventoryController::class, 'mapping']);
    Route::post('/physical-inventory/update-execution-date', [PhysicalInventoryController::class, 'updateExecutionDate']);
    Route::post('/physical-inventory/update-code', [PhysicalInventoryController::class, 'updateCode']);

    // Physical inventory line routes
    Route::resource('physical-inventory-line', PhysicalInventoryLineController::class);
    Route::post('/physical-inventory-line/update-line', [PhysicalInventoryLineController::class, 'updateLine']);

    //Products history
    Route::get('/products/purchase_history/{id}', [ProductController::class, 'getHistoryPurchase']);
    Route::get('/products/get_history_purchase/{id}', [ProductController::class, 'getDataHistoryPurchase']);

    //Report client history
    Route::get('/reports/history_purchase_clients', [ReporterController::class, 'getHistoryPurchaseClients']);
    Route::post('/reports/history_purchase_clients/get_report', [ReporterController::class, 'getHistoryPurchaseClientsReport']);

    // Sales tracking report routes
    Route::get('/reports/sales-tracking-report', [ReportController::class, 'getSalesTrackingReport']);
    Route::post('/reports/sales-tracking-report', [ReportController::class, 'postSalesTrackingReport']);
    Route::get('/reports/get_employees', [ReportController::class, 'getEmployees']);

    //Lost sales
    Route::get('/quotes/lost_sale/{id}', [QuoteController::class, 'createLostSale']);
    Route::get('/quotes/lost_sale/{id}/edit', [QuoteController::class, 'editLostSale']);
    Route::post('/quotes/lost_sale/store', [QuoteController::class, 'storeLostSale']);
    Route::put('/quotes/lost_sale/{id}/update', [QuoteController::class, 'updateLostSale']);

    Route::get('/reports/lost-sales', [ReportController::class, 'getLostSalesReport']);
    Route::post('/reports/lost-sales', [ReportController::class, 'postLostSalesReport']);

    // Validate if exists the tax number in customers module
    Route::get('/customer/verify-if-exists-tax-number', [CustomerController::class, 'verifiedIfExistsTaxNumber']);

    // Validate if exists the tax number in suppliers module
    Route::get('/contact/verify-if-exists-tax-number', [ContactController::class, 'verifiedIfExistsNIT']);

    // Validate if exists the dni in suppliers module
    Route::get('/contact/verify-if-exists-dni', [ContactController::class, 'verifiedIfExistsDUI']);

    // Check if the client has nit and nrc in POS
    Route::get('/customer/verified_tax_number_sell_pos', [CustomerController::class, 'verifiedTaxNumberSellPos']);
    // Check if the client has nit and nrc in PURCHASE
    Route::get('/contact/verified_tax_number_purchase', [ContactController::class, 'verifiedTaxNumberPurchases']);

    // All Sales report routes
    Route::get('/sales-reports/all-sales-report', [ReportController::class, 'getAllSalesReport']);
    Route::post('/sales-reports/all-sales-report', [ReportController::class, 'postAllSalesReport'])->name("sales_reports.all_sales_report");

    // All Sales report routes
    Route::get('/sales-reports/all-sales-with-utility-report', [ReportController::class, 'getAllSalesWithUtilityReport']);
    Route::post('/sales-reports/all-sales-with-utility-report', [ReportController::class, 'postAllSalesWithUtilityReport'])->name("sales.postAllSalesWithUtility");

    /** Sales summary by seller */
    Route::get('/reports/sales-summary-report', [ReporterController::class, 'getSalesSummarySellerReport']);
    Route::post('/reports/sales-summary-report', [ReporterController::class, 'postSalesSummarySellerReport'])->name("sales.postSalesSummarySellerReport");

    /** Sales by seller report */
    Route::get('/reports/sales-by-seller-report', [ReporterController::class, 'getSalesBySellerReport']);
    Route::post('/reports/sales-by-seller-report', [ReporterController::class, 'postSalesBySellerReport'])->name("sales.postSalesBySellerReport");

    /** Expense Purchase report */
    Route::get('/reports/expense-purchase-report', [ReporterController::class, 'getExpensePurchaseReport']);
    Route::post('/reports/expense-purchase-report', [ReporterController::class, 'postExpensePurchaseReport']);

    /** Bank reconciliation report */
    Route::post('/bank-transactions/get-bank-reconciliation', [BankTransactionController::class, 'getBankReconciliation']);

    // Detailed sales report routes
    Route::get('/reports/detailed-commissions-report', [ReportController::class, 'getDetailedCommissionsReport']);
    Route::post('/reports/detailed-commissions-report', [ReportController::class, 'postDetailedCommissionsReport']);

    // International Purchases
    Route::resource('/international-purchases', InternationalPurchaseController::class);
    // Check if the client has Tax number and nrc in purchases
    Route::get('/contact/verify-tax-number-reg-number', [ContactController::class, 'verifyTaxNumberAndRegNumber']);

    // Price list import
    Route::get('/import-price-list', [ProductController::class, 'getPriceList']);
    Route::post('/import-price-list/import', [ProductController::class, 'postPriceList'])->name('import-price-lists');

    // Import expenses routes
    Route::resource('import-expenses', ImportExpenseController::class);

    // Calculate tax and payments
    Route::get('/sales/calculate-tax-and-payments', [SellPosController::class, 'calculateTaxAndPayments']);

    // Sales toggle dropdown
    Route::get('pos/get_toggle_dropdown/{id}', [SellController::class, 'getToggleDropdown']);

    // Create all opening balances
    Route::get('/customers/create-opening-balances/{business_id}', [CustomerController::class, 'createAllOpeningBalances']);

    // Apportionments
    Route::resource('/apportionments', ApportionmentController::class);
    Route::get('/get_import_expenses', [ImportExpenseController::class, 'getImportExpenses']);
    Route::post('/get_import_expense_row', [ImportExpenseController::class, 'getImportExpenseRow']);
    Route::get('/get_purchases', [PurchaseController::class, 'getPurchases']);
    Route::post('/get_purchase_row', [PurchaseController::class, 'getPurchaseRow']);
    Route::post('/get_product_list', [ApportionmentController::class, 'getProductList']);
    Route::post('/add_product_row', [ApportionmentController::class, 'addProductRow']);

    // Account statement
    Route::get('/reports/account-statement', [ReportController::class, 'getAccountStatement']);
    Route::post('/reports/account-statement', [ReportController::class, 'postAccountStatement']);

    // Collections report
    Route::get('collections', [ReportController::class, 'getCollections']);
    Route::post('post-collections', [ReportController::class, 'postCollections']);

    // Mail routes
    Route::post('/balances_customer/send-account-statement', [MailController::class, 'sendAccountStatement']);

    // Account statement toggle dropdown
    Route::get('balances_customer/get_toggle_dropdown/{id}', [CustomerController::class, 'getToggleDropdown']);

    // Create kardex lines route
    Route::get('/kardex/create-kardex-lines/{variation_id}', [KardexController::class, 'createKardexLines']);

    // Treasury annexes routes
    Route::get('/treasury-annexes', [ReporterController::class, 'getTreasuryAnnexes']);
    Route::post('/treasury-annexes/annex-1', [ReporterController::class, 'exportAnnex1']);
    Route::post('/treasury-annexes/annex-2', [ReporterController::class, 'exportAnnex2']);
    Route::post('/treasury-annexes/annex-3', [ReporterController::class, 'exportAnnex3']);
    Route::post('/treasury-annexes/annex-5', [ReporterController::class, 'exportAnnex5']);
    Route::post('/treasury-annexes/annex-6', [ReporterController::class, 'exportAnnex6']);
    Route::post('/treasury-annexes/annex-7', [ReporterController::class, 'exportAnnex7']);
    Route::post('/treasury-annexes/annex-8', [ReporterController::class, 'exportAnnex8']);
    Route::post('/treasury-annexes/annex-9', [ReporterController::class, 'exportAnnex9']);

    // Retentions routes
    Route::resource('retentions', RetentionController::class);

    // Cost history report
    Route::get('/reports/cost-history/{variation_id}', [ReportController::class, 'generateCostHistory']);

    // Glasses consumption report routes
    Route::get('/reports/glasses-consumption', [ReportController::class, 'getGlassesConsumptionReport']);
    Route::post('/reports/glasses-consumption', [ReportController::class, 'postGlassesConsumptionReport']);

    // Stock report by location routes
    Route::get('/reports/stock-by-location', [ReportController::class, 'getStockReportByLocation']);
    Route::post('/reports/stock-by-location', [ReportController::class, 'postStockReportByLocation']);

    // Sales per seller report
    Route::get('/reports/sales-per-seller', [ReportController::class, 'getSalesPerSellerReport']);
    Route::post('/reports/sales-per-seller', [ReportController::class, 'postSalesPerSellerReport'])->name("sales_per_seller");

    // Payment report
    Route::get('/reports/payment', [ReportController::class, 'getPaymentReport'])->name("payment_report_get");
    Route::post('/reports/payment', [ReportController::class, 'postPaymentReport'])->name("payment_report_post");

    // Binnacle routes
    Route::resource('binnacle', BinnacleController::class);

    // --- BEGIN OPTICS ROUTES ---

    Route::group([], function () {
        // Patients Routes
        Route::get('patients/getPatientsData', [Optics\PatientController::class, 'getPatientsData']);
        Route::resource('patients', PatientController::class);
        Route::get('patients/getEmployeeByCode/{code}', [Optics\PatientController::class, 'getEmployeeByCode']);
        Route::get('patients_lab/get_patients', [Optics\PatientController::class, 'getPatients']);
        Route::get('patients/create/{patient_name?}', [Optics\PatientController::class, 'create']);

        // Material types
        Route::resource('material_type', MaterialTypeController::class);

        // Diagnostics
        Route::resource('diagnostic', DiagnosticController::class);

        // External labs
        Route::resource('external-labs', ExternalLabController::class);

        // Status lab orders
        Route::resource('status-lab-orders', StatusLabOrderController::class);

        // Graduation cards
        Route::resource('graduation-cards', GraduationCardController::class);

        // Lab erders
        Route::get('lab-orders/addProduct/{variation_id}/{warehouse_id}', [Optics\LabOrderController::class, 'addProduct']);
        Route::get('lab-orders/getProductsByOrder/{id}', [Optics\LabOrderController::class, 'getProductsByOrder']);
        Route::get('lab-orders/get-report/{id}', [Optics\LabOrderController::class, 'getReport']);
        Route::get('lab-orders/fillHoopFields/{variation_id}/{transaction_id}', [Optics\LabOrderController::class, 'fillHoopFields']);
        Route::get('lab-orders/fillHoopFields2/{variation_id}', [Optics\LabOrderController::class, 'fillHoopFields2']);
        Route::get('pos/lab-orders/create_lab_order', [Optics\LabOrderController::class, 'createLabOrder']);
        Route::get('lab-orders/close-edit-modal/{id}', [Optics\LabOrderController::class, 'closeEditModal']);
        Route::get('lab-orders-by-location', [Optics\LabOrderController::class, 'getLabOrdersByLocation']);
        Route::get('lab-orders/markPrinted/{id}', [Optics\LabOrderController::class, 'markPrinted']);
        Route::get('lab-orders/second-time/{id}', [Optics\LabOrderController::class, 'createOrderSecondTime']);
        Route::get('/lab-orders/print/{id}', [Optics\LabOrderController::class, 'print']);
        Route::get('/lab-orders/change-status/{order_id}/{status_id}', [Optics\LabOrderController::class, 'changeStatus']);
        Route::get('/lab-orders/print-change-status/{order_id}/{status_id}', [Optics\LabOrderController::class, 'changeStatusAndPrint']);
        Route::get('/lab-orders/transfer-change-status/{order_id}/{status_id}', [Optics\LabOrderController::class, 'changeStatusAndTransfer']);
        Route::get('/lab-orders/copy-change-status/{order_id}/{status_id}', [Optics\LabOrderController::class, 'changeStatusAndCopy']);
        Route::get('/lab-orders/edit-change-status/{order_id}/{status_id}', [Optics\LabOrderController::class, 'changeStatusAndEdit']);
        Route::get('/lab-orders/getHoops', [Optics\LabOrderController::class, 'getHoops']);
        Route::get('lab_order/get_toggle_dropdown/{id}', [Optics\LabOrderController::class, 'getToggleDropdown']);
        Route::post('/lab_orders/multiple-change-status', [Optics\LabOrderController::class, 'multipleChangeStatus']);
        Route::resource('lab-orders', LabOrderController::class);

        // Flow reasons
        Route::resource('flow-reason', FlowReasonController::class);

        // Inflows and outflows
        Route::resource('inflow-outflow', InflowOutflowController::class);
        Route::get('inflow-outflow/create/{type}', [Optics\InflowOutflowController::class, 'create']);
        Route::get('/pos/inflow-outflow/get_suppliers', [Optics\InflowOutflowController::class, 'getSuppliers']);
        Route::get('/pos/inflow-outflow/get_employees', [Optics\InflowOutflowController::class, 'getEmployees']);

        if (config('app.business') == 'optics') {
            // Products
            Route::get('/products/view-product-group-price/{id}', [Optics\ProductController::class, 'viewGroupPrice']);
            Route::get('/products/add-selling-prices/{id}', [Optics\ProductController::class, 'addSellingPrices']);
            Route::post('/products/save-selling-prices', [Optics\ProductController::class, 'saveSellingPrices']);
            Route::post('/products/mass-delete', [Optics\ProductController::class, 'massDestroy']);
            Route::get('/products/list', [Optics\ProductController::class, 'getProducts']);
            Route::get('/products/list_stock_transfer', [Optics\ProductController::class, 'getProductsTransferStock']);
            Route::get('/products/list_for_transfers', [Optics\ProductController::class, 'getProductsStockTransfer']);
            Route::get('/products/list_for_quotes', [Optics\ProductController::class, 'getProductsToQuote']);
            Route::get('/products/list-no-variation', [Optics\ProductController::class, 'getProductsWithoutVariations']);
            Route::get('/lab_orders/products/list_for_lab_orders', [Optics\ProductController::class, 'getProductsToLabOrder']);

            Route::post('/products/get_sub_categories', [Optics\ProductController::class, 'getSubCategories']);
            Route::post('/products/product_form_part', [Optics\ProductController::class, 'getProductVariationFormPart']);
            Route::post('/products/get_product_variation_row', [Optics\ProductController::class, 'getProductVariationRow']);
            Route::post('/products/get_variation_template', [Optics\ProductController::class, 'getVariationTemplate']);
            Route::get('/products/get_variation_value_row', [Optics\ProductController::class, 'getVariationValueRow']);
            Route::post('/products/check_product_sku', [Optics\ProductController::class, 'checkProductSku']);
            Route::get('/products/quick_add', [Optics\ProductController::class, 'quickAdd']);
            Route::post('/products/save_quick_product', [Optics\ProductController::class, 'saveQuickProduct']);

            Route::get('/products/view/{id}', [Optics\ProductController::class, 'view']);
            Route::get('/products/viewSupplier/{id}', [Optics\ProductController::class, 'viewSupplier']);
            Route::get('/products/viewKit/{id}', [Optics\ProductController::class, 'viewKit']);
            Route::get('/products/productHasSuppliers/{id}', [Optics\ProductController::class, 'productHasSuppliers']);
            Route::get('/products/kitHasProduct/{id}', [Optics\ProductController::class, 'kitHasProduct']);
            Route::get('/products/createProduct', [Optics\ProductController::class, 'createProduct']);
            Route::get('/products/getUnitPlan/{id}', [Optics\ProductController::class, 'getUnitplan']);
            Route::get('/products/getUnitsFromGroup/{id}', [Optics\ProductController::class, 'getUnitsFromGroup']);
            Route::get('/products/showProduct/{id}', [Optics\ProductController::class, 'showProduct']);
            Route::get('/products/showStock/{variation_id}/{location_id}', [Optics\ProductController::class, 'showStock']);
            Route::get('/products/getMeasureFromKitLines/{id}', [Optics\ProductController::class, 'getMeasureFromKitLines']);

            Route::get('products/get_toggle_dropdown/{id}', [Optics\ProductController::class, 'getToggleDropdown']);

            Route::post('products/check-sku-unique', [Optics\ProductController::class, 'checkSkuUnique']);

            Route::get('/products/recalculate-product-cost/{variation_id}', [Optics\ProductController::class, 'recalculateProductCost']);
            Route::get('/products/get-recalculate-cost', [Optics\ProductController::class, 'getRecalculateCost']);
            Route::post('/products/get-recalculate-cost', [Optics\ProductController::class, 'postRecalculateCost']);

            Route::resource('products', 'ProductController');

            // Materials
            Route::get('/products/getMaterialsData', [Optics\ProductController::class, 'getMaterialsData']);
            Route::get('/products/materialHasSuppliers/{id}', [Optics\ProductController::class, 'materialHasSuppliers']);

            // Sale price scales
            Route::get('/get_sale_price_scale/{id}', [Optics\ProductController::class, 'getSalePriceScale']);
            Route::post('/store_sale_price_scale', [Optics\ProductController::class, 'storeSalePriceScale']);
            Route::delete('/destroy_sale_price_scale/{id}', [Optics\ProductController::class, 'destroySalePriceScale']);
            Route::post('/edit_sale_price_scale/{id}', [Optics\ProductController::class, 'editSalePriceScale']);

            // Name images routes
            Route::get('/name-images', [Optics\ProductController::class, 'getNameImages'])->name('products.name_images');
            Route::post('/name-images', [Optics\ProductController::class, 'postNameImages']);

            // Price list import
            Route::get('/import-price-list', [Optics\ProductController::class, 'getPriceList']);
            Route::post('/import-price-list/import', [Optics\ProductController::class, 'postPriceList'])->name('import-price-lists');

            Route::get('lab-orders/products/list_for_orders', [Optics\ProductController::class, 'getProductsforOrders']);

            // Expenses
            Route::get('/expenses/get_suppliers', [Optics\ExpenseController::class, 'getSuppliers']);
            Route::get('/expenses/get_contacts', [Optics\ExpenseController::class, 'getAccount']);
            Route::get('/expenses/update-taxes', [Optics\ExpenseController::class, 'updateTaxes']);
            Route::get('/expenses/set-final-total-from-expenses', [Optics\ExpenseController::class, 'setFinalTotalFromExpenses']);
            Route::resource('expenses', 'ExpenseController');
            Route::get('/expenses/get_add_expenses/{bank_transaction_id?}', [Optics\ExpenseController::class, 'getAddExpenses']);
            Route::post('/expenses/post_add_expenses', [Optics\ExpenseController::class, 'postAddExpenses']);
            Route::get('/expenses/get_add_expense', [Optics\ExpenseController::class, 'getAddExpense']);
            Route::get('/expenses/get-purchases-expenses', [Optics\ExpenseController::class, 'getPurchasesExpenses']);
            Route::get('/expenses/get_expense_details/{expense_id}', [Optics\ExpenseController::class, 'getExpenseDetails']);

            // Expense categories
            Route::resource('expense-categories', ExpenseCategoryController::class);
        }
    });

    // Lab orders
    Route::get('/lab-order-reports/transfer-sheet', [ReportController::class, 'getTransferSheet']);
    Route::post('/lab-order-reports/transfer-sheet', [ReportController::class, 'postTransferSheet']);
    Route::get('/lab-order-reports/errors-report', [ReportController::class, 'getLabErrorsReport']);
    Route::get('/lab-order-reports/external-labs-report', [ReportController::class, 'getExternalLabsReport']);

    // Customer and patient
    Route::get('customer-and-patient/create/{name?}', [CustomerController::class, 'createCustomerAndPatient']);
    Route::post('customer-and-patient/store', [CustomerController::class, 'storeCustomerAndPatient']);

    // Reservations
    Route::resource('reservations', ReservationController::class);
    Route::get('pos/reservations/get_reservations', [ReservationController::class, 'getReservations']);
    Route::get('reservations/get_product_row/{quote_id}/{variation_id}/{location_id}/{row_count}', [ReservationController::class, 'getProductRow']);
    Route::get('reservations/get_payment_row/{removable}/{row_index}/{payment_id}', [ReservationController::class, 'getPaymentRow']);
    Route::get('/payments/add_payment-to-quote/{quote_id}', [TransactionPaymentController::class, 'addPaymentToQuote']);
    Route::get('/payments/show-to-quote/{quote_id}', [TransactionPaymentController::class, 'showToQuote']);
    Route::post('/payments/quote', [TransactionPaymentController::class, 'storeToQuote']);
    Route::get('/pos/{id}/edit/quote', [ReservationController::class, 'edit']);

    // Payment note report
    Route::get('/reports/payment-note-report', [ReportController::class, 'getPaymentNoteReport']);
    Route::post('/reports/payment-note-report', [ReportController::class, 'postPaymentNoteReport']);

    // Lab orders report
    Route::get('/reports/lab-orders-report', [ReportController::class, 'getLabOrdersReport']);
    Route::post('/reports/lab-orders-report', [ReportController::class, 'postLabOrdersReport']);

    // POS validations
    Route::get('/correlative/get-final-correlative', [SellPosController::class, 'getFinalCorrelative']);

    // Fix transfer
    Route::get('/fix-transfer/{transaction_id}', [StockTransferController::class, 'fixTransfer']);

    // Products report
    Route::post('/products/products-report', [ReportController::class, 'postProductsReport']);

    // POS
    Route::get('/pos/get_lab_order/{transaction_id}/{patient_id}', [SellPosController::class, 'getLabOrder']);
    Route::get('/pos/get_graduation_card/{transaction_id}', [SellPosController::class, 'getGraduationCard']);
    Route::post('/pos/post_lab_order', [SellPosController::class, 'postLabOrder']);

    // --- END OPTICS ROUTES ---

    // --- BEGIN WORKSHOP ROUTES ---

    // Customer vehicles routes
    Route::post('/get-vehicle-row', [CustomerController::class, 'getVehicleRow']);
    Route::get('/import-customer-vehicles', [CustomerVehicleController::class, 'getImporter']);
    Route::post('/import-customer-vehicles', [CustomerVehicleController::class, 'postImporter']);
    Route::post('/save-customer-vehicles', [CustomerVehicleController::class, 'import']);

    // Quotes
    Route::get('/quotes/get-customer-vehicles/{id}', [CustomerController::class, 'getCustomerVehicles']);
    Route::post('/quotes/add-service-block/{id}', [QuoteController::class, 'addServiceBlock']);
    Route::post('quotes/add-spare/{variation_id}', [QuoteController::class, 'addSpare']);
    Route::post('quotes/add-spare-not-stock/{variation_id}', [QuoteController::class, 'addSpareNotStock']);
    Route::get('quotes/get-service-blocks-by-quote/{id}', [QuoteController::class, 'getServiceBlocksByQuote']);
    Route::get('quotes/viewQuoteWorkshop/{id}', [QuoteController::class, 'viewQuoteWorkshop']);
    Route::post('quote/workshop-data/{quote_id}', [QuoteController::class, 'workshopData']);
    Route::post('quote/get-spare-lines', [QuoteController::class, 'getSpareLines']); // Workshop route

    // Orders
    Route::post('orders/get-spare-lines', [OrderController::class, 'getSpareLines']); // Workshop route
    Route::post('/orders/add-service-block/{id}', [OrderController::class, 'addServiceBlock']);

    // --- END WORKSHOP ROUTES ---
});
