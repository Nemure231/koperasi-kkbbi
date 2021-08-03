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

        function auto_kode_barang(){
          $db = \Config\Database::connect();
          $query = $db->table('barang')
                          ->select('RIGHT(barang.kode,5) as kode', FALSE)
                          ->orderBy('kode', 'DESC')
                         
                          ->limit(1)->get()->getRowArray();
  
              if (count($query) <>0) {
                  //$query2 = $query->get()->getRowArray();
                  $kode= intval($query['kode']) + 1;
              }else{
                  $kode =1;
              }
         
          // $kode1 = $db->table('tb_kode_barang')
          //                     ->select('huruf_kode_barang, jumlah_angka')
          //                     ->get()->getRowArray();
      
              $batas= str_pad($kode, "".'5'."","0", STR_PAD_LEFT);
              $kodetampil= "".'BR-'."" .$batas;
              return $kodetampil;
              
          
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


        function email_notifikasi($user, $teks, $toko, $tipe){
          return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
             <html xmlns="http://www.w3.org/1999/xhtml">
             <head>
               <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
               <meta name="viewport" content="width=device-width, initial-scale=1" />
               <title>KKBBI - Verifikasi</title>
 
               <style type="text/css">
               
                 img { max-width: 600px; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;}
                 a img { border: none; }
                 table { border-collapse: collapse !important;}
                 #outlook a { padding:0; }
                 .ReadMsgBody { width: 100%; }
                 .ExternalClass { width: 100%; }
                 .backgroundTable { margin: 0 auto; padding: 0; width: 100% !important; }
                 table td { border-collapse: collapse; }
                 .ExternalClass * { line-height: 115%; }
                 .container-for-gmail-android { min-width: 600px; }
 
 
               
                 * {
                   font-family: Helvetica, Arial, sans-serif;
                 }
 
                 body {
                   -webkit-font-smoothing: antialiased;
                   -webkit-text-size-adjust: none;
                   width: 100% !important;
                   margin: 0 !important;
                   height: 100%;
                   color: #676767;
                 }
 
                 td {
                   font-family: Helvetica, Arial, sans-serif;
                   font-size: 14px;
                   color: #777777;
                   text-align: center;
                   line-height: 21px;
                 }
 
                 a {
                   color: #007bff;
                   font-weight: bold;
                   text-decoration: none !important;
                 }
 
                 .pull-left {
                   text-align: left;
                 }
 
                 .pull-right {
                   text-align: right;
                 }
 
                 .header-lg,
                 .header-md,
                 .header-sm {
                   font-size: 32px;
                   font-weight: 700;
                   line-height: normal;
                   padding: 35px 0 0;
                   color: #4d4d4d;
                 }
 
                 .header-md {
                   font-size: 24px;
                 }
 
                 .header-sm {
                   padding: 5px 0;
                   font-size: 18px;
                   line-height: 1.3;
                 }
 
                 .content-padding {
                   padding: 20px 0 30px;
                 }
 
                 .mobile-header-padding-right {
                   width: 290px;
                   text-align: right;
                   padding-left: 10px;
                 }
 
                 .mobile-header-padding-left {
                   width: 290px;
                   text-align: left;
                   padding-left: 10px;
                 }
 
                 .free-text {
                   width: 100% !important;
                   padding: 10px 60px 0px;
                 }
 
                 .block-rounded {
                   border-radius: 5px;
                   border: 1px solid #e5e5e5;
                   vertical-align: top;
                 }
 
                 .button {
                   padding: 30px 0 0;
                 }
 
                 .info-block {
                   padding: 0 20px;
                   width: 260px;
                 }
 
                 .mini-block-container {
                   padding: 30px 50px;
                   width: 500px;
                 }
 
                 .mini-block {
                   background-color: #ffffff;
                   width: 498px;
                   border: 1px solid #cccccc;
                   border-radius: 5px;
                   padding: 45px 75px;
                 }
 
                 .block-rounded {
                   width: 260px;
                 }
 
                 .info-img {
                   width: 258px;
                   border-radius: 5px 5px 0 0;
                 }
 
                 .force-width-img {
                   width: 480px;
                   height: 1px !important;
                 }
 
                 .force-width-full {
                   width: 600px;
                   height: 1px !important;
                 }
 
                 .user-img img {
                   width: 130px;
                   border-radius: 5px;
                   border: 1px solid #cccccc;
                 }
 
                 .user-img {
                   text-align: center;
                   border-radius: 100px;
                   color: #007bff;
                   font-weight: 700;
                 }
 
                 .user-msg {
                   padding-top: 10px;
                   font-size: 14px;
                   text-align: center;
                 
                 }
 
                 .mini-img {
                   padding: 5px;
                   width: 140px;
                 }
 
                 .mini-img img {
                   border-radius: 5px;
                   width: 140px;
                 }
 
                 .force-width-gmail {
                   min-width:600px;
                   height: 0px !important;
                   line-height: 1px !important;
                   font-size: 1px !important;
                 }
 
                 .mini-imgs {
                   padding: 25px 0 30px;
                 }
               </style>
 
               <style type="text/css" media="screen">
                 @import url(http://fonts.googleapis.com/css?family=Oxygen:400,700);
               </style>
 
               <style type="text/css" media="screen">
                 @media screen {
                 
                   * {
                     font-family: "Oxygen", "Helvetica Neue", "Arial", "sans-serif" !important;
                   }
                 }
               </style>
 
               <style type="text/css" media="only screen and (max-width: 480px)">
             
                 @media only screen and (max-width: 480px) {
 
                   table[class*="container-for-gmail-android"] {
                     min-width: 290px !important;
                     width: 100% !important;
                   }
 
                   table[class="w320"] {
                     width: 320px !important;
                   }
 
                   img[class="force-width-gmail"] {
                     display: none !important;
                     width: 0 !important;
                     height: 0 !important;
                   }
 
                   td[class*="mobile-header-padding-left"] {
                     width: 160px !important;
                     padding-left: 0 !important;
                   }
 
                   td[class*="mobile-header-padding-right"] {
                     width: 160px !important;
                     padding-right: 0 !important;
                   }
 
                   td[class="mobile-block"] {
                     display: block !important;
                   }
 
                   td[class="mini-img"],
                   td[class="mini-img"] img{
                     width: 150px !important;
                   }
 
                   td[class="header-lg"] {
                     font-size: 24px !important;
                     padding-bottom: 5px !important;
                   }
 
                   td[class="header-md"] {
                     font-size: 18px !important;
                     padding-bottom: 5px !important;
                   }
 
                   td[class="content-padding"] {
                     padding: 5px 0 30px !important;
                   }
 
                   td[class="button"] {
                     padding: 5px !important;
                   }
 
                   td[class*="free-text"] {
                     padding: 10px 18px 30px !important;
                   }
 
                   img[class="force-width-img"],
                   img[class="force-width-full"] {
                     display: none !important;
                   }
 
                   td[class="info-block"] {
                     display: block !important;
                     width: 280px !important;
                     padding-bottom: 40px !important;
                   }
 
                   td[class="info-img"],
                   img[class="info-img"] {
                     width: 278px !important;
                   }
 
                   td[class="mini-block-container"] {
                     padding: 8px 20px !important;
                     width: 280px !important;
                   }
 
                   td[class="mini-block"] {
                     padding: 20px !important;
                   }
 
                   td[class="user-img"] {
                     display: block !important;
                     text-align: center !important;
                     width: 100% !important;
                     padding-bottom: 10px;
                   }
 
                   td[class="user-msg"] {
                     display: block !important;
                     padding-bottom: 20px;
                   }
                 }
               </style>
             </head>
 
             <body bgcolor="#f7f7f7">
             <table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android" width="100%">
               <tr>
                 <td align="left" valign="top" width="100%" style="background:repeat-x url(http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg) #ffffff;">
                   <center>
                 
                     <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff" background="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" style="background-color:transparent">
                       <tr>
                         <td width="100%" height="80" valign="top" style="text-align: center; vertical-align:middle;">
                       
                           <center>
                             <table cellpadding="0" cellspacing="0" width="600" class="w320">
                               <tr>
                                 <td class="pull-left mobile-header-padding-left" style="vertical-align: middle;">
                                 <a href=""><h1>KKBBI</h1></a>
                                 </td>
                                 <td class="pull-right mobile-header-padding-right" style="color: #4d4d4d;">
                               
                                 </td>
                               </tr>
                             </table>
                           </center>
                     
                         </td>
                       </tr>
                     </table>
                   </center>
                 </td>
               </tr>
               <tr>
                 <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;" class="content-padding">
                   <center>
                     <table cellspacing="0" cellpadding="0" width="600" class="w320">
                       <tr>
                         <td class="header-lg">
                           '.$tipe.'
                         </td>
                       </tr>
                       <tr>
                         <td class="free-text">
                           <span></span>
                         </td>
                       </tr>
                       <tr>
                         <td class="mini-block-container">
                           <table cellspacing="0" cellpadding="0" width="100%"  style="border-collapse:separate !important;">
                             <tr>
                               <td class="mini-block">
                                 <table cellpadding="0" cellspacing="0" width="100%">
                                   <tr>
                                     <td>
                                       <table cellspacing="0" cellpadding="0" width="100%">
                                         <tr>
                                           <td class="user-img">
                                           
                                             <br />Halo, '.$user['nama'].'
                                           </td>
                                         </tr>
                                         <tr>
                                           <td class="user-msg">
                                            '.$teks.'
                                           </td>
                                         </tr>
                                       </table>
                                     </td>
                                   </tr>  
                                   <tr>
                                     <td class="button">
                                       <div><a href="'.base_url().'"
                                       style="background-color:#007bff;border-radius:5px;color:#ffffff;display:inline-block;font-family:Cabin, Helvetica, Arial, sans-serif;font-size:14px;font-weight:regular;line-height:45px;text-align:center;text-decoration:none;width:155px;-webkit-text-size-adjust:none;mso-hide:all;">Periksa</a></div>
                                     </td>
                                   </tr>
                                 </table>
                               </td>
                             </tr>
                           </table>
                         </td>
                       </tr>
                     </table>
                   </center>
                 </td>
               </tr>
 
               <tr>
                 <td align="center" valign="top" width="100%" style="background-color: #f7f7f7; height: 100px;">
                   <center>
                     <table cellspacing="0" cellpadding="0" width="600" class="w320">
                       <tr>
                         <td style="padding: 25px 0 25px">
                           <strong>'.$toko['nama_toko'].'</strong><br />
                           '.$toko['alamat_toko'].'<br/>
                           '.$toko['telepon_toko'].'<br/>
                           '.$toko['email_toko'].'<br/><br/>
                           '.base_url().'<br/>
 
 
                         </td>
                       </tr>
                     </table>
                   </center>
                 </td>
               </tr>
             </table>
             </body>
             </html>
          ';
        }
 


        function email_verify($user, $token, $toko){
         return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
              <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
              <meta name="viewport" content="width=device-width, initial-scale=1" />
              <title>KKBBI - Verifikasi</title>

              <style type="text/css">
              
                img { max-width: 600px; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;}
                a img { border: none; }
                table { border-collapse: collapse !important;}
                #outlook a { padding:0; }
                .ReadMsgBody { width: 100%; }
                .ExternalClass { width: 100%; }
                .backgroundTable { margin: 0 auto; padding: 0; width: 100% !important; }
                table td { border-collapse: collapse; }
                .ExternalClass * { line-height: 115%; }
                .container-for-gmail-android { min-width: 600px; }


              
                * {
                  font-family: Helvetica, Arial, sans-serif;
                }

                body {
                  -webkit-font-smoothing: antialiased;
                  -webkit-text-size-adjust: none;
                  width: 100% !important;
                  margin: 0 !important;
                  height: 100%;
                  color: #676767;
                }

                td {
                  font-family: Helvetica, Arial, sans-serif;
                  font-size: 14px;
                  color: #777777;
                  text-align: center;
                  line-height: 21px;
                }

                a {
                  color: #007bff;
                  font-weight: bold;
                  text-decoration: none !important;
                }

                .pull-left {
                  text-align: left;
                }

                .pull-right {
                  text-align: right;
                }

                .header-lg,
                .header-md,
                .header-sm {
                  font-size: 32px;
                  font-weight: 700;
                  line-height: normal;
                  padding: 35px 0 0;
                  color: #4d4d4d;
                }

                .header-md {
                  font-size: 24px;
                }

                .header-sm {
                  padding: 5px 0;
                  font-size: 18px;
                  line-height: 1.3;
                }

                .content-padding {
                  padding: 20px 0 30px;
                }

                .mobile-header-padding-right {
                  width: 290px;
                  text-align: right;
                  padding-left: 10px;
                }

                .mobile-header-padding-left {
                  width: 290px;
                  text-align: left;
                  padding-left: 10px;
                }

                .free-text {
                  width: 100% !important;
                  padding: 10px 60px 0px;
                }

                .block-rounded {
                  border-radius: 5px;
                  border: 1px solid #e5e5e5;
                  vertical-align: top;
                }

                .button {
                  padding: 30px 0 0;
                }

                .info-block {
                  padding: 0 20px;
                  width: 260px;
                }

                .mini-block-container {
                  padding: 30px 50px;
                  width: 500px;
                }

                .mini-block {
                  background-color: #ffffff;
                  width: 498px;
                  border: 1px solid #cccccc;
                  border-radius: 5px;
                  padding: 45px 75px;
                }

                .block-rounded {
                  width: 260px;
                }

                .info-img {
                  width: 258px;
                  border-radius: 5px 5px 0 0;
                }

                .force-width-img {
                  width: 480px;
                  height: 1px !important;
                }

                .force-width-full {
                  width: 600px;
                  height: 1px !important;
                }

                .user-img img {
                  width: 130px;
                  border-radius: 5px;
                  border: 1px solid #cccccc;
                }

                .user-img {
                  text-align: center;
                  border-radius: 100px;
                  color: #007bff;
                  font-weight: 700;
                }

                .user-msg {
                  padding-top: 10px;
                  font-size: 14px;
                  text-align: center;
                
                }

                .mini-img {
                  padding: 5px;
                  width: 140px;
                }

                .mini-img img {
                  border-radius: 5px;
                  width: 140px;
                }

                .force-width-gmail {
                  min-width:600px;
                  height: 0px !important;
                  line-height: 1px !important;
                  font-size: 1px !important;
                }

                .mini-imgs {
                  padding: 25px 0 30px;
                }
              </style>

              <style type="text/css" media="screen">
                @import url(http://fonts.googleapis.com/css?family=Oxygen:400,700);
              </style>

              <style type="text/css" media="screen">
                @media screen {
                
                  * {
                    font-family: "Oxygen", "Helvetica Neue", "Arial", "sans-serif" !important;
                  }
                }
              </style>

              <style type="text/css" media="only screen and (max-width: 480px)">
            
                @media only screen and (max-width: 480px) {

                  table[class*="container-for-gmail-android"] {
                    min-width: 290px !important;
                    width: 100% !important;
                  }

                  table[class="w320"] {
                    width: 320px !important;
                  }

                  img[class="force-width-gmail"] {
                    display: none !important;
                    width: 0 !important;
                    height: 0 !important;
                  }

                  td[class*="mobile-header-padding-left"] {
                    width: 160px !important;
                    padding-left: 0 !important;
                  }

                  td[class*="mobile-header-padding-right"] {
                    width: 160px !important;
                    padding-right: 0 !important;
                  }

                  td[class="mobile-block"] {
                    display: block !important;
                  }

                  td[class="mini-img"],
                  td[class="mini-img"] img{
                    width: 150px !important;
                  }

                  td[class="header-lg"] {
                    font-size: 24px !important;
                    padding-bottom: 5px !important;
                  }

                  td[class="header-md"] {
                    font-size: 18px !important;
                    padding-bottom: 5px !important;
                  }

                  td[class="content-padding"] {
                    padding: 5px 0 30px !important;
                  }

                  td[class="button"] {
                    padding: 5px !important;
                  }

                  td[class*="free-text"] {
                    padding: 10px 18px 30px !important;
                  }

                  img[class="force-width-img"],
                  img[class="force-width-full"] {
                    display: none !important;
                  }

                  td[class="info-block"] {
                    display: block !important;
                    width: 280px !important;
                    padding-bottom: 40px !important;
                  }

                  td[class="info-img"],
                  img[class="info-img"] {
                    width: 278px !important;
                  }

                  td[class="mini-block-container"] {
                    padding: 8px 20px !important;
                    width: 280px !important;
                  }

                  td[class="mini-block"] {
                    padding: 20px !important;
                  }

                  td[class="user-img"] {
                    display: block !important;
                    text-align: center !important;
                    width: 100% !important;
                    padding-bottom: 10px;
                  }

                  td[class="user-msg"] {
                    display: block !important;
                    padding-bottom: 20px;
                  }
                }
              </style>
            </head>

            <body bgcolor="#f7f7f7">
            <table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android" width="100%">
              <tr>
                <td align="left" valign="top" width="100%" style="background:repeat-x url(http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg) #ffffff;">
                  <center>
                
                    <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff" background="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" style="background-color:transparent">
                      <tr>
                        <td width="100%" height="80" valign="top" style="text-align: center; vertical-align:middle;">
                      
                          <center>
                            <table cellpadding="0" cellspacing="0" width="600" class="w320">
                              <tr>
                                <td class="pull-left mobile-header-padding-left" style="vertical-align: middle;">
                                <a href=""><h1>KKBBI</h1></a>
                                </td>
                                <td class="pull-right mobile-header-padding-right" style="color: #4d4d4d;">
                              
                                </td>
                              </tr>
                            </table>
                          </center>
                    
                        </td>
                      </tr>
                    </table>
                  </center>
                </td>
              </tr>
              <tr>
                <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;" class="content-padding">
                  <center>
                    <table cellspacing="0" cellpadding="0" width="600" class="w320">
                      <tr>
                        <td class="header-lg">
                          Verifikasi
                        </td>
                      </tr>
                      <tr>
                        <td class="free-text">
                          <span></span>
                        </td>
                      </tr>
                      <tr>
                        <td class="mini-block-container">
                          <table cellspacing="0" cellpadding="0" width="100%"  style="border-collapse:separate !important;">
                            <tr>
                              <td class="mini-block">
                                <table cellpadding="0" cellspacing="0" width="100%">
                                  <tr>
                                    <td>
                                      <table cellspacing="0" cellpadding="0" width="100%">
                                        <tr>
                                          <td class="user-img">
                                          
                                            <br />Hai, '.$user['nama'].'
                                          </td>
                                        </tr>
                                        <tr>
                                          <td class="user-msg">
                                            Akun Anda berhasil dibuat, sebelum dapat mengakses web, silakan lakukan verifikasi dengan menekan tombol yang berada di bawah ini.
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>  
                                  <tr>
                                    <td class="button">
                                      <div><a href="'.base_url(). '/verifikasi?surel='. $user['surel']. '&token='. urlencode($token). '"
                                      style="background-color:#007bff;border-radius:5px;color:#ffffff;display:inline-block;font-family:Cabin, Helvetica, Arial, sans-serif;font-size:14px;font-weight:regular;line-height:45px;text-align:center;text-decoration:none;width:155px;-webkit-text-size-adjust:none;mso-hide:all;">Verifikasi</a></div>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </center>
                </td>
              </tr>

              <tr>
                <td align="center" valign="top" width="100%" style="background-color: #f7f7f7; height: 100px;">
                  <center>
                    <table cellspacing="0" cellpadding="0" width="600" class="w320">
                      <tr>
                        <td style="padding: 25px 0 25px">
                          <strong>'.$toko['nama_toko'].'</strong><br />
                          '.$toko['alamat_toko'].'<br/>
                          '.$toko['telepon_toko'].'<br/>
                          '.$toko['email_toko'].'<br/><br/>
                          '.base_url().'<br/>


                        </td>
                      </tr>
                    </table>
                  </center>
                </td>
              </tr>
            </table>
            </body>
            </html>
         ';
       }

       function email_kuitansi($transaksi, $toko, $barang){

              $loop = array(); 
              foreach($barang as $b):{
                $loop[] = '<tr>
              <td class="item-col item">
                <table cellspacing="0" cellpadding="0" width="100%">
                  <tr>
                    
                    <td class="product">
                      <span style="color: #4d4d4d; font-weight: bold;">'.$b['nama_barang'].'</span> <br />
                      
                    </td>
                  </tr>
                </table>
              </td>
              
              <td class="item-col price">
              
                '.'Rp. '. number_format($b['harga'], 0,",",".").'
              </td>
              <td class="item-col quantity">
                '.$b['qty'].'
              </td>
              <td class="item-col">
              '.'Rp. '. number_format($b['subtotal'], 0,",",".").'
              </td>
            </tr>';

          }
          endforeach;

     







         return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
         <html xmlns="http://www.w3.org/1999/xhtml">
         <head>
           <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
           <meta name="viewport" content="width=device-width, initial-scale=1" />
           <title>KKBBI - Kuitansi</title>
         
           <style type="text/css">
           
             img { max-width: 600px; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;}
             a img { border: none; }
             table { border-collapse: collapse !important;}
             #outlook a { padding:0; }
             .ReadMsgBody { width: 100%; }
             .ExternalClass { width: 100%; }
             .backgroundTable { margin: 0 auto; padding: 0; width: 100% !important; }
             table td { border-collapse: collapse; }
             .ExternalClass * { line-height: 115%; }
             .container-for-gmail-android { min-width: 600px; }
         
         
            
             * {
               font-family: Helvetica, Arial, sans-serif;
             }
         
             body {
               -webkit-font-smoothing: antialiased;
               -webkit-text-size-adjust: none;
               width: 100% !important;
               margin: 0 !important;
               height: 100%;
               color: #676767;
             }
         
             td {
               font-family: Helvetica, Arial, sans-serif;
               font-size: 14px;
               color: #777777;
               text-align: center;
               line-height: 21px;
             }
         
             a {
               color: #007bff;
               font-weight: bold;
               text-decoration: none !important;
             }
         
             .pull-left {
               text-align: left;
             }
         
             .pull-right {
               text-align: right;
             }
         
             .header-lg,
             .header-md,
             .header-sm {
               font-size: 32px;
               font-weight: 700;
               line-height: normal;
               padding: 35px 0 0;
               color: #4d4d4d;
             }
         
             .header-md {
               font-size: 24px;
             }
         
             .header-sm {
               padding: 5px 0;
               font-size: 18px;
               line-height: 1.3;
             }
         
             .content-padding {
               padding: 20px 0 5px;
             }
         
             .mobile-header-padding-right {
               width: 290px;
               text-align: right;
               padding-left: 10px;
             }
         
             .mobile-header-padding-left {
               width: 290px;
               text-align: left;
               padding-left: 10px;
             }
         
             .free-text {
               width: 100% !important;
               padding: 10px 60px 0px;
             }
         
             .button {
               padding: 30px 0;
             }
         
             .mini-block {
               border: 1px solid #e5e5e5;
               border-radius: 5px;
               background-color: #ffffff;
               padding: 12px 15px 15px;
               text-align: left;
               width: 253px;
             }
         
             .mini-container-left {
               width: 278px;
               padding: 10px 0 10px 15px;
             }
         
             .mini-container-right {
               width: 278px;
               padding: 10px 14px 10px 15px;
             }
         
             .product {
               text-align: left;
               vertical-align: top;
               width: 175px;
             }
         
             .total-space {
               padding-bottom: 8px;
               display: inline-block;
             }
         
             .item-table {
               padding: 50px 20px;
               width: 560px;
             }
         
             .item {
               width: 300px;
             }
         
             .mobile-hide-img {
               text-align: left;
               width: 125px;
             }
         
             .mobile-hide-img img {
               border: 1px solid #e6e6e6;
               border-radius: 4px;
             }
         
             .title-dark {
               text-align: left;
               border-bottom: 1px solid #cccccc;
               color: #4d4d4d;
               font-weight: 700;
               padding-bottom: 5px;
             }
         
             .item-col {
               padding-top: 20px;
               text-align: left;
               vertical-align: top;
             }
         
             .force-width-gmail {
               min-width:600px;
               height: 0px !important;
               line-height: 1px !important;
               font-size: 1px !important;
             }
         
           </style>
         
           <style type="text/css" media="screen">
             @import url(http://fonts.googleapis.com/css?family=Oxygen:400,700);
           </style>
         
           <style type="text/css" media="screen">
             @media screen {
             
               * {
                 font-family: "Oxygen", "Helvetica Neue", "Arial", "sans-serif" !important;
               }
             }
           </style>
         
           <style type="text/css" media="only screen and (max-width: 480px)">
           
             @media only screen and (max-width: 480px) {
         
               table[class*="container-for-gmail-android"] {
                 min-width: 290px !important;
                 width: 100% !important;
               }
         
               img[class="force-width-gmail"] {
                 display: none !important;
                 width: 0 !important;
                 height: 0 !important;
               }
         
               table[class="w320"] {
                 width: 320px !important;
               }
         
               td[class*="mobile-header-padding-left"] {
                 width: 160px !important;
                 padding-left: 0 !important;
               }
         
               td[class*="mobile-header-padding-right"] {
                 width: 160px !important;
                 padding-right: 0 !important;
               }
         
               td[class="header-lg"] {
                 font-size: 24px !important;
                 padding-bottom: 5px !important;
               }
         
               td[class="content-padding"] {
                 padding: 5px 0 5px !important;
               }
         
                td[class="button"] {
                 padding: 5px 5px 30px !important;
               }
         
               td[class*="free-text"] {
                 padding: 10px 18px 30px !important;
               }
         
               td[class~="mobile-hide-img"] {
                 display: none !important;
                 height: 0 !important;
                 width: 0 !important;
                 line-height: 0 !important;
               }
         
               td[class~="item"] {
                 width: 140px !important;
                 vertical-align: top !important;
               }
         
               td[class~="quantity"] {
                 width: 50px !important;
               }
         
               td[class~="price"] {
                 width: 90px !important;
               }
         
               td[class="item-table"] {
                 padding: 30px 20px !important;
               }
         
               td[class="mini-container-left"],
               td[class="mini-container-right"] {
                 padding: 0 15px 15px !important;
                 display: block !important;
                 width: 290px !important;
               }
         
             }
           </style>
         </head>
         
         <body bgcolor="#f7f7f7">
         <table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android" width="100%">
           <tr>
             <td align="left" valign="top" width="100%" style="background:repeat-x url(http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg) #ffffff;">
               <center>
              
                 <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff" background="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" style="background-color:transparent">
                   <tr>
                     <td width="100%" height="80" valign="top" style="text-align: center; vertical-align:middle;">
                     
                       <center>
                         <table cellpadding="0" cellspacing="0" width="600" class="w320">
                           <tr>
                             <td class="pull-left mobile-header-padding-left" style="vertical-align: middle;">
                               <a href=""><h1>KKBBI</h1></a>
                             </td>
                             <td class="pull-right mobile-header-padding-right" style="color: #4d4d4d;">
                              
                             </td>
                           </tr>
                         </table>
                       </center>
                      
                     </td>
                   </tr>
                 </table>
               </center>
             </td>
           </tr>
           <tr>
             <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;" class="content-padding">
               <center>
                 <table cellspacing="0" cellpadding="0" width="600" class="w320">
                   <tr>
                     <td class="header-lg">
                       Kuitansi
                     </td>
                   </tr>
                   <tr>
                     <td class="free-text">
                       Terima kasih sudah melakukan transaksi, '.$transaksi['nama'].', jangan sungkan untuk datang lagi!
                     </td>
                   </tr>
                   <tr>
                     
                   </tr>
                   <tr>
                     <td class="w320">
                       <table cellpadding="0" cellspacing="0" width="100%">
                         <tr>
                           <td class="mini-container-left">
                             <table cellpadding="0" cellspacing="0" width="100%">
                               <tr>
                                 <td class="mini-block-padding">
                                   <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:separate !important;">
                                     <tr>
                                       <td class="mini-block">
                                         <span class="header-sm">Tipe</span><br />
                                         Pendaftaran Calon Anggota <br />
                                       </td>
                                     </tr>
                                   </table>
                                 </td>
                               </tr>
                             </table>
                           </td>
                           <td class="mini-container-right">
                             <table cellpadding="0" cellspacing="0" width="100%">
                               <tr>
                                 <td class="mini-block-padding">
                                   <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:separate !important;">
                                     <tr>
                                       <td class="mini-block">
                                         <span class="header-sm">Tanggal</span><br />
                                         '.$transaksi['tanggal'].'<br />
                                         <br />
                                         <span class="header-sm">Kode</span> <br />
                                         '.$transaksi['kode'].'
                                       </td>
                                     </tr>
                                   </table>
                                 </td>
                               </tr>
                             </table>
                           </td>
                         </tr>
                       </table>
                     </td>
                   </tr>
                 </table>
               </center>
             </td>
           </tr>
           <tr>
             <td align="center" valign="top" width="100%" style="background-color: #ffffff;  border-top: 1px solid #e5e5e5; border-bottom: 1px solid #e5e5e5;">
               <center>
                 <table cellpadding="0" cellspacing="0" width="600" class="w320">
                     <tr>
                       <td class="item-table">
                         <table cellspacing="0" cellpadding="0" width="100%">
                           <tr>
                             <td class="title-dark" width="300">
                                Nama
                             </td>
                            
                             <td class="title-dark" width="100">
                               Harga
                             </td>
                             <td class="title-dark" width="97">
                               Qty
                             </td>
                             <td class="title-dark" width="100">
                               Subtotal
                             </td>
                           </tr>


                          '.implode($loop).'
                           <tr>
                             <td class="item-col item mobile-row-padding"></td>
                             <td class="item-col quantity"></td>
                             <td class="item-col price"></td>
                           </tr>
         
         
                           <tr>
                             <td class="item-col item">
                             </td>
                             
                             <td class="item-col quantity" style="text-align:left; padding-right: 10px; border-top: 1px solid #cccccc;">
                               <span class="total-space" style="font-weight:bold; color: #4d4d4d">Total</span> <br />
                             
                             </td>
                             <td class="item-col price" style="text-align: left; border-top: 1px solid #cccccc;">
                               <span class="total-space">'.$transaksi['total_qty'].'</span> <br />
                              
                             </td>
                             <td class="item-col price" style="text-align: left; border-top: 1px solid #cccccc;">
                               <span class="total-space"> '.'Rp. '. number_format($transaksi['total_harga'], 0,",",".").'</span> <br />
                              
                             </td>
                           </tr>
                           <tr>
                             <td class="item-col item">
                             </td>
                             
                             <td class="item-col quantity" style="text-align:left; padding-right: 10px; border-top: 1px solid #cccccc;">
                               <span class="total-space" style="font-weight:bold; color: #4d4d4d">Jumlah Uang</span> <br />
                             
                             </td>
                             <td class="item-col price" style="text-align: left; border-top: 1px solid #cccccc;">
                               <span class="total-space"></span> <br />
                              
                             </td>
                             <td class="item-col price" style="text-align: left; border-top: 1px solid #cccccc;">
                               <span class="total-space"> '.'Rp. '. number_format($transaksi['jumlah_uang'], 0,",",".").'</span> <br />
                              
                             </td>
                           </tr>
                           <tr>
                           <td class="item-col item">
                           </td>
                           
                           <td class="item-col quantity" style="text-align:left; padding-right: 10px; border-top: 1px solid #cccccc;">
                             <span class="total-space" style="font-weight:bold; color: #4d4d4d">Kembalian</span> <br />
                           
                           </td>
                           <td class="item-col price" style="text-align: left; border-top: 1px solid #cccccc;">
                             <span class="total-space"></span> <br />
                            
                           </td>
                           <td class="item-col price" style="text-align: left; border-top: 1px solid #cccccc;">
                             <span class="total-space"> '.'Rp. '. number_format($transaksi['kembalian'], 0,",",".").'</span> <br />
                            
                           </td>
                         </tr> 
                            
                         </table>
                       </td>
                     </tr>
                 </table>
               </center>
             </td>
           </tr>
           <tr>
             <td align="center" valign="top" width="100%" style="background-color: #f7f7f7; height: 100px;">
               <center>
                 <table cellspacing="0" cellpadding="0" width="600" class="w320">
                   <tr>
                   <td style="padding: 25px 0 25px">
                   <strong>'.$toko['nama_toko'].'</strong><br />
                   '.$toko['alamat_toko'].'<br/>
                   '.$toko['telepon_toko'].'<br/>
                   '.$toko['email_toko'].'<br/><br/>
                   '.base_url().'<br/>


                 </td>
                   </tr>
                 </table>
               </center>
             </td>
           </tr>
         </table>
         </div>
         </body>
         </html>';
       }

       function email_kuitansi_pendaftar($pendaftaran, $pembayaran, $toko){
        return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
          <meta name="viewport" content="width=device-width, initial-scale=1" />
          <title>KKBBI - Kuitansi</title>
        
          <style type="text/css">
          
            img { max-width: 600px; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;}
            a img { border: none; }
            table { border-collapse: collapse !important;}
            #outlook a { padding:0; }
            .ReadMsgBody { width: 100%; }
            .ExternalClass { width: 100%; }
            .backgroundTable { margin: 0 auto; padding: 0; width: 100% !important; }
            table td { border-collapse: collapse; }
            .ExternalClass * { line-height: 115%; }
            .container-for-gmail-android { min-width: 600px; }
        
        
           
            * {
              font-family: Helvetica, Arial, sans-serif;
            }
        
            body {
              -webkit-font-smoothing: antialiased;
              -webkit-text-size-adjust: none;
              width: 100% !important;
              margin: 0 !important;
              height: 100%;
              color: #676767;
            }
        
            td {
              font-family: Helvetica, Arial, sans-serif;
              font-size: 14px;
              color: #777777;
              text-align: center;
              line-height: 21px;
            }
        
            a {
              color: #007bff;
              font-weight: bold;
              text-decoration: none !important;
            }
        
            .pull-left {
              text-align: left;
            }
        
            .pull-right {
              text-align: right;
            }
        
            .header-lg,
            .header-md,
            .header-sm {
              font-size: 32px;
              font-weight: 700;
              line-height: normal;
              padding: 35px 0 0;
              color: #4d4d4d;
            }
        
            .header-md {
              font-size: 24px;
            }
        
            .header-sm {
              padding: 5px 0;
              font-size: 18px;
              line-height: 1.3;
            }
        
            .content-padding {
              padding: 20px 0 5px;
            }
        
            .mobile-header-padding-right {
              width: 290px;
              text-align: right;
              padding-left: 10px;
            }
        
            .mobile-header-padding-left {
              width: 290px;
              text-align: left;
              padding-left: 10px;
            }
        
            .free-text {
              width: 100% !important;
              padding: 10px 60px 0px;
            }
        
            .button {
              padding: 30px 0;
            }
        
            .mini-block {
              border: 1px solid #e5e5e5;
              border-radius: 5px;
              background-color: #ffffff;
              padding: 12px 15px 15px;
              text-align: left;
              width: 253px;
            }
        
            .mini-container-left {
              width: 278px;
              padding: 10px 0 10px 15px;
            }
        
            .mini-container-right {
              width: 278px;
              padding: 10px 14px 10px 15px;
            }
        
            .product {
              text-align: left;
              vertical-align: top;
              width: 175px;
            }
        
            .total-space {
              padding-bottom: 8px;
              display: inline-block;
            }
        
            .item-table {
              padding: 50px 20px;
              width: 560px;
            }
        
            .item {
              width: 300px;
            }
        
            .mobile-hide-img {
              text-align: left;
              width: 125px;
            }
        
            .mobile-hide-img img {
              border: 1px solid #e6e6e6;
              border-radius: 4px;
            }
        
            .title-dark {
              text-align: left;
              border-bottom: 1px solid #cccccc;
              color: #4d4d4d;
              font-weight: 700;
              padding-bottom: 5px;
            }
        
            .item-col {
              padding-top: 20px;
              text-align: left;
              vertical-align: top;
            }
        
            .force-width-gmail {
              min-width:600px;
              height: 0px !important;
              line-height: 1px !important;
              font-size: 1px !important;
            }
        
          </style>
        
          <style type="text/css" media="screen">
            @import url(http://fonts.googleapis.com/css?family=Oxygen:400,700);
          </style>
        
          <style type="text/css" media="screen">
            @media screen {
            
              * {
                font-family: "Oxygen", "Helvetica Neue", "Arial", "sans-serif" !important;
              }
            }
          </style>
        
          <style type="text/css" media="only screen and (max-width: 480px)">
          
            @media only screen and (max-width: 480px) {
        
              table[class*="container-for-gmail-android"] {
                min-width: 290px !important;
                width: 100% !important;
              }
        
              img[class="force-width-gmail"] {
                display: none !important;
                width: 0 !important;
                height: 0 !important;
              }
        
              table[class="w320"] {
                width: 320px !important;
              }
        
              td[class*="mobile-header-padding-left"] {
                width: 160px !important;
                padding-left: 0 !important;
              }
        
              td[class*="mobile-header-padding-right"] {
                width: 160px !important;
                padding-right: 0 !important;
              }
        
              td[class="header-lg"] {
                font-size: 24px !important;
                padding-bottom: 5px !important;
              }
        
              td[class="content-padding"] {
                padding: 5px 0 5px !important;
              }
        
               td[class="button"] {
                padding: 5px 5px 30px !important;
              }
        
              td[class*="free-text"] {
                padding: 10px 18px 30px !important;
              }
        
              td[class~="mobile-hide-img"] {
                display: none !important;
                height: 0 !important;
                width: 0 !important;
                line-height: 0 !important;
              }
        
              td[class~="item"] {
                width: 140px !important;
                vertical-align: top !important;
              }
        
              td[class~="quantity"] {
                width: 50px !important;
              }
        
              td[class~="price"] {
                width: 90px !important;
              }
        
              td[class="item-table"] {
                padding: 30px 20px !important;
              }
        
              td[class="mini-container-left"],
              td[class="mini-container-right"] {
                padding: 0 15px 15px !important;
                display: block !important;
                width: 290px !important;
              }
        
            }
          </style>
        </head>
        
        <body bgcolor="#f7f7f7">
        <table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android" width="100%">
          <tr>
            <td align="left" valign="top" width="100%" style="background:repeat-x url(http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg) #ffffff;">
              <center>
             
                <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff" background="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" style="background-color:transparent">
                  <tr>
                    <td width="100%" height="80" valign="top" style="text-align: center; vertical-align:middle;">
                    
                      <center>
                        <table cellpadding="0" cellspacing="0" width="600" class="w320">
                          <tr>
                            <td class="pull-left mobile-header-padding-left" style="vertical-align: middle;">
                              <a href=""><h1>KKBBI</h1></a>
                            </td>
                            <td class="pull-right mobile-header-padding-right" style="color: #4d4d4d;">
                             
                            </td>
                          </tr>
                        </table>
                      </center>
                     
                    </td>
                  </tr>
                </table>
              </center>
            </td>
          </tr>
          <tr>
            <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;" class="content-padding">
              <center>
                <table cellspacing="0" cellpadding="0" width="600" class="w320">
                  <tr>
                    <td class="header-lg">
                      Kuitansi
                    </td>
                  </tr>
                  <tr>
                    <td class="free-text">
                      Terima kasih sudah melakukan transaksi, '.$pendaftaran['nama'].', jangan sungkan untuk datang lagi!
                    </td>
                  </tr>
                  <tr>
                    
                  </tr>
                  <tr>
                    <td class="w320">
                      <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                          <td class="mini-container-left">
                            <table cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                                <td class="mini-block-padding">
                                  <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:separate !important;">
                                    <tr>
                                      <td class="mini-block">
                                        <span class="header-sm">Tipe</span><br />
                                        Pendaftaran Calon Anggota <br />
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                          </td>
                          <td class="mini-container-right">
                            <table cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                                <td class="mini-block-padding">
                                  <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:separate !important;">
                                    <tr>
                                      <td class="mini-block">
                                        <span class="header-sm">Tanggal</span><br />
                                        '.$pendaftaran['tanggal'].'<br />
                                        <br />
                                        <span class="header-sm">Kode</span> <br />
                                        '.$pendaftaran['kode'].'
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </center>
            </td>
          </tr>
          <tr>
            <td align="center" valign="top" width="100%" style="background-color: #ffffff;  border-top: 1px solid #e5e5e5; border-bottom: 1px solid #e5e5e5;">
              <center>
                <table cellpadding="0" cellspacing="0" width="600" class="w320">
                    <tr>
                      <td class="item-table">
                        <table cellspacing="0" cellpadding="0" width="100%">
                          <tr>
                            <td class="title-dark" width="300">
                               Nama
                            </td>
                           
                            <td class="title-dark" width="100">
                              Harga
                            </td>
                            <td class="title-dark" width="97">
                              Qty
                            </td>
                            <td class="title-dark" width="100">
                              Subtotal
                            </td>
                          </tr>
        
                          <tr>
                            <td class="item-col item">
                              <table cellspacing="0" cellpadding="0" width="100%">
                                <tr>
                                 
                                  <td class="product">
                                    <span style="color: #4d4d4d; font-weight: bold;">Pendaftaran</span> <br />
                                   
                                  </td>
                                </tr>
                              </table>
                            </td>
                            
                            <td class="item-col price">
                            
                             '.'Rp. '. number_format($pembayaran['uang'], 0,",",".").'
                            </td>
                            <td class="item-col quantity">
                              '.$pembayaran['qty'].'
                            </td>
                            <td class="item-col">
                           
                            '.'Rp. '. number_format($pembayaran['subtotal'], 0,",",".").'
                            </td>
                          </tr>
        
        
                          <tr>
                            <td class="item-col item mobile-row-padding"></td>
                            <td class="item-col quantity"></td>
                            <td class="item-col price"></td>
                          </tr>
        
        
                          <tr>
                            <td class="item-col item">
                            </td>
                            
                            <td class="item-col quantity" style="text-align:left; padding-right: 10px; border-top: 1px solid #cccccc;">
                              <span class="total-space" style="font-weight:bold; color: #4d4d4d">Total</span> <br />
                            
                            </td>
                            <td class="item-col price" style="text-align: left; border-top: 1px solid #cccccc;">
                              <span class="total-space">'.$pembayaran['qty'].'</span> <br />
                             
                            </td>
                            <td class="item-col price" style="text-align: left; border-top: 1px solid #cccccc;">
                              <span class="total-space"> '.'Rp. '. number_format($pembayaran['subtotal'], 0,",",".").'</span> <br />
                             
                            </td>
                          </tr>
                          
                           
                        </table>
                      </td>
                    </tr>
                </table>
              </center>
            </td>
          </tr>
          <tr>
            <td align="center" valign="top" width="100%" style="background-color: #f7f7f7; height: 100px;">
              <center>
                <table cellspacing="0" cellpadding="0" width="600" class="w320">
                  <tr>
                  <td style="padding: 25px 0 25px">
                  <strong>'.$toko['nama_toko'].'</strong><br />
                  '.$toko['alamat_toko'].'<br/>
                  '.$toko['telepon_toko'].'<br/>
                  '.$toko['email_toko'].'<br/><br/>
                  '.base_url().'<br/>


                </td>
                  </tr>
                </table>
              </center>
            </td>
          </tr>
        </table>
        </div>
        </body>
        </html>';
      }

      function email_debit_invoice($transaksi, $toko, $barang){

        $loop = array(); 
        foreach($barang as $b):{
          $loop[] = '<tr>
        <td class="item-col item">
          <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
              
              <td class="product">
                <span style="color: #4d4d4d; font-weight: bold;">'.$b['nama_barang'].'</span> <br />
                
              </td>
            </tr>
          </table>
        </td>
        
        <td class="item-col price">
        
          '.'Rp. '. number_format($b['harga'], 0,",",".").'
        </td>
        <td class="item-col quantity">
          '.$b['qty'].'
        </td>
        <td class="item-col">
        '.'Rp. '. number_format($b['subtotal'], 0,",",".").'
        </td>
      </tr>';

    }
    endforeach;









   return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
   <html xmlns="http://www.w3.org/1999/xhtml">
   <head>
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1" />
     <title>KKBBI - Kuitansi</title>
   
     <style type="text/css">
     
       img { max-width: 600px; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;}
       a img { border: none; }
       table { border-collapse: collapse !important;}
       #outlook a { padding:0; }
       .ReadMsgBody { width: 100%; }
       .ExternalClass { width: 100%; }
       .backgroundTable { margin: 0 auto; padding: 0; width: 100% !important; }
       table td { border-collapse: collapse; }
       .ExternalClass * { line-height: 115%; }
       .container-for-gmail-android { min-width: 600px; }
   
   
      
       * {
         font-family: Helvetica, Arial, sans-serif;
       }
   
       body {
         -webkit-font-smoothing: antialiased;
         -webkit-text-size-adjust: none;
         width: 100% !important;
         margin: 0 !important;
         height: 100%;
         color: #676767;
       }
   
       td {
         font-family: Helvetica, Arial, sans-serif;
         font-size: 14px;
         color: #777777;
         text-align: center;
         line-height: 21px;
       }
   
       a {
         color: #007bff;
         font-weight: bold;
         text-decoration: none !important;
       }
   
       .pull-left {
         text-align: left;
       }
   
       .pull-right {
         text-align: right;
       }
   
       .header-lg,
       .header-md,
       .header-sm {
         font-size: 32px;
         font-weight: 700;
         line-height: normal;
         padding: 35px 0 0;
         color: #4d4d4d;
       }
   
       .header-md {
         font-size: 24px;
       }
   
       .header-sm {
         padding: 5px 0;
         font-size: 18px;
         line-height: 1.3;
       }
   
       .content-padding {
         padding: 20px 0 5px;
       }
   
       .mobile-header-padding-right {
         width: 290px;
         text-align: right;
         padding-left: 10px;
       }
   
       .mobile-header-padding-left {
         width: 290px;
         text-align: left;
         padding-left: 10px;
       }
   
       .free-text {
         width: 100% !important;
         padding: 10px 60px 0px;
       }
   
       .button {
         padding: 30px 0;
       }
   
       .mini-block {
         border: 1px solid #e5e5e5;
         border-radius: 5px;
         background-color: #ffffff;
         padding: 12px 15px 15px;
         text-align: left;
         width: 253px;
       }
   
       .mini-container-left {
         width: 278px;
         padding: 10px 0 10px 15px;
       }
   
       .mini-container-right {
         width: 278px;
         padding: 10px 14px 10px 15px;
       }
   
       .product {
         text-align: left;
         vertical-align: top;
         width: 175px;
       }
   
       .total-space {
         padding-bottom: 8px;
         display: inline-block;
       }
   
       .item-table {
         padding: 50px 20px;
         width: 560px;
       }
   
       .item {
         width: 300px;
       }
   
       .mobile-hide-img {
         text-align: left;
         width: 125px;
       }
   
       .mobile-hide-img img {
         border: 1px solid #e6e6e6;
         border-radius: 4px;
       }
   
       .title-dark {
         text-align: left;
         border-bottom: 1px solid #cccccc;
         color: #4d4d4d;
         font-weight: 700;
         padding-bottom: 5px;
       }
   
       .item-col {
         padding-top: 20px;
         text-align: left;
         vertical-align: top;
       }
   
       .force-width-gmail {
         min-width:600px;
         height: 0px !important;
         line-height: 1px !important;
         font-size: 1px !important;
       }
   
     </style>
   
     <style type="text/css" media="screen">
       @import url(http://fonts.googleapis.com/css?family=Oxygen:400,700);
     </style>
   
     <style type="text/css" media="screen">
       @media screen {
       
         * {
           font-family: "Oxygen", "Helvetica Neue", "Arial", "sans-serif" !important;
         }
       }
     </style>
   
     <style type="text/css" media="only screen and (max-width: 480px)">
     
       @media only screen and (max-width: 480px) {
   
         table[class*="container-for-gmail-android"] {
           min-width: 290px !important;
           width: 100% !important;
         }
   
         img[class="force-width-gmail"] {
           display: none !important;
           width: 0 !important;
           height: 0 !important;
         }
   
         table[class="w320"] {
           width: 320px !important;
         }
   
         td[class*="mobile-header-padding-left"] {
           width: 160px !important;
           padding-left: 0 !important;
         }
   
         td[class*="mobile-header-padding-right"] {
           width: 160px !important;
           padding-right: 0 !important;
         }
   
         td[class="header-lg"] {
           font-size: 24px !important;
           padding-bottom: 5px !important;
         }
   
         td[class="content-padding"] {
           padding: 5px 0 5px !important;
         }
   
          td[class="button"] {
           padding: 5px 5px 30px !important;
         }
   
         td[class*="free-text"] {
           padding: 10px 18px 30px !important;
         }
   
         td[class~="mobile-hide-img"] {
           display: none !important;
           height: 0 !important;
           width: 0 !important;
           line-height: 0 !important;
         }
   
         td[class~="item"] {
           width: 140px !important;
           vertical-align: top !important;
         }
   
         td[class~="quantity"] {
           width: 50px !important;
         }
   
         td[class~="price"] {
           width: 90px !important;
         }
   
         td[class="item-table"] {
           padding: 30px 20px !important;
         }
   
         td[class="mini-container-left"],
         td[class="mini-container-right"] {
           padding: 0 15px 15px !important;
           display: block !important;
           width: 290px !important;
         }
   
       }
     </style>
   </head>
   
   <body bgcolor="#f7f7f7">
   <table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android" width="100%">
     <tr>
       <td align="left" valign="top" width="100%" style="background:repeat-x url(http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg) #ffffff;">
         <center>
        
           <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff" background="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" style="background-color:transparent">
             <tr>
               <td width="100%" height="80" valign="top" style="text-align: center; vertical-align:middle;">
               
                 <center>
                   <table cellpadding="0" cellspacing="0" width="600" class="w320">
                     <tr>
                       <td class="pull-left mobile-header-padding-left" style="vertical-align: middle;">
                         <a href=""><h1>KKBBI</h1></a>
                       </td>
                       <td class="pull-right mobile-header-padding-right" style="color: #4d4d4d;">
                        
                       </td>
                     </tr>
                   </table>
                 </center>
                
               </td>
             </tr>
           </table>
         </center>
       </td>
     </tr>
     <tr>
       <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;" class="content-padding">
         <center>
           <table cellspacing="0" cellpadding="0" width="600" class="w320">
             <tr>
               <td class="header-lg">
                 Debit Invoice
               </td>
             </tr>
             <tr>
               <td class="free-text">
                 Terima kasih sudah mengajukan barang, '.$transaksi['nama'].', jangan sungkan untuk mengajukan lagi!
               </td>
             </tr>
             <tr>
               
             </tr>
             <tr>
               <td class="w320">
                 <table cellpadding="0" cellspacing="0" width="100%">
                   <tr>
                     <td class="mini-container-left">
                       <table cellpadding="0" cellspacing="0" width="100%">
                         <tr>
                           <td class="mini-block-padding">
                             <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:separate !important;">
                               <tr>
                                 <td class="mini-block">
                                   <span class="header-sm">Tipe</span><br />
                                   Pengajuan Barang <br />
                                 </td>
                               </tr>
                             </table>
                           </td>
                         </tr>
                       </table>
                     </td>
                     <td class="mini-container-right">
                       <table cellpadding="0" cellspacing="0" width="100%">
                         <tr>
                           <td class="mini-block-padding">
                             <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:separate !important;">
                               <tr>
                                 <td class="mini-block">
                                   <span class="header-sm">Tanggal</span><br />
                                   '.$transaksi['tanggal'].'<br />
                                   <br />
                                   <span class="header-sm">Kode</span> <br />
                                   '.$transaksi['kode'].'
                                 </td>
                               </tr>
                             </table>
                           </td>
                         </tr>
                       </table>
                     </td>
                   </tr>
                 </table>
               </td>
             </tr>
           </table>
         </center>
       </td>
     </tr>
     <tr>
       <td align="center" valign="top" width="100%" style="background-color: #ffffff;  border-top: 1px solid #e5e5e5; border-bottom: 1px solid #e5e5e5;">
         <center>
           <table cellpadding="0" cellspacing="0" width="600" class="w320">
               <tr>
                 <td class="item-table">
                   <table cellspacing="0" cellpadding="0" width="100%">
                     <tr>
                       <td class="title-dark" width="300">
                          Nama
                       </td>
                      
                       <td class="title-dark" width="100">
                         Harga
                       </td>
                       <td class="title-dark" width="97">
                         Qty
                       </td>
                       <td class="title-dark" width="100">
                         Subtotal
                       </td>
                     </tr>


                    '.implode($loop).'
                     <tr>
                       <td class="item-col item mobile-row-padding"></td>
                       <td class="item-col quantity"></td>
                       <td class="item-col price"></td>
                     </tr>
   
   
                     <tr>
                       <td class="item-col item">
                       </td>
                       
                       <td class="item-col quantity" style="text-align:left; padding-right: 10px; border-top: 1px solid #cccccc;">
                         <span class="total-space" style="font-weight:bold; color: #4d4d4d">Total</span> <br />
                       
                       </td>
                       <td class="item-col price" style="text-align: left; border-top: 1px solid #cccccc;">
                         <span class="total-space">'.$transaksi['total_qty'].'</span> <br />
                        
                       </td>
                       <td class="item-col price" style="text-align: left; border-top: 1px solid #cccccc;">
                         <span class="total-space"> '.'Rp. '. number_format($transaksi['total_harga'], 0,",",".").'</span> <br />
                        
                       </td>
                     </tr>
                     
    
                      
                   </table>
                 </td>
               </tr>
           </table>
         </center>
       </td>
     </tr>
     <tr>
       <td align="center" valign="top" width="100%" style="background-color: #f7f7f7; height: 100px;">
         <center>
           <table cellspacing="0" cellpadding="0" width="600" class="w320">
             <tr>
             <td style="padding: 25px 0 25px">
             <strong>'.$toko['nama_toko'].'</strong><br />
             '.$toko['alamat_toko'].'<br/>
             '.$toko['telepon_toko'].'<br/>
             '.$toko['email_toko'].'<br/><br/>
             '.base_url().'<br/>


           </td>
             </tr>
           </table>
         </center>
       </td>
     </tr>
   </table>
   </div>
   </body>
   </html>';
 }

     
       
    
    
?>