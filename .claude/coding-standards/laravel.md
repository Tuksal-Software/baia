# Laravel Coding Standards

Bu döküman Laravel Developer Agent için zorunlu coding standards referansıdır.

---

## Principles

### Dependency Injection
- Always follow Laravel's IOC
- If not possible to inject in `__construct`, use alternative methods
- PHP Docblock definition is important for IDE intellisense

### PSR Standards
- Follow PSR-12 for code style
- Both Laravel, Composer and we follow PSR documents

---

## 1. Code Formatting & Style (PSR-12)

Follow PSR-12 coding standards for readability and consistency.

✅ **Do:**
```php
$response = [
    'charge_back_types' => ChargebackService::getTypesForApiAutomation(),
    'reasons' => $reasons,
];

return $this->sendSuccessResponse(
    result: $response,
    message: __("Get data successfully."),
    statusCode: ApiService::API_SERVICE_SUCCESS_CODE
);
```

❌ **Don't:**
```php
$response = array('charge_back_types' => ChargebackService::getTypesForApiAutomation(), 'reasons' => (new Reason())->getReasons(Config::get('constants.REASON_CODE.CHARGE_BACK'), array('selected_columns' => ['id', 'title', 'title_tr'])),);
return $this->sendSuccessResponse(result: $response, message: __("Get data successfully."), statusCode: ApiService::API_SERVICE_SUCCESS_CODE);
```

---

## 2. Array Syntax

Use short array syntax `[]` instead of legacy `array()`.

✅ **Do:**
```php
$extras = [
    'admin_id' => $auth->id,
    'type' => 'chargeBack',
    'is_admin' => 1,
];
```

❌ **Don't:**
```php
$extras = array(
    'admin_id' => $auth->id,
    'type' => 'chargeBack',
    'is_admin' => 1,
);
```

---

## 3. Variable Naming Conventions

Use camelCase for variables and lowercase for array keys.

✅ **Do:**
```php
// camelCase in placeholders
$url = "/api/merchants/{$merchantId}/transactions";
$message = "Processing for merchant: {$merchantId}";

// Correct camelCase and lowercase keys
$transactionStateId = $input['trans_state_id'];
$paymentId = $input['payment_id'];

$data = [
    'action' => 'APPROVE_FROM_CHARGEBACK_API_AUTOMATION_BY_ADMIN',
    'transaction_id' => $saleObj->id,
];
```

❌ **Don't:**
```php
// Inconsistent casing - ID should be Id
$transactionStateID = $input['trans_state_id'];
$paymentID = $input['paymentId'];

// Uppercase key should be lowercase
$data = [
    'Action' => 'APPROVE_FROM_CHARGEBACK_API_AUTOMATION_BY_ADMIN',
];
```

---

## Controllers

**Strategy:** Thin Controllers - keep business logic out of controllers.

---

## 4. Request Validation

Always use Laravel Request classes even for 1 input validation.

✅ **Do:**
```php
public function create(CreateChargebackRequest $request)
{
    $input = $request->validated();
    // Process validated data...
}
```

❌ **Don't:**
```php
public function create(Request $request)
{
    $input = $request->all();
    [$rules, $messages] = AppRequestValidation::newChargebackApiValidation();
    $validator = Validator::make($input, $rules, $messages);

    if ($validator->fails()) {
        return $this->sendApiResponse(__("Validation Errors"), ['errors' => $validator->errors()]);
    }
}
```

---

## 5. Constants and Enums

Use constants or enums for fixed values instead of magic strings/numbers.

✅ **Do:**
```php
class MerchantExtras extends Model
{
    public const DEACTIVATED_BY_RISK_YES = 1;
    public const DEACTIVATED_BY_RISK_NO = 0;
}

(new MerchantExtras())->updateOrCreateMerchantExtra([
    'merchant_id' => $this->merchant->id,
    'deactivated_by_risk' => MerchantExtras::DEACTIVATED_BY_RISK_YES,
]);

class TransactionState
{
    public const COMPLETED = 'completed';
    public const PENDING = 'pending';
    public const CHARGE_BACKED = 'charge_backed';
}
```

