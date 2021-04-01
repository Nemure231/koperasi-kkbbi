<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\ModelAksesRole;
class HakAkses implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null)
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        $cookie = $request->getCookie('jwt_token');
        $ModelAksesRole = new ModelAksesRole();

        if(!$cookie){
            $session->remove('email');
            $session->remove('role_id');
            $session->remove('id_user');
            $session->remove('nama');
            $session->setFlashdata('pesan', '<div class="alert alert-info alert-dismissible fade show" role="alert">
						<strong>Waktu login Anda baru saja habis, silakan login kembali.</strong>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>');
            return redirect()->to(base_url('/'));

        }

        $role_id = $session->get('role_id');
		if (!$role_id){
            return redirect()->to(base_url('/'));
        }
        
        $uri = $request->uri;
        $uri_menu = $uri->getSegment(1);

        $akses = $ModelAksesRole->cekAksesRoleUser($role_id, $uri_menu);
                    
        if ($akses < 1) {
            return redirect()->to(base_url('blokir'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}