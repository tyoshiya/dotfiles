<?php
class SalesController extends AppController {
    var $name = 'Sales';
    var $uses = array('Sale',"SaleDetail","ProductHistory",'Customer');
    //コンポーネント呼び出し
    var $components = array('Mailer','Crypt','Paging','Checker','Cookie');
    //ヘルパー呼び出し
    var $helpers = array('Html','Error','Sticky','Session','Blogpart','Diggpager');
    //初期化
    function beforeFilter() {
        parent::beforeFilter();
        vendor("dBug/dBug");

        $this->set('type',$this->model("ReceivableDetail")->type);

        $tax_calc_type = $this->Customer->tax_calc_type;
        $value_round_type = $this->Customer->value_round_type;
        $tax_round_type = $this->Customer->tax_round_type;
        $this->set("tax_calc_type",$tax_calc_type);
        $this->set("value_round_type",$value_round_type);
        $this->set("tax_round_type",$tax_round_type);
    }

    function edit($id = null){
        //	$this->model("ReceivableSummary")->__updateBalanceAfterThis(1000,169,2015,6);
        //セッションチェック
        $this->Checker->hasAdminSession($this->Session);
        $this->checkPermission();

        if(!empty($this->data["Sale"]["execute"])){
            $valid = true;
            if($this->model("Sale")->validates($this->data) === false){
                $valid = false;
            }
            if($this->model("SaleDetail")->validates($this->data) === false){
                $valid = false;
            }
            if($valid){
                $id = $this->model("Sale")->saveEdit($this->data);
                $this->Function->setFlash($this->viewPath,$this->action,
                    array("sale_id" => $id)
                );
                $this->redirect("/sales/edit");
            }else{
                $this->Session->setFlash('<span>'._DEF_VALIDATION_ERROR.'</span>','default',array('class'=>'error-message'));
            }
        }else{
            if($id !== null){
                $this->data = $this->model("Sale")->getEdit($id);
            }else{
                $this->data['Sale']['order_date'] = $this->Sale->getLatestOrderDate();
                parent::setDefault(array('Factory'),'Sale');
            }
        }
        //バリデータセット
        $this->set("id",$id);
        $this->set("validate",$this->Sale->validate);
        $this->set("validate_detail",$this->SaleDetail->validate);
    }

    function del($id = null){
        $this->Checker->hasAdminSession($this->Session);
        $this->Checker->checkId($id);

        $sales = $this->model("Sale")->findById($id);

        $this->model("Sale")->del($id);

        $this->model("SaleDetail")->findAllDell("sale_id = ".$id);

        //-- 部品入出庫情報保存 --//
        $product_id = $sales["Sale"]['product_id'];
        $factory_id = $_SESSION["site"]["user"]["factory_id"];
        $order_date = $sales["Sale"]["order_date"];
        $type = 6;
        $quantity = $sales["Sale"]["quantity"];
        $order_id = $id;
        $this->model("ProductHistory")->saveHistory($product_id,$factory_id,$type,$order_date,$order_id,$quantity);

        $this->Function->setFlash($this->viewPath,$this->action,array("sale_id" => $id));

        $this->redirect("/sales/edit");
    }

    function index(){
        $this->Checker->hasAdminSession($this->Session);
        $this->checkPermission();

        $sales = array();

        if($this->data){
            $this->Sale->validate = $this->Sale->validate_index;
            if($this->Sale->validates($this->data)){
                $sales = $this->Sale->getIndexData($this->data);

                //CSV出力
                if(@$this->params["url"]["mode"] == "csv"){
                    $this->csv($this->viewPath,$this->action,$sales);
                }
            }else{
                $this->Session->setFlash('<span>'._DEF_VALIDATION_ERROR.'</span>','default',array('class'=>'error-message'));
            }
        }else{
            $this->data['Sale']['order_date'] = date('Y/m');
        }

        $this->set("sales",$sales);
        $this->set("validate",$this->Sale->validate_index);
    }


    function search_ticket(){
        $this->Checker->hasAdminSession($this->Session);
        $this->checkPermission();

        if(empty($this->data['Sale']['execute']))
            $this->data['Sale']['max_cnt'] = 1;

        $this->set("ourname_print_flg",$this->Sale->ourname_print_flg);
        $this->set("validate",$this->Sale->validate_search_ticket);
    }

