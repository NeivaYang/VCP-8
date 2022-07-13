<?php
use App\Http\Middleware\LogActionsMiddleware;
/*use App\Classes\EntregaTecnica\EntregaTecnica;
use App\Http\Controllers\DocusignController;
use Illuminate\Support\Facades\Mail;*/

if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}

Route::get('docusign',['as' => 'docusign', 'uses' => 'DocusignController@index']);
Route::get('connect-docusign',['as' => 'connect.docusign', 'uses' => 'DocusignController@connectDocusign']);
Route::get('docusign/callback',['as' => 'docusign.callback', 'uses' => 'DocusignController@callback']);
Route::get('sign-document',['as' => 'docusign.sign', 'uses' => 'DocusignController@signDocument']);


/**
 * API - storing order data
 */
//Route::post('/api/storing_order_data', ['as => storing_order_data', 'uses' => 'Api\StoringDataOrderController@index']);


// ROTA DE FALLBACK CASO ALGUMA ROTA OCASIONE ERRO
Route::fallback(function(){
    echo 'Rota não existente. <a href="'.route('dashboard').'">Voltar</a>';
});

Auth::routes(['verify' => true]);
//////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////// ROTAS DE LOGIN ///////////////////////////////////////////////////
/////////////////////////////////////// LOGIN ROUTE //////////////////////////////////////////////////////

    Route::post('/login/Signin', ['as' => 'signin', 'uses' => 'Auth\AutenticacaoController@Signin']);
    Route::get('/login', ['as' => 'login', 'uses' => 'Auth\AutenticacaoController@login']);

    Route::get('/locale/{locale}', ['as' => 'language_update', 'uses' => 'Auth\AutenticacaoController@LanguageUpdate']);

//////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * Rotas para apenas usuários cadastrados
 */
Route::group(['middleware' => 'auth'], function () {
    //Logout
    Route::get('/sair', ['as' => 'sair', 'uses' => 'Auth\AutenticacaoController@sair']);
    Route::get('/admsystem', ['as' => 'admsystem', 'uses' => 'AdmSystem\AdmSystemController@index']);
});


