<?php
class TestsController extends AppController {
    var $name = 'Tests';
    var $uses = null;
    var $data_tables = array(
        "billings",
        "invoice_adjusts",
        "manufacture_deliveries",
        "manufacture_inspection_defects",
        "manufacture_inspection_flaws",
        "manufacture_lines",
        "manufacture_results",
        "manufacture_schedule_machine_rests",
        "manufacture_schedule_workers",
        "manufacture_schedules",
        "manufacture_work_result_warehousing_details",
        "manufacture_work_result_warehousings",
        "manufacture_work_results",
        "manufactures",
        "material_histories",
        "material_offsets",
        "material_stocks",
        "material_supplies",
        "payable_details",
        "payable_summaries",
        "payable_summary_details",
        "payables",
        "product_histories",
        "product_stocks",
        "product_supplies",
        "purchase_adjusts",
        "purchase_details",
        "purchaseorders",
        "purchases",
        "receivable_details",
        "receivable_summaries",
        "receivable_summary_details",
        "receivables",
        "sale_details",
        "saleorder_details",
        "saleorders",
        "sales",
        "subcontract_details",
        "subcontracts"
    );
    var $start_date = "2016-03";
    var $add_month = 12;
    var $amount_per_month = 30;

    //初期化
    function beforeFilter() {
        parent::beforeFilter();
        vendor("dBug/dBug");
        $this->layout = 'ajax';
        $this->autoRender = false;
        ini_set('memory_limit', '512M');
        ini_set("max_execution_time",240);
    }

    public function all(){
        $this->truncate_all_data_tables();
        $this->auto_save_saleorders();
        $this->auto_save_sales();
        $this->auto_save_receivables();
        $this->auto_save_reveivable_summaries();
    }

    public function truncate_all_data_tables(){
        $data_tables = $this->data_tables;

        foreach ($data_tables as $data_table) {
            $sql = " truncate table ".$data_table;
            $this->model("Saleorder")->query($sql);
            new dbug($data_table."のデータ削除完了");
        }
    }

