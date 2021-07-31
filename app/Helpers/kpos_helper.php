<?php 

use App\Models\Model_user_sub_menu;
use App\Models\Model_user_access_menu;
use App\Models\Model_menu_utama;

    
        function check_akses($role_id, $menu_id){
            $model = new Model_user_access_menu();

            $result=$model->select('role_id, menu_id')->where(['role_id' => $role_id, 'menu_id' => $menu_id])
                    ->countAllResults();

            if ($result > 0) {
                return 'checked="checked"';
            }
        }

        function sub_menu_conex($menuId, $mainId){
            $model = new Model_user_sub_menu();
            return  $model->select('judul, id_submenu, url, icon')->asArray()
                        ->join('user_menu', 'user_menu.id_menu = user_sub_menu.menu_id')
                        ->where('user_sub_menu.menu_id', $menuId)
                        ->where('user_sub_menu.menu_utama_id', $mainId)
                        ->where('user_sub_menu.is_active', 1)
                        ->findAll();
            
        }

        function main_menu_conex($menuId){
            $model = new Model_menu_utama();
            return $model->select('nama_menu_utama, id_menu_utama, ikon_menu_utama')->asArray()
                    ->join('user_menu', 'user_menu.id_menu = menu_utama.menu_id')
                    ->where('menu_utama.menu_id', $menuId)
                    ->findAll();
            
        }


        // function is_logged_in(){

        //         $role_id = $session->get('role_id');
        //         $uri = $request->uri;
        //         $menu = $uri->getSegment(1);

        //         $db = \Config\Database::connect();
    
        //         $queryMenu = $db->table('user_menu')->getWhere(['menu' => $menu])->getRowArray();
        //         $menu_id = $queryMenu['id_menu'];
    
        //         return $userAccess = $db->table('user_access_menu')->where([
        //             'role_id' => $role_id,
        //             'menu_id' => $menu_id
        //         ])->countAllResults();
    
        //         // if ($userAccess < 1) {
        //         //     return redirect()->to(base_url('blokir'));
        //         // }
    
        // }

        // function emil(){

        //     $session = \Config\Services::session();
            
        //     $email = $session->get('email');
        //     if (!$email){
        //         return redirect()->to(base_url('/'));
        //     }
        // }
    

   
        //special_data is such a session and validation
        function tampilan_login($center_html, $javascript_page, $data=[]){
            echo view('admin/admin-base-html/v_header', $data);
            echo view($center_html);
            echo view('admin/admin-base-html/v_js');
            echo view($javascript_page);

        }
    

    
        //special_data is such a session and validation
        function tampilan_user($center_html, $javascript_page, $data=[]){
            echo view('user/user-base-html/v_css', $data);
            echo view('user/user-base-html/v_navbar');
            echo view($center_html);
            echo view('user/user-base-html/v_footer');
            echo view('user/user-base-html/v_js');
            echo view($javascript_page);

        }
    

   
        //special_data is such a session and validation
        function tampilan_admin($center_html, $javascript_page, $data=[]){
           
            echo view('admin/admin-base-html/v_header', $data);
            echo view('admin/admin-base-html/v_navbar');
            echo view('admin/admin-base-html/v_sidebar');
            echo view($center_html);
            echo view('admin/admin-base-html/v_footer');
            echo view('admin/admin-base-html/v_js');
            echo view($javascript_page);

        }


        function email_konfirm($user, $pendaftaran){
            return '
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
    <style type="text/css">
        html,
        body {
	        margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }
        
      
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }
        
      
        div[style*="margin: 16px 0"] {
            margin:0 !important;
        }
        
     
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }
                
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            Margin: 0 auto !important;
        }
        table table table {
            table-layout: auto; 
        }
        
        
        img {
            -ms-interpolation-mode:bicubic;
        }
        
       
        .mobile-link--footer a,
        a[x-apple-data-detectors] {
            color:inherit !important;
            text-decoration: underline !important;
        }
      
    </style>
    
    
    <style>
        
        .button-td,
        .button-a {
            transition: all 100ms ease-in;
        }
        .button-td:hover,
        .button-a:hover {
            background: #555555 !important;
            border-color: #555555 !important;
        }

    </style>