❌ **Don't:**
```php
(new MerchantExtras())->updateOrCreateMerchantExtra([
    'merchant_id' => $this->merchant->id,
    'deactivated_by_risk' => 1,  // Magic number
]);

$search = [
    'request_type' => 'approve',  // Magic string
];
```

---

## 6. Single Responsibility Principle

Each function should do one thing.

✅ **Do:**
```php
private function approveChargeback(array $input): JsonResponse
{
    // Handle approval logic only
}

private function rejectChargeback(array $input): JsonResponse
{
    // Handle rejection logic only
}
```

❌ **Don't:**
```php
private function approveOrRejectChargeback(array $input)
{
    if ($input['request_type'] == 'approve') {
        // Approval logic
    } else {
        // Rejection logic
    }
}
```

---

## 7. Nested Conditionals

Avoid deep nesting. Extract complex conditions into methods.

✅ **Do:**
```php
private function isValidForChargeback(Transaction $transaction, string $stateId): bool
{
    return $this->isApprovalValid($transaction, $stateId)
        || $this->isRejectionValid($transaction, $stateId);
}

public function process(Request $request)
{
    if (!$this->isValidForChargeback($transaction, $stateId)) {
        return $this->sendErrorResponse("Invalid transaction state");
    }

    // Continue with main logic
}
```

❌ **Don't:**
```php
// 4+ levels of nested if statements
if ($input['request_type'] == 'approve') {
    if ($saleTransaction->transaction_state_id == TransactionState::CHARGE_BACK_APPROVED) {
        if ($transStateId == TransactionState::CHARGE_BACKED) {
            if ($bankResponseCode != 100) {
                $statusMessage = "Chargeback to bank is failed.";
            }
        }
    }
}
```

---

## 8. Return Types

Use specific return types instead of generic types like Object.

✅ **Do:**
```php
public static function findReasonById(int $reasonId, array $extras = []): ?Reason
{
    return self::query()
        ->where('id', $reasonId)
        ->first();
}
```

❌ **Don't:**
```php
public static function findReasonById(int $reasonId, array $extras = []): Object | Null
{
    // ...
}
```

---

## 9. Method Parameters

Define parameters explicitly instead of generic array parameters.

✅ **Do:**
```php
public function getReasons(
    string $reasonCode,
    array $selectedColumns = ['id', 'title']
): Collection {
    return $this->query()
        ->where('category_code', $reasonCode)
        ->select($selectedColumns)
        ->get();
}
```

❌ **Don't:**
```php
public function getReasons($reasoncode, array $extras = [])
{
    $selectedColumns = $extras['selected_columns'] ?? ['*'];
    // ...
}
```

---

## 10. RESTful API Naming

Follow REST conventions. Don't include verbs in resource URLs.

✅ **Do:**
```php
Route::group(['prefix' => 'chargeback'], function () {
    Route::get('/', [ChargebackController::class, 'index']);
    Route::post('/', [ChargebackController::class, 'store']);
    Route::post('/{id}/approve', [ChargebackController::class, 'approve']);
    Route::post('/{id}/reject', [ChargebackController::class, 'reject']);
});
```

❌ **Don't:**
```php
Route::post('create', [ChargebackController::class, 'create']);
Route::get('get-all', [ChargebackController::class, 'index']);
```

---

## 11. Encapsulate Complex Logic

Move complex logic into dedicated methods.

✅ **Do:**
```php
private function getStatusMessage(int $responseCode): string
{
    return match ($responseCode) {
        100 => "Transaction successfully chargebacked",
        4 => "Chargeback is not possible in this state",
        2 => "Transaction not found",
        200 => "Exception! Unknown Error",
        default => "Unknown Error",
    };
}
```

❌ **Don't:**
```php
$statusMessage = '';
if ($isDisableImportedTransactionRefund) {
    $statusMessage = ApiService::API_SERVICE_STATUS_MESSAGE[...];
} elseif (in_array($saleTransaction->transaction_state_id, [...])) {
    $statusMessage = 'Transaction already on chargeback process';
}
// ... inline complex logic
```

---

