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
        $ModelAksesRole = new ModelAksesRole();

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