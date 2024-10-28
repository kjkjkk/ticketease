<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HeatmapController;
use App\Http\Controllers\Admin\HistoryController;
use App\Http\Controllers\Admin\TicketRequestController;
use App\Http\Controllers\Admin\Heatmap\DistrictVsMonthController;
use App\Http\Controllers\Admin\Heatmap\TechnicianVsMonthController;
use App\Http\Controllers\Admin\Heatmap\DeviceVsMonthController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ReportController;
// Technician Controllers
use App\Http\Controllers\Technician\DashboardController as TechDashboardController;
use App\Http\Controllers\Technician\HistoryController as TechHistoryController;
// Requestor Controllers
use App\Http\Controllers\Requestor\CreateTicketController;
use App\Http\Controllers\Requestor\HomeController;
use App\Http\Controllers\Requestor\MyRequestController;
// Shared Controllers
use App\Http\Controllers\Shared\WalkInController;
use App\Http\Controllers\Shared\MyTicketController;
use App\Http\Controllers\Shared\CalendarController;
use App\Http\Controllers\Shared\ShowTicketController;
use App\Http\Controllers\Shared\ManageUserController;
use App\Http\Controllers\Shared\ViewTicketController;
use App\Http\Controllers\Shared\ProfileController;
// Model Controllers
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\ServiceReportController;
use App\Http\Controllers\Visualization\ChartsController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role === 'Admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'Technician') {
            return redirect()->route('technician.dashboard');
        } elseif ($user->role === 'Requestor') {
            return redirect()->route('requestor.home');
        }
    }
    return view('auth.login');
});

Auth::routes(['verify' => true]);
Auth::routes(['reset' => true]);