    public function auto_save_saleorders(){
        $products = $this->model("Product")->findAll("del_flg = 0","id,code");
        $customers = $this->model("Customer")->findAll("account_type = 1 and del_flg = 0","id");
        $clients = $this->model("Customer")->findAll("account_type = 3 and del_flg = 0","id");

        for($i = 0; $i <= $this->add_month; $i++){
            for($j = 0; $j < $this->amount_per_month; $j++){
                $saves = array();
                $saves["Saleorder"]["id"] = null;

                //部品
                $saves["Product"] = $products[rand(0,count($products) - 1)]["Product"];
                $saves["Saleorder"]["product_id"] = $saves["Product"]["id"];

                $saves["Saleorder"]["product_set_id"] = null;
                $product_set = $this->model("ProductSet")->findByCode($saves["Product"]["code"]);
                if(!empty($product_set)){
                    $saves["Saleorder"]["product_set_id"] = $product_set["ProductSet"]["id"];
                }

                //注文番号
                $saves["Saleorder"]["order_number"] = null;
                if(rand(0,1)){
                    $saves["Saleorder"]["order_number"] = $this->makeRandStr(12);
                }

                //受注先
                $saves["Saleorder"]["jobber_customer_id"] = $customers[rand(0,count($customers) - 1)]["Customer"]["id"];

                //受注日
                $start_date = $this->start_date;
                $start_date_from = date("Y-m-01",strtotime($start_date." +".$i."month"));
                $start_date_to = date("Y-m-t",strtotime($start_date_from));
                $saves["Saleorder"]["order_date"] = $this->makeRandDate($start_date_from,$start_date_to);

                //納期
                //受注日の翌月とする
                $saves["Saleorder"]["apo_deliv_date"] = null;
                if(rand(0,1)){
                    $saves["Saleorder"]["apo_deliv_date"] = date("Y-m-d",strtotime($saves["Saleorder"]["order_date"]." +1 month"));
                    $saves["Saleorder"]["apo_deliv_date_memo"] = $this->makeRandStr(10);
                }

                //出荷日
                $saves["Saleorder"]["deliv_date"] = null;
                if(rand(0,1)){
                    //受注日の3週間後とする
                    $saves["Saleorder"]["deliv_date"] = date("Y-m-d",strtotime($saves["Saleorder"]["order_date"]." +3 weeks"));
                }

                $saves["Saleorder"]["quantity"] = rand(1,1000);

                //単価
                $saves["Saleorder"]["price"] = 0;
                if(rand(0,1)){
                    $product_price = $this->model("ProductPrice")->find("product_id = ".$saves["Saleorder"]["product_id"]." and ".$saves["Saleorder"]["jobber_customer_id"]);
                    if($product_price){
                        $saves["Saleorder"]["price"] = $product_price["ProductPrice"]["price"];
                    }
                }

                $saves["Saleorder"]["factory_id"] = $_SESSION["site"]["user"]["factory_id"];
                $saves["Saleorder"]["staff_id"] = $_SESSION["site"]["user"]["id"];

                //納入先
                $saves["Saleorder"]["deliv_client_id"] = null;
                if(rand(0,1)){
                    $saves["Saleorder"]["deliv_client_id"] = $clients[rand(0,count($clients) - 1)]["Customer"]["id"];

                    $flg = rand(0,1);
                    if($flg == 1){
                        $saves["Saleorder"]["deliv_client_name3"] = $this->makeRandStr(20);
                    }
                }

                //発注先
                $saves["Saleorder"]["client_id"] = null;
                if(rand(0,1)){
                    $saves["Saleorder"]["client_id"] = $clients[rand(0,count($clients) - 1)]["Customer"]["id"];

                    if(rand(0,1)){
                        $saves["Saleorder"]["client_order_number"] = $this->makeRandStr(20);
                    }

                    $flg = rand(0,1);
                    if($flg == 1){
                        $saves["Saleorder"]["client_name3"] = $this->makeRandStr(20);
                    }
                }

                //付帯項目
                $counter = rand(0,3);
                for($k = 1; $k <= 3; $k++){
                    $saves["SaleorderDetail"]["name".$k] = null;
                    $saves["SaleorderDetail"]["quantity".$k] = null;
                    $saves["SaleorderDetail"]["price".$k] = null;
                    $saves["SaleorderDetail"]["total".$k] = null;

                    if($k <= $counter){
                        $saves["SaleorderDetail"]["name".$k] = $this->makeRandStr(30);
                        $saves["SaleorderDetail"]["quantity".$k] = rand(1,10);
                        $saves["SaleorderDetail"]["price".$k] = rand(1,500);
                        $saves["SaleorderDetail"]["total".$k] = $saves["SaleorderDetail"]["quantity".$k] * $saves["SaleorderDetail"]["price".$k];
                    }
                }

                //備考
                $counter = rand(0,3);
                for($k = 1; $k <= 3; $k++){
                    $key = "note";
                    if($k > 1){
                        $key.= $k;
                    }
                    $saves["Saleorder"][$key] = null;
                    if($k <= $counter){
                        $saves["Saleorder"][$key] = $this->makeRandStr(60);
                    }
                }

                $this->model("Saleorder")->create();
                $this->model("Saleorder")->saveFunc("saleorders","edit",array("data" => $saves));
            }
        }

        new dbug("受注伝票の生成が終わりました。");
    }

