<?php 

use App\Models\ModelSubmenu;
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

        function sub_menu_conex($menu_id, $menu_utama_id){
            $model = new ModelSubmenu();
            return  $model->ambilSubmenuUntukSidebar($menu_id, $menu_utama_id);
        }

        function main_menu_conex($menuId){
            $model = new Model_menu_utama();
            return $model->select('nama_menu_utama, id_menu_utama, ikon_menu_utama')->asArray()
                    ->join('user_menu', 'user_menu.id_menu = menu_utama.menu_id')
                    ->where('menu_utama.menu_id', $menuId)
                    ->findAll();
            
        }

        function implode_helper($array){
            if($array){
                return implode("<br>",$array ?? [] );
            }else{
                return 0;
            }
        }
   
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