<?php

namespace BlackCMS\ACL\Repositories\Eloquent;

use BlackCMS\ACL\Repositories\Interfaces\UserInterface;
use BlackCMS\Support\Repositories\Eloquent\RepositoriesAbstract;

class UserRepository extends RepositoriesAbstract implements UserInterface
{
    /**
     * {@inheritDoc}
     */
    public function getUniqueUsernameFromEmail($email)
    {
        $emailPrefix = substr($email, 0, strpos($email, "@"));
        $username = $emailPrefix;
        $offset = 1;
        while ($this->getFirstBy(["username" => $username])) {
            $username = $emailPrefix . $offset;
            $offset++;
        }

        $this->resetModel();

        return $username;
    }
}
