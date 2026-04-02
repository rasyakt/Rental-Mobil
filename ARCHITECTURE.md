# 🏗️ Rental Mobil - Architecture & Design Documentation

Dokumentasi lengkap tentang arsitektur, design patterns, dan best practices dalam Rental Mobil system.

## 📑 Table of Contents

1. [System Architecture Overview](#system-architecture-overview)
2. [Layer Architecture](#layer-architecture)
3. [Design Patterns](#design-patterns)
4. [Database Design](#database-design)
5. [API Design](#api-design)
6. [Security Architecture](#security-architecture)
7. [Performance Considerations](#performance-considerations)
8. [Code Organization](#code-organization)
9. [Development Guidelines](#development-guidelines)

---

## 🏢 System Architecture Overview

### High-Level Architecture Diagram

```
┌─────────────────────────────────────────────────────────────┐
│                       CLIENT LAYER                          │
│         (Web Browser - HTML, CSS, JS, Alpine.js)            │
└──────────────────────────┬──────────────────────────────────┘
                           │
          ┌────────────────┼────────────────┐
          │                │                │
          ▼                ▼                ▼
    ┌──────────────┐ ┌──────────────┐ ┌──────────────┐
    │    Routes    │ │   Middleware │ │   Requests   │
    │  (web.php)   │ │  (Auth, Role)│ │ (Validation) │
    └──────────────┘ └──────────────┘ └──────────────┘
          │                │                │
          └────────────────┼────────────────┘
                           │
                    ┌──────▼──────────┐
                    │  CONTROLLER     │
                    │    LAYER        │
                    └──────┬──────────┘
                           │
          ┌────────────────┼────────────────┐
          │                │                │
          ▼                ▼                ▼
    ┌──────────────┐ ┌──────────────┐ ┌──────────────┐
    │   Services   │ │   Traits     │ │  Helpers     │
    │(Business Log)│ │ (Reusable)   │ │  (Utilities) │
    └──────┬───────┘ └──────────────┘ └──────────────┘
           │
    ┌──────▼──────────┐
    │  MODEL LAYER    │
    │   (Eloquent)    │
    ├─────────────────┤
    │ - Relationships │
    │ - Scopes        │
    │ - Casts         │
    │ - Mutators      │
    └──────┬──────────┘
           │
    ┌──────▼──────────────┐
    │  QUERY BUILDER      │
    │  (Eloquent/PDO)     │
    └──────┬──────────────┘
           │
    ┌──────▼──────────────┐
    │   DATABASE LAYER    │
    │   (PostgreSQL)      │
    ├─────────────────────┤
    │ - Tables            │
    │ - Indexes           │
    │ - Constraints       │
    │ - Triggers          │
    └─────────────────────┘
```

### Technology Stack

```
┌─────────────────────────────────────────────────────────┐
│                    PRESENTATION LAYER                   │
│  Blade Templates | Tailwind CSS | Alpine.js | Vite     │
└────────────────────┬──────────────────────────┬─────────┘
                     │                          │
┌────────────────────▼──────────────────────────▼─────────┐
│                   APPLICATION LAYER                     │
│  Laravel 13 | Controllers | Services | Models | Routes  │
├─────────────────────────────────────────────────────────┤
│                   BUSINESS LOGIC                        │
│  BookingService | PaymentService | Middleware          │
├─────────────────────────────────────────────────────────┤
│                 DATA ACCESS LAYER                       │
│  Eloquent ORM | Query Builder | Repositories           │
├─────────────────────────────────────────────────────────┤
│                   DATABASE LAYER                        │
│  PostgreSQL 12+ | Migrations | Seeders                  │
└─────────────────────────────────────────────────────────┘

INFRASTRUCTURE SERVICES:
├─ Authentication: Laravel Auth + Custom Middleware
├─ Authorization: Role-Based Access Control
├─ File Storage: Local/S3
├─ Caching: Database/Redis
├─ Jobs: Database Queue
├─ Session: Database/File
├─ Logging: Single Channel
└─ Mail: SMTP/Mailgun
```

---

## 🔒 Layer Architecture

### 1. **Presentation Layer** (resources/views)

Tanggung jawab:
- Tampilkan data ke user
- Terima user input
- Format output (HTML, JSON)

Struktur:
```
resources/views/
├── layout.blade.php              # Master layout
├── auth/
│   ├── login.blade.php
│   └── register.blade.php
├── public/
│   ├── landing.blade.php
│   ├── vehicles.blade.php
│   └── vehicle-detail.blade.php
├── customer/
│   ├── dashboard.blade.php
│   ├── bookings/
│   ├── payments/
│   └── profile.blade.php
├── admin/
│   ├── dashboard.blade.php
│   ├── vehicles/
│   ├── drivers/
│   ├── bookings/
│   ├── payments/
│   └── reports/
└── errors/
    └── 404.blade.php
```

Best Practices:
- Gunakan components untuk reusable sections
- Keep business logic di controller/service
- Use Alpine.js untuk simple interactions
- Minimize JavaScript di templates

---

### 2. **Controller Layer** (app/Http/Controllers)

Tanggung jawab:
- Handle HTTP requests
- Call appropriate services/models
- Return responses
- Validate input menggunakan Request classes

Controller Categories:

**AuthController**
- Handle login/register/logout
- Create customer profile automatically

**Public Controllers**
- LandingController: Homepage, static pages
- SearchController: Vehicle search dengan filters

**Customer Controllers**
- DashboardController: Dashboard stats
- VehicleController: View vehicles
- BookingController: CRUD bookings
- PaymentController: Payment processing
- ProfileController: User profile management

**Admin Controllers**
- DashboardController: Admin statistics
- BranchController: Branch management
- VehicleController: Vehicle management
- DriverController: Driver management
- BookingController: Booking confirmations & assignments
- PaymentController: Payment verification
- MaintenanceController: Maintenance scheduling
- UserController: User & role management
- ReportController: Reports & exports

Best Practices:
```php
// ✅ Good - Thin controller
class BookingController {
    public function store(StoreBookingRequest $request)
    {
        $booking = $this->bookingService->createBooking(
            $request->validated()
        );
        return redirect()->route('bookings.show', $booking);
    }
}

// ❌ Bad - Fat controller
class BookingController {
    public function store(Request $request)
    {
        // 50 lines of business logic...
        $booking = new Booking;
        $booking->booking_number = generate_number();
        // ... more logic
    }
}
```

---

### 3. **Service Layer** (app/Services)

Tanggung jawab:
- Business logic execution
- Data transformation
- External API integration
- Transaction management

Available Services:

**BookingService**
```php
// Methods:
- calculatePrice($vehicle, $duration, $options)
- isVehicleAvailable($vehicleId, $fromDate, $toDate)
- createBooking($bookingData)
- confirmBooking($bookingId)
- cancelBooking($bookingId)
```

**PaymentService**
```php
// Methods:
- createPayment($bookingId, $amount)
- processMidtrans($payment)
- verifyMidtrans($snapToken)
- markAsPaid($paymentId)
- markAsFailed($paymentId)
```

Best Practices:
```php
// ✅ Good - Service encapsulates logic
class BookingService {
    public function calculatePrice(Vehicle $vehicle, array $options): array
    {
        $days = $options['days'];
        $withDriver = $options['with_driver'];
        
        $basePrice = $this->getBasePrice($vehicle, $days);
        $driverCost = $withDriver ? $vehicle->price_driver_daily * $days : 0;
        $tax = ($basePrice + $driverCost) * 0.1;
        
        return [
            'base_price' => $basePrice,
            'driver_cost' => $driverCost,
            'tax' => $tax,
            'total' => $basePrice + $driverCost + $tax
        ];
    }
}

// Usage in controller:
$booking = $bookingService->createBooking($validated);
```

---

### 4. **Model Layer** (app/Models)

Eloquent Models dengan relationships, scopes, dan business methods.

Key Models:

**User** - Extended user model
```php
- hasMany('Booking', 'customer_id') // untuk customer
- hasMany('Role')
- hasOne('Customer')
- belongsTo('Branch')
- hasPermission($permission) // method
```

**Vehicle** - Rental vehicles
```php
- belongsTo('VehicleCategory')
- belongsTo('Branch')
- hasMany('VehicleImage')
- hasMany('VehicleFeature')
- hasMany('Booking')
- isAvailable($fromDate, $toDate) // method
- isNeedsMaintenance() // method
```

**Booking** - Customer bookings
```php
- belongsTo('Customer')
- belongsTo('Vehicle')
- belongsTo('Driver')
- hasMany('BookingDetail')
- hasMany('Payment')
- getDurationDays() // method
- canBeCancelled() // method
```

**Payment** - Payment transactions
```php
- belongsTo('Booking')
- belongsTo('PaymentMethod')
- scopePending() // scope untuk filter
- scopeCompleted() // scope
```

Best Practices:
```php
// ✅ Use scopes untuk filtering
$bookings = Booking::active()->byCustomer($customerId)->get();

// ✅ Use relationships properly loaded
$bookings = Booking::with(['vehicle', 'customer', 'payment'])->get();

// ✅ Use accessors untuk computed properties
protected $appends = ['formatted_price', 'status_badge'];

// ✅ Use mutators untuk transforming input
protected function final_price(): Attribute
{
    return Attribute::make(
        set: fn($value) => round($value, 2)
    );
}
```

---

### 5. **Database Layer** (database/)

Migrations & Seeders untuk database management.

Database Migrations:
```
database/migrations/
├── 0001_01_01_000000_create_users_table.php
├── 2024_04_01_000001_create_roles_and_permissions_table.php
├── 2024_04_01_000002_create_branches_and_vehicles_table.php
├── 2024_04_01_000003_create_drivers_and_customers_table.php
├── 2024_04_01_000004_create_bookings_table.php
├── 2024_04_01_000005_create_payments_and_invoices_table.php
├── 2024_04_01_000006_create_tracking_and_maintenance_table.php
└── 2024_04_01_000007_create_promotions_and_logs_table.php
```

Database Seeders:
```
database/seeders/
├── RolePermissionSeeder.php
├── BranchSeeder.php
├── VehicleCategorySeeder.php
├── VehicleSeeder.php
├── DriverSeeder.php
├── UserSeeder.php
└── DatabaseSeeder.php
```

---

## 🎯 Design Patterns

### 1. **Service Pattern**

Encapsulate business logic dalam service classes.

```php
// app/Services/BookingService.php
class BookingService {
    public function createBooking(array $data): Booking
    {
        DB::beginTransaction();
        try {
            // Calculate pricing
            $pricing = $this->calculatePrice($data);
            
            // Create booking
            $booking = Booking::create([
                'customer_id' => $data['customer_id'],
                'vehicle_id' => $data['vehicle_id'],
                'pickup_date' => $data['pickup_date'],
                'return_date' => $data['return_date'],
                'total_price' => $pricing['total'],
                'status' => 'pending'
            ]);
            
            // Create order items
            $booking->details()->create($data['details']);
            
            DB::commit();
            return $booking;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}

// Usage in controller
class BookingController {
    public function __construct(private BookingService $service) {}
    
    public function store(StoreBookingRequest $request)
    {
        $booking = $this->service->createBooking($request->validated());
        return redirect()->route('bookings.show', $booking);
    }
}
```

### 2. **Repository Pattern** (Optional Enhancement)

Abstrak database queries untuk easier testing.

```php
// app/Repositories/BookingRepository.php
interface BookingRepository {
    public function findById($id): Booking;
    public function findByCustomer($customerId);
    public function create(array $data): Booking;
    public function update($id, array $data): bool;
}

class EloquentBookingRepository implements BookingRepository {
    public function findByCustomer($customerId)
    {
        return Booking::where('customer_id', $customerId)
            ->with(['vehicle', 'payment'])
            ->latest()
            ->get();
    }
}

// Usage
class BookingService {
    public function __construct(private BookingRepository $repo) {}
    
    public function getUserBookings($customerId)
    {
        return $this->repo->findByCustomer($customerId);
    }
}
```

### 3. **Middleware Pattern**

Handle cross-cutting concerns seperti authentication dan authorization.

```php
// app/Http/Middleware/CheckCustomer.php
class CheckCustomer {
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->user_type !== 'customer') {
            abort(403, 'Unauthorized');
        }
        return $next($request);
    }
}

// routes/web.php
Route::middleware(['auth', 'customer'])
    ->prefix('dashboard')
    ->group(function() {
        Route::get('/', [DashboardController::class, 'index']);
    });
```

### 4. **Factory Pattern** (Model Factories)

Generate test data untuk testing.

```php
// database/factories/BookingFactory.php
class BookingFactory extends Factory {
    public function definition(): array {
        return [
            'booking_number' => 'BK-' . now()->format('YmdHis'),
            'customer_id' => Customer::factory(),
            'vehicle_id' => Vehicle::factory(),
            'pickup_date' => now()->addDay(),
            'return_date' => now()->addDays(3),
            'status' => 'pending',
            'total_price' => 500000
        ];
    }
}

// Usage dalam tests
$booking = Booking::factory()->create();
$bookings = Booking::factory(10)->create();
```

### 5. **Observer Pattern** (Model Events)

Trigger actions ketika model events terjadi.

```php
// app/Observers/BookingObserver.php
class BookingObserver {
    public function created(Booking $booking)
    {
        // Create payment record
        Payment::create([
            'booking_id' => $booking->id,
            'amount' => $booking->total_price,
            'status' => 'pending'
        ]);
    }
    
    public function confirmed(Booking $booking)
    {
        // Send confirmation email
        Mail::send(new BookingConfirmed($booking));
    }
}

// app/Providers/AppServiceProvider.php
class AppServiceProvider extends ServiceProvider {
    public function boot()
    {
        Booking::observe(BookingObserver::class);
    }
}
```

### 6. **Trait Pattern** (Code Reusability)

Share functionality across multiple models.

```php
// app/Models/Traits/HasTimestamps.php
trait HasTimestamps {
    public function getCreatedAtAttribute()
    {
        return $this->attributes['created_at']->format('d M Y H:i');
    }
    
    public function getUpdatedAtAttribute()
    {
        return $this->attributes['updated_at']->format('d M Y H:i');
    }
}

// Usage
class Booking extends Model {
    use HasTimestamps;
}
```

---

## 🗄️ Database Design

### ERD (Entity Relationship Diagram)

```
Users ──┬─ 1:N ── Bookings
        │
        ├─ 1:N ── Customer
        │
        ├─ 1:N ── Driver
        │
        ├─ M:N ── Roles
        │
        └─ 1:N ── AuditLog

Branches ──┬─ 1:N ── Vehicles
           │
           ├─ 1:N ── Drivers
           │
           ├─ 1:N ── VehicleTracking
           │
           └─ 1:N ── MaintenanceLogs

Vehicles ──┬─ 1:N ── VehicleImages
           │
           ├─ 1:N ── VehicleFeatures
           │
           ├─ 1:N ── VehicleTrackings
           │
           ├─ 1:N ── Bookings
           │
           └─ 1:N ── MaintenanceLogs

Bookings ──┬─ 1:N ── BookingDetails
           │
           ├─ 1:N ── BookingAmenities
           │
           ├─ 1:1 ── Payment
           │
           └─ 1:1 ── Invoice

Drivers ──┬─ 1:N ── DriverSchedules
          │
          └─ 1:N ── Bookings

Customers ──── Customer Info

Payments ──┬─ 1:1 ── Invoice
           │
           └─ 1:N ── Refunds

Promotions ──── Discount Rules
```

### Indexing Strategy

```sql
-- Frequently searched columns
indexes:
- users(email) -> login queries
- bookings(customer_id, status) -> customer bookings filtered
- bookings(vehicle_id, pickup_date, return_date) -> availability check
- vehicles(branch_id, status) -> branch vehicles
- payments(booking_id, status) -> payment lookups
- vehicle_tracking(vehicle_id, created_at) -> tracking history
```

### Partitioning Strategy (untuk data besar)

```sql
-- Optional: Range partition bookings by year
ALTER TABLE bookings PARTITION BY RANGE (YEAR(created_at)) (
    PARTITION p2023 VALUES LESS THAN (2024),
    PARTITION p2024 VALUES LESS THAN (2025),
    PARTITION p2025 VALUES LESS THAN (2026)
);
```

---

## 🔌 API Design

### RESTful Naming Conventions

```
GET    /api/vehicles              # List all
POST   /api/vehicles              # Create
GET    /api/vehicles/{id}         # Show
PUT    /api/vehicles/{id}         # Full update
PATCH  /api/vehicles/{id}         # Partial update
DELETE /api/vehicles/{id}         # Delete

# Nested resources
GET    /api/vehicles/{id}/images  # Related resources
POST   /api/bookings/{id}/confirm # Custom actions
```

### Response Format

```json
{
  "success": true,
  "code": 200,
  "message": "Operation successful",
  "data": {
    "id": 1,
    "name": "Toyota Avanza",
    "price": 350000
  },
  "meta": {
    "page": 1,
    "per_page": 15,
    "total": 100
  }
}
```

### Error Response Format

```json
{
  "success": false,
  "code": 422,
  "message": "Validation failed",
  "errors": {
    "email": ["Email already exists"],
    "phone": ["Phone format invalid"]
  }
}
```

---

## 🔐 Security Architecture

### Authentication Flow

```
User → Login Form
       ↓
  Validate Credentials
       ↓
  Create Session
       ↓
  Set Auth Cookie
       ↓
  Redirect to Dashboard
```

### Authorization Flow

```
Request → Check Auth Middleware
           ↓
        Check Role Middleware
           ↓
        Check Permission
           ↓
        Allow/Deny Access
```

### Security Measures

```php
// CSRF Protection
<form method="POST">
    @csrf
    ...
</form>

// Input Validation
class StoreBookingRequest extends FormRequest {
    public function rules(): array {
        return [
            'pickup_date' => 'required|date|after:today',
            'vehicle_id' => 'required|exists:vehicles,id',
        ];
    }
}

// SQL Injection Prevention
// ✅ Using Eloquent:
$booking = Booking::where('id', $id)->first();

// Password Hashing
Hash::make('password'); // Argon2id hashing

// HTTPS Enforcement
APP_ENV=production // Forces HTTPS
SECURE_HSTS_ENABLED=true
```

---

## ⚡ Performance Considerations

### Query Optimization

```php
// ❌ N+1 Query Problem
$bookings = Booking::all();
foreach ($bookings as $booking) {
    echo $booking->vehicle->name; // Extra query per booking!
}

// ✅ Use eager loading
$bookings = Booking::with('vehicle', 'customer')->get();
foreach ($bookings as $booking) {
    echo $booking->vehicle->name; // Single query
}

// ✅ Lazy eager loading
$bookings = Booking::all();
$bookings->load('vehicle', 'customer');
```

### Caching Strategy

```php
// Cache frequently accessed data
$vehicles = cache()->remember('vehicles:all', 60*60, function() {
    return Vehicle::active()->get();
});

// Cache per branch
$branchVehicles = cache()->remember(
    "vehicles:branch:{$branchId}",
    60*60,
    fn() => Vehicle::where('branch_id', $branchId)->get()
);

// Clear cache on update
protected static function booted()
{
    static::updated(function($model) {
        cache()->forget('vehicles:all');
        cache()->forget("vehicles:branch:{$model->branch_id}");
    });
}
```

### Database Indexing

```sql
-- Index for fast lookups
CREATE INDEX idx_bookings_customer ON bookings(customer_id);
CREATE INDEX idx_vehicles_branch ON vehicles(branch_id);
CREATE INDEX idx_bookings_status ON bookings(status);

-- Composite index untuk common queries
CREATE INDEX idx_bookings_customer_status 
    ON bookings(customer_id, status);

-- Index untuk date ranges
CREATE INDEX idx_bookings_dates 
    ON bookings(pickup_date, return_date);
```

### Pagination

```php
// Paginate large result sets
$bookings = Booking::paginate(15);

// In view
{{ $bookings->links() }} // Bootstrap/Tailwind pagination
```

---

## 📂 Code Organization

### Directory Structure

```
app/
├── Console/              # Artisan commands
├── Events/              # Application events
├── Exceptions/          # Custom exceptions
├── Http/
│   ├── Controllers/     # Request handlers
│   ├── Middleware/      # Request middleware
│   └── Requests/        # Form request classes
├── Jobs/                # Queued jobs
├── Listeners/           # Event listeners
├── Mail/                # Mailable classes
├── Models/              # Eloquent models
├── Observers/           # Model observers
├── Policies/            # Authorization policies
├── Providers/           # Service providers
├── Services/            # Business logic
├── Traits/              # Reusable traits
├── Casts/               # Custom attribute casts
└── Enums/               # PHP enums

database/
├── migrations/          # Schema definitions
├── seeders/             # Database seeders
└── factories/           # Model factories

resources/
├── css/                 # Stylesheets
├── js/                  # JavaScript files
└── views/               # Blade templates

routes/
├── web.php              # Web routes
├── api.php              # API routes (optional)
└── console.php          # Artisan commands

tests/
├── Feature/             # Feature tests
└── Unit/                # Unit tests
```

### File Naming Conventions

```
Models:          Vehicle.php
Controllers:     VehicleController.php
Requests:        StoreVehicleRequest.php
Services:        VehicleService.php
Policies:        VehiclePolicy.php
Events:          VehicleCreated.php
Listeners:       SendVehicleNotification.php
Jobs:            ProcessVehicleImage.php
```

---

## 📋 Development Guidelines

### Code Style

**PSR-12 & Laravel Conventions:**

```php
// Class declaration
class BookingController extends Controller
{
    // 4-space indentation
    public function index()
    {
        // ...
    }
    
    // Separate methods with blank line
    public function show(Booking $booking)
    {
        // ...
    }
}
```

### Commenting Standards

```php
/**
 * Calculate total rental price
 *
 * @param Vehicle $vehicle
 * @param int $days
 * @param bool $withDriver
 * @return float
 */
public function calculatePrice(Vehicle $vehicle, int $days, bool $withDriver): float
{
    // Implementation...
}
```

### Testing Standards

```php
// Feature test untuk testing full workflows
class BookingTest extends TestCase
{
    public function test_customer_can_create_booking()
    {
        $customer = User::factory()->create(['user_type' => 'customer']);
        $vehicle = Vehicle::factory()->create();
        
        $response = $this->actingAs($customer)
            ->post('/dashboard/bookings', [
                'vehicle_id' => $vehicle->id,
                'pickup_date' => now()->addDay(),
                'return_date' => now()->addDays(3),
            ]);
        
        $response->assertRedirect('/dashboard/bookings');
        $this->assertCount(1, Booking::all());
    }
}

// Unit test untuk testing business logic
class BookingServiceTest extends TestCase
{
    public function test_calculate_price_with_driver()
    {
        $service = new BookingService();
        $vehicle = Vehicle::factory()->create([
            'price_daily' => 100000,
            'price_driver_daily' => 50000
        ]);
        
        $price = $service->calculatePrice($vehicle, 3, true);
        
        $this->assertEquals(450000, $price); // (100k + 50k) * 3
    }
}
```

### Git Workflow

```bash
# Create feature branch
git checkout -b feature/vehicle-management

# Make changes and commit
git add .
git commit -m "feat: add vehicle image upload"

# Push to remote
git push origin feature/vehicle-management

# Create pull request untuk review
```

### Commit Message Convention

```
feat:     New feature
fix:      Bug fix
docs:     Documentation
style:    Code style (formatting, missing semicolons, etc)
refactor: Refactoring code
perf:     Performance improvements
test:     Adding tests
chore:    Maintenance tasks

Examples:
feat: add vehicle image upload functionality
fix: resolve booking availability check bug
docs: update API documentation
refactor: extract booking service logic
```

---

## 🔄 Workflow & Best Practices

### Local Development Workflow

```bash
# 1. Pull latest changes
git pull origin develop

# 2. Create new feature branch
git checkout -b feature/your-feature

# 3. Install dependencies jika ada changes
composer install
npm install

# 4. Run database migrations if any
php artisan migrate

# 5. Make your changes

# 6. Run tests
php artisan test

# 7. Check code quality
php artisan pint --dirty

# 8. Commit changes
git add .
git commit -m "feat: your feature description"

# 9. Push to remote
git push origin feature/your-feature

# 10. Create Pull Request on GitHub
```

### Performance Checklist

Before pushing to production:

- [ ] All N+1 queries eliminated with eager loading
- [ ] Proper indexes created on frequently queried columns  
- [ ] Database transactions used for multi-step operations
- [ ] Caching implemented for expensive operations
- [ ] Pagination used for large result sets
- [ ] API responses optimized (select specific columns)
- [ ] Static assets minimized and cached
- [ ] Database queries profiled and optimized
- [ ] Load testing performed on critical paths

---

## 📚 Resources

- [Laravel Architecture Best Practices](https://laravel.com/docs/architecture-concepts)
- [PostgreSQL Performance Tuning](https://www.postgresql.org/docs/current/performance.html)
- [Clean Code in PHP](https://medium.com/web-dev-without-php)
- [SOLID Principles](https://en.wikipedia.org/wiki/SOLID)

---

**Created**: 2024 | **Updated**: Latest | **Maintained by**: Development Team
