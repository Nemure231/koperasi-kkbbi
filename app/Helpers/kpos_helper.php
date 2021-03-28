<?php 

use App\Models\ModelSubmenu;
use App\Models\ModelMenuUtama;
use App\Models\ModelAksesRole;
    
        function check_akses($role_id, $menu_id){
            $model = new ModelAksesRole();

            $result= $model->cekCentangAksesRole($role_id, $menu_id);

            if ($result > 0) {
                return 'checked="checked"';
            }
        }

        function sub_menu_conex($menu_id, $menu_utama_id){
            $model = new ModelSubmenu();
            return  $model->ambilSubmenuUntukSidebar($menu_id, $menu_utama_id);
        }

        function main_menu_conex($menuId){
            $model = new ModelMenuUtama();
            return $model->ambilMenuUtamaUntukSidebar($menuId);
            
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

        function tambah_input_helper($name, $type, $validasi){

            $class = ($validasi) ? 'is-invalid' : '';
              echo form_input([
                'name' => $name,
                'class' => "form-control "."$class"."",
                'value' => set_value($name, ''),
                'type' => $type
              ]);
        }

        function tambah_textarea_helper($name, $type, $validasi){

            $class = ($validasi) ? 'is-invalid' : '';
              echo form_textarea([
                'name' => $name,
                'class' => "form-control "."$class"."",
                'value' => set_value($name, ''),
                'type' => $type
              ]);
        }

        function tambah_input_password_helper($name, $type, $validasi){

            $class = ($validasi) ? 'is-invalid' : '';
              echo form_input([
                'name' => $name,
                'class' => "form-control "."$class"."",
                'type' => $type
              ]);
        }

        function edit_input_helper_no_modal($name, $type, $value, $validasi){
            $class = ($validasi) ? 'is-invalid' : '';
            echo form_input([
              'name' => $name,
              'class' => "form-control "."$class"."",
              'value' => $value,
              'type' => $type,
              'autofocus' => ''
            ]);
        }

        function edit_textarea_helper_no_modal($name, $type, $value, $validasi){
            $class = ($validasi) ? 'is-invalid' : '';
            echo form_textarea([
              'name' => $name,
              'class' => "form-control "."$class"."",
              'value' => $value,
              'type' => $type
            ]);
        }

        function edit_input_helper($name, $id, $type, $validasi){
            $class = ($validasi) ? 'is-invalid' : '';
            echo form_input([
              'id' => $id,
              'name' => $name,
              'class' => "form-control hapus-validasi-border "."$class"."",
              'value' => set_value($name, ''),
              'type' => $type
            ]);
        }

        function edit_textarea_helper($name, $id, $type, $validasi){
            $class = ($validasi) ? 'is-invalid' : '';
            echo form_textarea([
              'id' => $id,
              'name' => $name,
              'class' => "form-control hapus-validasi-border "."$class"."",
              'value' => set_value($name, ''),
              'type' => $type
            ]);
        }

        function edit_input_id_helper($name, $id, $value, $type){
            echo form_input([
                'name' => $name,
                'id'=> $id,
                'type'=> $type,
                'value' => $value
              ]);
        }
    
    
?>