## 12. Internationalization (i18n)

Use localization functions for all user-facing strings.

✅ **Do:**
```php
throw new InvalidArgumentException(__('validation.merchant_id_required'));
$message = __('merchant.closed_due_to_risk');

return $this->sendApiResponse(
    __('errors.transaction_not_found'),
    [],
    ApiService::API_SERVICE_FAILED_CODE
);
```

❌ **Don't:**
```php
throw new InvalidArgumentException('Merchant ID is required.');
$this->merchant->closeMerchant('İş yeri risk sebebiyle kapatılmıştır.');

return $this->sendApiResponse(
    "Something Went Wrong, Please Contact With Support team.",
    [],
    ApiService::API_SERVICE_FAILED_CODE
);
```

---

## 13. Spelling and Typos

Always double-check variable names, array keys, and method names.

✅ **Do:**
```php
$data = [
    'transaction_id' => $saleObj->id,
    'payment_id' => $input['paymentId'],
];
```

❌ **Don't:**
```php
$data = [
    'transacton_id' => $saleObj->id,  // Typo: missing 'i'
    'payment_id' => $input['paymentId'],
];
```

---

## 14. Variable Assignment for Readability

Assign complex expressions to variables for clarity.

✅ **Do:**
```php
$reasons = (new Reason())->getReasons(
    Config::get('constants.REASON_CODE.CHARGE_BACK'),
    ['id', 'title', 'title_tr']
);

$response = [
    'charge_back_types' => ChargebackService::getTypesForApiAutomation(),
    'reasons' => $reasons,
];
```

❌ **Don't:**
```php
$response = array(
    'charge_back_types' => ChargebackService::getTypesForApiAutomation(),
    'reasons' => (new Reason())->getReasons(Config::get('constants.REASON_CODE.CHARGE_BACK'), array('selected_columns' => ['id', 'title', 'title_tr'])),
);
```

---

## 15. Use Rule::in() for Validation

Use PHP enums, model constants, or Laravel's `Rule::in()` instead of hardcoded strings.

✅ **Do:**
```php
use Illuminate\Validation\Rule;
use App\Models\MerchantRiskHistory;

public function rules(): array
{
    return [
        'risk_reason' => 'required|string|max:255',
        'risk_status' => [
            'required',
            Rule::in(array_keys(MerchantRiskHistory::getStatus())),
        ],
    ];
}
```

❌ **Don't:**
```php
public function rules(): array
{
    return [
        'risk_reason' => 'required|string|max:255',
        'risk_status' => 'required|in:0,1,2',
    ];
}
```

---

## 16. Reuse Existing Methods (DRY Principle)

Check if similar methods already exist before writing new functionality.

✅ **Do:**
```php
$this->merchant->closeMerchant('Business closed due to risk.');
$changes = AuditLogger::getModelChanges($this->merchant);
```

❌ **Don't:**
```php
// Don't duplicate existing functionality
private function closeMerchant(): void
{
    $this->merchant->status = Merchant::MERCHANT_INACTIVE;
    $this->merchant->save();
    // ... duplicated logic
}
```

---

## 17. Use Model Helper Methods for Status Validation

Validate status values using model helper methods.

✅ **Do:**
```php
if (!in_array($this->riskStatus, array_keys(MerchantRiskHistory::getStatus()))) {
    throw new InvalidArgumentException(__('validation.invalid_risk_status'));
}
```

❌ **Don't:**
```php
if (!in_array($this->riskStatus, [0, 1, 2])) {
    throw new InvalidArgumentException('Invalid status.');
}
```

---

## 18. Validate Properties Correctly

Use `empty()` for required value checks.

✅ **Do:**
```php
private function validate(): void
{
    if (empty($this->merchantId)) {
        throw new InvalidArgumentException(__('validation.merchant_id_required'));
    }

    if (!isset($this->riskStatus) || $this->riskStatus === null) {
        throw new InvalidArgumentException(__('validation.risk_status_required'));
    }
}
```

❌ **Don't:**
```php
private function validate(): void
{
    if (!isset($this->riskReason)) {
        throw new InvalidArgumentException('Risk reason is required.');
    }
}
```

