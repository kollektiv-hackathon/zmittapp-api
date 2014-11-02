<?php
/*
 * This file is part of the [name] package.
 *
 * (c) Marc Juchli <mail@marcjuch.li>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zmittapp\ApiBundle\Exception;


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RessourceNotFoundException extends NotFoundHttpException
{
    protected $form;

    public function __construct($entityName, $id, $form = null)
    {
        $message = $entityName . " not found with id: " . $id;
        parent::__construct($message);
        $this->form = $form;
    }

}