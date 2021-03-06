<?php

Auth::routes();

//Route::get('/test', 'TestController@index')->name('test');
Route::get('/privacy-policy', 'HomeController@privacy_policy')->name('privacy_policy');
Route::get('/terms-of-use', 'HomeController@terms_of_use')->name('terms_of_use');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', 'HomeController@dashboard')->name('home');
    Route::get('/home', 'HomeController@dashboard')->name('home');
    Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

    Route::group(['prefix' => 'my_account'], function () {
        Route::get('/', 'MyAccountController@edit_profile')->name('my_account');
        Route::put('/', 'MyAccountController@update_profile')->name('my_account.update');
        Route::put('/change_password', 'MyAccountController@change_pass')->name('my_account.change_pass');
    });
    /* Administrations */
    Route::group(['prefix' => 'general'], function () {
        Route::group(['prefix' => 'office'], function () {
            Route::get('/', 'GeneralOfficeController@index');
            Route::get('index', 'GeneralOfficeController@index')->name('general-offices.index');
            Route::get('create', 'GeneralOfficeController@create')->name('general-offices.create');
            Route::delete('destroy/{ttr}', 'GeneralOfficeController@destroy')->name('general-offices.destroy');
            Route::get('show', 'GeneralOfficeController@show')->name('general-offices.show');
            Route::get('edit/{ttr}', 'GeneralOfficeController@edit')->name('general-offices.edit');
            Route::patch('update/{ttr}', 'GeneralOfficeController@update')->name('general-offices.update');
            Route::post('store', 'GeneralOfficeController@store')->name('general-offices.store');
        });
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', 'GeneralUserController@index');
            Route::get('index', 'GeneralUserController@index')->name('general-users.index');
            Route::get('create', 'GeneralUserController@create')->name('general-users.create');
            Route::delete('destroy/{ttr}', 'GeneralUserController@destroy')->name('general-users.destroy');
            Route::get('show', 'GeneralUserController@show')->name('users.show');
            Route::get('show', 'GeneralUserController@show')->name('general-users.show');
            Route::get('edit/{ttr}', 'GeneralUserController@edit')->name('general-users.edit');
            Route::patch('update/{ttr}', 'GeneralUserController@update')->name('general-users.update');
            Route::post('store', 'GeneralUserController@store')->name('general-users.store');
        });
    });
    /*     * ************* Reports **************** */
    Route::group(['prefix' => 'hr'], function () {
        Route::group(['prefix' => 'employees'], function () {
            Route::get('/', 'HrEmployeeController@index');
            Route::get('index', 'HrEmployeeController@index')->name('hr-employees.index');
            Route::get('create', 'HrEmployeeController@create')->name('hr-employees.create');
            Route::delete('destroy/{ttr}', 'HrEmployeeController@destroy')->name('hr-employees.destroy');
            Route::get('show', 'HrEmployeeController@show')->name('hr-employees.show');
            Route::get('edit/{ttr}', 'HrEmployeeController@edit')->name('hr-employees.edit');
            Route::patch('update/{ttr}', 'HrEmployeeController@update')->name('hr-employees.update');
            Route::post('store', 'HrEmployeeController@store')->name('hr-employees.store');
        });
        Route::group(['prefix' => 'jobs'], function () {
            Route::get('/', 'HrJobController@index');
            Route::get('index', 'HrJobController@index')->name('hr-jobs.index');
            Route::get('create', 'HrJobController@create')->name('hr-jobs.create');
            Route::delete('destroy/{ttr}', 'HrJobController@destroy')->name('hr-jobs.destroy');
            Route::get('show', 'HrJobController@show')->name('hr-jobs.show');
            Route::get('edit/{ttr}', 'HrJobController@edit')->name('hr-jobs.edit');
            Route::patch('update/{ttr}', 'HrJobController@update')->name('hr-jobs.update');
            Route::post('store', 'HrJobController@store')->name('hr-jobs.store');
        });
    });
    /*     * ************* Reports **************** */
    Route::group(['prefix' => 'reports'], function () {

        Route::get('financial', 'ReportsController@financial')->name('reports.financial');
        Route::post('financialreport', 'ReportsController@financialreport')->name('reports.financialreport');

        Route::get('trial', 'ReportsController@trialbalance')->name('reports.trial');
        Route::post('trialreport', 'ReportsController@trialbalancereport')->name('reports.trialreport');

        Route::get('dues', 'ReportsController@dues')->name('reports.dues');
        Route::post('duesreport', 'ReportsController@duesreport')->name('reports.duesreport');

        Route::get('payments', 'ReportsController@payments')->name('reports.payments');
        Route::post('paymentsreport', 'ReportsController@paymentsreport')->name('reports.paymentsreport');

        Route::post('odues', 'ReportsController@odues')->name('reports.odues');
        Route::post('par', 'ReportsController@par')->name('reports.par');
        Route::post('accrued', 'ReportsController@accrued')->name('reports.accrued');
    });

    Route::group(['prefix' => 'finance'], function () {
        Route::group(['prefix' => 'ledger'], function () {
            Route::get('/', 'FinGeneralLedgerController@index');
            Route::get('index', 'FinGeneralLedgerController@index')->name('fin-general-ledgers.index');
            Route::get('create', 'FinGeneralLedgerController@create')->name('fin-general-ledgers.create');
            Route::get('filemanager', 'FinGeneralLedgerController@filemanager')->name('fin-general-ledgers.filemanager');
            Route::post('upload', 'FinGeneralLedgerController@upload')->name('fin-general-ledgers.upload');
            Route::delete('destroy/{ttr}', 'FinGeneralLedger@destroy')->name('fin-general-ledgers.destroy');
            Route::get('/show/{ttr}', 'FinGeneralLedgerController@show')->name('fin-general-ledgers.show');
            Route::get('/process/{ttr}', 'FinGeneralLedgerController@process')->name('fin-general-ledgers.process');
            Route::get('/vouchers', 'VoucherController@index')->name('fin-general-ledgers.vouchers');
            Route::get('edit/{ttr}', 'FinGeneralLedgerController@edit')->name('fin-general-ledgers.edit');
            Route::patch('update/{ttr}', 'FinGeneralLedgerController@update')->name('fin-general-ledgers.update');
            Route::post('store', 'FinGeneralLedgerController@store')->name('fin-general-ledgers.store');
            Route::post('/submitvouchers', 'FinGeneralLedgerController@submitvouchers');
        });
        Route::group(['prefix' => 'checkbook'], function () {
            Route::get('/', 'FinCheckbookController@index');
            Route::get('index', 'FinCheckbookController@index')->name('fin-checkbooks.index');
            Route::get('create', 'FinCheckbookController@create')->name('fin-checkbooks.create');
            Route::delete('destroy/{ttr}', 'FinCheckbookController@destroy')->name('fin-checkbooks.destroy');
            Route::get('show', 'FinCheckbookController@show')->name('fin-checkbooks.show');
            Route::get('edit/{ttr}', 'FinCheckbookController@edit')->name('fin-checkbooks.edit');
            Route::patch('update/{ttr}', 'FinCheckbookController@update')->name('fin-checkbooks.update');
            Route::post('store', 'FinCheckbookController@store')->name('fin-checkbooks.store');
        });
        Route::group(['prefix' => 'accounts'], function () {
            Route::get('/', 'FinChartOfAccountController@index');
            Route::get('index', 'FinChartOfAccountController@index')->name('fin-chart-of-accounts.index');
            Route::get('create', 'FinChartOfAccountController@create')->name('fin-chart-of-accounts.create');
            Route::delete('destroy/{ttr}', 'FinChartOfAccountController@destroy')->name('fin-chart-of-accounts.destroy');
            Route::get('show', 'FinChartOfAccountController@show')->name('fin-chart-of-accounts.show');
            Route::get('edit/{ttr}', 'FinChartOfAccountController@edit')->name('fin-chart-of-accounts.edit');
            Route::patch('update/{ttr}', 'FinChartOfAccountController@update')->name('fin-chart-of-accounts.update');
            Route::post('store', 'FinChartOfAccountController@store')->name('fin-chart-of-accounts.store');
        });
        Route::group(['prefix' => 'banks'], function () {
            Route::get('/', 'FinBanksAccountController@index');
            Route::get('index', 'FinBanksAccountController@index')->name('fin-banks-accounts.index');
            Route::get('create', 'FinBanksAccountController@create')->name('fin-banks-accounts.create');
            Route::delete('destroy/{ttr}', 'FinBanksAccountController@destroy')->name('fin-banks-accounts.destroy');
            Route::get('show', 'FinBanksAccountController@show')->name('fin-banks-accounts.show');
            Route::get('edit/{ttr}', 'FinBanksAccountController@edit')->name('fin-banks-accounts.edit');
            Route::patch('update/{ttr}', 'FinBanksAccountController@update')->name('fin-banks-accounts.update');
            Route::post('store', 'FinBanksAccountController@store')->name('fin-banks-accounts.store');
        });
    });
    //Loans
    Route::group(['prefix' => 'aml'], function () {
        Route::get('/', 'AmlBlacklistController@index');
        Route::get('index', 'AmlBlacklistController@index')->name('aml-blacklists.index');
        Route::get('create', 'AmlBlacklistController@create')->name('aml-blacklists.create');
        Route::delete('destroy/{ttr}', 'AmlBlacklistController@destroy')->name('aml-blacklists.destroy');
        Route::get('show', 'AmlBlacklistController@show')->name('aml-blacklists.show');
        Route::get('edit/{ttr}', 'AmlBlacklistController@edit')->name('aml-blacklists.edit');
        Route::patch('update/{ttr}', 'AmlBlacklistController@update')->name('aml-blacklists.update');
        Route::post('store', 'AmlBlacklistController@store')->name('aml-blacklists.store');

        Route::get('/scan_aml', 'AmlBlacklistController@index')->name('scan_aml');
        Route::get('/upload_aml', 'AmlBlacklistController@index')->name('upload_aml');
    });
    //Loans
    Route::group(['prefix' => 'loans'], function () {
        //Borrowers
        Route::group(['prefix' => 'borrowers'], function () {
            Route::get('/', 'LoanBorrowerController@index');
            Route::get('index', 'LoanBorrowerController@index')->name('loan-borrowers.index');
            Route::get('create', 'LoanBorrowerController@create')->name('loan-borrowers.create');
            Route::delete('destroy/{ttr}', 'LoanBorrower@destroy')->name('loan-borrowers.destroy');
            Route::get('show', 'LoanBorrowerController@show')->name('loan-borrowers.show');
            Route::get('edit/{ttr}', 'LoanBorrowerController@edit')->name('loan-borrowers.edit');
            Route::patch('update/{ttr}', 'LoanBorrowerController@update')->name('loan-borrowers.update');
            Route::post('store', 'LoanBorrowerController@store')->name('loan-borrowers.store');
        });
        //Kibor
        Route::group(['prefix' => 'kibor'], function () {
            Route::get('/', 'LoanKiborRateController@index');
            Route::get('index', 'LoanKiborRateController@index')->name('loan-kibor-rates.index');
            Route::get('create', 'LoanKiborRateController@create')->name('loan-kibor-rates.create');
            Route::delete('destroy/{ttr}', 'LoanKiborRateController@destroy')->name('loan-kibor-rates.destroy');
            Route::get('show', 'LoanKiborRateController@show')->name('loan-kibor-rates.show');
            Route::get('edit/{ttr}', 'LoanKiborRateController@edit')->name('loan-kibor-rates.edit');
            Route::patch('update/{ttr}', 'LoanKiborRateController@update')->name('loan-kibor-rates.update');
            Route::post('store', 'LoanKiborRateController@store')->name('loan-kibor-rates.store');
        });
        //Kibor Hisotry
        Route::group(['prefix' => 'kiborhistory'], function () {
            Route::get('/', 'LoanKiborHistoryController@index');
            Route::get('index', 'LoanKiborHistoryController@index')->name('loan-kibor-histories.index');
            Route::get('create', 'LoanKiborHistoryController@create')->name('loan-kibor-histories.create');
            Route::delete('destroy/{ttr}', 'LoanKiborHistoryController@destroy')->name('loan-kibor-histories.destroy');
            Route::get('show', 'LoanKiborHistoryController@show')->name('loan-kibor-histories.show');
            Route::get('edit/{ttr}', 'LoanKiborHistoryController@edit')->name('loan-kibor-histories.edit');
            Route::patch('update/{ttr}', 'LoanKiborHistoryController@update')->name('loan-kibor-histories.update');
            Route::post('store', 'LoanKiborHistoryController@store')->name('loan-kibor-histories.store');
        });
        //takaful
        Route::group(['prefix' => 'takaful'], function () {
            Route::get('/', 'LoanTakafulController@index');
            Route::get('index', 'LoanTakafulController@index')->name('loan-takafuls.index');
            Route::get('create', 'LoanTakafulController@create')->name('loan-takafuls.create');
            Route::delete('destroy/{ttr}', 'LoanTakafulController@destroy')->name('loan-takafuls.destroy');
            Route::get('show', 'LoanTakafulController@show')->name('loan-takafuls.show');
            Route::get('edit/{ttr}', 'LoanTakafulController@edit')->name('loan-takafuls.edit');
            Route::patch('update/{ttr}', 'LoanTakafulController@update')->name('loan-takafuls.update');
            Route::post('store', 'LoanTakafulController@store')->name('loan-takafuls.store');
        });
        //Loans
        Route::get('/', 'LoansController@borrowers')->name('tt.borrowers');
        Route::get('/kibor', 'LoanKiborRateController@index')->name('kibor.all');
        Route::get('/kiborhistory', 'LoanKiborHistoryController@index')->name('kibor.history');
        Route::get('/takaful', 'LoanTakafulController@index')->name('takaful');
        Route::get('/loandetails', 'LoansController@loandetails')->name('tt.loandetails');
        Route::get('/', 'LoansController@index')->name('tt.borrowers');
        Route::get('show_schedule/{ttr}', 'LoansController@show_schedule')->name('ttr.show_schedule');
        Route::get('showloan/{ttr}', 'LoansController@showloan')->name('ttr.showloan');
        Route::get('gen_schedule/{ttr}', 'LoansController@gen_schedule')->name('ttr.gen_schedule');
        Route::get('loanstep/{ttr}', 'LoansController@loanstep')->name('ttr.loanstep');
        Route::get('taxcertificate/{ttr}', 'LoansController@taxcertificate')->name('loans.taxcertificate');
        Route::post('storestep', 'LoansController@loanstepStore')->name('storestep');

        Route::get('pay_installment/{ttr}', 'LoanPaymentRecoveredController@pay_installment')->name('loans.pay');
        Route::get('early_settlement/{ttr}', 'LoanPaymentRecoveredController@pay_ealrysettlement')->name('loans.early');
        Route::get('partial/{ttr}', 'LoanPaymentRecoveredController@pay_partial')->name('loans.partial');
        Route::post('store_partial', 'LoanPaymentRecoveredController@store_partial')->name('loan-payment-recovereds.store_partial');
        Route::get('takaful/{ttr}', 'LoansController@takafulreport')->name('loans.takaful');
    });
    //Payments
    Route::group(['prefix' => 'payment'], function () {
        Route::group(['prefix' => 'slips'], function () {
            Route::get('/', 'LoanBankSlipController@index');
            Route::get('index', 'LoanBankSlipController@index')->name('loan-bankslips.index');
            Route::get('create', 'LoanBankSlipController@create')->name('loan-bankslips.create');
            Route::delete('destroy/{ttr}', 'LoanBankSlipController@destroy')->name('loan-bankslips.destroy');
            Route::get('show', 'LoanBankSlipController@show')->name('loan-bankslips.show');
            Route::get('edit/{ttr}', 'LoanBankSlipController@edit')->name('loan-bankslips.edit');
            Route::patch('update/{ttr}', 'LoanBankSlipController@update')->name('loan-bankslips.update');
            Route::post('store', 'LoanBankSlipController@store')->name('loan-bankslips.store');
        });
        Route::group(['prefix' => 'due'], function () {
            Route::get('/', 'LoanPaymentDueController@index');
            Route::get('index', 'LoanPaymentDueController@index')->name('loan-payment-dues.index');
            Route::get('create', 'LoanPaymentDueController@create')->name('loan-payment-dues.create');
            Route::delete('destroy/{ttr}', 'LoanPaymentDue@destroy')->name('loan-payment-dues.destroy');
            Route::get('show', 'LoanPaymentDueController@show')->name('loan-payment-dues.show');
            Route::get('edit/{ttr}', 'LoanPaymentDueController@edit')->name('loan-payment-dues.edit');
            Route::patch('update/{ttr}', 'LoanPaymentDueController@update')->name('loan-payment-dues.update');
            Route::post('store', 'LoanPaymentDueController@store')->name('loan-payment-dues.store');
        });
        Route::group(['prefix' => 'recovered'], function () {
            Route::get('/', 'LoanPaymentRecoveredController@index');
            Route::get('index', 'LoanPaymentRecoveredController@index')->name('loan-payment-recovereds.index');
            Route::get('create', 'LoanPaymentRecoveredController@create')->name('loan-payment-recovereds.create');
            Route::post('store', 'LoanPaymentRecoveredController@store')->name('loan-payment-recovereds.store');
            Route::post('storepay', 'LoanPaymentRecoveredController@storepay')->name('loan-payment-recovereds.storepay');
            Route::post('earlypay', 'LoanPaymentRecoveredController@earlypay')->name('loan-payment-recovereds.earlypay');
            Route::delete('destroy/{ttr}', 'LoanPaymentRecoveredController@destroy')->name('loan-payment-recovereds.destroy');
            Route::get('show', 'LoanPaymentRecoveredController@show')->name('loan-payment-recovereds.show');
            Route::get('edit/{ttr}', 'LoanPaymentRecoveredController@edit')->name('loan-payment-recovereds.edit');
            Route::patch('update/{ttr}', 'LoanPaymentRecoveredController@update')->name('loan-payment-recovereds.update');
        });
    });

    /*     * ************* Support Team **************** */
    Route::group(['namespace' => 'SupportTeam',], function () {

        /*         * ************* Students **************** */
        Route::group(['prefix' => 'students'], function () {
            Route::get('reset_pass/{st_id}', 'StudentRecordController@reset_pass')->name('st.reset_pass');
            Route::get('graduated', 'StudentRecordController@graduated')->name('students.graduated');
            Route::put('not_graduated/{id}', 'StudentRecordController@not_graduated')->name('st.not_graduated');
            Route::get('list/{class_id}', 'StudentRecordController@listByClass')->name('students.list');

            /* Promotions */
            Route::post('promote_selector', 'PromotionController@selector')->name('students.promote_selector');
            Route::get('promotion/manage', 'PromotionController@manage')->name('students.promotion_manage');
            Route::delete('promotion/reset/{pid}', 'PromotionController@reset')->name('students.promotion_reset');
            Route::delete('promotion/reset_all', 'PromotionController@reset_all')->name('students.promotion_reset_all');
            Route::get('promotion/{fc?}/{fs?}/{tc?}/{ts?}', 'PromotionController@promotion')->name('students.promotion');
            Route::post('promote/{fc}/{fs}/{tc}/{ts}', 'PromotionController@promote')->name('students.promote');
        });

        /*         * ************* Users **************** */
        Route::group(['prefix' => 'users'], function () {
            Route::get('reset_pass/{id}', 'UserController@reset_pass')->name('users.reset_pass');
        });
        /*         * ************* Payments **************** */
        Route::group(['prefix' => 'payments'], function () {

            Route::get('manage/{class_id?}', 'PaymentController@manage')->name('payments.manage');
            Route::get('invoice/{id}/{year?}', 'PaymentController@invoice')->name('payments.invoice');
            Route::get('receipts/{id}', 'PaymentController@receipts')->name('payments.receipts');
            Route::get('pdf_receipts/{id}', 'PaymentController@pdf_receipts')->name('payments.pdf_receipts');
            Route::post('select_year', 'PaymentController@select_year')->name('payments.select_year');
            Route::post('select_class', 'PaymentController@select_class')->name('payments.select_class');
            Route::delete('reset_record/{id}', 'PaymentController@reset_record')->name('payments.reset_record');
            Route::post('pay_now/{id}', 'PaymentController@pay_now')->name('payments.pay_now');
        });

        /*         * ************* Pins **************** */
        Route::group(['prefix' => 'pins'], function () {
            Route::get('create', 'PinController@create')->name('pins.create');
            Route::get('/', 'PinController@index')->name('pins.index');
            Route::post('/', 'PinController@store')->name('pins.store');
            Route::get('enter/{id}', 'PinController@enter_pin')->name('pins.enter');
            Route::post('verify/{id}', 'PinController@verify')->name('pins.verify');
            Route::delete('/', 'PinController@destroy')->name('pins.destroy');
        });
    });
    
      Route::group(['prefix' => 'ajax'], function () {
        Route::get('get_lga/{state_id}', 'AjaxController@get_lga')->name('get_lga');
        Route::get('get_class_sections/{class_id}', 'AjaxController@get_class_sections')->name('get_class_sections');
        Route::get('get_class_subjects/{class_id}', 'AjaxController@get_class_subjects')->name('get_class_subjects');
    });
});

/* * ********************** SUPER ADMIN *************************** */
Route::group(['namespace' => 'SuperAdmin', 'middleware' => 'super_admin', 'prefix' => 'super_admin'], function () {

    Route::get('/settings', 'SettingController@index')->name('settings');
    Route::put('/settings', 'SettingController@update')->name('settings.update');
});

/* * ********************** PARENT *************************** */
Route::group(['namespace' => 'MyParent', 'middleware' => 'my_parent',], function () {

    Route::get('/my_children', 'MyController@children')->name('my_children');
});