---

## 19. Use Safe Null/Isset Checks

Use `isset()` appropriately. For class properties, use `empty()` or strict comparison.

✅ **Do:**
```php
if (empty($this->merchantId)) {
    throw new InvalidArgumentException(__('validation.merchant_id_required'));
}

if (!array_key_exists('status', $dirties)) {
    return;
}
```

❌ **Don't:**
```php
if (!isset($this->merchantId)) {  // Always true if property exists
    throw new InvalidArgumentException('Merchant ID is required.');
}
```

---

## 20. Null vs Empty String

Use `null` to represent absent/missing values, not empty strings.

✅ **Do:**
```php
$description = $input['description'] ?? null;
$optionalField = $request->input('optional_field');
```

❌ **Don't:**
```php
$description = $input['description'] ?? '';
$optionalField = $request->input('optional_field', '');
```

---

## 21. Boolean Parameter Usage

For boolean typed parameters, use direct conditionals. Always type-hint boolean parameters.

✅ **Do:**
```php
public function processWithdrawal(bool $isAutomatic): void
{
    if ($isAutomatic) {
        $this->processAutomatically();
    }
}
```

❌ **Don't:**
```php
public function processWithdrawal($isAutomatic): void
{
    if (!empty($isAutomatic)) {
        $this->processAutomatically();
    }
}
```

---

## 22. DTO Single Responsibility

Separate DTOs for input and output.

✅ **Do:**
```php
class WithdrawalInputDTO
{
    public function __construct(
        public readonly int $merchantId,
        public readonly float $amount,
        public readonly ?string $description,
    ) {}
}

class WithdrawalOutputDTO
{
    public function __construct(
        public readonly string $reason,
        public readonly string $description,
        public readonly bool $requiresExternalDocuments,
    ) {}
}

public function getWithdrawalReason(WithdrawalInputDTO $input): WithdrawalOutputDTO
```

❌ **Don't:**
```php
class WithdrawalDTO
{
    public int $merchantId;      // Input field
    public float $amount;        // Input field
    public string $reason;       // Output field
    public string $description;  // Used for both!
}
```

---

## 23. Repository Pattern for Complex Queries

Move complex database queries from Models to Repository classes.

✅ **Do:**
```php
class BTransRepository
{
    public function getHistoryWithPagination(array $filters): LengthAwarePaginator
    {
        return GovBTransSFP::query()
            ->when($filters['status'] ?? null, fn($q, $status) => $q->where('status', $status))
            ->when($filters['date_from'] ?? null, fn($q, $date) => $q->where('created_at', '>=', $date))
            ->orderBy('created_at', 'desc')
            ->paginate($filters['per_page'] ?? 15);
    }
}
```

❌ **Don't:**
```php
class GovBTransSFP extends Model
{
    public static function getListData($request)
    {
        $query = self::query();
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        // ... lots of filtering logic in Model
    }
}
```

---

## 24. Avoid request() Helper

Never use the global `request()` helper. Always inject the Request object.

✅ **Do:**
```php
class BTransService
{
    public function export(Request $request): Response
    {
        $filters = $request->validated();
        return $this->generateExport($filters);
    }
}
```

❌ **Don't:**
```php
class BTransService
{
    public function export(): Response
    {
        $filters = request()->all();  // Hidden dependency!
        $page = request()->input('page', 1);
        return $this->generateExport($filters);
    }
}
```

---

## 25. Task Number Traceability

Include task/ticket numbers in comments for business decisions or temporary code.

✅ **Do:**
```php
// Btrans cleaning disabled due to SMP-4154
if ($this->shouldSkipBtransCleaning()) {
    return;
}

// TODO: Remove after SMP-4200 is deployed to production
$legacyFallback = $this->useLegacyMethod();

// Workaround for PFINT-350 - bank API returns incorrect format
$amount = $this->normalizeAmount($rawAmount);
```

❌ **Don't:**
```php
// Btrans cleaning stopped temporarily
// TODO: Remove this later
// Workaround for bank issue
```

---

## 26. Keep Validation in Request Classes