    //
    function auto_save_sales(){
        //受注伝票を取得
        $saleorders = $this->model("Saleorder")->findAll("del_flg = 0 and factory_id = ".$_SESSION["site"]["user"]["factory_id"]);

        $clients = $this->model("Customer")->findAll("del_flg = 0 and account_type = 3");
        $products = $this->model("Product")->findAll("del_flg = 0");
        $customers = $this->model("Customer")->findAll("account_type = 1 and del_flg = 0");

        for($i = 0; $i <= $this->add_month; $i++){
            for($j = 0; $j < $this->amount_per_month; $j++){
                $saves = array();
                $saves["Sale"]["id"] = "";
                $saves["Sale"]["factory_id"] = $_SESSION["site"]["user"]["factory_id"];

                //受注伝票を使うかどうか
                $saleorder_flg = false;
                if(rand(0,1)){
                    $saleorders = $this->model("Saleorder")->getRemaining();
                    if($saleorders){
                        $saleorder_flg = true;

                        $saleorder = $saleorders[rand(0,count($saleorders) - 1)];

                        $saves["Sale"]["saleorder_id"] = $saleorder["Saleorder"]["id"];
                        $saves["Sale"]["order_number"] = $saleorder["Saleorder"]["order_number"];
                        $saves["Sale"]["deliv_date"] = $saleorder["Saleorder"]["deliv_date"];
                        $saves["Sale"]["memo"] = $saleorder["Saleorder"]["note"];
                        $saves["Sale"]["memo2"] = $saleorder["Saleorder"]["note2"];
                        $saves["Sale"]["memo3"] = $saleorder["Saleorder"]["note3"];
                        $saves["Sale"]["price"] = $saleorder["Saleorder"]["price"];

                        //売上日は受注日の1週間後とする
                        $saves["Sale"]["order_date"] = date("Y-m-d",strtotime($saleorder["Saleorder"]["order_date"]." +1 week"));

                        //部品
                        $saves["Sale"]["product_id"] = $saleorder["Saleorder"]["product_id"];
                        $saves["Sale"]["image_number"] = $saleorder["Product"]["image_number"];
                        $saves["Sale"]["product_name"] = $saleorder["Product"]["name"];
                        $saves["Sale"]["product_name2"] = $saleorder["Product"]["name2"];

                        //セット
                        $saves["Sale"]["product_set_id"] = $saleorder["Saleorder"]["product_set_id"];
                        $saves["Sale"]["product_set_code"] = $saleorder["ProductSet"]["code"];
                        $saves["Sale"]["product_set_name"] = $saleorder["ProductSet"]["name"];
                        $saves["Sale"]["product_set_count"] = $saleorder["ProductSet"]["count"];

                        //得意先
                        $saves["Sale"]["customer_id"] = $saleorder["Product"]["customer_id"];
                        $saves["Sale"]["customer_code"] = $saleorder["Customer"]["code"];
                        $saves["Sale"]["customer_name"] = $saleorder["Customer"]["name"];
                        $saves["Sale"]["customer_name2"] = $saleorder["Customer"]["name2"];

                        //受注先
                        $saves["Sale"]["jobber_customer_id"] = $saleorder["Saleorder"]["jobber_customer_id"];
                        $saves["Sale"]["jobber_customer_code"] = $saleorder["JobberCustomer"]["code"];
                        $saves["Sale"]["jobber_customer_name"] = $saleorder["JobberCustomer"]["name"];
                        $saves["Sale"]["jobber_customer_name2"] = $saleorder["JobberCustomer"]["name2"];
                        if($saleorder["Saleorder"]["jobber_customer_id"] != ""){
                            $saves["JobberCustomer"]["tax_round_type"] = $saleorder["JobberCustomer"]["tax_round_type"];
                            $saves["JobberCustomer"]["tax_calc_type"] = $saleorder["JobberCustomer"]["tax_calc_type"];
                            $saves["JobberCustomer"]["value_round_type"] = $saleorder["JobberCustomer"]["value_round_type"];
                        }else{
                            $saves["JobberCustomer"]["tax_round_type"] = 1;
                            $saves["JobberCustomer"]["tax_calc_type"] = 1;
                            $saves["JobberCustomer"]["value_round_type"] = 1;
                        }

                        //納入先
                        $saves["Sale"]["deliv_client_id"] = $saleorder["Saleorder"]["deliv_client_id"];
                        $saves["Sale"]["deliv_client_code"] = $saleorder["DelivClient"]["code"];
                        $saves["Sale"]["deliv_client_name"] = $saleorder["DelivClient"]["name"];
                        $saves["Sale"]["deliv_client_name2"] = $saleorder["DelivClient"]["name2"];
                        $saves["Sale"]["deliv_client_name3"] = $saleorder["Saleorder"]["deliv_client_name3"];

                        //発注先
                        $saves["Sale"]["client_id"] = $saleorder["Saleorder"]["client_id"];
                        $saves["Sale"]["client_code"] = $saleorder["Client"]["code"];
                        $saves["Sale"]["client_name"] = $saleorder["Client"]["name"];
                        $saves["Sale"]["client_name2"] = $saleorder["Client"]["name2"];
                        $saves["Sale"]["client_name3"] = $saleorder["Saleorder"]["client_name3"];
                        $saves["Sale"]["client_order_number"] = $saleorder["Saleorder"]["client_order_number"];

                        //受注数
                        $saves["Sale"]["quantity"] = rand(1,$saleorder[0]["remain"]);
                        

                        for($k = 1; $k <= 3; $k++){
                            $saves["SaleDetail"]["name".$k] = null;
                            $saves["SaleDetail"]["price".$k] = null;
                            $saves["SaleDetail"]["quantity".$k] = null;
                            $saves["SaleDetail"]["total".$k] = null;

                            if(isset($saleorder["SaleorderDetail"][$k])){
                                $saves["SaleDetail"]["name".$k] = $saleorder["SaleorderDetail"][$k]["name"];
                                $saves["SaleDetail"]["price".$k] = $saleorder["SaleorderDetail"][$k]["price"];
                                $saves["SaleDetail"]["quantity".$k] = $saleorder["SaleorderDetail"][$k]["quantity"];
                                $saves["SaleDetail"]["total".$k] = $saleorder["SaleorderDetail"][$k]["total"];
                            
                            }
                        }
                    }
                }

                if($saleorder_flg === false){
                    $saves["Sale"]["saleorder_id"] = null;
                    //売上日
                    $start_date = $this->start_date;
                    $start_date_from = date("Y-m-01",strtotime($start_date." +".$i."month"));
                    $start_date_to = date("Y-m-t",strtotime($start_date_from));
                    $saves["Sale"]["order_date"] = $this->makeRandDate($start_date_from,$start_date_to);

                    //注文番号
                    $saves["Sale"]["order_number"] = null;
                    if(rand(0,1)){
                        $saves["Sale"]["order_number"] = $this->makeRandStr(12);
                    }

                    //部品
                    $product = $products[rand(0,count($products) - 1)];
                    $saves["Sale"]["product_id"] = $product["Product"]["id"];
                    $saves["Sale"]["product_code"] = $product["Product"]["code"];
                    $saves["Sale"]["image_number"] = $product["Product"]["image_number"];
                    $saves["Sale"]["product_name"] = $product["Product"]["name"];
                    $saves["Sale"]["product_name2"] = $product["Product"]["name2"];

                    //セット
                    $saves["Sale"]["product_set_id"] = null;
                    $saves["Sale"]["product_set_count"] = null;
                    $product_set = $this->model("ProductSet")->findByCode($saves["Sale"]["product_code"]);
                    if(!empty($product_set)){
                        $saves["Sale"]["product_set_id"] = $product_set["ProductSet"]["id"];
                        $saves["Sale"]["product_set_count"] = $product_set["ProductSet"]["count"];
                    }

                    //得意先
                    $saves["Sale"]["customer_id"] = null;
                    $saves["Sale"]["customer_code"] = null;
                    $saves["Sale"]["customer_name"] = null;
                    $saves["Sale"]["customer_name2"] = null;
                    $customer = $this->model("Customer")->findByCode($saves["Sale"]["product_code"]);
                    if(!empty($customer)){
                        $saves["Sale"]["customer_id"] = $customer["Customer"]["id"];
                        $saves["Sale"]["customer_code"] = $product_set["Customer"]["code"];
                        $saves["Sale"]["customer_name"] = $product_set["Customer"]["name"];
                        $saves["Sale"]["customer_name2"] = $product_set["Customer"]["name2"];
                    }

                    //受注先
                    $saves["Sale"]["jobber_customer_id"] = null;
                    $saves["Sale"]["jobber_customer_code"] = null;
                    $saves["Sale"]["jobber_customer_name"] = null;
                    $saves["Sale"]["jobber_customer_name2"] = null;
                    $saves["JobberCustomer"]["tax_round_type"] = 1;
                    $saves["JobberCustomer"]["value_round_type"] = 1;
                    $saves["JobberCustomer"]["tax_calc_type"] = 1;
                    if(rand(0,1)){
                        $jobber_customer = $customers[rand(0,count($customers) - 1)];
                        $saves["Sale"]["jobber_customer_id"] = $jobber_customer["Customer"]["id"];
                        $saves["Sale"]["jobber_customer_code"] = $jobber_customer["Customer"]["code"];
                        $saves["Sale"]["jobber_customer_name"] = $jobber_customer["Customer"]["name"];
                        $saves["Sale"]["jobber_customer_name2"] = $jobber_customer["Customer"]["name2"];
                        $saves["JobberCustomer"]["tax_round_type"] = $jobber_customer["Customer"]["tax_round_type"];
                        $saves["JobberCustomer"]["value_round_type"] = $jobber_customer["Customer"]["value_round_type"];
                        $saves["JobberCustomer"]["tax_calc_type"] = $jobber_customer["Customer"]["tax_calc_type"];
                    }

                    //納入先
                    $saves["Sale"]["deliv_client_id"] = null;
                    $saves["Sale"]["deliv_client_code"] = null;
                    $saves["Sale"]["deliv_client_name"] = null;
                    $saves["Sale"]["deliv_client_name2"] = null;
                    $saves["Sale"]["deliv_client_name3"] = null;
                    if(rand(0,1)){
                        $deliv_client = $clients[rand(0,count($clients) - 1)];
                        $saves["Sale"]["deliv_client_id"] = $deliv_client["Customer"]["id"];
                        $saves["Sale"]["deliv_client_code"] = $deliv_client["Customer"]["code"];
                        $saves["Sale"]["deliv_client_name"] = $deliv_client["Customer"]["name"];
                        $saves["Sale"]["deliv_client_name2"] = $deliv_client["Customer"]["name2"];

                        $flg = rand(0,1);
                        if($flg == 1){
                            $saves["Sale"]["deliv_client_name3"] = $this->makeRandStr(20);
                        }
                    }

                    //発注先
                    $saves["Sale"]["client_id"] = null;
                    $saves["Sale"]["client_code"] = null;
                    $saves["Sale"]["client_name"] = null;
                    $saves["Sale"]["client_name2"] = null;
                    $saves["Sale"]["client_name3"] = null;
                    $saves["Sale"]["client_order_number"] = null;
                    if(rand(0,1)){
                        $client = $clients[rand(0,count($clients) - 1)];
                        $saves["Sale"]["client_id"] = $client["Customer"]["id"];
                        $saves["Sale"]["client_code"] = $client["Customer"]["code"];
                        $saves["Sale"]["client_name"] = $client["Customer"]["name"];
                        $saves["Sale"]["client_name2"] = $client["Customer"]["name2"];

                        if(rand(0,1)){
                            $saves["Sale"]["client_order_number"] = $this->makeRandStr(20);
                        }

                        $flg = rand(0,1);
                        if($flg == 1){
                            $saves["Sale"]["client_name3"] = $this->makeRandStr(20);
                        }
                    }

                    //受注数
                    $saves["Sale"]["quantity"] = rand(1,1000);

                    //単価
                    $saves["Sale"]["price"] = 0;
                    if($saves["Sale"]["jobber_customer_id"] > 0){
                        $product_price = $this->model("ProductPrice")->find("product_id = ".$saves["Sale"]["product_id"]." and ".$saves["Sale"]["jobber_customer_id"]);
                        if($product_price){
                            $saves["Sale"]["price"] = $product_price["ProductPrice"]["price"];
                        }
                    }

                    //適用
                    if(rand(0,1)){
                        $saves["Sale"]["memo"] = $this->makeRandStr(12);
                    }
                    if(rand(0,1)){
                        $saves["Sale"]["memo2"] = $this->makeRandStr(12);
                    }
                    if(rand(0,1)){
                        $saves["Sale"]["memo3"] = $this->makeRandStr(12);
                    }

                    //出荷日
                    $saves["Sale"]["deliv_date"] = null;
                    if(rand(0,1)){
                        //受注日の3週間後とする
                        $saves["Sale"]["deliv_date"] = date("Y-m-d",strtotime($saves["Sale"]["order_date"]." +3 weeks"));
                    }

                    //付帯項目
                    $counter = rand(0,3);
                    for($k = 1; $k <= 3; $k++){
                        $saves["SaleDetail"]["name".$k] = null;
                        $saves["SaleDetail"]["quantity".$k] = null;
                        $saves["SaleDetail"]["price".$k] = null;
                        $saves["SaleDetail"]["total".$k] = null;

                        if($k <= $counter){
                            $saves["SaleDetail"]["name".$k] = $this->makeRandStr(30);
                            $saves["SaleDetail"]["quantity".$k] = rand(1,10);
                            $saves["SaleDetail"]["price".$k] = rand(1,500);
                            $saves["SaleDetail"]["total".$k] = $saves["SaleDetail"]["quantity".$k] * $saves["SaleDetail"]["price".$k];
                        }
                    }
                }

                //金額
                $saves["Sale"]["subtotal"] = $this->calcSubtotal($saves["JobberCustomer"]["value_round_type"],$saves["Sale"]["quantity"],$saves["Sale"]["price"]);
                //税額
                $saves["Sale"]["tax"] = $this->calcTax($saves["JobberCustomer"]["tax_round_type"],$saves["Sale"]["subtotal"]);

                //合計
                $saves["Sale"]["total"] = $saves["Sale"]["subtotal"] + $saves["Sale"]["tax"];

                //備考
                if(rand(0,1)){
                    $saves["Sale"]["note"] = $this->makeRandStr(12);
                }

                $this->model("Sale")->saveEdit($saves);
            }
        }
        new dbug("売上伝票の生成が終わりました。");
    }

