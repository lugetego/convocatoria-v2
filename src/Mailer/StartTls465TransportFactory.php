<?php

namespace App\Mailer;

use Symfony\Component\Mailer\Transport\AbstractTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mailer\Transport\TransportInterface;

/**
 * El servidor de correo de matmor.unam.mx acepta STARTTLS en el puerto 465
 * en vez de TLS implícito (lo contrario a la convención habitual). El
 * EsmtpTransportFactory de Symfony fuerza TLS implícito cuando el puerto es
 * 465, así que aquí se construye el transporte explícitamente en modo
 * STARTTLS para ese puerto. DSN: smtp+starttls://user:pass@host:465
 */
final class StartTls465TransportFactory extends AbstractTransportFactory
{
    public function create(Dsn $dsn): TransportInterface
    {
        $transport = new EsmtpTransport($dsn->getHost(), $dsn->getPort(465), false, $this->dispatcher, $this->logger);
        $transport->setAutoTls(true);

        if ($user = $dsn->getUser()) {
            $transport->setUsername($user);
        }

        if ($password = $dsn->getPassword()) {
            $transport->setPassword($password);
        }

        return $transport;
    }

    protected function getSupportedSchemes(): array
    {
        return ['smtp+starttls'];
    }
}
