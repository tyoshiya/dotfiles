{'class', 'ReservationsController', 'extends', 'AppController', '$name', 'Reservations', '$uses', 'array', 'User', 'Cast', 'Work', 'Experience', 'Cost', 'Report', 'NonRegular', 'Salary', 'Reward', 'HelpCast', 'Event', 'Client', 'Shop', 'Money', 'Stock', 'Plan', 'ShopAd', 'CostMaster', 'ShopCost', 'Agency', 'ShopAgency', 'Message', 'Shopmessage', 'AdminSet', 'Special', 'StaffTask', 'StaffTaskList', 'Reservation', 'SalonMenu', 'ReservationMenu', '$helpers', 'Html', 'HtmlEx', 'Blogpart', 'Diggpager', 'Error', 'Sticky', 'Mobile', '$components', 'Paging', 'Crypt', 'Mailer', 'Checker', 'function', 'beforeFilter', 'parent::beforeFilter', 'vendor', 'dBug', '$user_code', '$this', 'generateList', 'null', 'shop_id', 'name', 'user_code', '$shop_code', 'shop_code', 'start_code', 'time_code', 'end_code', 'user_type_code', '$startday', '$endday', 'date', '$day_code', 'sprintf', 'day_code', 'position_code', 'men_time_code', 'eat_code', 'end_time_code', 'sake_type_code', 'session_id', 'Session', 'read', 'site', 'shop', 'sort_code', 'admin_sort_code', '$menu_code', 'menu_code', '$time_code', 'payment_code', 'manage_top', '$day', 'target_year', 'target_month', 'data', 'Beauty', 'hasUserSession', '$shop', 'findById', 'user', '$reservations', 'findAll', 'reserv_day', 'cast_id', 'empty', 'foreach', '$key', '$value', '$key_id', '$key_price', 'start_time', 'array_multisort', 'SORT_ASC', 'reservations', 'hair_shop_code', 'nomination_code', '$item_code', 'getCostMasterCode', 'item_code', '$active_user_code', 'del_flg', 'active_user_code', 'cast_code', '$cast_code', '$cost', 'work_day', '$keihi', '$str', 'price', 'cost', '$report', 'find', 'report', '$sales', 'getDaySale', 'sales', 'total_sale', '$total', 'getTotalTo', 'total', '$today_client', 'getTodayNum', 'today_client', '$datas', 'getDayIndex', 'datas', 'total_zaiko', 'count', '$locks', 'getLockData', 'locks', 'getTotal', '$cast_data', 'getTimeMoney', 'cast_data', '$av_time_money_f', 'getAvTimeMoney', '$av_time_money_b', 'av_time_money_f', 'av_time_money_b', '$first', 'first', '$cast_data_f', 'cast_data_f', '$back', 'back', '$cast_data_b', 'cast_data_b', '$men_money', 'men_money', '$baito_money', 'baito_money', '$costs', 'getCostData', 'costs', '$records', 'getMoneyData', 'records', '$yoshida_sakes', 'getYoshidaPrice', 'yoshida_sakes', '$suito', 'getSuito', '$tmp_sum1', 'CardSale', 'InMoney', '$casts_money', 'Payment', 'Gensen', '$helps', 'MenPayment', '$help_taxs', 'MenGensen', '$tmp_sum2', '$tmp_sum3', '$tmp_sum4', 'norm_money', '$arari_array', 'arari_array', '$shop_sum', 'getShopSum', 'shop_sum', 'manage_add', '$clients', 'clients', 'manage_add_end', 'execute', 'redirect', 'static', 'error', 'exit', 'dbug', 'save', 'false', '$res_id', 'getLastInsertId', '$menu_id', '$dat', 'reservation_id', 'menu_id', 'create', 'admin_menu_index', 'layout', 'admin', 'hasAdminSession', '$menus', 'menus', 'admin_menu_edit', 'checkId', 'validate', '$data', 'else', 'admin_menu_edit_end', 'validates', 'menu_index', 'render', 'admin_menu_del', 'del_execute', 'admin_menu_add', 'admin_menu_add_end', 'update_decision_flg', 'Configure::write', 'debug', 'ajax', 'autoRender', '$val', 'params', 'form', 'decision_flg', 'echo', 'true', 'manage_reward', 'hasVipUserSession', 'getRewardSum', '$baitos', 'getStaffMoney', '$baito_data', 'target_ym', 'Staff', 'end_flg', 'user_id', 'penalty_money', 'time_money', 'baitos', '$output_nums', 'getHistoryNum', 'output_nums', '$lock_chk', 'getLockChk', 'lock_chk', '$claim_shops', 'claimSum', 'claim_shops', 'shop_code2', 'manage_enter', '$cast_id', 'section', 'redirct', 'ststic', 'manage_baito_enter', '$user_id', '$p_money', 'time', 'payment_money', 'gensen_money', 'minus_money', 'base_money', 'ajax_enter', 'ajax_benter', '$user', 'manage_all_moutput', '$section', 'saveHistory', 'defined', 'FPDF_FONTPATH', 'define', 'font', 'SC_CHAR', 'UTF8', 'fpdf', 'mbfpdf', '$pdf', 'MBFPDF', 'AddMBFont', 'GOTHIC', 'SJIS', 'SetFont', '$page_y', '$page_x', '$cnt', 'AddPage', 'getX', 'getY', 'Image', 'dirname', '__FILE__', 'webroot', 'men_payment', 'SetAutoPageBreak', 'SetXY', 'Write', 'sjis_conv', 'com_name', '$address', 'todohu', 'address1', 'address2', 'address3', 'address4', 'position', 'Cell', 'SetX', 'number_format', 'WORKNUM', 'WORKTIME', '$sum', 'Output', 'manage_all_output', '$one_man', '$five_sen', '$sen', '$five_hyaku', '$one_hyaku', '$num', 'ceil', 'payment', 'nickname_sei', 'nickname_mei', 'CastContract', 'contract_term_code', 'term_end_day', 'target_cool_end_day', 'SHUKKIN', 'ZIKAN', 'DOUHAN', 'DBACK', 'POINT', 'HEIKIN', 'HEIKIN_ZIKYU', 'bottle_code', 'BBACK', 'SOSIKYU1', '$pay', '$shouhi', 'support_money', 'GENSEN', 'BAKKIN', 'business_card_money', 'HAIR', 'MAEBARAI', 'SpecialPayment', 'HITSUYOUDO', 'SUM1', 'koujo', 'SOUSIKYU3', '$money_type', 'getMoneyType', 'floor', '$sql', 'select', 'from', 'help_casts', 'Help', 'left', 'outer', 'join', 'casts', 'shops', 'MyShop', 'TargetShop', 'target_shop_id', 'where', 'order', 'query', '$help', 'help_payment', 'help_payment_maje', 'help_payment_lip', 'help_payment_eviza', 'rand', 'worked_money', 'worked_time', '$goukey', 'Rect', '$cast_f_gensen', 'getCastGensenTotal', 'getTax', '$total_gensen', '$target_ym', '$staff_money', '$m_one_man', '$m_five_sen', '$m_sen', '$m_five_hyaku', '$m_one_hyaku', '$pm_money', '$cast_b_gensen', '$men_gensen', 'getGensenTotal', 'login', 'login_code', 'password', '$cast', 'login_flag', 'write', 'stylist_manage', 'logout', 'delete', 'manage_on', '$beauty', 'decision_dtime', 'manage_del', 'manage_report_end', '$res', 'getReport', '$free_money', 'in_money', '$report_id', 'send_mail_work', '$mailTxt', 'guest_name', 'PHPMailer', 'jphpmailer', 'mb_language', 'japanese', 'mb_internal_encoding', '$subject', '$body', '$mail', 'JPHPMailer', 'IsSMTP', 'SMTPAuth', 'Port', '_def_mail_smtp_port', 'Username', '_def_mail_smtp_user', 'Password', '_def_mail_smtp_pass', 'Host', '_def_mail_smtp_host', 'addTo', 'setFrom', '_def_mail_from_address', '_def_mail_from_name', 'setSubject', 'setBody', 'print', 'send', 'send_sale_mail', 'cron_send_reserve', '$shops', 'hair_shop', '$tomorrow', 'strtotime', '$work_day', '$address_datas', 'send_mail_report', 'explode', '$cast_maegari', 'getCastMaebarai', '$men_maegari', 'getMenMaebarai', '$maebarai_txt', '$mae_money', 'loan', '$exs', 'getExReport', '$haken_txt', '$haken_money', '$hakens', 'getHakenReport', '$ag_code', 'agency_id', '$cost_txt', '$cost_money', 'getCostReport', 'buy_item', '$payday_txt', '$day_pay', '$pays', '$mpays', 'users', '$total_sale', 'getMonthTotal', '$texts', 'ShopName', 'card_sale', 'profit', 'comming_num', 'body', 'sale_mail', 'tnishikawa', 'skay', 'detail_pdf', 'getSetCast', 'detailSum', 'SetFillColor', '$stylist_num', '$row', 'setX', 'NameNum', 'FreeNum', 'manage_month_sum', '$reports', 'year', 'month', '$head_total', 'group', 'SumPrice', '$kmoney', 'keihi', 'round', '$outlook', 'open_day_code', 'str_replace', 'outlook', 'reports', '$kessan_arr', 'closing_date', '$from', '$where', '$item_totals', 'ItemSum', 'item_totals', '$item_month', 'item_month'}