Route::middleware('auth')->group(function () {
    Route::group(['prefix' => '/ticket', 'as' => 'ticket'], function () {
        Route::post('/store', [TicketController::class, 'store'])->name('.store');
        Route::put('/update', [TicketController::class, 'update'])->name('.update');
    });

    Route::controller(ChartsController::class)->group(function () {
        // Admin Data Charts
        Route::get('pending-tickets-data', 'getPendingTicketsData');
        Route::get('district-tickets-data', 'getDistrictTicketsData');
        Route::get('ticket-nature-tickets-data', 'getTicketNatureTicketsData');

        // Technician Data Charts
        Route::get('technician-monthly-tickets-data', 'getTechnicianMonthlyTickets');
        Route::get('technician-ticket-nature-per-month', 'getTechniciansTicketPerMonth');
        Route::get('technician-pending-ticekts-data', 'getTechnicianPendingTicketsData');
    });

    Route::get('/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::patch('/update-profile-information/{id}', [UserController::class, 'update'])->name('user.update-profile');
    Route::post('/change-signature', [UserController::class, 'changeSignature'])->name('change-signature');
    Route::post('/remove-signature', [UserController::class, 'removeSignature'])->name('remove-signature');
    // added route for changing of email --- h
    Route::patch('/change-email/{id}', [UserController::class, 'changeEmail'])->name('change-email');

    // setting up of routes for profile setup of both tech and requestor --- h
    Route::get('/profile-setup', [ProfileController::class, 'setup'])->name('profile-setup');
    Route::post('/store', [ProfileController::class, 'store'])->name('profile-setup.store');
    Route::get('/verify', [ProfileController::class, 'show'])->name('verify');

    // View Ticket
    Route::get('/view-ticket/{id}/{route}', [ViewTicketController::class, 'index'])->name('view-ticket');

    // Notifications Routes
    Route::get('/notifications', [NotificationController::class, 'getAllNotifications'])->name('notifications.all');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadNotificationsCount'])->name('notifications.unread-count');
    Route::post('/notifications/toggle-read/{notification}', [NotificationController::class, 'toggleIfRead'])->name('notifications.toggle-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
});

// Routes shared by Admin and Technician
Route::middleware(['auth', 'checkRole:Admin,Technician'])->group(function () {
    Route::group(['prefix' => 'shared'], function () {
        // Notification
        Route::get('/see-all-notifications', [NotificationController::class, 'seeAllNotifications'])->name('see-all-notifications');
        Route::get('/mark-read-or-unread/{notification}', [NotificationController::class, 'getToggleIfRead'])->name('mark-read-or-unread');
        Route::get('/mark-all-as-read', [NotificationController::class, 'getMarkAllAsRead'])->name('mark-all-as-read');
        // Walk-in Routes
        Route::group(['prefix' => 'walk-in', 'as' => 'shared.walk-in'], function () {
            Route::get('/', [WalkInController::class, 'index'])->name('');
        });
        // Invalid Ticket 
        Route::post('/invalid-ticket', [TicketController::class, 'invalid'])->name('invalid-ticket');
        // My Tickets Routes
        Route::group(['prefix' => 'my-tickets', 'as' => 'shared.my-tickets'], function () {
            Route::get('/', [MyTicketController::class, 'index'])->name('');
            Route::post('/reassign-ticket', [MyTicketController::class, 'reassignTicket'])->name('.reassign-ticket');
            Route::post('/cancel-reassign-ticket', [MyTicketController::class, 'cancelReassignTicket'])->name('.cancel-reassign-ticket');
            Route::patch('/submit-reassign', [MyTicketController::class, 'acceptOrRejectReassign'])->name('.submit-reassign');
        });
        // Calendar Routes
        Route::group(['prefix' => 'calendar', 'as' => 'shared.calendar'], function () {
            Route::get('/', [CalendarController::class, 'index'])->name('');
            Route::post('/store', [CalendarController::class, 'store'])->name('.store');
            Route::put('/edit', [CalendarController::class, 'edit'])->name('.edit');
        });
        // Show Ticket Routes
        Route::group(['prefix' => 'show-ticket', 'as' => 'shared'], function () {
            Route::get('/{id}/{route}', [ShowTicketController::class, 'index'])->name('.show-ticket');
            Route::post('/open-ticket', [ShowTicketController::class, 'openTicket'])->name('.open-ticket');
            Route::patch('/render-service', [ShowTicketController::class, 'renderService'])->name('.render-service');
            Route::patch('/update-service-status/{id}', [TicketController::class, 'updateServiceStatus'])->name('.update-service-status');
            Route::patch('/update-status', [ShowTicketController::class, 'updateTicketStatus'])->name('.update-status');
        });
        // Mange users route
        Route::group(['prefix' => 'manage-users', 'as' => 'shared.manage-users'], function () {
            Route::get('/', [ManageUserController::class, 'index'])->name('');
            Route::post('/store', [UserController::class, 'store'])->name('.store');
            Route::patch('/reset-password', [ManageUserController::class, 'resetPassword'])->name('.reset-password');
            Route::patch('/update-user-status', [ManageUserController::class, 'updateUserStatus'])->name('.update-user-status');
            Route::delete('/delete-user', [ManageUserController::class, 'destroy'])->name('.delete-user');
        });

        //Closing ticket route
        Route::patch('/close-ticket', [TicketController::class, "closeTicket"])->name('close-ticket');
        //For waste ticket route
        Route::patch('/for-waste', [TicketController::class, "forWaste"])->name('for-waste-ticket');
        //To CITC ticket route
        Route::patch('/to-citc', [TicketController::class, "toCitc"])->name('to-citc-ticket');

        // Service Report Routes
        Route::post('/browserpdf', [ServiceReportController::class, 'pdfinbrowser'])->name('browserpdf');
        Route::post('/downloadpdf', [ServiceReportController::class, 'downloadpdf'])->name('downloadpdf');
        Route::get('/service-report/{ticket_id}', [ServiceReportController::class, 'showpdf'])->name('service-report');
    });
});

// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::group(['prefix' => 'admin', 'as' => 'admin'], function () {
        //----------------changesssss-------------
        // Route::get('/send-notify', [NotifyProcessed::class, 'store'])->name('ticketDetails');
        //----------------changesssss-------------      
        // Dashboard Routes
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('.dashboard');
        // Report Route
        Route::get('/reports', [ReportController::class, 'index'])->name('.reports');
        Route::post('/export-report', [ReportController::class, 'export'])->name(('.export'));
        // Heatmap Routes
        // Route::get('/heatmap', [HeatmapController::class, 'index'])->name('.heatmap');
        Route::group(['prefix' => 'heatmap', 'as' => '.heatmap'], function () {
            Route::get('/', [HeatmapController::class, 'index'])->name('');

            Route::get('/district-vs-month', [DistrictVsMonthController::class, 'index'])->name('.district-vs-month');
            Route::get('/district-vs-month/{district}/{month}/{year}', [DistrictVsMonthController::class, 'district_vs_month'])->name('.drilldown.distict-vs-month');

            Route::get('/technician-vs-month', [TechnicianVsMonthController::class, 'index'])->name('.technician-vs-month');
            Route::get('/technician-vs-month/{technician}/{month}/{year}', [TechnicianVsMonthController::class, 'technician_vs_month'])->name('.drilldown.technician-vs-month');

            Route::get('/device-vs-month', [DeviceVsMonthController::class, 'index'])->name('.device-vs-month');
            Route::get('/device-vs-month/{device}/{month}/{year}', [DeviceVsMonthController::class, 'device_vs_month'])->name('.drilldown.device-vs-month');
        });

        // Ticket Request Routes
        Route::group(['prefix' => 'ticket-request', 'as' => '.ticket-request'], function () {
            Route::get('/', [TicketRequestController::class, 'index'])->name('');
            Route::get('/queue', [TicketRequestController::class, 'queue'])->name('.queue');
            Route::post('/assign', [TicketRequestController::class, 'assign'])->name('.assign');
        });
        // History Routes
        Route::get('/history', [HistoryController::class, 'index'])->name('.history');

        Route::get('/settings', [SettingsController::class, 'index'])->name('.settings');

        Route::get('/monthly-report', [DashboardController::class, 'exportMonthlyReport'])->name('.monthly-report');

        Route::post('/assign-temporary-admin', [UserController::class, 'assignTemporaryAdmin'])->name('.assign-temporary-admin');
        Route::post('/cancel-temporary-admin', [UserController::class, 'cancelTemporaryAdmin'])->name('.cancel-temporary-admin');
    });
});

