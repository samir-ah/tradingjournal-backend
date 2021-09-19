<?php

namespace App\Entity;

interface AuthorOwnedInterface
{
    public function getAuthor(): ?User;
    public function setAuthor(?User $user): self;
}