Validation logic should be in FormRequest classes, not Services.

✅ **Do:**
```php
class AddBankAccountRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'iban_validation_type' => ['required', 'int', Rule::in(...)],
        ];
    }
}

class BankAccountService
{
    public function addBankAccount(AddBankAccountRequest $request): array
    {
        $data = $request->validated();
        // ...
    }
}
```

❌ **Don't:**
```php
class BankAccountService
{
    private function validateData(Request $request): void
    {
        $request->validate([
            'iban_validation_type' => ['required', 'int', Rule::in(...)],
        ]);
    }
}
```

---

## 27. Use Readonly Constructor Properties for DI

Use PHP 8.1+ constructor property promotion with `readonly`.

✅ **Do:**
```php
class IBANVerificationService
{
    public function __construct(
        private readonly IBANValidateService $ibanValidateService,
        private readonly LoggerInterface $logger
    ) {}
}
```

❌ **Don't:**
```php
class IBANVerificationService
{
    private $ibanValidateService;
    private $logger;

    public function __construct(
        IBANValidateService $ibanValidateService,
        LoggerInterface $logger
    ) {
        $this->ibanValidateService = $ibanValidateService;
        $this->logger = $logger;
    }
}
```

---

## 28. Separate HTTP Methods into Distinct Controller Methods

Don't use `$request->isMethod()` or `Route::match()` to handle different HTTP methods.

✅ **Do - Routes:**
```php
Route::get('/packages/create', [PackageController::class, 'create'])->name('packages.create');
Route::post('/packages', [PackageController::class, 'store'])->name('packages.store');
```

✅ **Do - Controller:**
```php
class PackageController extends Controller
{
    public function create(): View
    {
        $data = (new PackageService())->createOrEditPackage();
        return view('packages.create', $data);
    }

    public function store(PackageRequest $request): RedirectResponse
    {
        $result = (new PackageService())->storeMerchantPackage($request->validated());
        flash($result['message'], $result['success'] ? 'success' : 'danger');
        return redirect()->route('packages.index');
    }
}
```

❌ **Don't:**
```php
Route::match(['get', 'post'], '/packages/store', [PackageController::class, 'store']);

public function store(Request $request)
{
    if ($request->isMethod('post')) {
        // Handle form submission
    } else {
        // Show form
    }
}
```

---

## 29. Log Edge Cases and Failure Conditions

Always add logging for edge cases like missing files, empty results, or unexpected states.

✅ **Do:**
```php
public function downloadReport(int $merchantId): Response
{
    $filePath = storage_path("reports/{$merchantId}.pdf");

    if (!file_exists($filePath)) {
        Log::error('Report file not found', [
            'merchant_id' => $merchantId,
            'file_path' => $filePath,
        ]);
        return response()->json(['error' => 'Report not found'], 404);
    }

    return response()->download($filePath);
}
```

❌ **Don't:**
```php
if (!file_exists($filePath)) {
    // No logging - impossible to debug in production
    return response()->json(['error' => 'Report not found'], 404);
}
```

---

## Models

- Don't use business logic inside Model files
- Keep Models clean for definitions only
- Always use attribute casting

---

## Laravel Boost Standards (30-46)

The following standards are derived from Laravel Boost - the official Laravel MCP server.

---

## 30. Always Declare Strict Types

Every PHP file must begin with `declare(strict_types=1);`

**Note:** Use strict types in newly created files. May not apply to old files.

✅ **Do:**
```php
<?php

declare(strict_types=1);

namespace App\Services;

class PaymentService
{
    public function processAmount(int $amount): bool
    {
        // Type errors will throw TypeError
    }
}
```

---

## 31. Use Model::query() Over DB Facade

Prefer Eloquent's `Model::query()` over `DB::` facade.

✅ **Do:**
```php
$merchants = Merchant::query()
    ->where('status', 'active')
    ->where('created_at', '>=', $date)
    ->get();

$transactions = Transaction::query()
    ->with('merchant')
    ->whereHas('merchant', fn($q) => $q->active())
    ->get();
```

