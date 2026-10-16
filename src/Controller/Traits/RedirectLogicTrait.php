<?php
declare(strict_types=1);

namespace CakeLteTools\Controller\Traits;

use Cake\Http\Response;

trait RedirectLogicTrait
{
    protected string $redirectKey = 'redirect';

    /**
     * @param array|string $url
     * @param int $status
     * @return \Cake\Http\Response|null
     */
    public function redirect($url, int $status = 302): ?Response
    {
        $redirect = $this->getRedirectUrl();
        if ($redirect) {
            $url = $redirect;
        }

        return parent::redirect($url, $status);
    }

    /**
     * @return string|null
     */
    public function getRedirectUrl(): ?string
    {
        return $this->getRequest()->getQuery($this->redirectKey)
            ?? $this->getRequest()->getData($this->redirectKey)
            ?? null;
    }
}