</head>
<body width="100%" bgcolor="#222222" style="Margin: 0;">
    <center style="width: 100%; background: #222222;">

        <div style="display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;font-family: sans-serif;">
            
        </div>
    
        <div style="max-width: 600px; margin: auto;">
           
            <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px;">
				<tr>
					<td style="padding: 20px 0; text-align: center">
						<img src="'.base_url('user/assets/logo/kkbbi.png').'" width="100" height="100" alt="alt_text" border="0">
					</td>
				</tr>
            </table>
         
            <table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff" width="100%" style="max-width: 600px;">
                
             
                <tr>
					<td>
                        <h1 align="center">'.$pendaftaran['kode'].'</h1>
					
					</td>
                </tr>
              
                <tr>
                    <td>
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                        	<tr>
	                            <td style="padding: 40px; font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #555555;">
	                              Terima kasih telah melakukan registerasi, Bapak/Ibu '.$user['nama'].'. Silakan datang ke koperasi untuk melakukan konfirmasi pada:
	                                <br>
                                    SIlakan datang ke kopersi
                                  
                                    <p></p>
                                    Dengan menunjukan Kode Konfirmasi kepada Sekretaris, dan membayar uang pendaftaran sebesar Rp.100.000.
                                    Bila dalam kurun waktu tersebut Anda tidak melakukan konfirmasi, kami akan mengirimkan surel pemberitahuan.
	                              
	                            </td>
								</tr>
                        </table>
                    </td>
                </tr>
               

            </table>
         
            <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 680px;">
                <tr>
                    <td style="padding: 40px 10px;width: 100%;font-size: 12px; font-family: sans-serif; mso-height-rule: exactly; line-height:18px; text-align: center; color: #888888;">
                        <webversion style="color:#cccccc; text-decoration:underline; font-weight: bold;"></webversion>
                        <br><br>
                        KKBBI (Koperasi Konsumen Berkah Bersama Indonesia)<br><span class="mobile-link--footer">Jl. Irigasi Sipon RT. 001/001 No.32, Ruko No 1, Kel.
                        Cipondoh
                        Makmur,
                        Kec.
                        Cipondoh,
                        Kota
                        Tangerang,
                        Banten,
                        15148</span><br><span class="mobile-link--footer">(123) 456-7890</span>
                        <br><br>
                    
                    </td>
                </tr>
            </table>
          
        </div>
    </center>