❌ **Don't:**
```php
$merchants = DB::table('merchants')
    ->where('status', 'active')
    ->get();
```

**Exception:** Use `DB::` for complex aggregations or bulk operations where performance is critical.

---

## 32. Use Named Routes with route() Helper

Always define named routes and use the `route()` helper. Never hardcode URLs.

✅ **Do:**
```php
Route::get('/merchants/{merchant}/transactions', [MerchantController::class, 'transactions'])
    ->name('merchants.transactions');

return redirect()->route('merchants.transactions', ['merchant' => $merchant->id]);
```

❌ **Don't:**
```php
return redirect('/merchants/' . $merchant->id . '/transactions');
```

---

## 33. Use env() Only in Config Files

Never call `env()` directly in application code.

✅ **Do:**
```php
// In config/services.php
return [
    'payment_gateway' => [
        'api_key' => env('PAYMENT_GATEWAY_API_KEY'),
        'timeout' => env('PAYMENT_GATEWAY_TIMEOUT', 30),
    ],
];

// In application code
$apiKey = config('services.payment_gateway.api_key');
```

❌ **Don't:**
```php
class PaymentGateway
{
    public function __construct()
    {
        $this->apiKey = env('PAYMENT_GATEWAY_API_KEY'); // Returns null when config is cached!
    }
}
```

---

## 34. Explicit Return Types for All Methods

All methods must have explicit return type declarations.

✅ **Do:**
```php
public function findMerchant(int $id): ?Merchant
{
    return Merchant::find($id);
}

public function getActiveCount(): int
{
    return Merchant::where('status', 'active')->count();
}

protected function validateInput(array $data): void
{
    // ...
}
```

---

## 35. Use Eager Loading to Prevent N+1 Queries

Always use eager loading (`with()`) when accessing relationships in loops.

✅ **Do:**
```php
$merchants = Merchant::query()
    ->with(['bankAccounts', 'transactions', 'settings'])
    ->where('status', 'active')
    ->get();

foreach ($merchants as $merchant) {
    $bankCount = $merchant->bankAccounts->count();  // No additional queries
}
```

❌ **Don't:**
```php
$merchants = Merchant::where('status', 'active')->get();

foreach ($merchants as $merchant) {
    $bankCount = $merchant->bankAccounts->count();  // N+1 query!
}
```

---

## 36. Use Specific Test Assertion Methods

Use specific assertion methods instead of generic status code checks.

✅ **Do:**
```php
$response->assertOk();                  // 200
$response->assertCreated();             // 201
$response->assertNotFound();            // 404
$response->assertForbidden();           // 403
$response->assertUnprocessable();       // 422
$response->assertRedirectToRoute('merchants.index');
```

❌ **Don't:**
```php
$response->assertStatus(200);
$this->assertEquals(200, $response->getStatusCode());
```

---

## 37. Mandatory Curly Braces for Control Structures

Always use curly braces, even for single-line statements.

✅ **Do:**
```php
if ($merchant->isActive()) {
    return true;
}

foreach ($transactions as $transaction) {
    $transaction->process();
}
```

❌ **Don't:**
```php
if ($merchant->isActive())
    return true;

foreach ($transactions as $transaction)
    $transaction->process();
```

---

## 38. Use Relationship Methods Over Raw Joins

Prefer Eloquent relationship methods over manual joins.

✅ **Do:**
```php
class Merchant extends Model
{
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}

$merchants = Merchant::whereHas('transactions', function ($query) {
    $query->where('amount', '>', 1000);
})->get();
```

❌ **Don't:**
```php
$merchants = DB::table('merchants')
    ->join('transactions', 'merchants.id', '=', 'transactions.merchant_id')
    ->where('transactions.amount', '>', 1000)
    ->select('merchants.*')
    ->get();
```

---

## 39. Use Constructor Property Promotion

Use PHP 8 constructor property promotion with `readonly`.

✅ **Do:**
```php
class MerchantService
{
    public function __construct(
        private readonly MerchantRepository $merchantRepository,
        private readonly PaymentGateway $paymentGateway,
        private readonly LoggerInterface $logger,
    ) {}
}
```

---

