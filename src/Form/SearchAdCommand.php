<?php

namespace App\Form;

class SearchAdCommand
{
    private $title;

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return $this
     */
    public function setTitle(?string $title): SearchAdCommand
    {
        $this->title = $title;

        return $this;
    }
}