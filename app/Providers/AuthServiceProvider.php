<?php

namespace LinkApp\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use LinkApp\Models\ERP\Usuario;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'LinkApp\Model' => 'LinkApp\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        

        $this->registerPolicies();

        Gate::define('access', function ($user,$permisosUsuario,$url) {

            $accion = "";

            $permisos = $permisosUsuario;

            if (isset($permisos) && !$permisos->isEmpty()) {

                foreach($permisos as $permiso){

                    $accion = url('/').$permiso->accion;
    
                   if ($accion === $url) {
    
                        return true;
    
                    }
                }
            }

           return false;

        });


        Gate::define('view', function ($user,$permisosUsuario,$url) {

            $accion = "";

            $permisos = $permisosUsuario;

            if (isset($permisos) && !$permisos->isEmpty()) {

                foreach($permisos as $permiso){

                    $accion = url('/').$permiso->accion;
    
                   if ($accion === $url) {
    
                        return true;
    
                    }
                }
            }

           return false;

        });

        Gate::define('view-home', function ($user,$permisosUsuario) {

            $permisos = $permisosUsuario;

            if (isset($permisos) && !$permisos->isEmpty()) {

                return true;

            }

           return false;

        });

        Gate::define('modify', function ($user,$permisosUsuario,$url) {

            $accion = "";

            $permisos = $permisosUsuario;

            if (isset($permisos) && !$permisos->isEmpty()) {

                foreach($permisos as $permiso){

                    $accion = url('/').$permiso->accion;

                if ($accion === $url) {

                        return $permiso->rolModificar === 1;

                    }
                }
            }

        });

        Gate::define('delete', function ($user,$permisosUsuario,$url) {

            $accion = "";

            $permisos = $permisosUsuario;

            if (isset($permisos) && !$permisos->isEmpty()) {

                foreach($permisos as $permiso){

                    $accion = url('/').$permiso->accion;

                if ($accion === $url) {

                        return $permiso->rolEliminar === 1;

                    }
                }
            }

        });

        Gate::define('insert', function ($user,$permisosUsuario,$url) {

            $accion = "";

            $permisos = $permisosUsuario;

            if (isset($permisos) && !$permisos->isEmpty()) {

                foreach($permisos as $permiso){

                    $accion = url('/').$permiso->accion;

                if ($accion === $url) {

                        return $permiso->rolInsertar === 1;

                    }
                }
            }

        });

        Gate::define('super', function ($user,$permisosUsuario,$url) {

            $accion = "";

            $permisos = $permisosUsuario;

            if (isset($permisos) && !$permisos->isEmpty()) {

                foreach($permisos as $permiso){

                    $accion = url('/').$permiso->accion;

                if ($accion === $url) {

                        return $permiso->rolSuper === 1;

                    }
                }
            }
            
        });

        Gate::define('admin', function ($user,$permisosUsuario,$url) {

            $accion = "";

            $permisos = $permisosUsuario;

            if (isset($permisos) && !$permisos->isEmpty()) {

                foreach($permisos as $permiso){

                    $accion = url('/').$permiso->accion;

                if ($accion === $url) {

                        return $permiso->rolAdmin === 1;

                    }
                }
            }

        });
    }
}