    function pdf_ticket(){
        $this->Checker->hasAdminSession($this->Session);

        $validation_errors = $this->Sale->validateTicketPdf($this->data);

        if(empty($validation_errors)){
            $this->Sale->pdfTicket($this->data);
            exit;
        }else{
            $this->Session->setFlash('<span>'._DEF_VALIDATION_ERROR.'</span>','default',array('class'=>'error-message'));
            $this->set('errors',$this->Sale->validationErrors);
            $this->render('../errors/validation_error');
        }
    }

    function daily_index(){
        //セッションチェック
        $this->Checker->hasAdminSession($this->Session);
        $this->checkPermission();

        //初期値
        $sales = array();

        if(!empty($this->data['Sale']['execute'])){
            $this->Sale->validate = $this->Sale->validate_daily_index;
            if($this->Sale->validates($this->data)){
                // データ取得
                $sales = $this->Sale->getDailyIndexData($this->data);
                //CSV出力
                if(@$this->params["url"]["mode"] == "csv"){
                    $this->csv($this->viewPath,$this->action,$sales);
                }
            }else{
                $this->Session->setFlash('<span>'._DEF_VALIDATION_ERROR.'</span>','default',array('class'=>'error-message'));
            }
        }else{
            $this->data['Sale']['order_date'] = date('Y/m/d');
        }

        //Viewに必要なデータをセット
        $this->set("sales",$sales);
        $this->set("validate",$this->Sale->validate_daily_index);
    }

    function daily_shipping_index(){
        //セッションチェック
        $this->Checker->hasAdminSession($this->Session);
        $this->checkPermission();

        //初期値
        $sales = array();

        if(!empty($this->data['Sale']['execute'])){
            $this->Sale->validate = $this->Sale->validate_daily_shipping_index;
            if($this->Sale->validates($this->data)){
                // データ取得
                $sales = $this->Sale->getDailyShippingIndexData($this->data);
                //CSV出力
                if(@$this->params["url"]["mode"] == "csv"){
                    $this->csv($this->viewPath,$this->action,$sales);
                }
            }else{
                $this->Session->setFlash('<span>'._DEF_VALIDATION_ERROR.'</span>','default',array('class'=>'error-message'));
            }
        }else{
            $this->data['Sale']['deliv_date'] = date('Y/m/d');
        }

        //Viewに必要なデータをセット
        $this->set("sales",$sales);
        $this->set("validate",$this->Sale->validate_daily_shipping_index);
    }

    function master_index(){
        //セッションチェック
        $this->Checker->hasAdminSession($this->Session);
        $this->checkPermission();

        //初期値
        $sales = array();

        if(!empty($this->data['Sale']['execute'])){
            $this->Sale->validate = $this->Sale->validate_master_index;
            if($this->Sale->validates($this->data)){
                // データ取得
                $sales = $this->Sale->getMasterIndexData($this->data);

                //CSV出力
                if(@$this->params["url"]["mode"] == "csv"){
                    $this->csv($this->viewPath,$this->action,$sales);
                }
            }else{
                $this->Session->setFlash('<span>'._DEF_VALIDATION_ERROR.'</span>','default',array('class'=>'error-message'));
            }
        }else{
            $this->data['Sale']['order_date'] = date('Y/m');
        }

        //Viewに必要なデータをセット
        $this->set("sales",$sales);
        $this->set("validate",$this->Sale->validate_master_index);
    }

    function sum_customer(){
        //セッションチェック
        $this->Checker->hasAdminSession($this->Session);
        $this->checkPermission();

        //初期値
        $sales = array();

        if(!empty($this->data['Sale']['execute'])){
            $this->Sale->validate = $this->Sale->validate_sum_customer;
            if($this->Sale->validates($this->data)){
                // データ取得
                $sales = $this->Sale->getSumCustomerData($this->data);

                //CSV出力
                if(@$this->params["url"]["mode"] == "csv"){
                    $this->csv($this->viewPath,$this->action,$sales);
                }
            }else{
                $this->Session->setFlash('<span>'._DEF_VALIDATION_ERROR.'</span>','default',array('class'=>'error-message'));
            }
        }else{
            $this->data['Sale']['order_date'] = date('Y/m');
        }

        //Viewに必要なデータをセット
        $this->set("sales",$sales);
        $this->set("validate",$this->Sale->validate_sum_customer);
    }

