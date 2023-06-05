<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CoachGptController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ListsController;
use App\Http\Controllers\MotivationTagsController;
use App\Http\Controllers\PipelineController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoiceMailController;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CompaignController;
use App\Http\Controllers\Admin\Users;
use App\Http\Controllers\PropertiesController;
use App\Models\CashBuyer;
use App\Http\Controllers\CashBuyerController;
use App\Http\Controllers\CalculatorController;
use SebastianBergmann\Complexity\Calculator;
use App\Http\Controllers\ContractController;

use App\Http\Controllers\InstaController;
use App\Http\Controllers\InstaLeadsController;
use App\Http\Controllers\LeadsController;

use App\Http\Controllers\SmsController;



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

Route::post('temp', function(Request $request) {
    return view('post_template_iframe')->with('domain', $request->domain['domain'])->with('phone', $request->phone)->render();
})->name('get_template');

Route::get('temp_url/{domain}', function(Request $request) {
    return view('post_template');
})->name('temp_url');

Route::get('code', function() {
    return substr(md5(microtime()), 0, 8);
});

if(config('app.system_domain') == config('app.customer_domain')) {
    $ADMIN_USER_IDS = [1];
    Route::get('/', function () use ($ADMIN_USER_IDS) {
        $user = Auth::user();
        if (empty($user)) {
            return Inertia::render('Auth/Login', [
                'canLogin'       => Route::has('login'),
                'canRegister'    => Route::has('register'),
                'laravelVersion' => Application::VERSION,
                'phpVersion'     => PHP_VERSION,
            ]);
        } else {
            if (in_array($user->id, $ADMIN_USER_IDS, true)) {
                return Inertia::render('Admin/Dashboard');
            } else {
                return Inertia::render('Dashboard');
            }

        }

    });

    Route::get('/dashboard', function () use ($ADMIN_USER_IDS) {
        $userId = Auth::user()->id;
        if (in_array($userId, $ADMIN_USER_IDS, true)) {
            return Inertia::render('Admin/Dashboard');
        } else {
            return Inertia::render('Dashboard');
        }
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('/dashboard-data', [DashboardController::class, 'index'])
        ->middleware(['auth', 'verified'])
        ->name('dashboard.data');
    Route::post('properties-data', [DashboardController::class, 'getPropertiesData'])
        ->middleware(['auth', 'verified'])->name('dashboard.properties-data');

    /* Admin Start */
    Route::get('/users', function () use ($ADMIN_USER_IDS) {
        $userId = Auth::user()->id;
        if (in_array($userId, $ADMIN_USER_IDS, true)) {
            return (new App\Http\Controllers\Admin\Users)->index();
        } else {
            return Inertia::render('Dashboard');
        }
    })->middleware(['auth', 'verified'])->name('all-users');;
    Route::post('/new-user', function (Request $request) use ($ADMIN_USER_IDS) {
        $userId = Auth::user()->id;
        if (in_array($userId, $ADMIN_USER_IDS, true)) {
            return (new App\Http\Controllers\Admin\Users)->store($request);
        } else {
            return Inertia::render('Dashboard');
        }
    })->middleware('auth', 'verified')->name('admin.new-user');

    Route::post('/update-unlock', function (Request $request) use ($ADMIN_USER_IDS) {
        $userId = Auth::user()->id;
        if (in_array($userId, $ADMIN_USER_IDS, true)) {
            return (new App\Http\Controllers\Admin\Users)->updateUnlock($request);
        } else {
            return Inertia::render('Dashboard');
        }
    })->middleware('auth', 'verified')->name('admin.user.premium_update');

    Route::post('/update-credit', function (Request $request) use ($ADMIN_USER_IDS) {
        $userId = Auth::user()->id;
        if (in_array($userId, $ADMIN_USER_IDS, true)) {
            return (new App\Http\Controllers\Admin\Users)->updateCredit($request);
        } else {
            return Inertia::render('Dashboard');
        }
    })->middleware('auth', 'verified')->name('admin.user.credit_update');


    Route::post('/delete-user', function (Request $request) use ($ADMIN_USER_IDS) {
        $userId = Auth::user()->id;
        if (in_array($userId, $ADMIN_USER_IDS, true)) {
            return (new App\Http\Controllers\Admin\Users)->destroy($request);
        } else {
            return Inertia::render('Dashboard');
        }
    })->middleware('auth', 'verified')->name('admin.delete-user');
    /* Admin end */

    /* Tag Management Start */
    Route::post('/tags/create', [MotivationTagsController::class, 'store'])
        ->middleware(['auth', 'verified'])
        ->name('motivation-tags.store');

    Route::post('/tags/delete', [MotivationTagsController::class, 'deleteTag'])
        ->middleware(['auth', 'verified'])
        ->name('motivation-tags.delete');

    Route::post('/tags/edit', [MotivationTagsController::class, 'updateTag'])
        ->middleware(['auth', 'verified'])
        ->name('motivation-tags.edit');
    /* Tag Management End */

    Route::get('/downloadTemplate', [\App\Http\Controllers\TemplateFile::class, 'downloadTemplate'])
        ->middleware(['auth', 'verified'])->name('downloadTemplate');

    Route::get('/lists', function () {
        return (new ListsController)->index();
    })->middleware(['auth', 'verified'])->name('users.lists.get');


    Route::get('/lists/{list}', [DashboardController::class, 'getPropertiesDataSingle'])
        ->middleware(['auth', 'verified'])->name('properties-data.list');
    Route::get('/lists/lead/{lead}', [DashboardController::class, 'getPropertiesDataSingleLead'])
        ->middleware(['auth', 'verified'])->name('properties-data.list.lead');

    Route::post("lead/new/update/{id}", [PropertiesController::class, "leasUpdate"])->name("lead.update.new");

    Route::post('/lists/upload', function (Request $request) {
        return (new ListsController)->uploadListsFile($request);
    })->middleware(['auth', 'verified'])->name('users.lists.upload');

    Route::post('/lists/edit-name', function (Request $request) {
        return (new ListsController)->editName($request);
    })
        ->middleware(['auth', 'verified'])
        ->name('users.lists.edit.name');

    Route::post('/lists/edit-tags', function (Request $request) {
        return (new ListsController)->editTags($request);
    })
        ->middleware(['auth', 'verified'])
        ->name('users.lists.edit.tags');
    Route::post('/lists/delete', function (Request $request) {
        return (new ListsController)->deleteList($request);
    })
        ->middleware(['auth', 'verified'])
        ->name('users.lists.delete');



    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


        Route::get('/insta', [ProfileController::class, 'insta'])->name('profile.insta');
        Route::post('/offer/update', [ProfileController::class, 'instaUpdate'])->name('offer.update');
        Route::get('/credits', [ProfileController::class, 'credits'])->name('credits');


    });


    // Route::POST("status_voice", [CompaignController::class, "status_voice"]);

    Route::middleware('auth')->group(function () {

        Route::get('/Campaigns', [CompaignController::class, 'index'])->name('compaigns.list');
        Route::get('/newIndex', [CompaignController::class, 'newIndex'])->name('compaigns.refresh');


        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


        Route::post('compaign/step1', [CompaignController::class, 'verifyStep1'])->name('compaign.step1');
        Route::post('compaign/voice', [CompaignController::class, 'verifyVoice'])->name('compaign.stepVoice');

        Route::post('compaign/delete/{id}', [CompaignController::class, 'compaignDelete'])->name('compaign.delete');



        Route::post('compaign/sendVoice', [CompaignController::class, 'sendVoice'])->name('compaign.sendVoice');

        Route::post('add_card', [ProfileController::class, "addCard"])->name('add_card');
        Route::post('upgrade-membership', [ProfileController::class, 'upgrade_membership'])->name('upgrade.membership');
        Route::post('credit_topup', [ProfileController::class, "creditTopup"])->name('credit_topup');

        Route::get('/insta-leads', [InstaLeadsController::class, 'index'])->name('insta_leads.index');

        Route::post('zipcode', [DashboardController::class, 'getCodeData'])->name('getCodeData');
        Route::post('generateList', [InstaLeadsController::class, 'generateList'])->name('generateList');
        Route::post('generateProjections', [InstaLeadsController::class, 'generateProjections'])->name('generateProjections');

        Route::post('instalist/delete', [InstaLeadsController::class, 'instalistDelete'])->name('instalist.delete');
        Route::get('getProjections', [InstaLeadsController::class, 'getProjections']);
        //Leads Routes
        Route::get('/leads', [LeadsController::class, 'index'])->name('leads.list');
        Route::post('/get_io_filter_data', [LeadsController::class, 'get_io_filter_data'])->name('get_io_filter_data');
        Route::get('/direct-mails', [InstaController::class, 'InstaIndex'])->name('insta.list');
        Route::post('/get_dm_filter_data', [InstaController::class, 'get_dm_filter_data'])->name('get_dm_filter_data');

        Route::post('/send-direct-mails', [DashboardController::class, 'sendMails'])->name('sendMails');
        //Leads Post Routes
        Route::post('leads/step1', [LeadsController::class, 'verifyStep1'])->name('leadMachine.step1');
        Route::post('leads/step2', [LeadsController::class, 'verifyStep2'])->name('leadMachine.step2');
        Route::post('leads/step3', [LeadsController::class, 'verifyStep3'])->name('leadMachine.step3');
        //Delete Lead
        Route::post('instant-delete', [LeadsController::class, 'deleteInstant'])->name('leadMachine.instant.delete');
        //update
        Route::post('leads/update', [LeadsController::class, 'updateLead'])->name('leadMachine.update');

        Route::get('/pipelines', [PipelineController::class, 'index'])->name('pipelines.list');
        Route::post('/pipeline/update', [PipelineController::class, 'update'])->name('pipelines.update');
        Route::post('/pipeline/import-lead', [PipelineController::class, 'importLead'])->name('pipelines.importLead');
        Route::post('pipelines/order-update',[PipelineController::class, 'orderUpdate'])->name('pipelines.orderUpdate');
        Route::post('pipelines/remove-property',[PipelineController::class, 'removeProperty'])->name('pipelines.propertyRemove');
        Route::post('pipelines/property-stage-switch',[PipelineController::class, 'propertyStageSwitch'])->name('pipelines.propertyStageSwitch');


        Route::get('calendar', [CalendarController::class, 'index'])->name('calendar.index');
        Route::post('calendar/events-by-month', [CalendarController::class, 'getMonthEventByDay'])->name('calendar.getEventsByMonth');
        Route::post('calendar/add-event', [CalendarController::class, 'addEvent'])->name('calendar.addEvent');
        Route::post('calendar/update-event', [CalendarController::class, 'updateEvent'])->name('calendar.updateEvent');

        Route::get('coach-gpt', [CoachGptController::class, 'index'])->name('coach-gpt.index');
        Route::post('coach-gpt/get-answer', [CoachGptController::class, 'getAnswer'])->name('coach-gpt.getAnswer');
    });

    Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'calculator', 'as' => 'users.calculator.'], function () {

        Route::get('/', [CalculatorController::class, 'index'])->name('index');
        Route::get('/max-allowable-offer', [CalculatorController::class, 'maxAllowableOffer'])->name('max-allowable-offer');
        Route::post('/max-allowable-offer/{id?}', [CalculatorController::class, 'storeMaxAllowableOffer'])->name('max-allowable-offer.store');
        Route::get('/max-allowable-offer/{maxAllowableOffer}/edit', [CalculatorController::class, 'editMaxAllowableOffer'])->name('max-allowable-offer.edit');
        Route::delete('/max-allowable-offer/{maxAllowableOffer}', [CalculatorController::class, 'destroyMaxAllowableOffer'])->name('max-allowable-offer.destroy');

        //fix & flip profit analysis
        Route::get('/profit-analysis', [CalculatorController::class, 'profitAnalysis'])->name('profit-analysis');
        Route::post('/profit-analysis/{id?}', [CalculatorController::class, 'storeProfitAnalysis'])->name('profit-analysis.store');
        Route::get('/profit-analysis/{profitAnalysis}/edit', [CalculatorController::class, 'editProfitAnalysis'])->name('profit-analysis.edit');
        Route::delete('/profit-analysis/{profitAnalysis}', [CalculatorController::class, 'destroyProfitAnalysis'])->name('profit-analysis.destroy');

        //brrrr profit analysis
        Route::get('/brrrr-profit-analysis', [CalculatorController::class, 'brrrrProfitAnalysis'])->name('brrrr-profit-analysis');
        Route::post('/brrrr-profit-analysis/{id?}', [CalculatorController::class, 'storeBrrrrProfitAnalysis'])->name('brrrr-profit-analysis.store');
        Route::get('/brrrr-profit-analysis/{profitAnalysis}/edit', [CalculatorController::class, 'editBrrrrProfitAnalysis'])->name('brrrr-profit-analysis.edit');
        Route::delete('/brrrr-profit-analysis/{profitAnalysis}', [CalculatorController::class, 'destroyBrrrrProfitAnalysis'])->name('brrrr-profit-analysis.destroy');

        //renovation
        Route::get('/renovation', [CalculatorController::class, 'renovation'])->name('renovation');
        Route::post('/renovation/{id?}', [CalculatorController::class, 'storeRenovation'])->name('renovation.store');
        Route::get('/renovation/{renovation}/edit', [CalculatorController::class, 'editRenovation'])->name('renovation.edit');
        Route::delete('/renovation/{renovation}', [CalculatorController::class, 'destroyRenovation'])->name('renovation.destroy');

        //comparative-market-analysis
        Route::get('/comparative-market-analysis', [CalculatorController::class, 'comparativeMarketAnalysis'])->name('comparative-market-analysis');
        Route::post('/comparative-market-analysis/{id?}', [CalculatorController::class, 'storeComparativeMarketAnalysis'])->name('comparative-market-analysis.store');
        Route::get('/comparative-market-analysis/{comparativeMarketAnalysis}/edit', [CalculatorController::class, 'editComparativeMarketAnalysis'])->name('comparative-market-analysis.edit');
        Route::delete('/comparative-market-analysis/{comparativeMarketAnalysis}', [CalculatorController::class, 'destroyComparativeMarketAnalysis'])->name('comparative-market-analysis.destroy');

    });


    /////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////

    Route::get('/cash-buyers-settings', function () use ($ADMIN_USER_IDS) {
        $userId = Auth::user()->id;
        if (in_array($userId, $ADMIN_USER_IDS, true)) {
            return Inertia::render('Admin/CashBuyerSetting');
        } else {
            $cashBuyer = CashBuyer::where('user_id', $userId)->first();
            return Inertia::render('CashBuyerSetting', ["cashBuyer" => $cashBuyer]);
        }
    })->middleware(['auth', 'verified'])->name('cash.buyer.settings');

    Route::get('/cash-buyers-settings/{id}', function (Request $request, $id) use ($ADMIN_USER_IDS) {
        $userId = Auth::user()->id;
        if (in_array($userId, $ADMIN_USER_IDS, true)) {
            $cashBuyer = CashBuyer::find($id);
            return Inertia::render('Admin/CashBuyerSetting', ["cashBuyer" => $cashBuyer]);
        } else {
            return Inertia::render('Dashboard');
        }
    })->middleware(['auth', 'verified'])->name('cash.buyer.settings.edit');

    Route::post('/cash-buyers-settings/{id}', function (Request $request, $id) use ($ADMIN_USER_IDS) {
        $userId = Auth::user()->id;
        if (in_array($userId, $ADMIN_USER_IDS, true)) {
            return (new App\Http\Controllers\CashBuyerController)->update($request, $id);
        } else {
            return Inertia::render('Dashboard');
        }
    })->middleware(['auth', 'verified'])->name('cash.buyer.settings');


    Route::post('/cash-buyers', function (Request $request) use ($ADMIN_USER_IDS) {
        $userId = Auth::user()->id;
        if (in_array($userId, $ADMIN_USER_IDS, true)) {
            return (new App\Http\Controllers\CashBuyerController)->destroy($request);
        } else {
            return Inertia::render('Dashboard');
        }
    })->middleware('auth', 'verified')->name('admin.cashbuyer.delete');

    Route::get('/cash-buyers', function () use ($ADMIN_USER_IDS) {
        $userId = Auth::user()->id;
        $cashBuyers = CashBuyer::all();
        if (in_array($userId, $ADMIN_USER_IDS, true)) {
            return Inertia::render('Admin/CashBuyer', ["cashBuyers" => $cashBuyers]);
        } else {
            return Inertia::render('Clients/CashBuyer', ["cashBuyers" => $cashBuyers]);
        }
    })->middleware(['auth', 'verified'])->name('cash.buyers');

    Route::post('cash-buyer', [CashBuyerController::class, 'saveCashBuyer'])
        ->middleware(['auth', 'verified'])->name('save.cash.buyer');

    Route::post('cash-buyer-import', [CashBuyerController::class, 'importCashBuyers'])
        ->middleware(['auth', 'verified'])->name('import.cash.buyer');

    /////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////

    Route::get("send-voicemail", [VoiceMailController::class, "sendForm"]);
    Route::post("send-voicemail", [VoiceMailController::class, "send"]);
    Route::get("rapid", [VoiceMailController::class, "rapidapi"]);
    Route::POST("status_voice", [VoiceMailController::class, "status_voice"]);

    Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'contracts', 'as' => 'contracts.'], function () {
        Route::get('/', [ContractController::class, 'index'])->name('index');
        Route::get('/closing-agreement', [ContractController::class, 'closing'])->name('closing');
        Route::get('/purchase-sale-agreement', [ContractController::class, 'purchase_sale'])->name('purchase.sale');
        Route::get('/land-sale-agreement', [ContractController::class, 'land_sale'])->name('land.sale');

        Route::post('/closing-agreement', [ContractController::class, 'closing_pdf'])->name('closing.pdf');
        Route::post('/purchase-sale-agreement', [ContractController::class, 'purchase_sale_pdf'])->name('purchase.sale.pdf');
        Route::post('/land-sale-agreement', [ContractController::class, 'land_sale_pdf'])->name('land.sale.pdf');
        Route::post('/add-share-count', [ContractController::class, 'add_share_count'])->name('add.share.count');

    });


    Route::get("stripe", function() {
        Artisan::call("schedule:run");
        return 123;

        $user = auth()->user();
        if(empty($user->stripe_id)) {
            $stripe = new \Stripe\StripeClient(
                env('STRIPE_SECRET')
            );
            $customer = $stripe->customers->create([
                'description' => 'Customer for credits',
                'email' => $user->email
            ]);
            dd($customer->id);

            return json_decode($customer);
        }
    });


    Route::get("signout", function() {
        \Auth::logout();
        return redirect()->route('dashboard');
    })->name('signout');


    Route::get('do', [VoiceMailController::class, "status_voice1"]);

    require __DIR__ . '/auth.php';
    Route::get("/user-web", [\App\Http\Controllers\UserWebController::class, "userIndex"])->name('user_web_step1');
    Route::post("/save-address", [\App\Http\Controllers\UserWebController::class, "saveAddress"])->name('instant.offer.address');
    Route::post("/save-counter/{id}", [\App\Http\Controllers\UserWebController::class, "saveCounter"])->name('instant.offer.counter');
    Route::post("/get-offer", [\App\Http\Controllers\UserWebController::class, "getOffer"])->name('instant.offer.getOffer');
    Route::get('/step2/{id}', [\App\Http\Controllers\UserWebController::class, "step2"])->name('user_web_step2');

    Route::get('/step3/{id}',  [\App\Http\Controllers\UserWebController::class, "step3"])->name('user_web_step3');

    Route::get('/deny/{id}', [\App\Http\Controllers\UserWebController::class, "denyOffer"])->name('user_web_deny');
    Route::get('/accept/{id}', [\App\Http\Controllers\UserWebController::class, "acceptOffer"])->name('user_web_accept');

    Route::view('/failed', 'user_web.failed')->name('user_web_failed');
    Route::get('/create-cpanel', [\App\Http\Controllers\UserWebController::class, "cpanel"])->name('cpanel.create');
} else {
    require __DIR__.'/customer.php';
}




