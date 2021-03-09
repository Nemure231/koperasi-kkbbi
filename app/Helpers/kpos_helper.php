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
    
    
?>