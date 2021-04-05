<?php 

use App\Models\ModelSubmenu;
use App\Models\ModelMenuUtama;
use App\Models\ModelAksesRole;


        if (! function_exists('check_akses')) {
          function check_akses($role_id, $menu_id){
              $model = new ModelAksesRole();

              $result= $model->cekCentangAksesRole($role_id, $menu_id);

              if ($result > 0) {
                  return 'checked="checked"';
              }
          }
        }
        if (! function_exists('sub_menu_conex')) {
          function sub_menu_conex($menu_id, $menu_utama_id){
              $model = new ModelSubmenu();
              return  $model->ambilSubmenuUntukSidebar($menu_id, $menu_utama_id);
          }
        }

        if (! function_exists('main_menu_conex')) {
          function main_menu_conex($menuId){
              $model = new ModelMenuUtama();
              return $model->ambilMenuUtamaUntukSidebar($menuId);
              
          }
        }
        if (! function_exists('implode_helper')) {
          function implode_helper($array){
              if($array){
                  return implode("<br>",$array ?? [] );
              }else{
                  return 0;
              }
          }
        }
   
        //special_data is such a session and validation
        if (! function_exists('tampilan_login')) {
          function tampilan_login($center_html, $javascript_page, $data=[]){
              echo view('admin/admin-base-html/v_header', $data);
              echo view($center_html);
              echo view('admin/admin-base-html/v_js');
              echo view($javascript_page);

          }
        }
    

    
        //special_data is such a session and validation
        if (! function_exists('tampilan_user')) {
          function tampilan_user($center_html, $javascript_page, $data=[]){
              echo view('user/user-base-html/v_css', $data);
              echo view('user/user-base-html/v_navbar');
              echo view($center_html);
              echo view('user/user-base-html/v_footer');
              echo view('user/user-base-html/v_js');
              echo view($javascript_page);

          }
        }
    

   
        if (! function_exists('tampilan_admin')) {
          function tampilan_admin($center_html, $javascript_page, $data=[]){
            
              echo view('admin/admin-base-html/v_header', $data);
              echo view('admin/admin-base-html/v_navbar');
              echo view('admin/admin-base-html/v_sidebar');
              echo view($center_html);
              echo view('admin/admin-base-html/v_footer');
              echo view('admin/admin-base-html/v_js');
              echo view($javascript_page);

          }
        }

        if (! function_exists('tambah_input_helper')) {
          function tambah_input_helper($name, $type, $validasi){

              $class = ($validasi) ? 'is-invalid' : '';
                echo form_input([
                  'name' => $name,
                  'class' => "form-control "."$class"."",
                  'value' => set_value($name, ''),
                  'type' => $type
                ]);
          }
        }

        if (! function_exists('tambah_textarea_helper')) {
          function tambah_textarea_helper($name, $type, $validasi){

              $class = ($validasi) ? 'is-invalid' : '';
                echo form_textarea([
                  'name' => $name,
                  'class' => "form-control "."$class"."",
                  'value' => set_value($name, ''),
                  'type' => $type
                ]);
          }
        }

        if (! function_exists('tambah_input_password_helper')) {
          function tambah_input_password_helper($name, $type, $validasi){

              $class = ($validasi) ? 'is-invalid' : '';
                echo form_input([
                  'name' => $name,
                  'class' => "form-control "."$class"."",
                  'type' => $type
                ]);
          }
        }

        if (! function_exists('edit_input_helper_no_modal')) {
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
        }

        if (! function_exists('edit_textarea_helper_no_modal')) {
          function edit_textarea_helper_no_modal($name, $type, $value, $validasi){
              $class = ($validasi) ? 'is-invalid' : '';
              echo form_textarea([
                'name' => $name,
                'class' => "form-control "."$class"."",
                'value' => $value,
                'type' => $type
              ]);
          }
        }
        if (! function_exists('edit_input_helper')) {
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
        }

        if (! function_exists('edit_textarea_helper')) {
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
        }
        if (! function_exists('edit_input_id_helper')) {
          function edit_input_id_helper($name, $id, $value, $type){
              echo form_input([
                  'name' => $name,
                  'id'=> $id,
                  'type'=> $type,
                  'value' => $value
                ]);
          }
        }

        if (! function_exists('array_exists')) {
          function array_exists($array, $key){
            if ($array instanceof ArrayAccess) {
              return $array->offsetExists($key);
            }

            return array_key_exists($key, $array);
          }
        }


        if (! function_exists('array_accessible')) {
          function array_accessible($value){
            return is_array($value) || $value instanceof ArrayAccess;
          }
        }


        if (! function_exists('data_set')) {
          function data_set(&$target, $key, $value, $overwrite = true){
            $segments = is_array($key) ? $key : explode('.', $key);
            if (($segment = array_shift($segments)) === '*') {
                if (! array_accessible($target)) {
                    $target = [];
                }
                if ($segments) {
                    foreach ($target as &$inner) {
                        data_set($inner, $segments, $value, $overwrite);
                    }
                } elseif ($overwrite) {
                    foreach ($target as &$inner) {
                        $inner = $value;
                    }
                }
            } elseif (array_accessible($target)) {
                if ($segments) {
                    if (! array_exists($target, $segment)) {
                        $target[$segment] = [];
                    }
                    data_set($target[$segment], $segments, $value, $overwrite);
                } elseif ($overwrite || ! array_exists($target, $segment)) {
                    $target[$segment] = $value;
                }
            } elseif (is_object($target)) {
                if ($segments) {
                    if (! isset($target->{$segment})) {
                        $target->{$segment} = [];
                    }
                    data_set($target->{$segment}, $segments, $value, $overwrite);
                } elseif ($overwrite || ! isset($target->{$segment})) {
                    $target->{$segment} = $value;
                }
            } else {
                $target = [];
                if ($segments) {
                    data_set($target[$segment], $segments, $value, $overwrite);
                } elseif ($overwrite) {
                    $target[$segment] = $value;
                }
            }

            return $target;
          }
        }


        if (! function_exists('data_fill')) {
          function data_fill(&$target, $key, $value){
              return data_set($target, $key, $value, false);
          }
        }
    
    
?>