    /**
     *	売上実績表
     */
    function sum_project(){
        //セッションチェック
        $this->Checker->hasAdminSession($this->Session);
        $this->checkPermission();

        //初期値
        $sales = array();
        $arr_ym = array();

        if(!empty($this->data['Sale']['execute'])){

            $this->Sale->validate = $this->Sale->validate_sum_project;

            if($this->Sale->validates($this->data)){
                /* データ取得 */
                list($sales,$arr_ym) = $this->Sale->getSumProjectData($this->data);
                //CSV出力
                if(@$this->params["url"]["mode"] == "csv"){
                    $this->csv($this->viewPath,$this->action,$sales,array("arr_ym" => $arr_ym));
                }
            }else{
                $this->Session->setFlash('<span>'._DEF_VALIDATION_ERROR.'</span>','default',array('class'=>'error-message'));
            }
        }else{
            parent::setDefault(array('Factory'),'Sale');
            $this->data['Sale']['order_date'] = date('Y/m');
        }
        //データセット
        $this->set('sales',$sales);
        $this->set('arr_ym',$arr_ym);
        $this->set("validate",$this->Sale->validate_sum_project);
    }

    function data_link(){
        $this->Checker->hasAdminSession($this->Session);
        $this->checkPermission();

        $sales = array();

        if($this->data){
            $this->Sale->validate = $this->Sale->validate_data_link;
            if($this->Sale->validates($this->data)){
                $sales = $this->Sale->getDataLink($this->data);

                //CSV出力
                if(@$this->params["url"]["mode"] == "csv"){
                    $this->csv($this->viewPath,$this->action,$sales);
                }
            }else{
                $this->Session->setFlash('<span>'._DEF_VALIDATION_ERROR.'</span>','default',array('class'=>'error-message'));
            }
        }else{
            $this->data["Sale"]["order_date"] = date("Y/m");
        }

        $this->set("sales",$sales);
        $this->set("validate",$this->Sale->validate_data_link);
    }


    /**
     *	売上伝票一括出力
     */
    function all_pdf_detail($mode = null){
        $this->Checker->hasAdminSession($this->Session);
        $this->checkPermission();

        if(!empty($this->data)){
            switch($mode){
            case 1:
                $this->Sale->validate = $this->Sale->validate_all_pdf_detail1;
                break;
            case 2:
                $this->Sale->validate = $this->Sale->validate_all_pdf_detail2;
                break;
            }
            //バリデーション
            if($this->Sale->validates($this->data)){
                //伝票出力
                $this->data["mode"] = $mode;
                $sales = $this->model("Sale")->getPdfSale("all",array("mode" => $mode,"data" => $this->data));
                //new dbug($sales);exit;

                $this->model("Pdf")->outputSales($sales);
                exit();
            }else{
                $errors = $this->Sale->validationErrors;
            }

            //エラー表示
            if(!empty($errors)){
                $this->Session->setFlash('<span>'._DEF_VALIDATION_ERROR.'</span>','default',array('class'=>'error-message'));
                $this->set('errors',$errors);
                $this->render('../errors/validation_error');
            }
        }else{
            $this->data['Sale']['order_date_from'] = date("Y/m/d");
            $this->data['Sale']['order_date_to'] =  date("Y/m/d");
        }
        $this->set('validate1',$this->Sale->validate_all_pdf_detail1);
        $this->set('validate2',$this->Sale->validate_all_pdf_detail2);
    }

    ////--モーダル--------------------------------------------------------------------------------
    function modal_search($mode){
        //セッションチェック
        $this->Checker->hasAdminSession($this->Session);
        $this->layout = 'modal';
        //データ取得
        $sales = array();
        $sales_all = array();
        $page = null;

        if($this->data){
            //現在のページを取得
            $page = $this->Paging->getPage();
            //全データを取得
            $sales_all = $this->Sale->getModalSearch($this->data);
            //本ページで必要なデータを抽出
            $sales = $this->Paging->getPageData($sales_all , _def_listnum, $page);
        }
        //Viewに必要なデータをセット
        $this->set("total",count($sales_all));
        $this->set("page",$page);
        $this->set("sales",$sales);
        $this->render("modal_search");
    }
    ////----------------------------------------------------------------------------------