Route::group(['middleware' => 'auth', 'middleware' => 'verified', 'middleware' => 'logActions'], function () {

    //Route::group(['middleware' => 'administrador'], function () {

        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////// ROTAS DE BOCAIS ///////////////////////////////////////////////////
        /////////////////////////////////////// NOZZLE ROUTE /////////////////////////////////////////////////////

            Route::get('/nozzles', ['as' => 'manager_nozzles', 'uses' => 'Sistema\BocalController@manageNozzles']);
            Route::get('/nozzles/create', ['as' => 'create_nozzles', 'uses' => 'Sistema\BocalController@createNozzle']);
            Route::post('/nozzles/save', ['as' => 'save_nozzle', 'uses' => 'Sistema\BocalController@saveNozzle']);
            Route::get('/nozzles/edit/{id}', ['as' => 'edit_nozzle', 'uses' => 'Sistema\BocalController@editNozzle']);
            Route::post('/nozzles/update', ['as' => 'update_nozzle', 'uses' => 'Sistema\BocalController@updateNozzle']);
            Route::delete('/nozzles/delete/{id}', ['as' => 'delete_nozzle', 'uses' => 'Sistema\BocalController@delete']);
            Route::post('/nozzles/filter', ['as' => 'filter_nozzle', 'uses' => 'Sistema\BocalController@searchNozzle']);

        ////////////////////////////////////////////////////////////////////////////////////////////////////////// 

        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////// ROTAS DE PIVÔ ///////////////////////////////////////////////////
        /////////////////////////////////////// PIVOT ROUTE /////////////////////////////////////////////////////

            Route::get('/pivots', ['as' => 'manager_pivot', 'uses' => 'Sistema\PivoController@managerPivot']);
            Route::get('/pivots/create', ['as' => 'create_pivot', 'uses' => 'Sistema\PivoController@createPivot']);
            Route::post('/pivots/save', ['as' => 'save_pivot', 'uses' => 'Sistema\PivoController@savePivot']);
            Route::get('/pivots/edit/{id}', ['as' => 'edit_pivot', 'uses' => 'Sistema\PivoController@editPivot']);
            Route::post('/pivots/update', ['as' => 'update_pivot', 'uses' => 'Sistema\PivoController@updatePivot']);
            Route::delete('/pivots/delete/{id}', ['as' => 'delete_pivot', 'uses' => 'Sistema\PivoController@delete']);
            Route::post('/pivots/filter', ['as' => 'filter_pivot', 'uses' => 'Sistema\PivoController@searchPivot']);

            //////////////////////////////////////////////////////////////////////////////////////////////////////////

            Route::get('/usuarios/{id_usuario}/aprovar_email_usuario', ['as' => 'aprovarUsuario', 'uses' => 'Sistema\UsuarioController@validarEmailUsuario']);
        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////// ROTAS DE REVENDAS ////////////////////////////////////////////////
        /////////////////////////////////////// RESALES ROUTES ///////////////////////////////////////////////////

            Route::get('/resales', ['as' => 'manager_resales', 'uses' => 'Sistema\RevendasController@managerResales']);
            Route::get('/resales/create_resales', ['as' => 'create_resales', 'uses' => 'Sistema\RevendasController@createResales']);
            Route::post('/resales/save_resales', ['as' => 'save_resales', 'uses' => 'Sistema\RevendasController@saveResales']);
            Route::get('/resales/edit_resales/{id}', ['as' => 'edit_resales', 'uses' => 'Sistema\RevendasController@editResales']);
            Route::post('/resales/update_resales', ['as' => 'update_resales', 'uses' => 'Sistema\RevendasController@updateResales']);
            Route::delete('/resales/delete_resales/{id}', ['as' => 'delete_resales', 'uses' => 'Sistema\RevendasController@delete']);
            Route::post('/resales/filter_resales', ['as' => 'filter_resales', 'uses' => 'Sistema\RevendasController@searchResales']);
        
        
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////// ROTAS CADASTRO EMPRESA //////////////////////////////////////
        ///////////////////////////////////////////// COMPANY REGISTER ROUTES /////////////////////////////////////
        
            Route::get('/empresa', ['as' => 'manager_empresa', 'uses' => 'Sistema\EmpresaController@managerEmpresa']);
            Route::get('/empresa/create_empresa', ['as' => 'create_empresa', 'uses' => 'Sistema\EmpresaController@createEmpresa']);
            Route::post('/empresa/save_empresa', ['as' => 'save_empresa', 'uses' => 'Sistema\EmpresaController@saveEmpresa']);
            Route::get('/empresa/edit_empresa/{id}', ['as' => 'edit_empresa', 'uses' => 'Sistema\EmpresaController@editEmpresa']);
            Route::post('/empresa/update_empresa', ['as' => 'update_empresa', 'uses' => 'Sistema\EmpresaController@updateEmpresa']);
            Route::delete('/empresa/delete_empresa/{id}', ['as' => 'delete_empresa', 'uses' => 'Sistema\EmpresaController@delete']);
            Route::post('/empresa/filter_empresa', ['as' => 'filter_empresa', 'uses' => 'Sistema\EmpresaController@searchEmpresa']);
            Route::post('/empresa/checkemail', ['as'=> 'checkEmail', 'uses' => 'Sistema\EmailController@checkEmail']);

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////// ROTAS GERENCIAMENTO DE FUNCOES ///////////////////////////////////
        //////////////////////////////////////// FUNCTIONS MANGEMENT ROUTES //////////////////////////////////////

            Route::get('/funcoes', ['as' => 'funcao_gerenciar', 'uses' => 'Sistema\FuncaoController@gerenciarFuncao']);
            Route::post('/funcoes/cadastra', ['as' => 'funcao_cadastra', 'uses' => 'Sistema\FuncaoController@cadastrarFuncao']);
            Route::get('/funcoes/cadastros', ['as' => 'funcao_cadastro', 'uses' => 'Sistema\FuncaoController@cadastroFuncao']);
            Route::get('/funcoes/editar/{id}', ['as' => 'funcao_editar', 'uses' => 'sistema\FuncaoController@editarFuncao']);
            Route::post('/funcoes/edita', ['as' => 'funcao_edita', 'uses' => 'Sistema\FuncaoController@editaFuncao']);
            Route::delete('/funcoes/remover/{id}', ['as' => 'funcao_remover', 'uses' => 'Sistema\FuncaoController@removerFuncao']);
            Route::post('/empresa/filter_funcao', ['as' => 'filter_funcao', 'uses' => 'Sistema\FuncaoController@searchFuncao']);
        
        
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////// ROTAS DE CADASTRO DE EQUIPAMENTOS ///////////////////////////
        ///////////////////////////////////////////// EQUIPAMENTS REGISTER ROUTES /////////////////////////////////

            Route::get('/equipamento', ['as' => 'manage_equipamentos', 'uses' => 'Sistema\EquipamentosController@manageEquipamentos']);
            Route::get('/equipamento/create_equipamentos', ['as' => 'create_equipamentos', 'uses' => 'Sistema\EquipamentosController@createEquipamentos']);
            Route::post('/equipamento/save_equipamentos', ['as' => 'save_equipamentos', 'uses' => 'Sistema\EquipamentosController@saveEquipamentos']);
            Route::get('/equipamento/edit_equipamentos/{id}', ['as' => 'edit_equipamentos', 'uses' => 'Sistema\EquipamentosController@editEquipamentos']);
            Route::post('/equipamento/update_equipamentos', ['as' => 'update_equipamentos', 'uses' => 'Sistema\EquipamentosController@updateEquipamentos']);
            Route::delete('/equipamento/delete_equipamentos{id}', ['as' => 'delete_equipamentos', 'uses' => 'Sistema\EquipamentosController@deleteEquipamentos']);
    
        
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////// ROTA DE ENTREGA TÉCNICA ////////////////////////////////////////////
        /////////////////////////////////////// Commissioning ROUTE ////////////////////////////////////////////////
            // gerenciar
            Route::get('/commissioning', ['as' => 'manage_commissioning', 'uses' => 'EntregaTecnica\EntregaTecnicaController@manageCommissioning']);

            // editar entrega tecnica
            Route::get('/commissioning/edit_commissioning/{id}', ['as' => 'edit_commissioning', 'uses' => 'EntregaTecnica\EntregaTecnicaController@editCommissioning']);
            
            // criar entrega tecnica
            Route::post('/commissioning/save_commissioning', ['as' => 'save_commissioning', 'uses' => 'EntregaTecnica\EntregaTecnicaController@saveCommissioning']);
            Route::post('/commissioning/save_commissioning_check', ['as' => 'check_commissioning', 'uses' => 'EntregaTecnica\EntregaTecnicaController@VerifyDadosCommissioning']);
            
            // criar verificacao
            Route::get('/commissioning/create_commissioning_telemetry/{id}', ['as' => 'create_telemetry_commissioning', 'uses' => 'EntregaTecnica\EntregaTecnicaController@createTelemetryCommissioning']);
            Route::post('/commissioning/save_commissioning_telemetry', ['as' => 'save_telemetry_commissioning', 'uses' => 'EntregaTecnica\EntregaTecnicaController@saveTelemetryCommissioning']);
            
            // criar parte aerea
            Route::get('/commissioning/create_commissioning_aerial_part/{id}', ['as' => 'create_aerial_part_commissioning', 'uses' => 'EntregaTecnica\EntregaTecnicaController@createCommissioningAerialPart']);
            Route::post('/commissioning/save_commissioning_aerial_part', ['as' => 'save_commissioning_aerial_part', 'uses' => 'EntregaTecnica\EntregaTecnicaController@saveCommissioningAerialPart']);
            
            // criar lances
            Route::get('/commissioning/create_commissioning_span/{id}', ['as' => 'create_commissioning_span', 'uses' => 'EntregaTecnica\EntregaTecnicaController@createCommissioningSpan']);
            Route::post('/commissioning/save_commissioning_span', ['as' => 'save_commissioning_span', 'uses' => 'EntregaTecnica\EntregaTecnicaController@saveCommissioningSpan']);
            
            // criar pressurização
            Route::get('/commissioning/create_commissioning_pressurization/{id}', ['as' => 'create_commissioning_pressurization', 'uses' => 'EntregaTecnica\EntregaTecnicaController@createPressurizationCommissioning']);
            Route::post('/commissioning/save_commissioning_pressurization', ['as' => 'save_commissioning_pressurization', 'uses' => 'EntregaTecnica\EntregaTecnicaController@savePressurizationCommissioning']);
            
            // criar bomba
            Route::get('/commissioning/create_commissioning_pump/{id}', ['as' => 'create_commissioning_pump', 'uses' => 'EntregaTecnica\EntregaTecnicaController@createPumpCommissioning']);
            Route::post('/commissioning/save_commissioning_pump', ['as' => 'save_commissioning_pump', 'uses' => 'EntregaTecnica\EntregaTecnicaController@savePumpCommissioning']);
            Route::get('/commissioning/edit_commissioning_pump/{id}', ['as' => 'edit_commissioning_pump', 'uses' => 'EntregaTecnica\EntregaTecnicaController@editpumpCommissioning']);
            Route::post('/commissioning/update_commissioning_pump', ['as' => 'update_commissioning_pump', 'uses' => 'EntregaTecnica\EntregaTecnicaController@updatePumpCommissioning']);
            
            // criar chave de partida 
            Route::get('/commissioning/create_commissioning_starter_key/{id}', ['as' => 'create_commissioning_starter_key', 'uses' => 'EntregaTecnica\EntregaTecnicaController@createStarterKeyCommissioning']);
            Route::post('/commissioning/save_commissioning_starter_key', ['as' => 'save_commissioning_starter_key', 'uses' => 'EntregaTecnica\EntregaTecnicaController@saveStarterKeyCommissioning']);
            
            // criar aspersores
            Route::get('/commissioning/create_commissioning_sprinklers/{id}', ['as' => 'create_commissioning_sprinklers', 'uses' => 'EntregaTecnica\EntregaTecnicaController@createSprinklersCommissioning']);
            Route::post('/commissioning/save_commissioning_sprinklers', ['as' => 'save_commissioning_sprinklers', 'uses' => 'EntregaTecnica\EntregaTecnicaController@saveSprinklersCommissioning']);
            
            // criar medições de sucção
            Route::get('/commissioning/create_commissioning_suction/{id}', ['as' => 'create_commissioning_suction', 'uses' => 'EntregaTecnica\EntregaTecnicaController@createSuctionMeasurementsCommissioning']);
            Route::post('/commissioning/save_commissioning_suction', ['as' => 'save_commissioning_suction', 'uses' => 'EntregaTecnica\EntregaTecnicaController@saveSuctionMeasurementsCommissioning']);
            
            // criar medições de ligação de pressão
            Route::get('/commissioning/create_commissioning_pressure_connection/{id}', ['as' => 'create_commissioning_pressure_connection', 'uses' => 'EntregaTecnica\EntregaTecnicaController@createPressureConnectionMeasurementsCommissioning']);
            Route::post('/commissioning/save_commissioning_pressure_connection', ['as' => 'save_commissioning_pressure_connection', 'uses' => 'EntregaTecnica\EntregaTecnicaController@savePressureConnectionMeasurementsCommissioning']);
            
            // criar medições de adutora
            Route::get('/commissioning/create_commissioning_water_supply/{id}', ['as' => 'create_commissioning_water_supply', 'uses' => 'EntregaTecnica\EntregaTecnicaController@createWaterSupplyMeasurementsCommissioning']);
            Route::post('/commissioning/save_commissioning_water_supply', ['as' => 'save_commissioning_water_supply', 'uses' => 'EntregaTecnica\EntregaTecnicaController@saveWaterSupplyMeasurementsCommissioning']);

            // criar testes
            Route::post('/commissioning/save_commissioning_test_eletric', ['as' => 'save_commissioning_test_eletric', 'uses' => 'EntregaTecnica\EntregaTecnicaController@saveElectricalTestCommissioning']);
            
            // criar testes
            Route::get('/commissioning/create_commissioning_tests/{id}', ['as' => 'create_commissioning_tests', 'uses' => 'EntregaTecnica\EntregaTecnicaController@createTestsCommissioning']);
            Route::post('/commissioning/save_commissioning_tests', ['as' => 'save_commissioning_tests', 'uses' => 'EntregaTecnica\EntregaTecnicaController@saveTestsCommissioning']);
        
            Route::post('/commissioning/save_img_commissioning_test', ['as' => 'save_img_commissioning_test', 'uses' => 'EntregaTecnica\EntregaTecnicaController@imgTestCommissioning']);

            // ficha tecnica
            Route::get('/commissioning/datasheet_commissioning/{id}', ['as' => 'datasheet_commissioning', 'uses' => 'EntregaTecnica\EntregaTecnicaController@datasheetCommissioning']);
            
            // enviar ficha tecnica
            Route::get('/commissioning/send_commissioning/{id}', ['as' => 'send_commissioning', 'uses' => 'EntregaTecnica\EntregaTecnicaController@sendCommissioning']);
            Route::post('/commissioning/send_complete_commissioning', ['as' => 'send_complete_commissioning', 'uses' => 'EntregaTecnica\EntregaTecnicaController@sendCompleteCommissioning']);
            Route::post('/ajax/commissioning/sendConfirmation_complete_commissioning', ['as' => 'sendConfirmation_commissioning', 'uses' => 'EntregaTecnica\EntregaTecnicaController@sendConfirmationCommissioning']);
            Route::post('/ajax/commissioning/checkCommissioningStatus', ['as' => 'checkStatus_commissioning', 'uses' => 'EntregaTecnica\EntregaTecnicaController@checkStatusCommissioning']);

            // análise entrega técnica
            Route::get('/commissioning/manage_analysis_commissioning', ['as' => 'manage_analysis_commissioning', 'uses' => 'EntregaTecnica\EntregaTecnicaController@manageAnalysisCommissioning']);
            Route::get('/commissioning/analysis_commissioning/{id}', ['as' => 'analysis_commissioning', 'uses' => 'EntregaTecnica\EntregaTecnicaController@analysisCommissioning']);
            Route::post('/commissioning/send_analisy_commissioning', ['as' => 'send_analisy_commissioning', 'uses' => 'EntregaTecnica\EntregaTecnicaController@sendAnalisyCommissioning']);
            
            // search
            Route::post('/commissioning/filter', ['as' => 'commissioning_filter', 'uses' => 'EntregaTecnica\EntregaTecnicaController@searchCommissioning']);

            /////////////////////////////////////////////////////////////////////////////////////////////////////////////


        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////// ROTAS DE PAÍSES ///////////////////////////////////////////////////
        /////////////////////////////////////// NOZZLE ROUTE /////////////////////////////////////////////////////

            Route::post('/country/filter', ['as' => 'country_filter', 'uses' => 'Sistema\CountryController@searchCountry']);
            Route::get('/country', ['as' => 'country_manage', 'uses' => 'Sistema\CountryController@manageCountry']);
            Route::get('/country/create', ['as' => 'country_create', 'uses' => 'Sistema\CountryController@createCountry']);
            Route::post('/country/save', ['as' => 'country_save', 'uses' => 'Sistema\CountryController@saveCountry']);
            Route::get('/country/edit/{id}', ['as' => 'country_edit', 'uses' => 'Sistema\CountryController@editCountry']);
            Route::post('/country/update', ['as' => 'country_update', 'uses' => 'Sistema\CountryController@updateCountry']);
            Route::delete('/country/delete/{id}', ['as' => 'country_delete', 'uses' => 'Sistema\CountryController@deleteCountry']);

        //////////////////////////////////////////////////////////////////////////////////////////////////////////
    //});

    /*
     *  Rotas de usuários gerentes
     *  Podem ser acessadas apenas por usuários administradores e gerentes
     */
    //Route::group(['middleware' => 'gerente'], function () {

        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////// ROTAS DE USUÁRIOS ////////////////////////////////////////////////
        /////////////////////////////////////// USER ROUTE ///////////////////////////////////////////////////////
            //Route::get('/user', ['as' => 'usuarios_manager', 'uses' => 'Sistema\UsuarioController@managerUsuarios'])->middleware(LogActionsMiddleware::class);
            Route::get('/user', ['as' => 'usuarios_manager', 'uses' => 'Sistema\UsuarioController@managerUsuarios']);
            Route::get('/user/create', ['as' => 'usuario_create', 'uses' => 'Sistema\UsuarioController@createUsuario']);
            Route::post('/user/save', ['as' => 'usuario_save', 'uses' => 'Sistema\UsuarioController@saveUsuario']);
            Route::get('/user/edit/{id}', ['as' => 'usuario_edit', 'uses' => 'Sistema\UsuarioController@editUsuarios']);
            Route::post('/user/update', ['as' => 'usuario_update', 'uses' => 'Sistema\UsuarioController@updateUsuarios']);
            Route::delete('/user/remover/{id}', ['as' => 'usuario.remover', 'uses' => 'Sistema\UsuarioController@delete']);
            Route::post('/user/status/{id}', ['as' => 'usuario_status', 'uses' => 'Sistema\UsuarioController@UserChangeStatus']);
            Route::any('filter', ['as' => 'filter', 'uses' => 'Sistema\UsuarioController@searchUser']);

        /////////////////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////l///////////////////////////////////////////////////////
        /////////////////////////////////////// ROTAS DE PERFIL /////////////////////////////////////////////////
        /////////////////////////////////////// PROFILE ROUTE ///////////////////////////////////////////////////

            Route::get('/usuarios/perfil', ['as' => 'usuario_profile', 'uses' => 'sistema\UsuarioController@getProfile']);
            Route::post('/usuarios/perfil/alterar', ['as' => 'usuario_alterar', 'uses' => 'sistema\UsuarioController@alteraInfoPerfil']);
            Route::post('/usuarios/perfil', ['as' => 'alterar_senha', 'uses' => 'sistema\UsuarioController@alterarSenha']);
            //Route::get('/usuarios/perfil/{id}', [UsuarioController::class, 'getProfile'])->name('usuario.profile');
            //Route::post('/usuarios/perfil/alterar', [UsuarioController::class, 'alteraInfoPerfil'])->name('usuario.alterar');
            //Route::post('/usuarios/perfil/alterarSenha', [UsuarioController::class, 'alterarSenha'])->name('alterar.senha');

        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////// ROTAS DE CENTRO DE CUSTO /////////////////////////////////////////
        /////////////////////////////////////// COST CENTER ROUTES (SUB REGIONS) /////////////////////////////////

            Route::get('/cost_center', ['as' => 'manage_cost_center', 'uses' => 'Sistema\CentroCustosController@manageCostCenter']);
            Route::get('/cost_center/create', ['as' => 'create_cost_center', 'uses' => 'Sistema\CentroCustosController@createCostCenter']);
            Route::post('/cost_center/save', ['as' => 'save_cost_center', 'uses' => 'Sistema\CentroCustosController@saveCostCenter']);
            Route::get('/cost_center/edit/{id}', ['as' => 'edit_cost_center', 'uses' => 'Sistema\CentroCustosController@editCostCenter']);
            Route::post('/cost_center/update', ['as' => 'update_cost_center', 'uses' => 'Sistema\CentroCustosController@updateCostCenter']);
            Route::delete('/cost_center/delete/{id}', ['as' => 'delete_center_cost', 'uses' => 'Sistema\CentroCustosController@delete']);
            Route::post('/cost_center/filter', ['as' => 'filter_center_cost', 'uses' => 'Sistema\CentroCustosController@searchCdc']);

        //////////////////////////////////////////////////////////////////////////////////////////////////////////

    //});

    /*
     *  Rotas de usuários supervisores
     *  Podem ser acessadas apenas por usuários administradores, gerentes e supervisores
     */
    //Route::group(['middleware' => 'supervisor'], function () {
    //});

    /*
     *  Rotas de usuários consultores
     *  Podem ser acessadas apenas por usuários administradores, gerentes, supervisores e consultores
     */
    //Route::group(['middleware' => 'consultor'], function () {

        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////// ROTAS DE FAZENDAS ////////////////////////////////////////////////
        /////////////////////////////////////// FARM ROUTES //////////////////////////////////////////////////////

            Route::get('/farm', ['as' => 'farms_manager', 'uses' => 'Sistema\FazendaController@manageFarms']);
            Route::get('/farm/farmSelect', ['as' => 'farms_select', 'uses' => 'Sistema\FazendaController@selectFarms']);
            Route::post('/farm/setfarm', ['as' => 'farm_setFarm', 'uses' => 'Sistema\FazendaController@setFarm']);
            Route::get('/farm/create', ['as' => 'farm_create', 'uses' => 'Sistema\FazendaController@createFarm']);
            Route::post('/farm/save', ['as' => 'farm_save', 'uses' => 'Sistema\FazendaController@saveFarm']);
            Route::get('/farm/edit/{id}', ['as' => 'farm_edit', 'uses' => 'Sistema\FazendaController@editFarm']);
            Route::POST('/farm/update', ['as' => 'farm_update', 'uses' => 'Sistema\FazendaController@updateFarm']);
            Route::delete('/farm/delete/{id}', ['as' => 'delete_Farm', 'uses' => 'Sistema\FazendaController@deleteFarm']);
            Route::post('/farm/filter', ['as' => 'filter_farm', 'uses' => 'Sistema\FazendaController@searchFarm']);

            //Rotas de fazenda
            Route::get('/farm/userAssist', ['as' => 'farm_userAssist', 'uses' => 'Sistema\FazendaController@userAssist']);
            Route::post('/farm/assist/create', ['as' => 'farm_createUserAssist', 'uses' => 'Sistema\FazendaController@createAssist']);
            Route::delete('/farm/assist/delete/{id}', ['as' => 'farm_deleteAssist', 'uses' => 'Sistema\FazendaController@deleteAssist']);

        //////////////////////////////////////////////////////////////////////////////////////////////////////////

        /////////////////////////////////////// ROTAS DE PROPRIETÁRIOS ///////////////////////////////////////////
        /////////////////////////////////////// OWNER ROUTES /////////////////////////////////////////////////////
            Route::get('/owners', ['as' => 'owner_manager', 'uses' => 'Sistema\ProprietarioController@managerOwners']);
            Route::get('/owner/createOwner', ['as' => 'owner_create', 'uses' => 'Sistema\ProprietarioController@createOwner']);
            Route::post('/owner/saveOwner', ['as' => 'owner_save', 'uses' => 'Sistema\ProprietarioController@saveOwner']);
            Route::get('/owner/editOwner/{id}', ['as' => 'owner_edit', 'uses' => 'Sistema\ProprietarioController@editOwner']);
            Route::post('/owner/update', ['as' => 'owner_update', 'uses' => 'Sistema\ProprietarioController@updateOwner']);
            Route::delete('/owner/delete/{id}', ['as' => 'owner_delete', 'uses' => 'Sistema\ProprietarioController@delete']);
            Route::any('/owner/filter', ['as' => 'owner_filter', 'uses' => 'Sistema\ProprietarioController@searchOwner']);

        //////////////////////////////////////////////////////////////////////////////////////////////////////////

    //});


    /*
     *  Rotas de usuários assistentes
     *  Podem ser acessadas apenas por usuários administradores, gerentes, supervisores, consultores e assistentes
     */
    //Route::group(['middleware' => 'assistente'], function () {

        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////// ROTA DO DASHBOARD ////////////////////////////////////////////////
        /////////////////////////////////////// DASHBOARD ROUTE //////////////////////////////////////////////////

            Route::get('/', ['as' => 'dashboard', 'uses' => 'Projetos\DashboardController@index']);
        //////////////////////////////////////////////////////////////////////////////////////////////////////////


    //});
    

});