    //入金の自動生成
    public function auto_save_receivables(){
        $customers = $this->model("Customer")->findAll("account_type = 1 and del_flg = 0");

        $type = $this->model("ReceivableDetail")->type;
        $type_count = count($type);


        for($i = 0; $i <= $this->add_month; $i++){
            for($j = 0; $j < $this->amount_per_month; $j++){
                $saves = array();
                $saves["Receivable"]["id"] = "";
                $saves["Receivable"]["factory_id"] = $_SESSION["site"]["user"]["factory_id"];

                $start_date = $this->start_date;
                $start_date_from = date("Y-m-01",strtotime($start_date." +".$i."month"));
                $start_date_to = date("Y-m-t",strtotime($start_date_from));
                $saves["Receivable"]["receipt_date"] = $this->makeRandDate($start_date_from,$start_date_to);

                $saves["Receivable"]["customer_id"] = $customers[rand(0,count($customers) - 1)]["Customer"]["id"];

                $this->model("Receivable")->create();
                $this->model("Receivable")->save($saves,false);
                $receivable_id = $this->model("Receivable")->getLastInsertId();

                $end = rand(1,5);
                $subtotal = 0;
                for($k = 0; $k < $end; $k++){
                    $saves = array();
                    $saves["ReceivableDetail"]["receivable_id"] = $receivable_id;

                    $key = rand(1,$type_count);
                    $saves["ReceivableDetail"]["type"] = $key;

                    $receivable_detail_amount = rand(100,10000);
                    $saves["ReceivableDetail"]["amount"] = $receivable_detail_amount;
                    $subtotal += $receivable_detail_amount;

                    $saves["ReceivableDetail"]["note"] = $this->makeRandStr(6);

                    $this->model("ReceivableDetail")->create();
                    $this->model("ReceivableDetail")->save($saves,false);
                }

                $saves = array();
                $saves["Receivable"]["id"] = $receivable_id;
                $saves["Receivable"]['subtotal'] = $subtotal;
                $saves["Receivable"]['tax_rate'] = _def_tax_rate;
                $saves["Receivable"]['tax'] = floor($saves["Receivable"]['subtotal'] * _def_tax_rate);
                $saves["Receivable"]['total'] = $saves["Receivable"]['subtotal'] + $saves["Receivable"]['tax'];
                $this->model("Receivable")->create();
                $this->model("Receivable")->save($saves,false);
            }
        }
        new dbug("入金伝票の生成が終わりました。");
    }

    public function auto_save_reveivable_summaries(){
        for($i = 0; $i <= $this->add_month; $i++){
            $start_date = $this->start_date;

            //残高を更新
            $saves = array();
            $start_date = $this->start_date;
            $start_date_from = date("Y-m-01",strtotime($start_date." +".$i."month"));
            $saves["ReceivableSummary"]["date"] = date("Y/m",strtotime($start_date_from));
            $saves["ReceivableSummary"]["type"] = 1;
            $this->model("ReceivableSummary")->saveAddBalance($saves);

            //残高を更新
            $saves = array();
            $start_date_from = date("Y-m-01",strtotime($start_date." +".$i."month"));
            $saves["ReceivableSummary"]["date"] = date("Y/m",strtotime($start_date_from));
            $saves["ReceivableSummary"]["type"] = 2;
            $this->model("ReceivableSummary")->saveAddBalance($saves);
        }
        new dbug("残高の計算が終わりました。");
    }

}
?>