    /* ajax */
    function ajax_get_by_id(){
        $this->layout = "ajax";
        $this->autoRender = false;
        $res = $this->Sale->findById($this->params['form']['id']);
        if(!empty($res)){
            require_once APP."controllers".DS."components".DS."json.php";
            $json = new Services_JSON();
            echo $json->encode($res);
        }
    }

    function delete_all(){
        $sales = $this->model("Sale")->findAll();

        if(!empty($sales)){
            foreach($sales as $key => $row){
                $this->model("Sale")->del($row["Sale"]["id"]);

                $this->model("SaleDetail")->findAllDell("sale_id = ".$row["Sale"]["id"]);

            }
        }

        $this->model("ProductHistory")->deleteAll(array(5,6));

        exit;
    }

    function upload(){
        $this->checkPermission();

        if(!empty($this->data['Sale']['execute'])){
            $this->set("validate",$this->model("Sale")->validate);
            $this->set("validate_detail",$this->model("SaleDetail")->validate);

            if ($_GET["mode"] == "upload") {
                unset($this->data[0]);

                //CSV読み込み
                setlocale(LC_ALL, 'ja_JP.UTF-8');
                $data = file_get_contents($_FILES["data"]["tmp_name"]["Sale"]["file"]);
                $data = mb_convert_encoding($data,"UTF-8","sjis-win");
                $tmp = tmpFile();
                $read_data = array();

                $i = 0;
                fwrite($tmp,$data);
                rewind($tmp);
                while(($line = fgetcsv($tmp,0,",")) !== false){
                    if($i != 1){
                        $read_data[] = $line;
                    }
                    $i++;
                }

                //読み込みデータから売上データを作成
                $cols = $read_data[0];
                unset($read_data[0]);
                $read_data = array_merge($read_data);
                //                $this->data["Sale"]["max_page"] = count($read_data);
                //                $this->data["Sale"]["page"] = 0;
                $factory = $this->model("Factory")->findById($_SESSION["site"]["user"]["factory_id"]);

                $save_cnt = 0;
                foreach ($read_data as $key => $val) {
                    $saves = array();
                    //工場はログインユーザーの工場
                    $saves["Sale"]["factory_id"] = $factory["Factory"]["id"];

                    foreach ($cols as $key2 => $col) {
                        if($col == "saleorder_id"){
                            $saleorder = $this->model("Saleorder")->findById($read_data[$key][$key2]); 

                            if($saleorder){
                                //受注関係
                                $saves["Sale"]["quantity"] = $saleorder["Saleorder"]["quantity"];
                                $saves["Sale"]["price"] = $saleorder["Saleorder"]["price"];
                                $saves["Sale"]["subtotal"] = $saleorder["Saleorder"]["subtotal"];
                                $saves["Sale"]["deliv_date"] = $saleorder["Saleorder"]["deliv_date"];
                                $saves["Sale"]["memo"] = $saleorder["Saleorder"]["note"];
                                $saves["Sale"]["memo2"] = $saleorder["Saleorder"]["note2"];
                                $saves["Sale"]["memo3"] = $saleorder["Saleorder"]["note3"];
                                $saves["Sale"]["deliv_client_name3"] = $saleorder["Saleorder"]["deliv_client_name3"];
                                $saves["Sale"]["client_order_number"] = $saleorder["Saleorder"]["client_order_number"];
                                $saves["Sale"]["client_name3"] = $saleorder["Saleorder"]["client_name3"];

                                //部品関係 
                                if($saleorder["Saleorder"]["product_id"] > 0){
                                    $product = $this->model("Product")->findById($saleorder["Saleorder"]["product_id"]); 
                                    if($product){
                                        $saves["Sale"]["product_code"] = $product["Product"]["code"];
                                        $saves["Sale"]["product_id"] = $product["Product"]["id"];
                                        $saves["Sale"]["product_name"] = $product["Product"]["name"];
                                        $saves["Sale"]["product_name2"] = $product["Product"]["name2"];
                                        $saves["Sale"]["image_number"] = $product["Product"]["image_number"];

                                        //得意先関係
                                        $customer = $this->model("Customer")->findById($product["Product"]["customer_id"]); 
                                        if($customer){
                                            $saves["Sale"]["customer_code"] = $customer["Customer"]["code"];
                                            $saves["Sale"]["customer_id"] = $customer["Customer"]["id"];
                                            $saves["Sale"]["customer_name"] = $customer["Customer"]["name"];
                                            $saves["Sale"]["customer_name2"] = $customer["Customer"]["name2"];
                                        }else{
                                            $saves["Sale"]["customer_id"] = "";
                                            $saves["Sale"]["customer_code"] = "";
                                            $saves["Sale"]["customer_name"] = "";
                                            $saves["Sale"]["customer_name2"] = "";
                                        }
                                    }else{
                                        $saves["Sale"]["product_id"] = "";
                                        $saves["Sale"]["product_code"] = "";
                                        $saves["Sale"]["product_name"] = "";
                                        $saves["Sale"]["product_name2"] = "";
                                        $saves["Sale"]["image_number"] = "";
                                        $saves["Sale"]["customer_id"] = "";
                                        $saves["Sale"]["customer_code"] = "";
                                        $saves["Sale"]["customer_name"] = "";
                                        $saves["Sale"]["customer_name2"] = "";
                                    }

                                    //セット関係
                                    $product_set = $this->model("ProductSet")->findById($saleorder["Saleorder"]["product_set_id"]); 
                                    if($product_set){
                                        $saves["Sale"]["product_set_id"] = $product_set["ProductSet"]["id"];
                                        $saves["Sale"]["product_set_code"] = $product_set["ProductSet"]["code"];
                                        $saves["Sale"]["product_set_count"] = $product_set["ProductSet"]["count"];

                                        $set_product = $this->model("Product")->findById($product_set["ProductSet"]["product_id"]);
                                        if($set_product){
                                            $saves["Sale"]["product_set_name"] = $set_product["Product"]["name"];
                                        }else{
                                            $saves["Sale"]["product_set_name"] = "";
                                        }
                                    }else{
                                        $saves["Sale"]["product_set_id"] = "";
                                        $saves["Sale"]["product_set_code"] = "";
                                        $saves["Sale"]["product_set_count"] = "";
                                        $saves["Sale"]["product_set_name"] = "";
                                    }

                                    //受注先関係
                                    $jobber_customer = $this->model("Customer")->findById($saleorder["Saleorder"]["jobber_customer_id"]); 
                                    if($jobber_customer){
                                        $saves["Sale"]["jobber_customer_id"] = $jobber_customer["Customer"]["id"];
                                        $saves["Sale"]["jobber_customer_code"] = $jobber_customer["Customer"]["code"];
                                        $saves["Sale"]["jobber_customer_name"] = $jobber_customer["Customer"]["name"];
                                        $saves["Sale"]["jobber_customer_name2"] = $jobber_customer["Customer"]["name2"];
                                        $saves["Sale"]["tax_calc_type"] = $jobber_customer["Customer"]["tax_calc_type"];
                                        $saves["Sale"]["tax_round_type"] = $jobber_customer["Customer"]["tax_round_type"];
                                        $saves["Sale"]["value_round_type"] = $jobber_customer["Customer"]["value_round_type"];
                                    }else{
                                        $saves["Sale"]["jobber_customer_id"] = "";
                                        $saves["Sale"]["jobber_customer_code"] = "";
                                        $saves["Sale"]["jobber_customer_name"] = "";
                                        $saves["Sale"]["jobber_customer_name2"] = "";
                                        $saves["JobberCustomer"]["tax_round_type"] = "";
                                        $saves["JobberCustomer"]["tax_calc_type"] = "";
                                        $saves["JobberCustomer"]["value_round_type"] = "";
                                    }

                                    //納入場所関係
                                    $deliv_client = $this->model("Customer")->findById($saleorder["Saleorder"]["deliv_client_id"]); 
                                    if($deliv_client){
                                        $saves["Sale"]["deliv_client_id"] = $deliv_client["Customer"]["id"];
                                        $saves["Sale"]["deliv_client_code"] = $deliv_client["Customer"]["code"];
                                        $saves["Sale"]["deliv_client_name"] = $deliv_client["Customer"]["name"];
                                        $saves["Sale"]["deliv_client_name2"] = $deliv_client["Customer"]["name2"];
                                    }else{
                                        $saves["Sale"]["deliv_client_id"] = "";
                                        $saves["Sale"]["deliv_client_code"] = "";
                                        $saves["Sale"]["deliv_client_name"] = "";
                                        $saves["Sale"]["deliv_client_name2"] = "";
                                    }

                                    //発注先
                                    $client = $this->model("Customer")->findById($saleorder["Saleorder"]["client_id"]); 
                                    if($client){
                                        $saves["Sale"]["client_id"] = $client["Customer"]["id"];
                                        $saves["Sale"]["client_code"] = $client["Customer"]["code"];
                                        $saves["Sale"]["client_name"] = $client["Customer"]["name"];
                                        $saves["Sale"]["client_name2"] = $client["Customer"]["name2"];
                                    }else{
                                        $saves["Sale"]["client_id"] = "";
                                        $saves["Sale"]["client_code"] = "";
                                        $saves["Sale"]["client_name"] = "";
                                        $saves["Sale"]["client_name2"] = "";
                                    }
                                }
                            }
                        }else{
                        }

                        //部品
                        if($col == "product_code"){
                            if($read_data[$key][$key2] != ""){
                                $product = $this->model("Product")->find("code = '".$read_data[$key][$key2]."'"); 
                                if($product){
                                    $saves["Sale"]["product_id"] = $product["Product"]["id"];
                                    $saves["Sale"]["product_code"] = $read_data[$key][$key2];
                                    $saves["Sale"]["product_name"] = $product["Product"]["name"];
                                    $saves["Sale"]["product_name2"] = $product["Product"]["name2"];
                                    $saves["Sale"]["image_number"] = $product["Product"]["image_number"];

                                    //得意先関係
                                    $customer = $this->model("Customer")->findById($product["Product"]["customer_id"]); 
                                    if($customer){
                                        $saves["Sale"]["customer_code"] = $customer["Customer"]["code"];
                                        $saves["Sale"]["customer_id"] = $customer["Customer"]["id"];
                                        $saves["Sale"]["customer_name"] = $customer["Customer"]["name"];
                                        $saves["Sale"]["customer_name2"] = $customer["Customer"]["name2"];
                                    }else{
                                        $saves["Sale"]["customer_id"] = "";
                                        $saves["Sale"]["customer_code"] = "";
                                        $saves["Sale"]["customer_name"] = "";
                                        $saves["Sale"]["customer_name2"] = "";
                                    }
                                }else{
                                    $saves["Sale"]["product_id"] = "";
                                    $saves["Sale"]["product_code"] = "";
                                    $saves["Sale"]["product_name"] = "";
                                    $saves["Sale"]["product_name2"] = "";
                                    $saves["Sale"]["image_number"] = "";
                                    $saves["Sale"]["customer_id"] = "";
                                    $saves["Sale"]["customer_code"] = "";
                                    $saves["Sale"]["customer_name"] = "";
                                    $saves["Sale"]["customer_name2"] = "";
                                }
                            }
                        }

                        //セット
                        if($col == "product_set_code"){
                            if($read_data[$key][$key2] != ""){
                                $product_set = $this->model("ProductSet")->find("code = '".$read_data[$key][$key2]."'"); 
                                if($product_set){
                                    $saves["Sale"]["product_set_id"] = $product_set["ProductSet"]["id"];
                                    $saves["Sale"]["product_set_code"] = $product_set["ProductSet"]["code"];
                                    $saves["Sale"]["product_set_count"] = $product_set["ProductSet"]["count"];

                                    $set_product = $this->model("Product")->findById($product_set["ProductSet"]["product_id"]);
                                    if($set_product){
                                        $saves["Sale"]["product_set_name"] = $set_product["Product"]["name"];
                                    }else{
                                        $saves["Sale"]["product_set_name"] = "";
                                    }
                                }else{
                                    $saves["Sale"]["product_set_id"] = "";
                                    $saves["Sale"]["product_set_code"] = "";
                                    $saves["Sale"]["product_set_name"] = "";
                                    $saves["Sale"]["product_set_count"] = "";
                                }
                            }else{
                                $saves["Sale"]["product_set_id"] = "";
                            }
                        }

                        //受注先
                        if($col == "jobber_customer_code"){
                            if($read_data[$key][$key2] != ""){
                                $jobber_customer = $this->model("Customer")->find("code = '".$read_data[$key][$key2]."'"); 
                                if($jobber_customer){
                                    $saves["Sale"]["jobber_customer_id"] = $jobber_customer["Customer"]["id"];
                                    $saves["Sale"]["jobber_customer_code"] = $jobber_customer["Customer"]["code"];
                                    $saves["Sale"]["jobber_customer_name"] = $jobber_customer["Customer"]["name"];
                                    $saves["Sale"]["tax_calc_type"] = $jobber_customer["Customer"]["tax_calc_type"];
                                    $saves["Sale"]["tax_round_type"] = $jobber_customer["Customer"]["tax_round_type"];
                                    $saves["Sale"]["value_round_type"] = $jobber_customer["Customer"]["value_round_type"];

                                }else{
                                    $saves["Sale"]["jobber_customer_id"] = "";
                                    $saves["Sale"]["jobber_customer_code"] = "";
                                    $saves["Sale"]["jobber_customer_name"] = "";
                                    $saves["JobberCustomer"]["tax_round_type"] = "";
                                    $saves["JobberCustomer"]["tax_calc_type"] = "";
                                    $saves["JobberCustomer"]["value_round_type"] = "";
                                }
                            }
                        }

                        //納入先
                        if($col == "deliv_client_code"){
                            if($read_data[$key][$key2] != ""){
                                $deliv_client = $this->model("Customer")->find("code = '".$read_data[$key][$key2]."'"); 
                                if($deliv_client){
                                    $saves["Sale"]["deliv_client_id"] = $deliv_client["Customer"]["id"];
                                    $saves["Sale"]["deliv_client_code"] = $deliv_client["Customer"]["code"];
                                    $saves["Sale"]["deliv_client_name"] = $deliv_client["Customer"]["name"];
                                    $saves["Sale"]["deliv_client_name2"] = $deliv_client["Customer"]["name2"];
                                }else{
                                    $saves["Sale"]["deliv_client_id"] = "";
                                    $saves["Sale"]["deliv_client_code"] = "";
                                    $saves["Sale"]["deliv_client_name"] = "";
                                    $saves["Sale"]["deliv_client_name2"] = "";
                                }
                            }
                        }

                        //発注先
                        if($col == "client_code"){
                            if($read_data[$key][$key2] != ""){
                                $client = $this->model("Customer")->find("code = '".$read_data[$key][$key2]."'"); 
                                if($client){
                                    $saves["Sale"]["client_id"] = $client["Customer"]["id"];
                                    $saves["Sale"]["client_code"] = $client["Customer"]["code"];
                                    $saves["Sale"]["client_name"] = $client["Customer"]["name"];
                                    $saves["Sale"]["client_name2"] = $client["Customer"]["name2"];
                                }else{
                                    $saves["Sale"]["client_id"] = "";
                                    $saves["Sale"]["client_code"] = "";
                                    $saves["Sale"]["client_name"] = "";
                                    $saves["Sale"]["client_name2"] = "";
                                }
                            }
                        }

                        if(isset($saves["Sale"][$col])){
                            if($saves["Sale"][$col] == ""){
                                $saves["Sale"][$col] = $read_data[$key][$key2];
                                if(strpos($col,"sale_detail_") !== false){
                                    $saves["SaleDetail"][str_replace("sale_detail_","",$col)] = $read_data[$key][$key2];

                                }else{
                                    $saves["Sale"][$col] = $read_data[$key][$key2];
                                }
                            }
                        }else{
                            if(strpos($col,"sale_detail_") !== false){
                                $saves["SaleDetail"][str_replace("sale_detail_","",$col)] = $read_data[$key][$key2];

                            }else{
                                if(isset($read_data[$key][$key2])){
                                    $saves["Sale"][$col] = $read_data[$key][$key2];
                                }
                            }
                        }
                    }

                    $saves["Sale"]["id"] = "";
                    $this->model("Sale")->create();
                    $this->model("Sale")->saveEdit($saves);
                    $save_cnt++;
                }

                $this->Session->setFlash('<span>'.$save_cnt.'件のデータを保存しました。</span>');
            }

            /*
            if ($_GET["mode"] == "save") {
                $page = $this->data["Sale"]["page"];
                $data = $this->data[$page];
                $valid = true;
                if($this->model("Sale")->validates($data) === false){
                    $valid = false;
                }
                if($this->model("SaleDetail")->validates($data) === false){
                    $valid = false;
                }
                if($valid){
                    $data["Sale"]["id"] = "";
                    $id = $this->model("Sale")->saveEdit($data);
                    $this->Function->setFlash($this->viewPath,"edit",
                        array("sale_id" => $id)
                    );
                    if($this->data["Sale"]["max_page"] == $this->data["Sale"]["page"] + 1){
                        $this->redirect("/sales/upload");
                    }else{
                        $this->data["Sale"]["page"]++;
                    }
                }else{
                    $this->Session->setFlash('<span>'._DEF_VALIDATION_ERROR.'</span>','default',array('class'=>'error-message'));
                }
            }
             */
        }else{
            if(isset($_GET["mode"])){
                if ($_GET["mode"] == "download") {
                    $this->layout = false;
                    $this->autoRender = false;
                    $file_name = $_GET["file_name"];
                    $path_name = dirname(__FILE__)."/../files/sales_upload/".$file_name;
                    header("Content-Disposition: attachment; filename='".basename($path_name)."'");
                    header("Content-Type: application/octet-stream");
                    header("Content-Transfer-Encoding: binary");
                    header("Content-Length:".filesize($path_name));
                    readfile($path_name);
                    unlink($path_name);
                }
            }
        }
    }