## 40. Prohibit Empty Constructors

Do not create constructors with no parameters.

✅ **Do:**
```php
class MerchantValidator
{
    public function validate(array $data): bool
    {
        // ...
    }
}
```

❌ **Don't:**
```php
class MerchantValidator
{
    public function __construct()
    {
        // Empty constructor
    }
}
```

---

## 41. Trailing Commas in Multi-line Arrays

Always add a trailing comma after the last element.

✅ **Do:**
```php
$riskyStatuses = [
    MerchantRiskHistory::RISKY,
    MerchantRiskHistory::REJECTED,  // <-- trailing comma
];
```

❌ **Don't:**
```php
$riskyStatuses = [
    MerchantRiskHistory::RISKY,
    MerchantRiskHistory::REJECTED   // <-- no trailing comma
];
```

---

## 42. Use instanceof for Model Null Checks

Use `instanceof` instead of `empty()` or null comparison for Eloquent models.

✅ **Do:**
```php
$bank = MerchantBankAccount::find($bankId);
if (!($bank instanceof MerchantBankAccount)) {
    return [false, ['Bank not found']];
}
```

❌ **Don't:**
```php
$bank = MerchantBankAccount::find($bankId);
if (empty($bank)) {
    return [false, ['Bank not found']];
}
```

---

## 43. Use Short Array Destructuring

Use `[$a, $b]` instead of `list()`.

✅ **Do:**
```php
[$merchant, $wallets, $riskData] = $this->getMerchantAndWallet($merchantId);
['name' => $name, 'email' => $email] = $userData;
```

❌ **Don't:**
```php
list($merchant, $wallets, $riskData) = $this->getMerchantAndWallet($merchantId);
```

---

## 44. Typed Constants with Explicit Visibility

All class constants should have explicit visibility and type declarations (PHP 8.1+).

✅ **Do:**
```php
class Merchant
{
    public const int STATUS_ACTIVE = 1;
    public const int STATUS_INACTIVE = 0;
    public const string DEFAULT_CURRENCY = 'TRY';
    protected const int MAX_RETRY_COUNT = 3;
    private const string API_VERSION = 'v2';
}
```

❌ **Don't:**
```php
class Merchant
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
}
```

---

## 45. Prefer Native PHP Functions for Simple Operations

Use native PHP functions instead of Laravel helpers for simple operations.

✅ **Do:**
```php
if (in_array($status, $allowedStatuses, true)) {
    // Use strict mode
}

if (array_key_exists('merchant_id', $data)) {
    // Check if key exists
}

// Laravel helpers OK for complex nested access
$value = Arr::get($config, 'database.connections.mysql.host');
```

❌ **Don't:**
```php
if (Arr::has($allowedStatuses, $status)) {
    // Unnecessary overhead
}
```

---

## 46. camelCase for Route Parameters

Use camelCase for route parameters.

✅ **Do:**
```php
Route::get('/merchant/{merchantId}/bank/{bankId}', [MerchantController::class, 'showBank']);

public function showBank(int $merchantId, int $bankId): View
```

❌ **Don't:**
```php
Route::get('/merchant/{merchant_id}/bank/{bank_id}', [MerchantController::class, 'showBank']);
```

---

## Quick Reference Checklist

- [ ] PSR-12 formatting
- [ ] Short array syntax `[]`
- [ ] camelCase variables, lowercase array keys
- [ ] FormRequest for validation
- [ ] Constants/Enums for magic values
- [ ] Single Responsibility
- [ ] No deep nesting
- [ ] Explicit return types
- [ ] Named parameters
- [ ] RESTful routes
- [ ] i18n for user strings
- [ ] DRY - reuse existing methods
- [ ] Repository for complex queries
- [ ] No `request()` helper
- [ ] Task numbers in comments
- [ ] `declare(strict_types=1)`
- [ ] `Model::query()` over `DB::`
- [ ] Named routes with `route()`
- [ ] `env()` only in config
- [ ] Eager loading
- [ ] Curly braces always
- [ ] Constructor property promotion
- [ ] Trailing commas
- [ ] `instanceof` for model checks
