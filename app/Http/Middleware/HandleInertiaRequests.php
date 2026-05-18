<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

/**
 * HandleInertiaRequests
 *
 * Middleware que comparte datos globales con todos los componentes React.
 * Los mensajes flash y el locale se inyectan automáticamente en cada página.
 */
class HandleInertiaRequests extends Middleware
{
    /**
     * Vista raíz de Inertia (resources/views/app.blade.php).
     */
    protected $rootView = 'app';

    /**
     * Versión de los assets para cache busting.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Props compartidas con TODOS los componentes React.
     * flash → mensajes de éxito/error
     * locale → idioma actual (multi-idioma)
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            // Mensajes flash de éxito y error
            'flash' => [
                'success' => $request->session()->get('success'),
                'error'   => $request->session()->get('error'),
            ],
            // Locale actual para soporte multi-idioma
            'locale' => app()->getLocale(),
        ]);
    }
}