</body>
</html>
            ';
        }

        function email_verify($user, $token){
            return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width">
                <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
                <title></title> 
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
            
                <style type="text/css">
            
                    html,
                    body {
                        margin: 0 auto !important;
                        padding: 0 !important;
                        height: 100% !important;
                        width: 100% !important;
                    }
                    
                  
                    * {
                        -ms-text-size-adjust: 100%;
                        -webkit-text-size-adjust: 100%;
                    }
                    
                 
                    div[style*="margin: 16px 0"] {
                        margin:0 !important;
                    }
                    
                
                    table,
                    td {
                        mso-table-lspace: 0pt !important;
                        mso-table-rspace: 0pt !important;
                    }
                            
                    table {
                        border-spacing: 0 !important;
                        border-collapse: collapse !important;
                        table-layout: fixed !important;
                        Margin: 0 auto !important;
                    }
                    table table table {
                        table-layout: auto; 
                    }
                    
            
                    img {
                        -ms-interpolation-mode:bicubic;
                    }
                
                    .mobile-link--footer a,
                    a[x-apple-data-detectors] {
                        color:inherit !important;
                        text-decoration: underline !important;
                    }
                  
                </style>
                
              
                <style>
                    
                
                    .button-td,
                    .button-a {
                        transition: all 100ms ease-in;
                    }
                    .button-td:hover,
                    .button-a:hover {
                        background: #555555 !important;
                        border-color: #555555 !important;
                    }
            
                </style>
            
            </head>
            <body width="100%" bgcolor="#222222" style="Margin: 0;">
                <center style="width: 100%; background: #222222;">
            
                 
                    <div style="display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;font-family: sans-serif;">
                       
                    </div>

                    <button class="btn btn-danger btn-lg"> Henlo</button>
             
                    <div style="max-width: 600px; margin: auto;">
                   
                        <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px;">
                            <tr>
                                <td style="padding: 20px 0; text-align: center">
                                    <img src="'.base_url('user/assets/logo/kkbbi.png').'" width="100" height="100" alt="alt_text" border="0">
                                </td>
                            </tr>
                        </table>
                    
                        <table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff" width="100%" style="max-width: 600px;">
                         
                            <tr>
                                <td>
                                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tr>
                                            <td style="padding: 40px; font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #555555;">
                                                Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent laoreet malesuada cursus. Maecenas scelerisque congue eros eu posuere. Praesent in felis ut velit pretium lobortis rhoncus ut&nbsp;erat.
                                                <br><br>
                                                <!-- Button : Begin -->
                                                <table cellspacing="0" cellpadding="0" border="0" align="center" style="Margin: auto;">
                                                    <tr>
                                                        <td style="border-radius: 3px; background: #222222; text-align: center;" class="button-td">
                                                            <a href="'.base_url(). '/verifikasi?surel='. $user['surel']. '&token='. urlencode($token). '" style="background: #222222; border: 15px solid #222222; font-family: sans-serif; font-size: 13px; line-height: 1.1; text-align: center; text-decoration: none; display: block; border-radius: 3px; font-weight: bold;" class="button-a">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#ffffff">Verifikasi AKun</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </table>
                                           
                                            </td>
                                            </tr>
                                    </table>
                                </td>
                            </tr>
                        
                            
            
                        </table>
                     
                        <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 680px;">
                            <tr>
                                <td style="padding: 40px 10px;width: 100%;font-size: 12px; font-family: sans-serif; mso-height-rule: exactly; line-height:18px; text-align: center; color: #888888;">
                                    <webversion style="color:#cccccc; text-decoration:underline; font-weight: bold;"></webversion>
                                    <br><br>
                                    KKBBI (Koperasi Konsumen Berkah Bersama Indonesia)<br><span class="mobile-link--footer">Jl. Irigasi Sipon RT. 001/001 No.32, Ruko No 1, Kel.
                                    Cipondoh
                                    Makmur,
                                    Kec.
                                    Cipondoh,
                                    Kota
                                    Tangerang,
                                    Banten,
                                    15148</span><br><span class="mobile-link--footer">(123) 456-7890</span>
                                    <br><br>
                                
                                </td>
                            </tr>
                        </table>
                    
                    </div>
                </center>
            </body>
            </html>';
        }


        function sukam(){
            return '<!doctype html><html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
              <head>
                <title>
                </title>
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <style type="text/css">
                  #outlook a{padding: 0;}
                              .ReadMsgBody{width: 100%;}
                              .ExternalClass{width: 100%;}
                              .ExternalClass *{line-height: 100%;}
                              body{margin: 0; padding: 0; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;}
                              table, td{border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;}
                              img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;}
                              p{display: block; margin: 13px 0;}
                </style>
            
                <style type="text/css">
                  @media only screen and (max-width:480px) {
                                        @-ms-viewport {width: 320px;}
                                        @viewport {	width: 320px; }
                                  }
                </style>
               
               
                <style type="text/css">
                  @media only screen and (min-width:480px) {
                  .dys-column-per-100 {
                      width: 100.000000% !important;
                      max-width: 100.000000%;
                  }
                  }
                  @media only screen and (min-width:480px) {
                  .dys-column-per-5 {
                      width: 5% !important;
                      max-width: 5%;
                  }
                  .dys-column-per-45 {
                      width: 45% !important;
                      max-width: 45%;
                  }
                  }
                  @media only screen and (max-width:480px) {
                  
                                table.full-width-mobile { width: 100% !important; }
                                  td.full-width-mobile { width: auto !important; }
                  
                  }
                  @media only screen and (min-width:480px) {
                  .dys-column-per-100 {
                      width: 100.000000% !important;
                      max-width: 100.000000%;
                  }
                  }
                  @media only screen and (min-width:480px) {
                  .dys-column-per-100 {
                      width: 100.000000% !important;
                      max-width: 100.000000%;
                  }
                  }
                </style>
              </head>
              <body>
                <div>
                
                  <div style="background:#FFFFFF;background-color:#FFFFFF;margin:0px auto;max-width:600px;">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#FFFFFF;background-color:#FFFFFF;width:100%;">
                      <tbody>
                        <tr>
                          <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;">
                          
                            <div class="dys-column-per-100 outlook-group-fix" style="direction:ltr;display:inline-block;font-size:13px;text-align:left;vertical-align:top;width:100%;">
                              <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
                                <tr>
                                  <td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                    <div style="color:#4d4d4d;font-family:Oxygen, Helvetica neue, sans-serif;font-size:32px;font-weight:700;line-height:37px;text-align:center;">
                                      KKBBI: Debit Invoice
                                    </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                    <div style="color:#777777;font-family:Oxygen, Helvetica neue, sans-serif;font-size:14px;line-height:21px;text-align:center;">
                                      Terima kasih telah menyuplai barag!
                                    </div>
                                  </td>
                                </tr>
                              </table>
                            </div>
                           
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                 
                  <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#f7f7f7;background-color:#f7f7f7;width:100%;">
                    <tbody>
                      <tr>
                        <td>
                          <div style="margin:0px auto;max-width:600px;">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                              <tbody>
                                <tr>
                                  <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;">
                                   
                                    <div class="dys-column-per-45 outlook-group-fix" style="direction:ltr;display:inline-block;font-size:13px;text-align:left;vertical-align:top;width:100%;">
                                      <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                        <tbody>
                                          <tr>
                                            <td style="background-color:#ffffff;border:1px solid #e5e5e5;padding:15px;vertical-align:top;">
                                              <table border="0" cellpadding="0" cellspacing="0" role="presentation" style=" width="100%">
                                                <tr>
                                                  <td align="left" style="font-size:0px;padding:0px ;word-break:break-word;">
                                                    <div style="color:#4d4d4d;font-family:Oxygen, Helvetica neue, sans-serif;font-size:18px;font-weight:700;line-height:25px;text-align:left;">
                                                      Tipe
                                                    </div>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td align="left" style="font-size:0px;padding:0px;word-break:break-word;">
                                                    <div style="color:#777777;font-family:Oxygen, Helvetica neue, sans-serif;font-size:14px;line-height:23px;text-align:left;">
                                                      Penyuplaian barang
                                                    </div>
                                                  </td>
                                                </tr>
                                              </table>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </div>
                                
                                    <div class="dys-column-per-5 outlook-group-fix" style="direction:ltr;display:inline-block;font-size:13px;text-align:left;vertical-align:top;width:100%;">
                                      <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                        <tbody>
                                          <tr>
                                            <td style="background-color:#FFFFFF;padding:0;vertical-align:top;">
                                              <table border="0" cellpadding="0" cellspacing="0" role="presentation" style=" width="100%">
                                              </table>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </div>
                                 
                                    <div class="dys-column-per-45 outlook-group-fix" style="direction:ltr;display:inline-block;font-size:13px;text-align:left;vertical-align:top;width:100%;">
                                      <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                        <tbody>
                                          <tr>
                                            <td style="background-color:#ffffff;border:1px solid #e5e5e5;padding:15px;vertical-align:top;">
                                              <table border="0" cellpadding="0" cellspacing="0" role="presentation" style=" width="100%">
                                                <tr>
                                                  <td align="left" style="font-size:0px;padding:0px ;word-break:break-word;">
                                                    <div style="color:#4d4d4d;font-family:Oxygen, Helvetica neue, sans-serif;font-size:18px;font-weight:700;line-height:25px;text-align:left;">
                                                      Tanggal
                                                    </div>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td align="left" style="font-size:0px;padding:0px;word-break:break-word;">
                                                    <div style="color:#777777;font-family:Oxygen, Helvetica neue, sans-serif;font-size:14px;line-height:22px;text-align:left;">
                                                      January 12, 2019
                                                    </div>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td align="left" style="font-size:0px;padding:0px ;word-break:break-word;">
                                                    <div style="color:#4d4d4d;font-family:Oxygen, Helvetica neue, sans-serif;font-size:18px;font-weight:700;line-height:25px;text-align:left;">
                                                      Kode
                                                    </div>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td align="left" style="font-size:0px;padding:0px;word-break:break-word;">
                                                    <div style="color:#777777;font-family:Oxygen, Helvetica neue, sans-serif;font-size:14px;line-height:22px;text-align:left;">
                                                      #1233445
                                                    </div>
                                                  </td>
                                                </tr>
                                              </table>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </div>
                                   
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  
                  <div style="background:#FFFFFF;background-color:#FFFFFF;margin:0px auto;max-width:600px;">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#FFFFFF;background-color:#FFFFFF;width:100%;">
                      <tbody>
                        <tr>
                          <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;">
                            
                            <div class="dys-column-per-100 outlook-group-fix" style="direction:ltr;display:inline-block;font-size:13px;text-align:left;vertical-align:top;width:100%;">
                              <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
                                <tr>
                                  <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                    <table border="0" cellpadding="0" cellspacing="0" style="cellpadding:0;cellspacing:0;color:#777777;font-family:"Oxygen", "Helvetica Neue", helvetica, sans-serif;font-size:14px;line-height:21px;table-layout:auto;width:100%;" width="100%">
                                      <tr>
                                        <th style="text-align: left; border-bottom: 1px solid #cccccc; color: #4d4d4d; font-weight: 700; padding-bottom: 5px;" width="50%">
                                          Nama
                                        </th>
                                        <th style="text-align: right; border-bottom: 1px solid #cccccc; color: #4d4d4d; font-weight: 700; padding-bottom: 5px;" width="15%">
                                          Harga
                                        </th>
                                        <th style="text-align: right; border-bottom: 1px solid #cccccc; color: #4d4d4d; font-weight: 700; padding-bottom: 5px; " width="15%">
                                          QTY
                                        </th>
                                        <th style="text-align: right; border-bottom: 1px solid #cccccc; color: #4d4d4d; font-weight: 700; padding-bottom: 5px; " width="15%">
                                          Subtotal
                                        </th>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                                <tr>
                                  <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                    <table border="0" cellpadding="0" cellspacing="0" style="cellpadding:0;cellspacing:0;color:#000000;font-family:Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;table-layout:auto;width:100%;" width="100%">
                                      <tr style="font-size:14px; line-height:19px; font-family: "Oxygen", "Helvetica Neue", helvetica, sans-serif; color:#777777">
                                        <td width="50%">
                                          <table cellpadding="0" cellspacing="0" style="font-size:14px; line-height:19px; font-family: "Oxygen", "Helvetica Neue", helvetica, sans-serif;" width="100%">
                                            <tbody>
                                              <tr>
                                               
                                                <td style="text-align:left; font-size:14px; line-height:19px; font-family: " oxygen", "helvetica neue", helvetica, sans-serif; color: #777777;">
                                                  <span style="color: #4d4d4d; font-weight:bold;">
                                                    Golden Earrings
                                                  </span>
                                                 
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </td>
                                        <td style="text-align:right; " width="10%">
                                          $3.50
                                        </td>
                                        <td style="text-align:center; " width="10%">
                                          1
                                        </td>
                                        <td style="text-align:right; " width="10%">
                                          $3.50
                                        </td>
                                      </tr>
                                      <tr style="font-size:14px; line-height:19px; font-family: "Oxygen", "Helvetica Neue", helvetica, sans-serif; color:#777777">
                                        <td width="50%">
                                          <table cellpadding="0" cellspacing="0" width="100%">
                                            <tbody>
                                              <tr>
                                                
                                                <td style="text-align:left; font-size:14px; line-height:19px; font-family: " oxygen", "helvetica neue", helvetica, sans-serif; color: #777777;">
                                                  <span style="color: #4d4d4d; font-weight:bold;">
                                                    Pink Shoes
                                                  </span>
                                                  
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </td>
                                        <td style="text-align:right; " width="10%">
                                          $10.50
                                        </td>
                                        <td style="text-align:center; " width="10%">
                                          1
                                        </td>
                                        <td style="text-align:right; " width="10%">
                                          $10.50
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                                <tr>
                                  <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                    <table border="0" cellpadding="0" cellspacing="0" style="cellpadding:0;cellspacing:0;color:#000000;font-family:Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;table-layout:auto;width:100%;" width="100%">
                                      <tr style="font-size:14px; line-height:19px; font-family: "Oxygen", "Helvetica Neue", helvetica, sans-serif; color:#777777">
                                        <td width="50%">
                                        </td>
                                        <td style="text-align:right; padding-left: 11px; border-top: 1px solid #cccccc;">
                                          
                                          <span style="display: inline-block;font-weight: bold; color: #4d4d4d">
                                            Total
                                          </span>
                                        </td>
                                        <td style="text-align:right; padding-left: 25px; border-top: 1px solid #cccccc;">
                                          
                                          <span style="display: inline-block;font-weight: bold; color: #4d4d4d">
                                            1
                                          </span>
                                        </td>
                                       
                                      
                                      
                                       
                                        <td style="text-align: right; border-top: 1px solid #cccccc;">
                                         
                                          <span style="display: inline-block;font-weight: bold; color: #4d4d4d">
                                            $15.75
                                          </span>
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                              </table>
                            </div>
                           
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                
                  <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#f7f7f7;background-color:#f7f7f7;width:100%;">
                    <tbody>
                      <tr>
                        <td>
                          <div style="margin:0px auto;max-width:600px;">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                              <tbody>
                                <tr>
                                  <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;">
                                   
                                    <div class="dys-column-per-100 outlook-group-fix" style="direction:ltr;display:inline-block;font-size:13px;text-align:left;vertical-align:top;width:100%;">
                                      <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
                                        <tr>
                                          <td align="center" style="font-size:0px;padding:5px 25px;word-break:break-word;">
                                            <div style="color:#777777;font-family:Oxygen, Helvetica neue, sans-serif;font-size:14px;font-style:bold;font-weight:700;line-height:21px;text-align:center;">
                                              KKBBI
                                            </div>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td align="center" style="font-size:0px;padding:5px 25px;word-break:break-word;">
                                            <div style="color:#777777;font-family:Oxygen, Helvetica neue, sans-serif;font-size:14px;font-style:bold;line-height:1;text-align:center;">
                                              Alamat
                                              <br />
                                              No TLP
                                              <br />
                                              email
                                            </div>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td align="center" style="font-size:0px;padding:5px 25px;word-break:break-word;">
                                            <div style="color:#777777;font-family:Oxygen, Helvetica neue, sans-serif;font-size:14px;font-style:bold;line-height:1;text-align:center;">
                                              web
                                            </div>
                                          </td>
                                        </tr>
                                      </table>
                                    </div>
                                  
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </body>
            </html>";

        }
    
    
?>