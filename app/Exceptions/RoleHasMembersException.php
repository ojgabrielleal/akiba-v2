<?php

namespace App\Exceptions;

use Exception;

use App\Traits\HasFlashMessages;

class RoleHasMembersException extends Exception
{
    use HasFlashMessages;

    /**
     * Renderiza a exceção em uma resposta HTTP.
     */
    public function render($request)
    {
        return $this->flashMessage('dependencies');
    }
}