    function zip_download_file(){
        if(!empty($this->data['Sale']['execute'])){
            $chdir = dirname(__FILE__)."/../files/sales_upload";
            chdir($chdir);
            $file_name = "sales_upload_".date("YmdHis").".zip";
            $command = "zip ".$file_name." README.txt sales_upload.csv";
            exec($command);
            $this->redirect("/sales/upload?mode=download&file_name=".$file_name);
        }
    }

    public function dev_delete_before_created(){
        ini_set('memory_limit', '512M');
        ini_set("max_execution_time",0);

        $backup_path = dirname(__FILE__)."/../backups/dev/";
        $file_name = "sales.dev_delete_before_created.".date("YmdHis").".sql";
        $this->dbBackup($backup_path,$file_name);

        $created = "2016-08-31 23:59:59";
        $sales = $this->model("Sale")->findAll("created <= '".$created."'");
        if(!empty($sales)){
            foreach ($sales as $sale) {
                $this->__del($sale["Sale"]["id"]);
            }
        }
        exit;
    }

    public function dev_delete_after_created(){
        ini_set('memory_limit', '512M');
        ini_set("max_execution_time",0);

        $backup_path = dirname(__FILE__)."/../backups/dev/";
        $file_name = "sales.dev_delete_after_created.".date("YmdHis").".sql";
        $this->dbBackup($backup_path,$file_name);

        $created = "2017/02/13 00:00:00";
        $sales = $this->model("Sale")->findAll("created >= '".$created."'");
        if(!empty($sales)){
            foreach ($sales as $sale) {
                $this->__del($sale["Sale"]["id"]);
            }
        }
        exit;
    }