// Technician Routes
Route::middleware(['auth', 'technician'])->group(function () {
    Route::group(['prefix' => 'technician', 'as' => 'technician'], function () {
        // Dashboard Routes
        Route::get('/dashboard', [TechDashboardController::class, 'index'])->name('.dashboard');

        Route::get('/history', [TechHistoryController::class, 'index'])->name('.history');
    });

    // Route::get('/history', [TechHistoryController::class, 'index'])->name('.history');
});

// Requestor Routes
Route::middleware(['auth', 'requestor'])->group(function () {

    Route::group(['prefix' => 'requestor', 'as' => 'requestor'], function () {
        // Home Routes
        Route::get('/home', [HomeController::class, 'index'])->name('.home');
        // Create Ticket Routes
        Route::group(['prefix' => 'create-ticket', 'as' => '.create-ticket'], function () {
            Route::get('/', [CreateTicketController::class, 'index'])->name('');
            Route::post('/store', [CreateTicketController::class, 'store'])->name('.store');
        });
        // My Requests Routes
        Route::get('/my-requests', [MyRequestController::class, 'index'])->name('.my-requests');
        // Reset Ticket Route
        Route::post('/reset-ticket', [CreateTicketController::class, 'resetTicket'])->name('.reset-ticket');
        // View Ticket
        Route::get('/view-ticket/{ticket_id}', [MyRequestController::class, 'viewTicket'])->name('.view-ticket');
    });
});
