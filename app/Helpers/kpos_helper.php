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
    
    
?>