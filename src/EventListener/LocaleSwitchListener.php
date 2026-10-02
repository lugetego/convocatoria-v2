<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;

// Prioridad > 15: debe correr ANTES que Symfony\Component\HttpKernel\EventListener\LocaleAwareListener
// (prioridad 15), que es quien propaga request->getLocale() al traductor. Si corriéramos después,
// el cambio de idioma por query string nunca llegaría al traductor para esta petición.
#[AsEventListener(event: 'kernel.request', priority: 20)]
class LocaleSwitchListener
{
    private const ALLOWED_LOCALES = ['es', 'en'];

    public function __invoke(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $locale = $request->query->get('_locale');

        if (null !== $locale && \in_array($locale, self::ALLOWED_LOCALES, true)) {
            $request->setLocale($locale);
        }
    }
}
