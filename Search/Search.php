<?php

namespace Herzult\Bundle\ForumBundle\Search;

use Symfony\Component\Validator\Constraints as Assert;

class Search
{
    /**
     * @Assert\NotBlank(),
     * @Assert\Length(min=3, minMessage="Just a little too short.")
     */
    protected $query;

    public function getQuery()
    {
        return $this->query;
    }

    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }
}
