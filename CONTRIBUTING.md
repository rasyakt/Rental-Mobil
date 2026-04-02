# 🤝 Rental Mobil - Contributing Guidelines

Terima kasih atas minat Anda untuk berkontribusi pada Rental Mobil! Panduan ini membantu memastikan kode berkualitas tinggi dan proses review yang smooth.

## 📋 Table of Contents

1. [Code of Conduct](#code-of-conduct)
2. [Getting Started](#getting-started)
3. [Development Workflow](#development-workflow)
4. [Code Standards](#code-standards)
5. [Testing Requirements](#testing-requirements)
6. [Pull Request Process](#pull-request-process)
7. [Reporting Issues](#reporting-issues)
8. [Documentation](#documentation)

---

## 📜 Code of Conduct

### Kami Berkomitmen Untuk:

- 🤝 Lingkungan yang inklusif dan welcoming
- ✨ Kolaborasi konstruktif dan saling menghormati
- 🎯 Fokus pada kualitas code dan user experience
- 🚀 Continuous improvement dan learning

### Perilaku yang Tidak Diterima:

- 🚫 Harassment atau discrimination
- 🚫 Spam atau promotional content
- 🚫 Unsafe atau malicious code
- 🚫 Disrespectful communication

---

## 🚀 Getting Started

### Prerequisites

- PHP 8.3+
- PostgreSQL 12+
- Composer
- Node.js 18+
- Git

### Setup Development Environment

```bash
# 1. Clone repository
git clone https://github.com/your-repo/rental-mobil.git
cd rental-mobil

# 2. Setup environment
cp .env.example .env
php artisan key:generate

# 3. Configure database
# Update .env dengan database credentials

# 4. Install dependencies
composer install
npm install

# 5. Run migrations & seeds
php artisan migrate:fresh --seed

# 6. Start development servers
php artisan serve        # Terminal 1
npm run dev              # Terminal 2 (dalam folder project)
```

### Verify Installation

```bash
# Check if Laravel is running
curl http://localhost:8000

# Check database connection
php artisan tinker
>>> DB::connection()->getPDO()   # Should not throw error

# Check if migrations worked
>>> DB::table('users')->count()  # Should return > 0
```

---

## 🔄 Development Workflow

### 1. Create Feature Branch

```bash
# Update main branch dulu
git checkout develop
git pull origin develop

# Create feature branch dengan naming convention
git checkout -b feature/add-vehicle-dashboard
git checkout -b fix/booking-calculation-bug
git checkout -b docs/update-readme

# Branch naming:
# feature/  - New features
# fix/      - Bug fixes
# docs/     - Documentation updates
# refactor/ - Code refactoring
# test/     - Testing improvements
# chore/    - Maintenance tasks
```

### 2. Make Your Changes

```bash
# Pastikan editor Anda pakai 4-space indentation
# PSR-12 style adalah standard

# Development best practices:
# - Commit small, logical changes
# - Write descriptive commit messages
# - Test frequently during development
# - Write tests as you code
```

### 3. Commit Changes

```bash
# Good commit message
git commit -m "feat: add vehicle availability filter to dashboard"
git commit -m "fix: resolve booking price calculation for monthly rentals"
git commit -m "docs: update API documentation for booking endpoints"

# Bad commit message
git commit -m "fixed stuff"
git commit -m "updates"
git commit -m "working version"

# Format: type(scope): description
# Types: feat, fix, docs, style, refactor, test, chore
# Scope: optional (feature area)
# Description: clear, present tense, no period
```

### 4. Keep Branch Updated

```bash
# Rebase dengan develop branch
git fetch origin
git rebase origin/develop

# Resolve conflicts jika ada
# Edit conflicted files, then:
git add .
git rebase --continue

# Atau merge jika prefer
git merge origin/develop
```

### 5. Push & Create Pull Request

```bash
# Push changes
git push origin feature/add-vehicle-dashboard

# Create PR di GitHub dengan:
# - Clear title (format: feat: ... / fix: ... / etc)
# - Detailed description
# - Link related issues
# - Screenshots untuk UI changes
```

---

## 💻 Code Standards

### PHP Code Style (PSR-12)

```php
<?php

// Use strict types
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Class declaration - opening brace on same line
class VehicleController extends Controller
{
    // Proper indentation (4 spaces)
    public function index()
    {
        $vehicles = Vehicle::paginate(15);
        return view('vehicles.index', compact('vehicles'));
    }

    // Blank line between methods
    public function store(StoreVehicleRequest $request)
    {
        $vehicle = Vehicle::create($request->validated());
        return redirect()->route('vehicles.show', $vehicle);
    }
}
```

### Naming Conventions

```php
// Classes - PascalCase
class VehicleController {}
class BookingService {}

// Methods & functions - camelCase
public function getAvailableVehicles() {}
function calculateDuration() {}

// Constants - UPPER_SNAKE_CASE
const MAX_BOOKING_DURATION = 90;
const DEFAULT_PRICE_PER_DAY = 100000;

// Variables - snake_case
$total_price = 500000;
$booking_date = now();

// Properties - camelCase
private $bookingService;
protected $vehicleRepository;
```

### Comments & Documentation

```php
/**
 * Calculate the total rental price
 *
 * @param Vehicle $vehicle The vehicle to rent
 * @param int $days Number of rental days
 * @param bool $withDriver Whether to include driver
 * @return float The total price in rupiah
 * @throws InvalidArgumentException When days is negative
 */
public function calculatePrice(Vehicle $vehicle, int $days, bool $withDriver): float
{
    if ($days <= 0) {
        throw new InvalidArgumentException('Days must be positive');
    }

    $basePrice = $vehicle->price_daily * $days;
    $driverCost = $withDriver ? $vehicle->price_driver_daily * $days : 0;
    $tax = ($basePrice + $driverCost) * 0.1;

    return $basePrice + $driverCost + $tax;
}
```

### Database Naming

```php
// Table names - snake_case plural
'vehicles'
'vehicle_categories'
'booking_details'

// Column names - snake_case singular
'vehicle_id'
'customer_id'
'created_at'
'is_active'

// Foreign keys - {table}_id
'vehicle_id'  // references vehicles table
'user_id'     // references users table

// Indexes - idx_{table}_{columns}
'idx_vehicles_category'
'idx_bookings_customer_status'

// Timestamps
'created_at'
'updated_at'
'deleted_at'

// Flags
'is_active'
'is_verified'
'with_driver'
```

### View File Naming

```
resources/views/
├── layout.blade.php              # Main layout
├── auth/
│   ├── login.blade.php
│   └── register.blade.php
├── vehicles/
│   ├── index.blade.php           # List view
│   ├── create.blade.php          # Create form
│   ├── edit.blade.php            # Edit form
│   └── show.blade.php            # Detail view
└── components/
    ├── vehicle-card.blade.php
    └── booking-form.blade.php
```

### Code Quality Tools

```bash
# Format code dengan Pint (Laravel code formatter)
php artisan pint

# Format only changed files
php artisan pint --dirty

# Check code without modifying
php artisan pint --test

# Run static analysis
php stan analyse

# Check for security issues
php artisan security-checker
```

---

## ✅ Testing Requirements

### Write Tests For:

1. **Controllers** - Test HTTP requests & responses
2. **Services** - Test business logic
3. **Models** - Test relationships & scopes
4. **Validation** - Test form request rules

### Feature Tests Example

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_create_booking()
    {
        $customer = User::factory()->create(['user_type' => 'customer']);
        $vehicle = Vehicle::factory()->create(['status' => 'available']);

        $response = $this->actingAs($customer)
            ->post('/dashboard/bookings', [
                'vehicle_id' => $vehicle->id,
                'pickup_date' => now()->addDay()->format('Y-m-d'),
                'return_date' => now()->addDays(3)->format('Y-m-d'),
                'pickup_address' => 'Jakarta Pusat',
                'with_driver' => false,
            ]);

        $response->assertRedirect('/dashboard/bookings');
        $this->assertCount(1, $customer->bookings);
    }

    public function test_cannot_book_unavailable_vehicle()
    {
        $customer = User::factory()->create(['user_type' => 'customer']);
        $vehicle = Vehicle::factory()->create(['status' => 'maintenance']);

        $response = $this->actingAs($customer)
            ->post('/dashboard/bookings', [
                'vehicle_id' => $vehicle->id,
                'pickup_date' => now()->addDay()->format('Y-m-d'),
                'return_date' => now()->addDays(3)->format('Y-m-d'),
            ]);

        $response->assertSessionHasErrors('vehicle_id');
    }
}
```

### Unit Tests Example

```php
<?php

namespace Tests\Unit;

use App\Models\Vehicle;
use App\Services\BookingService;
use Tests\TestCase;

class BookingServiceTest extends TestCase
{
    private BookingService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new BookingService();
    }

    public function test_calculate_price_daily_rental()
    {
        $vehicle = Vehicle::factory()->create([
            'price_daily' => 100000,
            'price_driver_daily' => 50000,
        ]);

        $price = $this->service->calculatePrice(
            vehicle: $vehicle,
            days: 3,
            withDriver: false
        );

        // Expected: (100k * 3) + tax
        $this->assertEquals(330000, $price);
    }

    public function test_calculate_price_with_driver()
    {
        $vehicle = Vehicle::factory()->create([
            'price_daily' => 100000,
            'price_driver_daily' => 50000,
        ]);

        $price = $this->service->calculatePrice(
            vehicle: $vehicle,
            days: 3,
            withDriver: true
        );

        // Expected: (100k + 50k) * 3 + tax
        $this->assertEquals(495000, $price);
    }
}
```

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/BookingTest.php

# Run specific test method
php artisan test --filter=test_customer_can_create_booking

# Run with coverage
php artisan test --coverage

# Run with detailed output
php artisan test --verbose
```

### Test Coverage Requirements

Minimum coverage expectations:
- **Controllers**: 70% (critical paths)
- **Services**: 90% (business logic)
- **Models**: 80% (relationships, scopes)
- **Overall**: 75%

```bash
# Generate coverage report
php artisan test --coverage --coverage-html=coverage
# Open coverage/index.html dalam browser
```

---

## 📤 Pull Request Process

### Before Creating PR

- [ ] Branch up-to-date dengan `develop`
- [ ] Code follows PSR-12 standards
- [ ] All tests passing (`php artisan test`)
- [ ] No console warnings/errors
- [ ] Code documented dengan proper comments
- [ ] Database changes include migrations
- [ ] UI changes include screenshots
- [ ] Updated relevant documentation

### PR Title Format

```
feat(scope): description
fix(scope): description
docs(scope): description
refactor(scope): description
test(scope): description

Examples:
feat(bookings): add availability filter to dashboard
fix(payments): resolve Midtrans callback verification
docs(api): update booking endpoints documentation
refactor(services): extract booking calculation logic
```

### PR Description Template

```markdown
## Description
Brief explanation of what this PR does.

## Related Issues
Fixes #123
Relates to #124

## Type of Change
- [ ] New feature
- [ ] Bug fix
- [ ] Documentation update
- [ ] Code refactoring
- [ ] Database migration
- [ ] UI/UX change

## Changes Made
- Detailed list of changes
- Another change
- One more change

## Testing Done
- [ ] Unit tests written
- [ ] Feature tests written
- [ ] Manual testing completed
- [ ] No breaking changes

## Screenshots (if UI changes)
[Add screenshots here]

## Checklist
- [ ] Code follows PSR-12 style
- [ ] Tests passing locally
- [ ] Documentation updated
- [ ] No console errors
- [ ] Database migrations included
```

### Review Process

1. **Automated Checks**
   - GitHub Actions runs tests
   - Code style checks
   - Security scanning

2. **Code Review**
   - Minimum 1 approval required
   - Changes requested addressed
   - Conversations resolved

3. **Merge**
   - Squash commits if many
   - Delete branch after merge
   - Monitor deployment

---

## 🐛 Reporting Issues

### Create Issue For:

1. **Bugs** - Unexpected behavior
2. **Features** - New functionality requests
3. **Improvements** - Enhancement suggestions
4. **Documentation** - Unclear documentation

### Issue Template

```markdown
## Description
Clear description of the issue.

## Steps to Reproduce
1. Go to page X
2. Click button Y
3. See error Z

## Expected Behavior
What should happen.

## Actual Behavior
What actually happens.

## Environment
- PHP Version: 8.3.0
- Laravel Version: 13.0
- Database: PostgreSQL 13
- Browser: Chrome 120

## Screenshots
[Add screenshots if applicable]

## Possible Solution
[Optional: suggest a fix]
```

---

## 📚 Documentation

### Update Docs When:

1. Adding new features
2. Changing API endpoints
3. Modifying database schema
4. Updating configuration
5. Adding environment variables

### Documentation Location

```
Project Root/
├── README.md              # Overview & quick start
├── SETUP_GUIDE.md        # Installation guide
├── ARCHITECTURE.md       # System architecture
├── CONTRIBUTING.md       # This file
└── docs/ (optional)
    ├── api.md            # API documentation
    ├── database.md       # Database schema
    └── deployment.md     # Deployment guide
```

### Documentation Format

Use Markdown dengan clear structure:
- H1 for main title
- H2 for sections
- H3 for subsections
- Code blocks dengan language syntax highlight
- Links untuk related docs

---

## 🎓 Learning Resources

### Laravel Resources
- [Laravel Documentation](https://laravel.com/docs)
- [Laracasts Video Tutorials](https://laracasts.com)
- [Laravel Shift Blog](https://laravelshift.com/blog)

### Database
- [PostgreSQL Documentation](https://www.postgresql.org/docs)
- [Database Optimization Tips](https://www.postgresql.org/docs/current/performance.html)

### Code Quality
- [PSR-12 Coding Standard](https://www.php-fig.org/psr/psr-12/)
- [Clean Code Principles](https://en.wikipedia.org/wiki/Code_smell)
- [SOLID Principles](https://en.wikipedia.org/wiki/SOLID)

### Testing
- [Laravel Testing Documentation](https://laravel.com/docs/testing)
- [Pest Testing Framework](https://pestphp.com)

---

## ❓ Help & Support

### Questions?

- 📧 Email: dev@rental-mobil.id
- 💬 Slack/Discord: development-channel
- 📝 GitHub Discussions: [Link]

### Code Review Feedback

- Be respectful & constructive
- Suggest improvements, don't demand
- Ask questions if unclear
- Praise good code

---

## 🎉 Recognition

Contributors akan di-recognize di:
- README.md contributors section
- Release notes
- Annual appreciation event

---

Thank you untuk kontribusi Anda! 🙏

**Last Updated**: 2024 | **Maintained by**: Development Team