    protected function __del($id){
        $sale = $this->model("Sale")->findById($id);
        $this->model("Sale")->del($id);
        $this->model("SaleDetail")->findAllDell("sale_id = ".$id);

        if($sale["Sale"]["product_id"] != "" && $sale["Sale"]["order_date"] != "" && $sale["Sale"]["quantity"]){
            $product_id = $sale["Sale"]["product_id"];
            $factory_id = $sale["Sale"]["factory_id"];
            $type = 5;
            $this->model("ProductHistory")->deleteHistory($product_id,$factory_id,$type,$id);

            //セットの時はセット構成部品をの在庫を変動
            if($sale["Sale"]["product_set_id"] != ""){
                $product_set = $this->model("ProductSet")->findAll("product_id = ".$sale["Sale"]["product_id"]." and del_flg = 0","id",null,1);

                if(!empty($product_set)){
                    $product_set_components = $this->model("ProductSetComponent")->findAll("del_flg = 0 and product_set_id = ".$product_set[0]["ProductSet"]["id"]);

                    if(!empty($product_set_components)){
                        foreach ($product_set_components as $row) {
                            $product_id = $row["ProductSetComponent"]["part_product_id"];
                            $factory_id = $sale["Sale"]["factory_id"];
                            $type = 5;
                            $order_id = $id;
                            $this->model("ProductHistory")->deleteHistory($product_id,$factory_id,$type,$id);
                        }
                    }
                }
            }
        }
    }

}
?>
