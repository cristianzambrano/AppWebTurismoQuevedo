<?php 
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\permisos_rol_model;

class AuthCheck implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null)
    {

        $session = session();
        if (!$session->get('isLoggedIn')) 
           return $this->createResponse('Unauthorized', $request, 'Debe iniciar sesión como usuario autorizado.');
        
        $userProfile = $session->get('rol');
        $currentRoute = $request->uri->getRoutePath();

        if (!$this->isRouteAllowed($userProfile, $currentRoute)) {
            return $this->createResponse('Unauthorized', $request, 'Acceso denegado.!');
        }


    }


    private function isRouteAllowed($userProfile, $currentRoute)
    {
        $permisosPerfilModel = new permisos_rol_model();
        $allowedRoutes = $permisosPerfilModel->getAllowedRoutes($userProfile);
        foreach ($allowedRoutes as $route) {
            $pattern = '#^' . preg_replace('#(:num)#', '[0-9]+', $route['ruta']) . '$#';
            if (preg_match($pattern, $currentRoute)) {
                return true;
            }
        }

        return false;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }

    private function createResponse($type, $request, $message)
    {

        if ($request->isAJAX()) {
            $response = service('response');
            if($type=='Bad Request')
                return $response->setStatusCode(400, 'Bad Request')->setBody($message);
            else if($type=='Unauthorized')
                return $response->setStatusCode(401, 'Acceso NO autorizado')->setBody($message);
            else
                return $response->setStatusCode(500, 'Internal Server Error')->setBody($message);

        } else {
            return redirect()->to('/unauthorized');
        }
    }
        
  
}